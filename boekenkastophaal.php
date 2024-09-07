<?php
header('Content-Type: application/json');
// databaseconnectie
include 'connection.php'; 

// bevat alleen ID's van de boeken die in de boekenkast zijn
$sql = "
    SELECT books.id AS book_ID, books.title 
    FROM books 
    INNER JOIN bookshelf 
    ON books.id = bookshelf.book_id";
$result = mysqli_query($conn, $sql);

if (!$result) {
    // Output de fout als de query mislukt
    echo json_encode(['error' => 'Fout in de query: ' . mysqli_error($conn)]);
    exit();
}
$bookshelf = [];
while ($row = mysqli_fetch_assoc($result)) {
    $bookshelf[] = $row;
}

if (empty($bookshelf)) {
    echo json_encode(['message' => 'Geen boeken gevonden in de boekenkast.']);
} else {
    echo json_encode($bookshelf);
}

mysqli_close($conn);
?>
