<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "127.0.0.1";
$username = "u695647153_braza_eu";
$password = "CHKMTob@ep8^vdJ<m+fhq8ZG";
$dbname = "u695647153_bdd_eu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
} else {
    echo "Connexion réussie à la base de données.";
}

$conn->close();
?>