<?php

session_start();

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: /gestion_bibliotheque/app/views/login.php");
    exit;
}

// Récupération du rôle
$role = $_SESSION['role'];

// Redirection selon le rôle
switch ($role) {

    case 'ADHERENT':
        header("Location: /gestion_bibliotheque/app/views/dashboard_adherent.php");
        exit;

    case 'RB':
        header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php");
        exit;

    case 'RP':
        header("Location: /gestion_bibliotheque/app/views/dashboard_rp.php");
        exit;

    default:
        die("Rôle inconnu.");
}