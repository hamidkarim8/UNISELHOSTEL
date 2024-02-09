<?php
// Establish a database connection (replace these values with your actual database credentials)
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "uniselhostel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the updated memo content from the form
$memo_content = $_POST['memo_content'];

// Update the memo content in the database
$sql = "UPDATE memos SET content='$memo_content' WHERE id=1"; // Assuming you have a table named 'memos' with a column 'content' where the memo content is stored
if ($conn->query($sql) === TRUE) {
    echo "Memo updated successfully";
} else {
    echo "Error updating memo: " . $conn->error;
}

$conn->close();
?>
