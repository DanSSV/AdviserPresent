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
    echo json_encode(array('status' => 'match'));
} else {
    echo json_encode(array('status' => 'no match'));
}

// Close the database connection
$stmt->close();
$conn->close();
?>