<?php
// Database connection
$mysqli = new mysqli("localhost", "root", "", "bibliotheek");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Retrieve form data
$bookData = new stdClass();
$bookData->title = $_POST['title'];
$bookData->subtitle = $_POST['subtitle'];
$bookData->pageCount = $_POST['pageCount'];
$bookData->author = $_POST['author'];
$bookData->publisher = $_POST['publisher'];
$bookData->isbn = $_POST['isbn'];
$bookData->edition = $_POST['edition'];
$bookData->summary = $_POST['summary'];
$bookData->content = $_POST['content'];

// Prepare and bind
$stmt = $mysqli->prepare("INSERT INTO books (title, subtitle, pageCount, author, publisher, isbn, edition, summary, content) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt === false) {
    die("Prepare failed: " . $mysqli->error);
}

$stmt->bind_param("ssisissss", 
    $bookData->title, 
    $bookData->subtitle, 
    $bookData->pageCount, 
    $bookData->author, 
    $bookData->publisher, 
    $bookData->isbn, 
    $bookData->edition, 
    $bookData->summary, 
    $bookData->content
);

$response = new stdClass();
if ($stmt->execute()) {
    // Get the last inserted ID
    $book_id = $stmt->insert_id;
    $response->message = "Boek succesvol opgeslagen.";
    $response->book_id = $book_id;
    $response->book_data = $bookData;
} else {
    $response->message = "Er is een fout opgetreden bij het opslaan van het boek.";
    $response->error = $stmt->error;
}

$stmt->close();
$mysqli->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
