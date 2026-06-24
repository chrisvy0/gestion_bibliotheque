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
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $user = verifyUser($email, $password);
            if (!$user) {
                die("Email ou mot de passe incorrect");
            }
            if ($user['is_verified'] == 0) {
            die("Veuillez vérifier votre adresse email avant de vous connecter.");
            
}
             $_SESSION['user_id'] = $user['id'];
             $_SESSION['nom'] = $user['nom'];
             $_SESSION['prenom'] = $user['prenom'];
             $_SESSION['email'] = $user['email'];
             $_SESSION['role'] = $user['role'];
             $_SESSION['photo'] = $user['photo'];
             $_SESSION['must_change_pwd'] = $user['must_change_pwd'];
             if ($user['must_change_pwd'] == 1) {
            header("Location: /gestion_bibliotheque/app/views/changePassword.php");
            exit;
        }
        header("Location: /gestion_bibliotheque/dashboard.php");
        exit;
        }
    }
    function processPasswordChange(){
        if (!isset($_SESSION['user_id'])) {
            die("Non autorisé");
        }
        if($_SERVER['REQUEST_METHOD'] == "POST"){

            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if($new_password !== $confirm_password){
                die("Les mots de passe ne correspondent pas");
            }

            if(strlen($new_password) < 8){
                die("Mot de passe trop faible");
            }

            $hash = password_hash($new_password, PASSWORD_DEFAULT);

            $userId = $_SESSION['user_id'];

            $success = updatePassword($userId, $hash);

            if($success){
                $_SESSION['must_change_pwd'] = 0;
                header("Location: /gestion_bibliotheque/dashboard.php");
                exit;
            }
        }
    }
 
?>