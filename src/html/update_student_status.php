<?php
include 'db_connection.php';

// Check if studentID and status are provided in the request body
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->studentID) && isset($data->status)) {
        // Sanitize input
        $studentID = mysqli_real_escape_string($conn, $data->studentID);
        $status = mysqli_real_escape_string($conn, $data->status);

        // Update student status in the database
        $updateQuery = "UPDATE student SET status='$status' WHERE studentID='$studentID'";

        if (mysqli_query($conn, $updateQuery)) {
            $response = array("success" => true);
            echo json_encode($response);
        } else {
            $response = array("success" => false, "error" => mysqli_error($conn));
            echo json_encode($response);
        }
    } else {
        $response = array("success" => false, "error" => "studentID and status are required");
        echo json_encode($response);
    }
} else {
    $response = array("success" => false, "error" => "Invalid request method");
    echo json_encode($response);
}

// Close database connection
mysqli_close($conn);
?>
