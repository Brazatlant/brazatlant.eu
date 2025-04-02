<?php
session_start();

$servername = "127.0.0.1:3306";
$username = "u695647153_braza_eu";
$password = "CHKMTob@ep8^vdJ<m+fhq8ZG";
$dbname = "u695647153_bdd_eu";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom_utilisateur = trim($_POST['username'] ?? '');
    $mot_de_passe = trim($_POST['password'] ?? '');

    // Vérifier que les champs ne sont pas vides
    if (empty($nom_utilisateur) || empty($mot_de_passe)) {
        die("Veuillez remplir tous les champs.");
    }

    // Préparer et exécuter la requête pour éviter les injections SQL
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE nom_utilisateur = ?");
    if (!$stmt) {
        die("Erreur lors de la préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param("s", $nom_utilisateur);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si l'utilisateur existe
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Vérifier le mot de passe
        if (password_verify($mot_de_passe, $row['mot_de_passe'])) {
            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['nom_utilisateur'] = $row['nom_utilisateur'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['grade_id'] = $row['grade_id'];

            // Récupérer le nom du grade
            $grade_stmt = $conn->prepare("SELECT grade_nom FROM grades WHERE grade_id = ?");
            if ($grade_stmt) {
                $grade_stmt->bind_param("s", $row['grade_id']);
                $grade_stmt->execute();
                $grade_result = $grade_stmt->get_result();
                if ($grade_result->num_rows > 0) {
                    $grade_row = $grade_result->fetch_assoc();
                    $_SESSION['grade_nom'] = $grade_row['grade_nom'];
                } else {
                    $_SESSION['grade_nom'] = "Grade inconnu";
                }
                $grade_stmt->close();
            }

            // Rediriger vers la page principale
            header("Location: ../index.html");
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Nom d'utilisateur non trouvé.";
    }

    $stmt->close();
}

// Fermer la connexion à la base de données
$conn->close();
?>