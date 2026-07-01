<?php
session_start();
require_once "../../database.php";
require_once "../models/ouvrages.php";

// Ce contrôleur gère l'ajout d'un ouvrage depuis le dashboard RB
// et empêche l'accès direct à un utilisateur non RB.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'RB') {
    header("Location: /gestion_bibliotheque/index.php");
    exit;
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'create') {
        addOuvrage();
    }
}

function addOuvrage() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupération des valeurs du formulaire
        $titre = trim($_POST['titre'] ?? '');
        $code = trim($_POST['code'] ?? '');
        $rayon_id = (int)($_POST['rayon_id'] ?? 0);
        $date_edition = trim($_POST['date_edition'] ?? '');
        $nb_exemplaires = (int)($_POST['nb_exemplaires'] ?? 0);
        $photoName = null;

        // Validation des champs obligatoires
        if (empty($titre) || empty($code) || $rayon_id <= 0 || $nb_exemplaires <= 0) {
            $_SESSION['error'] = "Veuillez remplir tous les champs obligatoires";
            header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php?view=add_ouvrage");
            exit;
        }

        // Gestion du fichier image si un fichier a été envoyé
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
            $extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($extension, $allowedExtensions)) {
                $photoName = time() . "_" . uniqid() . "." . $extension;
                $destination = "../../uploads/" . $photoName;
                move_uploaded_file($_FILES['photo']['tmp_name'], $destination);
            } else {
                $_SESSION['error'] = "Format de photo non autorisé";
                header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php?view=add_ouvrage");
                exit;
            }
        }

        // Ajoute l'ouvrage en base de données
        $ouvrage_id = createOuvrage($titre, $code, $rayon_id, $date_edition ?: null, $photoName);

        if ($ouvrage_id) {
            // Crée les exemplaires associés selon le nombre choisi
            if ($nb_exemplaires > 0) {
                createExemplaires($ouvrage_id, $nb_exemplaires);
            }
            $_SESSION['success'] = "Ouvrage créé avec succès avec $nb_exemplaires exemplaire(s) !";
            header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php");
            exit;
        } else {
            $_SESSION['error'] = "Erreur lors de la création de l'ouvrage";
            header("Location: /gestion_bibliotheque/app/views/dashboard_rb.php?view=add_ouvrage");
            exit;
        }
    }
}
?>
