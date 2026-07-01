<?php
function countRayons() {
    global $connexion;
    $sql = "SELECT COUNT(*) AS total FROM rayon";
    $result = mysqli_query($connexion, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

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
function getOuvragesRecents($limite = 5) {
    global $connexion;
    $sql = "SELECT o.titre, o.code, r.libelle AS rayon,
                   COUNT(e.id) AS nb_exemplaires
            FROM ouvrage o
            JOIN rayon r ON o.rayon_id = r.id
            LEFT JOIN exemplaire e ON e.ouvrage_id = o.id
            GROUP BY o.id
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