<?php
// Configuration de la base de données
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

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et valider les données du formulaire
    $nom_utilisateur = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['password'] ?? '';
    $confirm_mot_de_passe = $_POST['confirmPassword'] ?? '';
    $grade_id = '000001'; // ID par défaut pour les nouveaux utilisateurs

    // Vérifier que tous les champs sont remplis
    if (empty($nom_utilisateur) || empty($email) || empty($mot_de_passe) || empty($confirm_mot_de_passe)) {
        die("Veuillez remplir tous les champs.");
    }

    // Vérifier que les mots de passe correspondent
    if ($mot_de_passe !== $confirm_mot_de_passe) {
        die("Les mots de passe ne correspondent pas.");
    }

    // Vérifier si l'email est valide
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Adresse email invalide.");
    }

    // Vérifier si le nom d'utilisateur ou l'email existe déjà
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE nom_utilisateur = ? OR email = ?");
    if (!$stmt) {
        die("Erreur lors de la préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param("ss", $nom_utilisateur, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("Nom d'utilisateur ou email déjà utilisé.");
    }
    $stmt->close();

    // Hacher le mot de passe
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_BCRYPT);

    // Insérer les données dans la base de données
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe, date_creation, grade_id) VALUES (?, ?, ?, NOW(), ?)");
    if (!$stmt) {
        die("Erreur lors de la préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param("ssss", $nom_utilisateur, $email, $mot_de_passe_hache, $grade_id);

    if ($stmt->execute()) {
        echo "Compte créé avec succès !";
        header("Location: login.html"); // Rediriger vers la page de connexion
        exit();
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}

// Fermer la connexion à la base de données
$conn->close();
?>