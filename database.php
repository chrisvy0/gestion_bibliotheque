<?php
$server = "localhost";
$port = "3306";
$user = "root";
$password = "";
$dbname = "gestion_bibliothèque";

$connexion = mysqli_connect($server, $user, $password, $dbname, $port);

if(!$connexion){
    echo "Connexion échoué";
}else{
   // echo "Success";
} 
?>