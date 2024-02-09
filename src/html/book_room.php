<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['studentID'])) {
    echo json_encode(array("success" => false, "message" => "User not logged in"));
    exit;
}

// Check if hostelID is provided in the request body
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->hostelID)) {
        // Get the studentID from the session
        $studentID = $_SESSION['studentID'];
        // Sanitize input
        $hostelID = mysqli_real_escape_string($conn, $data->hostelID);

        // Update room status in the database
        $updateQuery = "UPDATE hostel SET status='Unavailable', bookedBy='$studentID' WHERE hostelID='$hostelID'";

        // Insert booking information into bookingList table
        $insertQuery = "INSERT INTO bookingList (hostelID, studentID, created_At, status) VALUES ('$hostelID', '$studentID', NOW(),'PENDING')";

        // Perform the update query
        if (mysqli_query($conn, $updateQuery)) {
            // Perform the insert query
            if (mysqli_query($conn, $insertQuery)) {
                $response = array("success" => true);
                echo json_encode($response);
            } else {
                $response = array("success" => false, "error" => "Failed to insert booking information: " . mysqli_error($conn));
                echo json_encode($response);
            }
        } else {
            $response = array("success" => false, "error" => "Failed to update room status: " . mysqli_error($conn));
            echo json_encode($response);
        }
    } else {
        $response = array("success" => false, "error" => "hostelID is required");
        echo json_encode($response);
    }
} else {
    $response = array("success" => false, "error" => "Invalid request method");
    echo json_encode($response);
}

// Close database connection
mysqli_close($conn);
?>
