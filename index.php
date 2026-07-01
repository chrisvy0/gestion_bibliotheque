<?php
// Démarre ou récupère la session utilisateur
session_start();

// Inclut la connexion à la base de données et les fonctions utilisateur
require_once "database.php";
require_once "app/models/user.php";

// Si un utilisateur est déjà connecté, on le redirige directement vers
// le dashboard correspondant à son rôle.
if (isset($_SESSION['user_id'])) {
    header("Location: /gestion_bibliotheque/dashboard.php");
    exit;
}

// Sinon, on affiche la page de connexion.
require_once "app/views/login.php";
?>
