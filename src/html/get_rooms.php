<?php
// Include the database connection
include_once 'db_connection.php';

// Initialize response array
$response = array();

// Prepare SQL statement to select all rooms
$sql = "SELECT * FROM hostel";

// Execute the statement
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Loop through each row and add it to the response
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
}

// Close connection
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
