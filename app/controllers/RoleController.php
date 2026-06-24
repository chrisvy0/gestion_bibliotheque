<?php
session_start();

require_once "../../database.php";
require_once "../models/user.php";

// Vérifier que c'est un RP
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'RP') {
    header("Location: /gestion_bibliotheque/index.php");
    exit;
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'update_role') {
        updateRole();
    }
}

function updateRole() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userId = (int)$_POST['user_id'];
        $newRole = trim($_POST['role']);
        
        if (empty($userId) || empty($newRole)) {
            die("Données manquantes");
        }
        
        $validRoles = ['ADHERENT', 'RB', 'RP'];
        if (!in_array($newRole, $validRoles)) {
            die("Rôle invalide");
        }
        
        $result = updateUserRole($userId, $newRole);
        
        if ($result) {
            header("Location: /gestion_bibliotheque/app/views/manageRoles.php?success=1");
            exit;
        } else {
            die("Erreur lors de la mise à jour du rôle");
        }
    }
}
?>
