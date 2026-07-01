<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblotheque</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="flex flex-col items-center justify-center w-screen h-screen bg-gray-200 text-gray-700">

	<!-- Component Start -->
	<h1 class="font-bold text-2xl">Bon retour :)</h1>
	<form class="flex flex-col bg-white rounded shadow-lg p-12 mt-12" action="/gestion_bibliotheque/app/controllers/LoginController.php?action=login" method="post">
		<label class="font-semibold text-xs" for="email">Email</label>
		<input class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="email" id="email" name="email" required>
		<label class="font-semibold text-xs mt-3" for="password">Mot de passe</label>
		<input class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="password" id="password" name="password" required>
		<button type="submit" name="submit" class="flex items-center justify-center h-12 px-6 w-64 bg-blue-600 mt-8 rounded font-semibold text-sm text-blue-100 hover:bg-blue-700">Se connecter</button>
		<div class="flex mt-6 justify-center text-xs">
			<a class="text-blue-400 hover:text-blue-500" href="#">Mot de passe oublié</a>
			<span class="mx-2 text-gray-300">/</span>
			<a class="text-blue-400 hover:text-blue-500" href="/gestion_bibliotheque/app/views/inscription.php">S'inscrire</a>
		</div>
	</form>
	<!-- Component End  -->

</body>
</html>
