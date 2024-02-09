<?php
include 'db_connection.php';

// Check if hostelID and status are provided in the request body
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->hostelID) && isset($data->status)) {
        // Sanitize input
        $hostelID = mysqli_real_escape_string($conn, $data->hostelID);
        $status = mysqli_real_escape_string($conn, $data->status);

        // Update room status in the database
        $updateQuery = "UPDATE hostel SET status='$status' WHERE hostelID='$hostelID'";

        if (mysqli_query($conn, $updateQuery)) {
            $response = array("success" => true);
            echo json_encode($response);
        } else {
            $response = array("success" => false, "error" => mysqli_error($conn));
            echo json_encode($response);
        }
    } else {
        $response = array("success" => false, "error" => "hostelID and status are required");
        echo json_encode($response);
    }
} else {
    $response = array("success" => false, "error" => "Invalid request method");
    echo json_encode($response);
}

// Close database connection
mysqli_close($conn);
?>
