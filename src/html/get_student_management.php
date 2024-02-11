<?php
include_once 'db_connection.php';

$students = array();

$sql = "SELECT student.fullname, student.studentID, hostel.block, hostel.floor, hostel.unit, hostel.roomNumber, student.status, student.blacklist 
        FROM student 
        LEFT JOIN bookingList ON student.studentID = bookingList.studentID 
        LEFT JOIN hostel ON hostel.hostelID = bookingList.hostelID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Concatenate block, floor, unit, and roomNumber into a single string
        if (!empty($row['block']) && !empty($row['floor']) && !empty($row['unit']) && !empty($row['roomNumber'])) {
            $room = $row['block'][6] . '-' . $row['floor'][0] . $row['floor'][6] . '-' . $row['unit'][0] . $row['unit'][5] . '-' . $row['roomNumber'][0] . $row['roomNumber'][5];
            $row['room'] = $room;
        } else {
            $row['room'] = '<span style="color:red;">No Booking Record</span>';
        }
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
