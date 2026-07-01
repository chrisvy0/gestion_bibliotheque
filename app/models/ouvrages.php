<?php
// Compte le nombre total de rayons enregistrés
function countRayons() {
    global $connexion;
    $sql = "SELECT COUNT(*) AS total FROM rayon";
    $result = mysqli_query($connexion, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

// Compte le nombre total d'ouvrages enregistrés
function countOuvrages() {
    global $connexion;
    $sql = "SELECT COUNT(*) AS total FROM ouvrage";
    $result = mysqli_query($connexion, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function countAuteurs() {
    global $connexion;
    $sql = "SELECT COUNT(*) AS total FROM auteur";
    $result = mysqli_query($connexion, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function countExemplairesDisponibles() {
    global $connexion;
    $sql = "SELECT COUNT(*) AS total FROM exemplaire WHERE statut = 'disponible'";
    $result = mysqli_query($connexion, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}
// Récupère les ouvrages récents avec leur rayon et photo
function getOuvragesRecents($limite = 5) {
    global $connexion;
    $sql = "SELECT o.id, o.titre, o.code, o.date_edition, o.photo, r.libelle AS rayon
            FROM ouvrage o
            JOIN rayon r ON o.rayon_id = r.id
            ORDER BY o.id DESC
            LIMIT ?";
    $stmt = mysqli_prepare($connexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $limite);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $ouvrages = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $ouvrages[] = $row;
    }
    return $ouvrages;
}

// Crée un nouvel ouvrage et retourne son ID
function createOuvrage($titre, $code, $rayon_id, $date_edition = null, $photo = null) {
    global $connexion;
    $sql = "INSERT INTO ouvrage (titre, code, rayon_id, date_edition, photo) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connexion, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssiss", $titre, $code, $rayon_id, $date_edition, $photo);
        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            $ouvrage_id = mysqli_insert_id($connexion);
            mysqli_stmt_close($stmt);
            return $ouvrage_id;
        }
        mysqli_stmt_close($stmt);
    }
    return false;
}

function getRayons() {
    global $connexion;
    $sql = "SELECT * FROM rayon ORDER BY libelle ASC";
    $result = mysqli_query($connexion, $sql);
    $rayons = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rayons[] = $row;
    }
    return $rayons;
}

function getAuteurs() {
    global $connexion;
    $sql = "SELECT * FROM auteur ORDER BY nom ASC";
    $result = mysqli_query($connexion, $sql);
    $auteurs = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $auteurs[] = $row;
    }
    return $auteurs;
}

function createExemplaires($ouvrage_id, $nombre) {
    global $connexion;
    for ($i = 0; $i < $nombre; $i++) {
        $sql = "INSERT INTO exemplaire (ouvrage_id, statut) VALUES (?, 'disponible')";
        $stmt = mysqli_prepare($connexion, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $ouvrage_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
    return true;
}

// Gestion des Rayons
function createRayon($libelle) {
    global $connexion;
    $sql = "INSERT INTO rayon (libelle) VALUES (?)";
    $stmt = mysqli_prepare($connexion, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $libelle);
        $result = mysqli_stmt_execute($stmt);
        $id = mysqli_insert_id($connexion);
        mysqli_stmt_close($stmt);
        return $result ? $id : false;
    }
    return false;
}

function updateRayon($id, $libelle) {
    global $connexion;
    $sql = "UPDATE rayon SET libelle = ? WHERE id = ?";
    $stmt = mysqli_prepare($connexion, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $libelle, $id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }
    return false;
}

function deleteRayon($id) {
    global $connexion;
    $sql = "DELETE FROM rayon WHERE id = ?";
    $stmt = mysqli_prepare($connexion, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }
    return false;
}

// Gestion des Auteurs
function createAuteur($nom, $prenom = null) {
    global $connexion;
    $sql = "INSERT INTO auteur (nom, prenom) VALUES (?, ?)";
    $stmt = mysqli_prepare($connexion, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $nom, $prenom);
        $result = mysqli_stmt_execute($stmt);
        $id = mysqli_insert_id($connexion);
        mysqli_stmt_close($stmt);
        return $result ? $id : false;
    }
    return false;
}

function updateAuteur($id, $nom, $prenom = null) {
    global $connexion;
    $sql = "UPDATE auteur SET nom = ?, prenom = ? WHERE id = ?";
    $stmt = mysqli_prepare($connexion, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssi", $nom, $prenom, $id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }
    return false;
}

function deleteAuteur($id) {
    global $connexion;
    $sql = "DELETE FROM auteur WHERE id = ?";
    $stmt = mysqli_prepare($connexion, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }
    return false;
}
?>