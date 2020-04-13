-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 13 avr. 2020 à 00:12
-- Version du serveur :  10.4.12-MariaDB
-- Version de PHP : 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `wakoky`
--

-- --------------------------------------------------------

--
-- Structure de la table `links`
--

CREATE TABLE `links` (
  `playlist_id` int(11) NOT NULL,
  `link` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exec_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `links`
--

INSERT INTO `links` (`playlist_id`, `link`, `id`, `name`, `exec_order`) VALUES
(15, 'rzJBkSBx-Uk', 56, '🎧 XXXTENTACION - Save Me (DareveL Remix) (8D AUDIO) 🎧', 1),
(15, 'db7_icvfxSE', 68, 'Travis Scott - HIGHEST IN THE ROOM | 8D SOUNDS', 2),
(15, 'rzJBkSBx-Uk', 71, '🎧 XXXTENTACION - Save Me (DareveL Remix) (8D AUDIO) 🎧', 3),
(15, 'db7_icvfxSE', 72, 'Travis Scott - HIGHEST IN THE ROOM | 8D SOUNDS', 4),
(15, 'rzJBkSBx-Uk', 73, '🎧 XXXTENTACION - Save Me (DareveL Remix) (8D AUDIO) 🎧', 5),
(19, '5BgLoQ1NnJc', 74, 'XXXTENTACION - School Shooters (Official Video) (feat. Lil Wayne)', 1),
(19, 'db7_icvfxSE', 75, 'Travis Scott - HIGHEST IN THE ROOM | 8D SOUNDS', 2),
(19, 'rzJBkSBx-Uk', 76, '🎧 XXXTENTACION - Save Me (DareveL Remix) (8D AUDIO) 🎧', 3),
(19, 'rzJBkSBx-Uk', 77, '🎧 XXXTENTACION - Save Me (DareveL Remix) (8D AUDIO) 🎧', 4),
(19, 'db7_icvfxSE', 78, 'Travis Scott - HIGHEST IN THE ROOM | 8D SOUNDS', 5),
(19, 'db7_icvfxSE', 79, 'Travis Scott - HIGHEST IN THE ROOM | 8D SOUNDS', 6),
(20, '5BgLoQ1NnJc', 80, 'XXXTENTACION - School Shooters (Official Video) (feat. Lil Wayne)', 1);

-- --------------------------------------------------------

--
-- Structure de la table `playlists`
--

CREATE TABLE `playlists` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `playlists`
--

INSERT INTO `playlists` (`id`, `name`, `user_id`) VALUES
(14, 'ma playliste de bg', 8),
(15, 'myPlaylist', 1),
(19, 'more bitch', 1),
(20, 'la', 1),
(22, 'f', 1),
(23, '1', 1),
(24, '2', 1),
(25, '5', 1),
(26, 'ls', 1),
(27, '3', 1),
(30, 'rap', 1),
(31, '53', 1),
(32, 'gh', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'hugo', 'hugolachkar@gmail.com', '3e031b4cec984b466a226d7dc5206859'),
(7, 'dana', 'test@gmail.com', '098f6bcd4621d373cade4e832627b4f6'),
(8, 'cycy', 'cycy@gmail.com', '202cb962ac59075b964b07152d234b70');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT pour la table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
