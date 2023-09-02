<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaflet Map</title>
    <!-- Include Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>

<body>
    <div id="map" style="height: 400px;"></div>

    <script>
        // Initialize Leaflet map
        var map = L.map('map').setView([0, 0], 13);

        // Add a tile layer to the map (you can choose any tile provider)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Create a marker for the current location
        var marker = L.marker([0, 0]).addTo(map);

        // Function to send an AJAX request to save location
        function saveLocation(lat, lng) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "save_location.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText); // Log the server response (for testing)
                }
            };
            xhr.send("latitude=" + lat + "&longitude=" + lng);
        }

        // Function to get location and save it
        function getLocationAndSave() {
            // Get the user's current location using the Geolocation API
            navigator.geolocation.getCurrentPosition(function (position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;

                // Set the marker's position and bind a popup with lat/lng
                marker.setLatLng([lat, lng]).bindPopup("Latitude: " + lat + "<br>Longitude: " + lng).openPopup();

                // Center the map on the user's location
                map.setView([lat, lng], 13);

                // Save the location data to the server
                saveLocation(lat, lng);
            }, function (error) {
                // Handle errors (e.g., user denied location access)
                console.error("Error getting location:", error);
            });
        }

        // Call the function to get location and save it when the page loads
        window.addEventListener("load", getLocationAndSave);
    </script>
</body>

</html>