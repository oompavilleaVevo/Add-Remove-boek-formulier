<?php

// Zorgt voor een databaseconnectie
include 'connection.php'; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO books (title, subtitle, pageCount, author, publisher, isbn, edition, summary, content) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssissssss", $title, $subtitle, $pageCount, $author, $publisher, $isbn, $edition, $summary, $content);

// Set parameters and execute
$title = $_POST['title'];
$subtitle = $_POST['subtitle'];
$pageCount = $_POST['pageCount'];
$author = $_POST['author'];
$publisher = $_POST['publisher'];
$isbn = $_POST['isbn'];
$edition = $_POST['edition'];
$summary = $_POST['summary'];
$content = $_POST['content'];

if ($stmt->execute()) {
    echo "New book record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
