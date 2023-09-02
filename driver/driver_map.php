<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Route | TriSakay</title>
    <!-- Include Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="../css/search.css">
    <style>
        
    </style>
    <?php
    include('../php/dependencies.php');
    ?>
    
</head>

<body>
    <?php
    include('../php/navbar_driver.php');
    ?>
    <div id="map" style="height: 75vh;"></div>
    
    <div class="info">
        <?php
        include('user_find.php');
        ?>
        
    </div>
    <script src="map.js"></script>
</body>

</html>