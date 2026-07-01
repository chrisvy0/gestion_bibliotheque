<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] != 'ADHERENT') {
    die("Accès refusé");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

<h1>Dashboard</h1>

<p><strong>Nom :</strong> <?= htmlspecialchars($_SESSION['nom']) ?></p>
<p><strong>Prénom :</strong> <?= htmlspecialchars($_SESSION['prenom']) ?></p>
<p><strong>Email :</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
<p><strong>Rôle :</strong> <?= htmlspecialchars($_SESSION['role']) ?></p>

<h3>Photo de profil</h3>

<?php if (!empty($_SESSION['photo'])): ?>
    <img src="/gestion_bibliotheque/uploads/<?= htmlspecialchars($_SESSION['photo']) ?>" width="150" alt="Photo de profil">
<?php else: ?>
    <p>Aucune photo</p>
<?php endif; ?>

<br><br>

<a href="/gestion_bibliotheque/app/controllers/logout.php">Déconnexion</a>

</body>
</html>