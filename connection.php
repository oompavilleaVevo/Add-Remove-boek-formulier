<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bibliotheek";

// Maakt verbinding met de database
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Verbinding mislukt: " . mysqli_connect_error());
}
?>
