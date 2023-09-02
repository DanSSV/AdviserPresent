
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>
</head>
<body>
    
</body>
<script>
    // Function to check the status every 5 seconds
function checkStatus() {
    var plateNumber = "GHI-123"; // Replace with your plate number

    $.ajax({
        type: "POST",
        url: "check_status.php",
        data: { plateNumber: plateNumber },
        dataType: "json",
        success: function (response) {
            // Check the status returned from the server
            if (response.status === "match") {
                // Redirect to driver_map.php
                window.location.href = "driver_map.php";
            } else {
                // Update the status on the web page
                $("#status").text("Status: " + response.status);
            }
        },
        complete: function () {
            // Schedule the next check after 5 seconds
            setTimeout(checkStatus, 5000);
        }
    });
}

// Start checking the status when the page loads
$(document).ready(function () {
    checkStatus();
});

</script>
</html>