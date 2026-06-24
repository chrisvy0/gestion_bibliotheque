-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 24 juin 2026 à 05:38
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_bibliothèque`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('ADHERENT','RB','RP') DEFAULT 'ADHERENT',
  `token` varchar(64) DEFAULT NULL,
  `token_expire` datetime DEFAULT NULL,
  `must_change_pwd` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `photo` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `password`, `role`, `token`, `token_expire`, `must_change_pwd`, `created_at`, `photo`, `is_verified`) VALUES
(5, 'Ngondo', 'Chrisvy', 'chrisvyboussiengue@gmail.com', '$2y$10$TSuDBUY9coZ8JoIziHV0Q.W8HAgSrCwyZPd.49LdR5/oh/YJV9Yb.', 'RP', NULL, NULL, 0, '2026-06-24 03:17:16', '1782271036_6a3b4c3c39652.jpeg', 1),
(6, 'Ngondo', 'Chrisvy', 'chrisvyngondo@gmail.com', '$2y$10$UszXJTkcDeROAUv1qzlnWO6rgbDUKaNibh9MDzbJflfr4bsLzdA.y', 'RB', NULL, NULL, 0, '2026-06-24 03:29:19', '1782271759_6a3b4f0f7fb7d.jpeg', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
