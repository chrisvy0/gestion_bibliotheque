<?php
session_start();
require_once "../../database.php";
require_once "../models/ouvrages.php";

// Contrôleur pour gérer les auteurs depuis le dashboard RB
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'RB') {
    header("Location: /gestion_bibliotheque/index.php");
    exit;
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'create') {
        addAuteur();
    } elseif ($_GET['action'] == 'update') {
        updateAuteurAction();
    } elseif ($_GET['action'] == 'delete') {
        deleteAuteurAction();
    }
}

function addAuteur() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');

        if (empty($nom)) {
            $_SESSION['error'] = "Le nom de l'auteur est obligatoire";
            header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php");
            exit;
        }

        $result = createAuteur($nom, $prenom ?: null);
        $_SESSION['success'] = $result ? "Auteur créé avec succès !" : "Erreur lors de la création de l'auteur";
    }
    header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php");
    exit;
}

function updateAuteurAction() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = (int)($_POST['id'] ?? 0);
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');

        if ($id <= 0 || empty($nom)) {
            $_SESSION['error'] = "Données invalides";
            header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php");
            exit;
        }

        $result = updateAuteur($id, $nom, $prenom ?: null);
        $_SESSION['success'] = $result ? "Auteur modifié avec succès !" : "Erreur lors de la modification de l'auteur";
    }
    header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php");
    exit;
}

function deleteAuteurAction() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error'] = "ID invalide";
            header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php");
            exit;
        }

        $result = deleteAuteur($id);
        $_SESSION['success'] = $result ? "Auteur supprimé avec succès !" : "Erreur lors de la suppression de l'auteur";
    }
    header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php");
    exit;
}
?>
