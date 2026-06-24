<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] != 'RB') {
    die("Accès refusé");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Responsable Bibliothèque</title>
</head>
<body>

<h1>Dashboard Responsable Bibliothèque</h1>

<p>Bienvenue <?= $_SESSION['prenom']; ?></p>

<ul>
    <li>Gérer les rayons</li>
    <li>Gérer les auteurs</li>
    <li>Gérer les ouvrages</li>
    <li>Gérer les exemplaires</li>
</ul>

<br><br>

<a href="/gestion_bibliotheque/app/controllers/logout.php">Déconnexion</a>

</body>
</html>