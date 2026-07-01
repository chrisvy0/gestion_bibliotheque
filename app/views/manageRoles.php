<?php
session_start();

// Charge la connexion et le modèle utilisateur qui permet de récupérer la liste des utilisateurs
require_once "../../database.php";
require_once "../models/user.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: /gestion_bibliotheque/index.php");
    exit;
}

// Seul le responsable des prêts peut accéder à la gestion des rôles
if ($_SESSION['role'] != "RP") {
    die("Accès refusé");
}

$users = getAllUsers();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestion des rôles</title>
</head>
<body>

<h1>Gestion des rôles</h1>

<table border="1">

    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Rôle</th>
        <th>Vérifié</th>
        <th>Action</th>
    </tr>

    <?php foreach($users as $user): ?>

    <tr>

        <td><?php echo $user['id']; ?></td>

        <td><?php echo $user['nom']; ?></td>

        <td><?php echo $user['prenom']; ?></td>

        <td><?php echo $user['email']; ?></td>

        <td><?php echo $user['role']; ?></td>

        <td>
            <?php echo ($user['is_verified'] == 1) ? 'Oui' : 'Non'; ?>
        </td>

        <td>

            <form action="../controllers/RoleController.php?action=update_role" method="post">

                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

                <select name="role">
                    <option value="ADHERENT" <?php echo ($user['role'] == 'ADHERENT') ? 'selected' : ''; ?>>ADHERENT</option>
                    <option value="RB" <?php echo ($user['role'] == 'RB') ? 'selected' : ''; ?>>RB</option>
                    <option value="RP" <?php echo ($user['role'] == 'RP') ? 'selected' : ''; ?>>RP</option>
                </select>

                <button type="submit">
                    Modifier
                </button>

            </form>

        </td>

    </tr>

    <?php endforeach; ?>

</table>

<br>

<a href="dashboard_rp.php">
    Retour
</a>

</body>
</html>