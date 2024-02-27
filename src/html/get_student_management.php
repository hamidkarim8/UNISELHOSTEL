<?php
include_once 'db_connection.php';

$students = array();

$sql = "SELECT 
student.fullname, 
student.studentID, 
hostel.block, 
hostel.floor, 
hostel.unit, 
hostel.roomNumber, 
student.status, 
student.blacklist, 
IFNULL(bookinglist.status, 'No Booking Record') AS bookingStatus 
FROM 
student 
LEFT JOIN 
bookinglist ON student.studentID = bookinglist.studentID 
LEFT JOIN 
hostel ON hostel.hostelID = bookinglist.hostelID
WHERE 
bookinglist.bookingID IN (
    SELECT MAX(bookingID) 
    FROM bookinglist 
    GROUP BY studentID
) OR bookinglist.bookingID IS NULL;
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Concatenate block, floor, unit, and roomNumber into a single string
        if (!empty($row['block']) && !empty($row['floor']) && !empty($row['unit']) && !empty($row['roomNumber']) && $row['bookingStatus']=='APPROVED') {
            $room = $row['block'][6] . '-' . $row['floor'][0] . $row['floor'][6] . '-' . $row['unit'][0] . $row['unit'][5] . '-' . $row['roomNumber'][0] . $row['roomNumber'][5];
            $row['room'] = '<span style="color:green;">' . $room . '<br>(APPROVED)</span>';
        }elseif (!empty($row['block']) && !empty($row['floor']) && !empty($row['unit']) && !empty($row['roomNumber']) && $row['bookingStatus']=='REJECTED') {
            $room = $row['block'][6] . '-' . $row['floor'][0] . $row['floor'][6] . '-' . $row['unit'][0] . $row['unit'][5] . '-' . $row['roomNumber'][0] . $row['roomNumber'][5];
            $row['room'] = '<span style="color:red;">' . $room . '<br>(REJECTED)</span>';
        }
        elseif (!empty($row['block']) && !empty($row['floor']) && !empty($row['unit']) && !empty($row['roomNumber']) && $row['bookingStatus']=='PENDING') {
            $room = $row['block'][6] . '-' . $row['floor'][0] . $row['floor'][6] . '-' . $row['unit'][0] . $row['unit'][5] . '-' . $row['roomNumber'][0] . $row['roomNumber'][5];
            $row['room'] = '<span">' . $room . '<br>(PENDING)</span>';
        }
         else {
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
