<?php
include 'db_connection.php';

// Check if bookingID is provided in the request body
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->bookingID)) {
        // Sanitize input
        $bookingID = mysqli_real_escape_string($conn, $data->bookingID);

        // Update booking status in the database
        $updateQuery = "UPDATE bookinglist SET status='APPROVED' WHERE bookingID='$bookingID'";

        if (mysqli_query($conn, $updateQuery)) {
            $response = array("success" => true);
            echo json_encode($response);
        } else {
            $response = array("success" => false, "error" => mysqli_error($conn));
            echo json_encode($response);
        }
    } else {
        $response = array("success" => false, "error" => "bookingID is required");
        echo json_encode($response);
    }
} else {
    $response = array("success" => false, "error" => "Invalid request method");
    echo json_encode($response);
}

// Close database connection
mysqli_close($conn);
?>
