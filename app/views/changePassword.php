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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changement de mot de passe obligatoire</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="flex flex-col items-center justify-center w-screen h-screen bg-gray-200 text-gray-700">
    <!-- Component Start -->
    <h1 class="font-bold text-2xl mb-4">Changement de mot de passe</h1>
    <p class="text-center mb-6 max-w-md text-sm">Bonjour <span class="font-semibold"><?php echo htmlspecialchars($_SESSION['prenom']); ?></span>, pour la sécurité de votre compte, veuillez modifier votre mot de passe.</p>

    <!-- Le formulaire envoie les données vers le contrôleur -->
    <form class="flex flex-col bg-white rounded shadow-lg p-12 mt-4" action="/gestion_bibliotheque/app/controllers/loginController.php?action=update_password" method="post">
        
        <label class="font-semibold text-xs" for="new_password">Nouveau mot de passe</label>
        <input class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="password" id="new_password" name="new_password" required>

        <label class="font-semibold text-xs mt-3" for="confirm_password">Confirmer le mot de passe</label>
        <input class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit" class="flex items-center justify-center h-12 px-6 w-64 bg-blue-600 mt-8 rounded font-semibold text-sm text-blue-100 hover:bg-blue-700">Mettre à jour</button>
    </form>
    <!-- Component End -->
</body>
</html>