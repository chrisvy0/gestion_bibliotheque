<?php
// Paramètres de connexion à la base de données
$server = "localhost";
$port = "3306";
$user = "root";
$password = "";
$dbname = "gestion_bibliothèque";

// Création de la connexion MySQLi utilisée dans toute l'application
// Ce fichier est inclus par les contrôleurs et les vues qui ont besoin
// d'accéder à la base de données.
$connexion = mysqli_connect($server, $user, $password, $dbname, $port);

if(!$connexion){
    // Affiche un message d'erreur si la connexion échoue
    echo "Connexion échoué";
} else {
   // La connexion est établie avec succès.
}
?>
