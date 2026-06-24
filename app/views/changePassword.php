<?php
// On démarre la session pour vérifier qui est connecté
session_start();

// S'il n'y a pas de session utilisateur ouverte, on le renvoie au login
if (!isset($_SESSION['user_id'])) {
    header("Location: /gestion_bibliotheque/app/views/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Changement de mot de passe obligatoire</title>
</head>
<body>
    <h2>Première connexion : Veuillez changer votre mot de passe</h2>
    <p>Bonjour <?php echo htmlspecialchars($_SESSION['prenom']); ?>, pour la sécurité de votre compte de bibliothèque, vous devez modifier votre mot de passe temporaire.</p>

    <!-- Le formulaire envoie les données vers le contrôleur -->
    <form action="/gestion_bibliotheque/app/controllers/loginController.php?action=update_password" method="post">
        
        <label for="new_password">Nouveau mot de passe :</label>
        <input type="password" name="new_password" required><br><br>

        <label for="confirm_password">Confirmer le mot de passe :</label>
        <input type="password" name="confirm_password" required><br><br>

        <button type="submit">Mettre à jour mon mot de passe</button>
    </form>
</body>
</html>