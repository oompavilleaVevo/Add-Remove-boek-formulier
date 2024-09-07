<?php
header('Content-Type: application/json');

// databaseconnectie
include 'connection.php'; 
$sql = "SELECT id AS book_ID, title FROM books";  // Zet id om naar book_ID
$result = mysqli_query($conn, $sql);

$books = [];
while ($row = mysqli_fetch_assoc($result)) {
    $books[] = $row;
}
echo json_encode($books);
mysqli_close($conn);
?>
