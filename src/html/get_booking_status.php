<?php
require_once 'db_connection.php';

session_start();

if (!isset($_SESSION['studentID'])) {
    echo json_encode(array("success" => false, "message" => "User not logged in"));
    exit;
}

$studentID = $_SESSION['studentID'];

$sql = "SELECT bl.*, h.block, h.floor, h.unit, h.roomNumber, s.fullname, DATE_FORMAT(bl.created_at, '%d-%m-%Y %H:%i:%s') AS created_at
        FROM bookingList AS bl
        JOIN hostel AS h ON bl.hostelID = h.hostelID
        JOIN student AS s ON bl.studentID = s.studentID
        WHERE bl.studentID = '$studentID'
        ORDER BY bl.bookingID DESC
        LIMIT 1";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $bookingDetails = $result->fetch_assoc();
    echo json_encode(array("success" => true, "bookingDetails" => $bookingDetails));
} else {
    echo json_encode(array("success" => false, "message" => "No booking details found"));
}

$conn->close();
?>
