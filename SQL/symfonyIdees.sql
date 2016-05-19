-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Jeu 19 Mai 2016 à 19:16
-- Version du serveur :  5.5.42
-- Version de PHP :  5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `symfonyIdees`
--

-- --------------------------------------------------------

--
-- Structure de la table `community`
--

CREATE TABLE `community` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `community`
--

INSERT INTO `community` (`id`, `name`, `description`) VALUES
(1, 'Licence PRISM', 'Le groupe concerne la classe.'),
(4, 'Les étudiants de France', '');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `firstName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valideToken` datetime DEFAULT NULL,
  `administrator` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `name`, `firstName`, `email`, `password`, `token`, `valideToken`, `administrator`) VALUES
(2, 'VANDYCKE', 'Steve', 'svandycke@gmail.com', '$2y$10$.D1it0MT7VkGV30ywN5/FuUriQDJL00tf/SuLrLWCOvI0r0lo/kyy', 'bbee0ed1df9a84eb007030e0b38e6dd7a217be64', '2016-05-20 19:15:24', 1),
(3, 'GEFFLOT', 'Marie', 'gefflotmarie@gmail.com', '$2y$10$.D1it0MT7VkGV30ywN5/FuUriQDJL00tf/SuLrLWCOvI0r0lo/kyy', '8654a737a790e1c17f80dbcd3bccfaf30a692781', '2016-05-16 19:50:07', 0),
(61, 'VANDYCKE', 'Jérémy', 'jeremy.vandycke@gmail.com', '$2y$10$Dqwmo6rM4HKrAiCJTIL/LenpiYInt7aVXP9VGmxvjiDlrpQ2dZDL2', '8b3045fe890af20e07c9eee32cc6d5c2aa18eb50', '2016-05-17 10:22:56', 0),
(62, 'CHEVALLIER', 'Alexandre', 'alexandre.chevallier@gmail.com', '$2y$10$D4Juxbvox1nCuQmrGJRfJeN.XvL746Ehm04XbhUBSCN680LMTWoB.', NULL, NULL, 1),
(73, 'RUBIO-BELANDO', 'Nicolas', 'nicolas.rubio@gmail.com', '$2y$10$QCGRj70Hu3t1vVU52vQCmOXjZ.iLYBVJlPG5iGvck0UJZ70kdNfuC', '2da0a4c50ed7eedfd07fb6701c48cf3511ecaaf7', '2016-05-20 10:08:48', 0),
(74, 'DUPONT', 'Maxime', 'azerty@gmail.com', '$2y$10$LjoqxBjvyMeN/QUUMiUBPO4YpgYsF453NkjMbOQrVbJGeMzQnSOue', NULL, NULL, 1),
(75, 'GRIMONT', 'Charles', 'charles.grimont@gmail.com', '$2y$10$IoQpZskxgXWDq/XwteHlVO4uNsWjQh/lI0l2PgrgT7OCfyyGBx0CW', '98a20d5255f54d198f4e615c950e8bc06006018d', '2016-05-18 19:03:48', 1),
(77, 'TICHET', 'Tibault', 'tichet.tibault@gmail.com', '$2y$10$PvqUvdZ5h2QekTuA1Yt75ub.80Vef2nZ.yrJMygt9fPlmimWSWxbS', '6aebd5c7f4d1b53f3487e9bfe638027b870bbc73', '2016-05-18 14:20:41', 0),
(78, 'GRIMONT', 'Charles', 'charles.grimonta@gmail.com', '$2y$10$DL/nBToeI.bp0S9OrClHGOtHVt17s0vbENjMxjRqCEGMc3Yh.x8fO', NULL, NULL, 1),
(82, 'GRIMONT', 'Charles', 'charle.grimontaa@gmail.com', '$2y$10$1rnVumhvSQTXJBqQcs3oF.LpLEdOBX2ju6XeSsrwjJ0j.bq.4vmGq', NULL, NULL, 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `community`
--
ALTER TABLE `community`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `community`
--
ALTER TABLE `community`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=83;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
