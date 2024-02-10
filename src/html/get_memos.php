<?php
// Include the database connection file
include 'db_connection.php';

// Function to fetch memos from the database
// Function to fetch memos from the database
function getMemosFromDatabase($conn) {
    // SQL query to fetch memos
    $sql = "SELECT sender, recipient, DATE_FORMAT(date, '%d-%m-%Y') as date, content, greeting FROM memos ORDER BY memoID DESC LIMIT 1";

    $result = $conn->query($sql);

    $memos = [];

    if ($result->num_rows > 0) {
        // Fetch each row from the result set
        while ($row = $result->fetch_assoc()) {
            // Convert sender and recipient to uppercase
            $row['sender'] = strtoupper($row['sender']);
            $row['recipient'] = strtoupper($row['recipient']);

            // Add each memo to the $memos array
            $memos[] = $row;
        }
    }

    return $memos;
}


// Call the function to get memos from the database
$memos = getMemosFromDatabase($conn);

// Encode the memos array as JSON and output it
// echo json_encode($memos);

// Close the database connection
$conn->close();
?>
