<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $to = "jesuisdanstacave@gmail.com";
    $subject = "Contact Form Submission from $name";
    $body = "Nom: $name\n";
    $body .= "Email: $email\n";
    $body .= "Message:\n$message\n";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(["success" => true, "message" => "Message envoyé avec succès !"]);
    } else {
        echo json_encode(["success" => false, "message" => "Échec de l'envoi du message."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Méthode de requête non valide."]);
}
?>
