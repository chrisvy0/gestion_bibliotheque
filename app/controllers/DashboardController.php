<?php

// Démarre ou récupère la session utilisateur
session_start();

// Vérifie que l'utilisateur est connecté avant de rediriger
if (!isset($_SESSION['user_id'])) {
    header("Location: /gestion_bibliotheque/app/views/login.php");
    exit;
}

// On récupère le rôle stocké en session
$role = $_SESSION['role'];

// Redirige vers le dashboard correspondant au rôle utilisateur
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
