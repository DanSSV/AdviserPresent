<?php
// Step 1: Include the database connection file
include('../db/dbconn.php');

// Step 2: Query the history_1 table to find user_id
$plateNumber = 'GHI-123';
$status = 'active';

$query = "SELECT user_id FROM history_1 WHERE plate_number = ? AND status = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $plateNumber, $status);
$stmt->execute();
$stmt->bind_result($userId);
$stmt->fetch();
$stmt->close();

// Step 3: Query the users table to find the passenger's name
if (!empty($userId)) {
    $query = "SELECT name FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($name);
    $stmt->fetch();
    $stmt->close();

    // Step 4: Display the passenger's name in the <h1> tag
    echo '<h1>Passenger Name: ' . $name . '</h1>';
} else {
    echo '<h1>Passenger not found</h1>';
}

// Step 5: Close the database connection
$conn->close();
?>