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
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/contact.css">
    <script defer src="/js/menui.js"></script>
</head>
    <header>
        <div class="logo">Braza Site</div>  
        <nav>
            <ul id="menu"></ul>
        </nav>
    </header>
    <body>
    <main>
        <h1>Informations du compte</h1>
        <form id="contactForm" action="../php/send_mail.php" method="post" enctype="multipart/form-data" class="contact-form">
            <label for="name">Nom d'utilisateur</label>
            <p></strong><?php echo htmlspecialchars($_SESSION['nom_utilisateur']); ?></p>
            
            <label for="email">Email:</label>
            <p></strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
            
            <label for="grade">ID du grade</label>
            <p></strong> <?php echo htmlspecialchars($_SESSION['grade_id']); ?></p>

            <label for="grade">Nom du grade:</label>
            <p></strong> <?php echo htmlspecialchars($_SESSION['grade_nom']); ?></p>
            
            <button type="submit">Se déconnecter</button>
        </form>

        <div id="popup" class="popup hidden">
            <div class="popup-content">
                <p id="popup-message"></p>
            </div>
        </div>
    </main>

</body>
</html>