<?php
include 'db_connection.php';

// Check if bookingID is provided in the request body
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->bookingID)) {
        // Sanitize input
        $bookingID = mysqli_real_escape_string($conn, $data->bookingID);

        // Update booking status in the database
        $updateQuery = "UPDATE bookingList SET status='REJECTED' WHERE bookingID='$bookingID'";

        // Add query to set bookedBy to NULL in hostel table
        $updateHostelQuery = "UPDATE hostel 
                              INNER JOIN bookingList ON hostel.hostelID = bookingList.hostelID
                              SET hostel.bookedBy = NULL, hostel.status = 'Available'
                              WHERE bookingList.bookingID = '$bookingID'";

        if (mysqli_query($conn, $updateQuery) && mysqli_query($conn, $updateHostelQuery)) {
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
