<?php
session_start();

$servername = "127.0.0.1:3306";
$username = "u695647153_braza_eu";
$password = "CHKMTob@ep8^vdJ<m+fhq8ZG";
$dbname = "u695647153_bdd_eu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_utilisateur = $_POST['nom_utilisateur'] ?? null;
    $mot_de_passe = $_POST['mot_de_passe'] ?? null;

    if (!$nom_utilisateur || !$mot_de_passe) {
        die("Veuillez remplir tous les champs.");
    }

    // Préparer et exécuter la requête pour éviter les injections SQL
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE nom_utilisateur = ?");
    $stmt->bind_param("s", $nom_utilisateur);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($mot_de_passe, $row['mot_de_passe'])) {
            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['nom_utilisateur'] = $row['nom_utilisateur'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['grade_id'] = $row['grade_id'];

            // Récupérer le nom du grade
            $grade_stmt = $conn->prepare("SELECT grade_nom FROM grades WHERE grade_id = ?");
            $grade_stmt->bind_param("s", $row['grade_id']);
            $grade_stmt->execute();
            $grade_result = $grade_stmt->get_result();
            if ($grade_result->num_rows > 0) {
                $grade_row = $grade_result->fetch_assoc();
                $_SESSION['grade_nom'] = $grade_row['grade_nom'];
            } else {
                $_SESSION['grade_nom'] = "Grade inconnu";
            }

            // Rediriger vers la page principale
            header("Location: menu.php");
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Utilisateur non trouvé.";
    }

    $stmt->close();
}

$conn->close();
?>