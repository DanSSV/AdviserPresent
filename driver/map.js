// Initialize the map without zoom controls
var map = L.map("map", {
  zoomControl: false, // Disable the default zoom control
}).setView([0, 0], 13);

// Add a tile layer to the map (you can change the tile source if needed)
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution:
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

var startingMarker, newMarker, trackMarker; // Variables to store markers

// Define the custom icon for the trackMarker
var trackMarkerIcon = L.icon({
  iconUrl:
    "https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png",
  iconSize: [25, 41], // Set the icon size as needed
  iconAnchor: [12, 41], // Set the anchor point of the icon
  popupAnchor: [1, -34], // Set the popup anchor
});

// Watch the user's position and update the tracking marker
if ("geolocation" in navigator) {
  navigator.geolocation.getCurrentPosition(function (position) {
    var userLat = position.coords.latitude;
    var userLng = position.coords.longitude;

    // Create the tracking marker with the custom icon and add it to the map
    trackMarker = L.marker([userLat, userLng], { icon: trackMarkerIcon, zIndexOffset: 1000 }).addTo(map);

    // Center the map on the tracking marker's position
    map.setView([userLat, userLng]);

    // Use AJAX to fetch data from your database
    fetch("get_marker_data.php")
      .then((response) => response.json())
      .then((data) => {
        // Extract latitude and longitude from the data
        var startingLat = parseFloat(data.starting_lat);
        var startingLng = parseFloat(data.starting_lng);
        var newLat = parseFloat(data.new_lat);
        var newLng = parseFloat(data.new_lng);

        // Add markers for both the starting location and the new location
        startingMarker = L.marker([startingLat, startingLng]).addTo(map);
        newMarker = L.marker([newLat, newLng]).addTo(map);

        // Center the map to a suitable location (you may want to adjust this)
        map.setView([startingLat, startingLng], 16);

        // Define waypoints for the OSRM API request
        var waypoints = [
          [startingLng, startingLat], // Note the order of longitude and latitude
          [newLng, newLat],
        ];

        // Construct the URL for the OSRM API request
        var osrmURL =
          "https://router.project-osrm.org/route/v1/driving/" +
          waypoints.join(";") +
          "?geometries=geojson";

        // Make an AJAX request to the OSRM API to fetch the route data
        fetch(osrmURL)
          .then((response) => response.json())
          .then((routeData) => {
            // Extract the route geometry from the response
            var routeGeometry = routeData.routes[0].geometry;

            // Create a GeoJSON layer for the route and add it to the map
            L.geoJSON(routeGeometry).addTo(map);

            // Calculate the distance in kilometers
            var distance = routeData.routes[0].distance / 1000; // Convert meters to kilometers

            // Calculate the ETA assuming a constant speed of 20 km/h
            var speed = 20; // Speed in km/h
            var eta = (distance / speed) * 60; // Calculate ETA in minutes

            // Calculate the fare based on the distance
            var cost = distance <= 2 ? 30 : 30 + (distance - 2) * 10;
            cost = Math.round(cost);

            // Create a popup content string with distance, fare, and ETA
            // var popupContent =
            //   "Distance: " + distance.toFixed(2) + " km<br>Fare: ₱" + cost + "<br>ETA: " + eta.toFixed(0) + " minutes";

            // Bind the popup to the tracking marker
            trackMarker.bindPopup(popupContent).openPopup();
          })
          .catch((error) => console.error(error));
      })
      .catch((error) => console.error(error));
  });
}
