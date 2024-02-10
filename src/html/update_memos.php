<?php
// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $memo_from = $_POST['memo_from'];
    $memo_to = $_POST['memo_to'];
    $memo_date = $_POST['memo_date'];
    $memo_content = $_POST['memo_content'];
    $memo_greeting = $_POST['memo_greeting'];

    // Include the database connection file
    include 'db_connection.php';

    // Prepare SQL statement to insert memo
    $sql = "INSERT INTO memos (sender, recipient, date, content, greeting) VALUES ('$memo_from', '$memo_to', '$memo_date', '$memo_content', '$memo_greeting')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "Memo inserted successfully";
    } else {
        echo "Error inserting memo: " . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
