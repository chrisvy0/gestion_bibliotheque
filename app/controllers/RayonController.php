<?php
session_start();
require_once "../../database.php";
require_once "../models/ouvrages.php";

// Contrôleur pour la gestion des rayons depuis le dashboard RB
// L'accès est limité aux utilisateurs responsables de bibliothèque.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'RB') {
    header("Location: /gestion_bibliotheque/index.php");
    exit;
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'create') {
        addRayon();
    } elseif ($_GET['action'] == 'update') {
        updateRayonAction();
    } elseif ($_GET['action'] == 'delete') {
        deleteRayonAction();
    }
}

function addRayon() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $libelle = trim($_POST['libelle'] ?? '');

        if (empty($libelle)) {
            $_SESSION['error'] = "Le nom du rayon est obligatoire";
            header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php");
            exit;
        }

        $result = createRayon($libelle);
        $_SESSION['success'] = $result ? "Rayon créé avec succès !" : "Erreur lors de la création du rayon";
    }
    header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php");
    exit;
}

function updateRayonAction() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = (int)($_POST['id'] ?? 0);
        $libelle = trim($_POST['libelle'] ?? '');

        if ($id <= 0 || empty($libelle)) {
            $_SESSION['error'] = "Données invalides";
            header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php");
            exit;
        }

        $result = updateRayon($id, $libelle);
        $_SESSION['success'] = $result ? "Rayon modifié avec succès !" : "Erreur lors de la modification du rayon";
    }
    header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php");
    exit;
}

function deleteRayonAction() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error'] = "ID invalide";
            header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php");
            exit;
        }

        $result = deleteRayon($id);
        $_SESSION['success'] = $result ? "Rayon supprimé avec succès !" : "Erreur lors de la suppression du rayon";
    }
    header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php");
    exit;
}
?>
