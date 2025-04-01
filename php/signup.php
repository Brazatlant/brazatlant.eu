<?php
$servername = "127.0.0.1:3306";
$username = "u695647153_braza_eu";
$password = "CHKMTob@ep8^vdJ<m+fhq8ZG";
$dbname = "u695647153_bdd_eu";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$nom_utilisateur = $_POST['nom_utilisateur'];
$email = $_POST['email'];
$mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);
$grade_id = '000001';

$stmt = $conn->prepare("INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe, date_creation, grade_id) VALUES (?, ?, ?, NOW(), ?)");
$stmt->bind_param("ssss", $nom_utilisateur, $email, $mot_de_passe, $grade_id);

if ($stmt->execute()) {
    echo "Compte créé avec succès !";
} else {
    echo "Erreur : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>