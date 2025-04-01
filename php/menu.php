<?php
session_start();

if (!isset($_SESSION['nom_utilisateur'])) {
    header("Location: login.php");
    exit();
}

$error_message = $_SESSION['error_message'] ?? null;
unset($_SESSION['error_message']); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['nom_utilisateur']); ?> !</h1>
    </header>

    <main>
        <?php if ($error_message): ?>
            <div class="error-box">
                <p><?php echo htmlspecialchars($error_message); ?></p>
            </div>
        <?php endif; ?>

        <section>
            <h2>Informations du compte</h2>
            <p><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($_SESSION['nom_utilisateur']); ?></p>
            <p><strong>Email :</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
            <p><strong>ID du grade :</strong> <?php echo htmlspecialchars($_SESSION['grade_id']); ?></p>
            <p><strong>Nom du grade :</strong> <?php echo htmlspecialchars($_SESSION['grade_nom']); ?></p>
        </section>

        <section>
            <h2>Actions disponibles</h2>
            <ul>
                <li><a href="admin.php">Accéder à l'espace admin (si disponible)</a></li>
                <li><a href="logout.php">Se déconnecter</a></li>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Brazatlant.eu</p>
    </footer>
</body>
</html>