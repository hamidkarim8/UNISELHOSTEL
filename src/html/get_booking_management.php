<?php
include_once 'db_connection.php';

$students = array();

$sql = "SELECT bookinglist.bookingID, student.fullname, student.studentID, hostel.block, hostel.floor, hostel.unit, hostel.roomNumber, bookinglist.status, bookinglist.created_at FROM student JOIN bookinglist ON student.studentID = bookinglist.studentID JOIN hostel ON hostel.hostelID = bookinglist.hostelID WHERE student.studentID = bookinglist.studentID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Convert the created_at date to "dd-mm-yyyy" format
        $created_at = date_create($row['created_at']);
        $formatted_date = date_format($created_at, 'd-m-Y H:i:s'); // Include time as well

        // Concatenate block, floor, unit, and roomNumber into a single string
        $room = $row['block'][6] . '-' . $row['floor'][0] . $row['floor'][6] . '-' . $row['unit'][0] . $row['unit'][5] . '-' . $row['roomNumber'][0] . $row['roomNumber'][5];
        
        // Add formatted date and room to the row
        $row['created_at'] = $formatted_date;
        $row['room'] = $room;
        
        $students[] = $row;
    }
    // Output JSON response
    echo json_encode($students);
} else {
    // Output JSON response for no students found
    echo json_encode(array("message" => "No students found"));
}

$conn->close();
?>
