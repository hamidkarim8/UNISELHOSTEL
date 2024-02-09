<?php
// Include database connection
include 'db_connection.php';

// Decode JSON data received from the client
$data = json_decode(file_get_contents("php://input"));

// Check if hostelID is provided
if (!empty($data->hostelID)) {
    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("DELETE FROM hostel WHERE hostelID = ?");
    $stmt->bind_param("i", $data->hostelID);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // Return success response with HTTP status code 200 OK
        http_response_code(200);
        echo json_encode(array("success" => true));
    } else {
        // Return error response with HTTP status code 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("success" => false));
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Return error response if hostelID is not provided with HTTP status code 400 Bad Request
    http_response_code(400);
    echo json_encode(array("success" => false, "message" => "Hostel ID is required"));
}
?>
