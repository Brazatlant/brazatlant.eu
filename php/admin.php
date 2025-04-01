<!-- filepath: c:\Users\pance\OneDrive\Documents\GitHub\brazatlant.eu\php\admin.php -->
<?php
session_start();

// Vérifier si l'utilisateur est connecté et s'il a le grade "admin"
if (!isset($_SESSION['nom_utilisateur']) || $_SESSION['grade_id'] !== '000002') {
    // Stocker un message d'erreur dans la session
    $_SESSION['error_message'] = "Vous n'avez pas l'autorisation d'accéder à cette page.";
    // Rediriger vers la page menu.php
    header("Location: menu.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Gestion - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Bienvenue sur la page de gestion</h1>
        <p>Connecté en tant qu'administrateur : <?php echo htmlspecialchars($_SESSION['nom_utilisateur']); ?></p>
        <a href="logout.php">Se déconnecter</a>
    </header>

    <main>
        <section>
            <h2>Gestion des utilisateurs</h2>
            <p>Ajoutez ici des fonctionnalités pour gérer les utilisateurs, comme les supprimer ou modifier leurs grades.</p>
        </section>

        <section>
            <h2>Autres outils d'administration</h2>
            <p>Ajoutez ici d'autres outils pour l'administration du site.</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Brazatlant.eu</p>
    </footer>
</body>
</html>