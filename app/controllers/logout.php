<?php
// Démarre la session existante
session_start();

// Détruit toutes les données de session pour déconnecter l'utilisateur
session_destroy();

// Redirige vers la page de connexion
header("Location: /gestion_bibliotheque/index.php");
exit;
?>
