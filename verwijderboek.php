<?php
header('Content-Type: application/json');

// databaseconnectie
include 'connection.php'; 


$bookId = $_POST['deleteBookId'];

// checkt of de boek_ID in de boeken tabel bestaat
$sql = "SELECT * FROM books WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $bookId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'Boek ID niet gevonden.']);
    exit;
}

// boek verwijderen
$sql = "DELETE FROM books WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $bookId);

if ($stmt->execute()) {

    echo json_encode(['message' => 'Boek succesvol verwijderd.']);
} else {
    echo json_encode(['error' => 'Er is een fout opgetreden bij het verwijderen van het boek.']);
}

$stmt->close();
$conn->close();
?>
