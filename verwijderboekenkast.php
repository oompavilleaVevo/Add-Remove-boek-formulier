<?php
header('Content-Type: application/json');

// Zorg voor een databaseconnectie
include 'connection.php';

// Verkrijg het boek ID van de request
$bookId = $_POST['removeBookId'];

// Controleer of het boek in de boekenkast staat
$sql = "SELECT * FROM bookshelf WHERE book_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $bookId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Boek staat niet in de boekenkast
    echo json_encode(['error' => 'Boek staat niet in de boekenkast.']);
} else {
    // Verwijder het boek uit de boekenkast
    $sql = "DELETE FROM bookshelf WHERE book_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $bookId);
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Boek succesvol verwijderd uit de boekenkast.']);
    } else {
        echo json_encode(['error' => 'Er is een fout opgetreden bij het verwijderen van het boek.']);
    }
}

$stmt->close();
$conn->close();
?>
