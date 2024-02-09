<?php
// Include the database connection
include_once 'db_connection.php';

// Check if room ID is provided in the request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hostelID'])) {
    // Initialize response array
    $response = array();

    // Retrieve room ID from the request
    $hostelID = $_POST['hostelID'];

    // Prepare SQL statement to delete the room
    $sql = "DELETE FROM hostel WHERE hostelID = ?";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $hostelID);

    // Execute the statement
    if ($stmt->execute()) {
        // Room deleted successfully
        $response['success'] = true;
        $response['message'] = "Room deleted successfully!";
    } else {
        // Failed to delete room
        $response['success'] = false;
        $response['message'] = "Failed to delete room: " . $conn->error;
    }

    // Close statement
    $stmt->close();

    // Close connection
    $conn->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If the request method is not POST or room ID is not provided
    http_response_code(400); // Bad Request
    echo json_encode(array("error" => "Bad Request"));
}
?>
