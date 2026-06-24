<?php
    function findByEmail($email){
        global $connexion;
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($connexion, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            return $user;
        }
        
        return false;

    }
    function createUser($nom, $prenom, $email, $password, $photo, $token, $token_expire) {
        global $connexion;
        $sql = "INSERT INTO users(nom, prenom, email, password,photo,  role, is_verified, token, token_expire, must_change_pwd)
        VALUES(?, ?, ?, ?,?, 'ADHERENT', 0, ?, ?, 1)";
        $stmt = mysqli_prepare($connexion, $sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "sssssss", $nom, $prenom, $email, $password, $photo, $token, $token_expire);

            $result = mysqli_stmt_execute($stmt);
            if(!$result){
                die(mysqli_error($connexion));
            }
            return $result;
        }
        return false;

    }
    function verifyUser($email, $password){
        global $connexion;
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($connexion, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
        }
        
        return false;
    }
    function updatePassword($userId, $passwordHache) {
        global $connexion;

        // Requête préparée pour changer le mot de passe et passer must_change_pwd à 0
        $sql = "UPDATE users SET password = ?, must_change_pwd = 0 WHERE id = ?";
        $stmt = mysqli_prepare($connexion, $sql);

        if ($stmt) {
            // "si" veut dire : un String (le password) et un Integer (l'id de l'user)
            mysqli_stmt_bind_param($stmt, "si", $passwordHache, $userId);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            return $result;
        }
        return false;
    }
    function findByToken($token) {
        global $connexion;

        $sql = "SELECT * FROM users WHERE token = ?";
        $stmt = mysqli_prepare($connexion, $sql);
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }
    function activateUser($userId) {
        global $connexion;

        $sql = "UPDATE users 
                SET is_verified = 1,
                    token = NULL,
                    token_expire = NULL
                WHERE id = ?";

        $stmt = mysqli_prepare($connexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userId);

        return mysqli_stmt_execute($stmt);
    }

    // Fonctions pour la gestion des rôles (RP uniquement)
    function getAllUsers() {
        global $connexion;
        $sql = "SELECT id, nom, prenom, email, role, is_verified FROM users ORDER BY nom ASC";
        $stmt = mysqli_prepare($connexion, $sql);
        
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_stmt_close($stmt);
            return $users;
        }
        return [];
    }

    function updateUserRole($userId, $newRole) {
        global $connexion;
        
        // Vérifier que le rôle est valide
        $validRoles = ['ADHERENT', 'RB', 'RP'];
        if (!in_array($newRole, $validRoles)) {
            return false;
        }
        
        $sql = "UPDATE users SET role = ? WHERE id = ?";
        $stmt = mysqli_prepare($connexion, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $newRole, $userId);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return $result;
        }
        return false;
    }

    function getUserById($userId) {
        global $connexion;
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = mysqli_prepare($connexion, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $userId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            return $user;
        }
        return false;
    }

?>