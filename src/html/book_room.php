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

        // Check if the student has a booking with approved or pending status
        $bookingQuery = "SELECT * FROM bookinglist WHERE studentID='$studentID' ORDER BY created_At DESC LIMIT 1";
        $bookingResult = mysqli_query($conn, $bookingQuery);

        if ($bookingResult) {
            if (mysqli_num_rows($bookingResult) > 0) {
                $bookingData = mysqli_fetch_assoc($bookingResult);
                $bookingStatus = $bookingData['status'];

                if ($bookingStatus === 'APPROVED' || $bookingStatus === 'PENDING') {
                    // If the booking status is approved or pending, don't allow booking
                    $response = array("success" => false, "message" => "Failed! You already made a booking with status: $bookingStatus");
                    echo json_encode($response);
                    exit;
                }
            }
        } else {
            // Error handling for the booking query
            $response = array("success" => false, "error" => "Failed to fetch booking information: " . mysqli_error($conn));
            echo json_encode($response);
            exit;
        }

        // Update room status in the database
        $updateQuery = "UPDATE hostel SET status='Unavailable', bookedBy='$studentID' WHERE hostelID='$hostelID'";

        // Insert booking information into bookinglist table
        $insertQuery = "INSERT INTO bookinglist (hostelID, studentID, created_At, status) VALUES ('$hostelID', '$studentID', NOW(),'PENDING')";

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
