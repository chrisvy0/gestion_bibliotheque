<?php
// Initialise la session utilisateur si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifie l'accès RB au dashboard
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] != 'RB') {
    die("Accès refusé");
}

// Charge la connexion et les fonctions métier pour les ouvrages, rayons et auteurs
require_once __DIR__ . "/../../database.php";
require_once __DIR__ . "/../models/ouvrages.php";

// Récupère les statistiques et données à afficher dans le dashboard
$totalRayons = countRayons();
$totalOuvrages = countOuvrages();
$totalAuteurs = countAuteurs();
$exemplairesDisponibles = countExemplairesDisponibles();
$ouvragesRecents = getOuvragesRecents();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Responsable Bibliothèque</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="relative w-64 bg-white dark:bg-gray-800 shadow-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-purple-600">Bibliothèque</h1>
            </div>
            <nav class="mt-6">
                <a href="#" class="flex items-center px-6 py-3 text-gray-700 dark:text-gray-300 bg-purple-50 dark:bg-purple-900 border-r-4 border-purple-600">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="/gestion_bibliotheque/app/views/gerer_rayons.php" class="flex items-center px-6 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0 0h6"></path>
                    </svg>
                    <span>Gérer les rayons</span>
                </a>
                <a href="/gestion_bibliotheque/app/views/gerer_auteurs.php" class="flex items-center px-6 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Gérer les auteurs</span>
                </a>
                <a href="/gestion_bibliotheque/app/views/add_ouvrage.php"
   class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 4v16m8-8H4"></path>
    </svg>
    Gérer ouvrage
</a>
                <a href="/gestion_bibliotheque/app/views/manage_exemplaires.php" class="flex items-center px-6 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19H2v-1a6 6 0 0112 0v1h3V9h-2"></path>
                    </svg>
                    <span>Gérer les exemplaires</span>
                </a>
            </nav>
            <div class="absolute bottom-0 left-0 w-64 p-6 border-t border-gray-200 dark:border-gray-700">
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
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Bienvenue <?= htmlspecialchars($_SESSION['prenom']); ?></h2>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </button>
                        <?php
                            $photoPath = isset($_SESSION['photo']) && $_SESSION['photo'] ? '/gestion_bibliotheque/uploads/' . $_SESSION['photo'] : null;
                        ?>
                        <?php if ($photoPath): ?>
                            <img src="<?= htmlspecialchars($photoPath); ?>" alt="Profile" class="w-10 h-10 rounded-full object-cover">
                        <?php else: ?>
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['prenom']); ?>&background=purple&color=fff" alt="Profile" class="w-10 h-10 rounded-full">
                        <?php endif; ?>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="p-6">
                <!-- Affiche les messages de succès ou d'erreur stockés en session -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        <?= htmlspecialchars($_SESSION['success']); ?>
                        <?php unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <?= htmlspecialchars($_SESSION['error']); ?>
                        <?php unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <!-- Page title + action -->
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Ouvrages</h3>
                    <a href="/gestion_bibliotheque/app/views/add_ouvrage.php"
   class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 4v16m8-8H4"></path>
    </svg>
    Ajouter un ouvrage
</a>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Rayons -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 mr-4 text-orange-500 bg-orange-100 dark:bg-orange-500 dark:text-orange-100 rounded-full">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total Rayons</p>
                                <p class="text-2xl font-bold text-gray-700 dark:text-gray-200"><?= $totalRayons ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Ouvrages -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 mr-4 text-blue-500 bg-blue-100 dark:bg-blue-500 dark:text-blue-100 rounded-full">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total Ouvrages</p>
                                <p class="text-2xl font-bold text-gray-700 dark:text-gray-200"><?= $totalOuvrages ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Auteurs -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 mr-4 text-green-500 bg-green-100 dark:bg-green-500 dark:text-green-100 rounded-full">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total Auteurs</p>
                                <p class="text-2xl font-bold text-gray-700 dark:text-gray-200"><?= $totalAuteurs ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Exemplaires Disponibles -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 mr-4 text-purple-500 bg-purple-100 dark:bg-purple-500 dark:text-purple-100 rounded-full">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Exemplaires Disponibles</p>
                                <p class="text-2xl font-bold text-gray-700 dark:text-gray-200"><?= $exemplairesDisponibles ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Ouvrages Récents -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Ouvrages Récents</h3>
                    </div>
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Couverture</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Titre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Rayon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Date d'édition</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Exemplaires</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
    <?php if (empty($ouvragesRecents)): ?>
        <tr>
            <td colspan="7" class="px-6 py-4 text-sm text-gray-500 text-center">
                Aucun ouvrage enregistré pour le moment.
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($ouvragesRecents as $ouvrage): ?>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                    <?php if (!empty($ouvrage['photo'])): ?>
                        <img src="/gestion_bibliotheque/uploads/<?= htmlspecialchars($ouvrage['photo']); ?>" alt="Couverture" class="w-16 h-16 object-cover rounded">
                    <?php else: ?>
                        <div class="w-16 h-16 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded text-xs text-gray-500 dark:text-gray-300">
                            Aucune
                        </div>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                    <?= htmlspecialchars($ouvrage['titre']) ?>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                    <?= htmlspecialchars($ouvrage['code']) ?>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                    <?= htmlspecialchars($ouvrage['rayon']) ?>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                    <?= htmlspecialchars($ouvrage['date_edition'] ?? '-') ?>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                    <?= htmlspecialchars($ouvrage['nb_exemplaires'] ?? 0) ?>
                </td>

                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                    Modifier | Supprimer
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>