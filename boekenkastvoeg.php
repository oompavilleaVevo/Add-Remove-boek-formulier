<?php
header('Content-Type: application/json');
// maakt databaseconnectie
include 'connection.php'; 

if (isset($_POST['bookId']) && isset($_POST['title'])) {
    $bookId = $_POST['bookId'];
    $title = $_POST['title'];

    // SQL-query om boek aan de boekenkast toe te kunnen voegen
    $sql = "INSERT INTO bookshelf (book_ID, title) VALUES ('$bookId', '$title')";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['message' => 'Boek succesvol toegevoegd aan boekenkast.']);
    } else {
        echo json_encode(['message' => 'Fout bij het toevoegen van boek aan de boekenkast.']);
    }
} else {
    echo json_encode(['message' => 'Gegevens niet compleet.']);
}

mysqli_close($conn);
?>
