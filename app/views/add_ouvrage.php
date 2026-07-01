<?php
// Initialise la session et vérifie que l'utilisateur est un RB
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'RB') {
    header("Location: /gestion_bibliotheque/app/views/login.php");
    exit;
}

// Charge la connexion et les fonctions métier
require_once "../../database.php";
require_once "../models/ouvrages.php";

// Charge la liste des rayons et auteurs pour les formulaires
$rayons = getRayons();
$auteurs = getAuteurs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un ouvrage - Bibliothèque</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="flex h-screen">
        <!-- Sidebar (réutilisable) -->
        <aside class="w-64 bg-white dark:bg-gray-800 shadow-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-purple-600">Bibliothèque</h1>
            </div>
            <nav class="mt-6">
                <a href="/gestion_bibliotheque/app/views/dashboard_rb.php" class="flex items-center px-6 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="/gestion_bibliotheque/app/views/add_ouvrage.php" class="flex items-center px-6 py-3 text-gray-700 dark:text-gray-300 bg-purple-50 dark:bg-purple-900 border-r-4 border-purple-600">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0 0h6"></path>
                    </svg>
                    <span>Ajouter un ouvrage</span>
                </a>
            </nav>
            <div class="absolute bottom-0 w-64 p-6 border-t border-gray-200 dark:border-gray-700">
                <a href="/gestion_bibliotheque/app/controllers/logout.php" class="flex items-center justify-center w-full px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Déconnexion
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200"><?= $editMode ? 'Modifier un ouvrage' : 'Ajouter un nouvel ouvrage' ?></h2>
                </div>
            </header>

            <!-- Form Content -->
            <div class="p-6">
                <!-- Messages d'erreur/succès -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <?= htmlspecialchars($_SESSION['error']); ?>
                        <?php unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <!-- Formulaire d'ajout d'ouvrage -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 max-w-2xl">
                    <form action="/gestion_bibliotheque/app/controllers/OuvrageController.php?action=<?= $editMode ? 'update' : 'create' ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                        <?php if ($editMode): ?>
                            <input type="hidden" name="id" value="<?= htmlspecialchars($editId); ?>">
                        <?php endif; ?>
                        
                        <!-- Titre -->
                        <div>
                            <label for="titre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Titre de l'ouvrage *
                            </label>
                            <input type="text" id="titre" name="titre" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="Ex: Le Seigneur des Anneaux" value="<?= htmlspecialchars($titre); ?>">
                        </div>

                        <!-- Code -->
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Code de l'ouvrage *
                            </label>
                            <input type="text" id="code" name="code" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="Ex: LV001" value="<?= htmlspecialchars($code); ?>">
                        </div>

                        <!-- Rayon -->
                        <div>
                            <label for="rayon_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Rayon *
                            </label>
                            <select id="rayon_id" name="rayon_id" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Sélectionnez un rayon</option>
                                <?php foreach ($rayons as $rayon): ?>
                                    <option value="<?= $rayon['id']; ?>" <?= $rayon_id == $rayon['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($rayon['libelle']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Date d'édition -->
                        <div>
                            <label for="date_edition" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Date d'édition
                            </label>
                            <input type="date" id="date_edition" name="date_edition"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="<?= htmlspecialchars($date_edition); ?>">
                        </div>

                        <!-- Photo de l'ouvrage -->
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Photo de l'ouvrage
                            </label>
                            <input type="file" id="photo" name="photo" accept="image/*"
                                   class="w-full text-sm text-gray-700 dark:text-gray-200 file:bg-purple-600 file:text-white file:px-3 file:py-2 file:rounded-lg file:border-0 file:ring-2 file:ring-purple-500 dark:file:bg-purple-500 dark:file:text-white" />
                            <?php if ($editMode && !empty($ouvrage['photo'])): ?>
                                <p class="text-xs text-gray-500 mt-2">Laisser vide pour conserver l'image actuelle.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Nombre d'exemplaires -->
                        <div>
                            <label for="nb_exemplaires" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nombre d'exemplaires *
                            </label>
                            <input type="number" id="nb_exemplaires" name="nb_exemplaires" required min="1" value="<?= htmlspecialchars($nb_exemplaires); ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="Ex: 3">
                        </div>

                        <!-- Boutons -->
                        <div class="flex space-x-4">
                            <button type="submit" class="flex-1 px-6 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition">
                                Ajouter l'ouvrage
                            </button>
                            <a href="/gestion_bibliotheque/app/views/dashboard_rb.php" class="flex-1 px-6 py-2 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition text-center">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
