<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] != 'RP') {
    die("Accès refusé");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Responsable des Prêts</title>
</head>
<body>

<h1>Dashboard Responsable des Prêts</h1>

<p>Bienvenue <?= htmlspecialchars($_SESSION['prenom']); ?></p>

<p>Utilisez ce tableau de bord pour gérer les rôles et suivre les prêts.</p>

<ul>
    <li><a href="/gestion_bibliotheque/app/views/manageRoles.php">Gérer les rôles</a></li>
    <li>Voir les demandes de prêt</li>
    <li>Valider un prêt</li>
    <li>Enregistrer un retour</li>
    <li>Voir les retardataires</li>
</ul>

<br><br>

<a href="/gestion_bibliotheque/app/controllers/logout.php">Déconnexion</a>

</body>
</html>