<?php
// Include the database connection
require '../db/dbconn.php';

// Define the plate number to check
$plateNumber = "GHI-123";

// SQL query to check if a record with status 'active' and the given plate number exists in the 'history_1' table
$query = "SELECT * FROM history_1 WHERE status = 'active' AND plate_number = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $plateNumber);
$stmt->execute();
$result = $stmt->get_result();

// Check if a matching record was found
if ($result->num_rows > 0) {
    // Redirect the user to driver_map.php
    header("Location: driver_map.php");
    exit(); // Make sure to exit to prevent further execution
}

// Close the database connection
$stmt->close();
$conn->close();
?>
<?php
// Include the database connection
require '../db/dbconn.php';

// Get the plate number from the POST data
$plateNumber = $_POST['plateNumber'];

// SQL query to check if a record with status 'active' and the given plate number exists in the 'history_1' table
$query = "SELECT * FROM history_1 WHERE status = 'active' AND plate_number = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $plateNumber);
$stmt->execute();
$result = $stmt->get_result();

// Check if a matching record was found
if ($result->num_rows > 0) {
    echo "match";
} else {
    echo "no match";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
