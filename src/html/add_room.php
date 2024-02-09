<?php
// Include the database connection file
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $block = filter_input(INPUT_POST, 'block', FILTER_SANITIZE_STRING);
    $floor = filter_input(INPUT_POST, 'floor', FILTER_SANITIZE_STRING);
    $unit = filter_input(INPUT_POST, 'unit', FILTER_SANITIZE_STRING);
    $roomNumber = filter_input(INPUT_POST, 'roomNumber', FILTER_SANITIZE_STRING);

    // Prepare and bind the INSERT statement
    $stmt = $conn->prepare("INSERT INTO hostel (block, floor, unit, roomNumber, created_At, status) VALUES (?, ?, ?, ?, NOW(), 'Available')");
    $stmt->bind_param("ssss", $block, $floor, $unit, $roomNumber);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        // Return success message as JSON response
        echo json_encode(array("success" => true));
    } else {
        // Return error message as JSON response
        echo json_encode(array("success" => false));
    }

    // Close statement
    $stmt->close();
} else {
    // If the request method is not POST, return error
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}

// Close connection
$conn->close();
?>