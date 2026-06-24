<?php
session_start();

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: /gestion_bibliotheque/index.php");
    exit;
}

// Récupération du rôle
$role = $_SESSION['role'];

// Redirection selon le rôle
switch ($role) {
    case 'ADHERENT':
        include "app/views/dashboard_adherent.php";
        break;

    case 'RB':
        include "app/views/dashboard_rb.php";
        break;

    case 'RP':
        include "app/views/dashboard_rp.php";
        break;

    default:
        session_destroy();
        die("Rôle inconnu. Veuillez vous reconnecter.");
}
?>
