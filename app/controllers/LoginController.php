<?php
    session_start();
    require_once "../../database.php";
    require_once "../models/user.php";
    if (isset($_GET['action'])) {
        if ($_GET['action'] == "login") {
            login();
        } elseif ($_GET['action'] == "update_password") {
            processPasswordChange();
        }
}
    function login(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            // Récupère les informations envoyées par le formulaire de connexion
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            // Vérifie l'utilisateur en base avec email + mot de passe
            $user = verifyUser($email, $password);
            if (!$user) {
                die("Email ou mot de passe incorrect");
            }

            // Vérifie que l'utilisateur a confirmé son email
            if ($user['is_verified'] == 0) {
                die("Veuillez vérifier votre adresse email avant de vous connecter.");
            }

            // Stocke les données utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['photo'] = $user['photo'];
            $_SESSION['must_change_pwd'] = $user['must_change_pwd'];

            // Si l'utilisateur doit changer son mot de passe, on le redirige vers la page dédiée
            if ($user['must_change_pwd'] == 1) {
                header("Location: /gestion_bibliotheque/app/views/changePassword.php");
                exit;
            }

            // Sinon, redirection vers le dashboard principal
            header("Location: /gestion_bibliotheque/dashboard.php");
            exit;
        }
    }

    function processPasswordChange(){
        // Vérifie que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            die("Non autorisé");
        }

        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            // Vérifie la confirmation du mot de passe
            if($new_password !== $confirm_password){
                die("Les mots de passe ne correspondent pas");
            }

            // Vérifie la longueur minimale du mot de passe
            if(strlen($new_password) < 8){
                die("Mot de passe trop faible");
            }

            // Hash du mot de passe avant sauvegarde
            $hash = password_hash($new_password, PASSWORD_DEFAULT);
            $userId = $_SESSION['user_id'];

            // Mise à jour en base
            $success = updatePassword($userId, $hash);

            if($success){
                // Désactive l'obligation de changer le mot de passe
                $_SESSION['must_change_pwd'] = 0;
                header("Location: /gestion_bibliotheque/dashboard.php");
                exit;
            }
        }
    }

?>