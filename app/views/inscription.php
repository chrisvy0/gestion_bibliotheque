<form action="/gestion_bibliotheque/app/controllers/AuthController.php?action=register" method="post"  enctype="multipart/form-data">
    <label for="">Nom</label>
    <input type="text" name="nom"><br>
    <label for="">prenom</label>
    <input type="text" name="prenom"><br>
    <label for="">Email</label>
    <input type="email" name="email"><br>
    <label for="">Mot de passe</label>
    <input type="password" name="password"><br> 
    <label for="">Confirmer le mot de passe</label>
    <input type="password" name="password_confirm"><br>
    <label for="">Photo de profil</label>
    <input type="file" name="photo" accept="image/*"><br>    
    <button type="submit" name="valider">S'inscrire</button><br>
    <a href="/gestion_bibliotheque/app/views/login.php">Vous avez déjà un compte ? Se connecter</a>     
</form>