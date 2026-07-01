<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Bibliotheque</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="flex flex-col items-center justify-center w-screen h-screen bg-gray-200 text-gray-700">

	<!-- Component Start -->
	<!-- Titre du formulaire d'inscription -->
	<h1 class="font-bold text-2xl">Créer un compte</h1>
	<!-- Formulaire d'inscription avec upload de photo -->
	<form class="flex flex-col bg-white rounded shadow-lg p-12 mt-12" action="/gestion_bibliotheque/app/controllers/AuthController.php?action=register" method="post" enctype="multipart/form-data">
		<label class="font-semibold text-xs" for="nom">Nom</label>
		<input class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="text" id="nom" name="nom" required>
		<label class="font-semibold text-xs mt-3" for="prenom">Prénom</label>
		<input class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="text" id="prenom" name="prenom" required>
		<label class="font-semibold text-xs mt-3" for="email">Email</label>
		<input class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="email" id="email" name="email" required>
		<label class="font-semibold text-xs mt-3" for="password">Mot de passe</label>
		<input class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="password" id="password" name="password" required>
		<label class="font-semibold text-xs mt-3" for="password_confirm">Confirmer le mot de passe</label>
		<input class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="password" id="password_confirm" name="password_confirm" required>
		<label class="font-semibold text-xs mt-3" for="photo">Photo de profil</label>
		<input class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="file" id="photo" name="photo" accept="image/*">
		<button type="submit" name="valider" class="flex items-center justify-center h-12 px-6 w-64 bg-blue-600 mt-8 rounded font-semibold text-sm text-blue-100 hover:bg-blue-700">S'inscrire</button>
		<div class="flex mt-6 justify-center text-xs">
			<a class="text-blue-400 hover:text-blue-500" href="/gestion_bibliotheque/app/views/login.php">Vous avez déjà un compte ? Se connecter</a>
		</div>
	</form>
	<!-- Component End  -->

</body>
</html>