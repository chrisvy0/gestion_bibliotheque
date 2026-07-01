<?php
    require_once "../../vendor/autoload.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "../../database.php";
    require_once "../models/user.php";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    if(isset($_GET['action'])){
        if($_GET['action'] == 'register'){
            register();
        }
        elseif($_GET['action'] == 'verify_account'){
            verifyAccount();
        }
    }
    
    function register(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Récupère les valeurs saisies par le formulaire
            $nom = trim($_POST['nom']);
            $prenom = trim($_POST['prenom']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $password_confirm = trim($_POST['password_confirm']);

            // Validation des champs obligatoires
            if(empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($password_confirm)){
                die("Erreur: Tous les champs sont obligatoire");
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                die("Erreur: l'email n'est pas valide");
            }
            if($password !== $password_confirm){
                die("Erreur: les mots de passe ne correspondent pas");
            }
            if (findByEmail($email)) {
                die("Cet email est déjà associé à un utilisateur");
            }

            // Gestion de la photo de profil si fournie
            $photoName = null;
            if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
                // Récupération de l'extension
                $extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

                // Extensions autorisées
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                if(!in_array($extension, $allowedExtensions)){
                    die("Format d'image non autorisé");
                }

                // Nom de fichier unique pour éviter les collisions
                $photoName = time() . "_" . uniqid() . "." . $extension;
                $destination = "../../uploads/" . $photoName;
                move_uploaded_file($_FILES['photo']['tmp_name'], $destination);
            }

            // Génération du token de validation d'email
            $token = bin2hex(random_bytes(32));
            $token_expire = date('Y-m-d H:i:s', strtotime('+1 day'));

            // Hash du mot de passe avant insertion
            $passwordHach = password_hash($password, PASSWORD_DEFAULT);

            // Enregistrement utilisateur
            $savesuccess = createUser($nom, $prenom, $email, $passwordHach, $photoName, $token, $token_expire);
            if ($savesuccess) {
                sendVerificationMail($email, $token);
                echo "Inscription réussie. Vérifiez votre email.";
                header("Refresh:3; URL=/gestion_bibliotheque/app/views/login.php");
                exit;
            }

        }
    }
    function verifyAccount() {

        // 1. récupérer token depuis URL
        $token = $_GET['token'];

        // 2. appeler le MODEL
        $user = findByToken($token);

        // 3. vérifier existence
        if (!$user) {
            die("Token invalide");
        }

        // 4. vérifier expiration
        if ($user['token_expire'] < date('Y-m-d H:i:s')) {
            die("Token expiré");
        }

        // 5. activer utilisateur via MODEL
        activateUser($user['id']);

        echo "Compte activé avec succès !";
    }
    function sendVerificationMail($email, $token){

        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();

            $mail->Host = 'smtp.gmail.com';

            $mail->SMTPAuth = true;

            $mail->Username = 'chrisvyngondo@gmail.com';

            $mail->Password = 'lphw hlto mlen ossm';

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $mail->Port = 587;

            $mail->setFrom(
                'chrisvyngondo@gmail.com',
                'Bibliotheque IIBS'
            );

            $mail->addAddress($email);

            $link =
            "http://localhost/gestion_bibliotheque/app/controllers/AuthController.php?action=verify_account&token="
            . $token;

            $mail->isHTML(true);

            $mail->Subject = 'Activation de votre compte';

            $mail->Body =
            "Cliquez sur le lien suivant pour activer votre compte : <br><br>
            <a href='$link'>$link</a>";

            $mail->send();

            return true;

        } catch (Exception $e) {

            echo "Erreur mail : " . $mail->ErrorInfo;

            return false;
        }
}
?>