<?php
session_start();
require_once "database.php";
require_once "app/models/user.php";

// Si l'utilisateur est déjà connecté, rediriger vers le dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: /gestion_bibliotheque/dashboard.php");
    exit;
}

// Sinon, afficher la page de login
require_once "app/views/login.php";
?>