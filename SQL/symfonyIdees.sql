-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Mar 24 Mai 2016 à 13:07
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
-- Structure de la table `commentary_idea`
--

CREATE TABLE `commentary_idea` (
  `id` int(11) NOT NULL,
  `idIdea` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `commentary` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `community`
--

CREATE TABLE `community` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `community`
--

INSERT INTO `community` (`id`, `name`, `description`) VALUES
(1, 'Licence PRISM', 'Le groupe concerne la classe.'),
(7, 'VANDYCKE', 'Le groupe de la famille'),
(8, 'DUT GEII', 'Un forum d''entre aide.');

-- --------------------------------------------------------

--
-- Structure de la table `idea`
--

CREATE TABLE `idea` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idea` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idCommunauty` int(11) DEFAULT NULL,
  `idUser` int(11) NOT NULL,
  `publicateDate` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `idea`
--

INSERT INTO `idea` (`id`, `title`, `idea`, `idCommunauty`, `idUser`, `publicateDate`) VALUES
(1, 'Une guitare qui joue de la musique', 'Je ne sais pas', NULL, 2, '2016-05-23 06:31:09'),
(3, 'Hello', 'Bonjour', 1, 2, '2016-05-23 07:06:05'),
(6, 'Un téléphone qui passe des appels', 'Français', NULL, 2, '2016-05-24 01:18:29'),
(7, 'GEII', 'Bonjour', NULL, 2, '2016-05-23 10:02:12'),
(12, 'APP', 'sdsds', NULL, 2, '2016-05-23 10:43:20'),
(13, 'Frameword', 'Essa', NULL, 2, '2016-05-23 10:49:35'),
(16, 'Un aspirateur qui aspire', 'qdsqsdqdsq', NULL, 2, '2016-05-24 01:00:00'),
(23, 'Idée d''Hamada', 'Hello comment ça va ?', NULL, 2, '2016-05-24 12:51:29');

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
  `token` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `valideToken` datetime NOT NULL,
  `administrator` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `name`, `firstName`, `email`, `password`, `token`, `valideToken`, `administrator`) VALUES
(2, 'VANDYCKE', 'Steve', 'svandycke@gmail.com', 'c3284d0f94606de1fd2af172aba15bf3', '657ca3afb568d213cc68e5acf28e076f395ee939', '2016-05-25 12:58:49', 1),
(62, 'CHEVALLIER', 'Alexandre', 'alexandre.chevallier4@gmail.com', '8f8c1ff4ce76e757e2000ed4e6926af4', '062f0c44703b4ed45f198f51d29e730fc94527e7', '2016-05-25 12:59:05', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_community`
--

CREATE TABLE `user_community` (
  `id` int(11) NOT NULL,
  `idCommunity` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `user_community`
--

INSERT INTO `user_community` (`id`, `idCommunity`, `idUser`) VALUES
(6, 7, 2),
(7, 1, 62),
(8, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `vote_user_idea`
--

CREATE TABLE `vote_user_idea` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idIdea` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `vote_user_idea`
--

INSERT INTO `vote_user_idea` (`id`, `idUser`, `idIdea`) VALUES
(21, 2, 6),
(24, 2, 16),
(25, 2, 13),
(26, 2, 23),
(30, 62, 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `commentary_idea`
--
ALTER TABLE `commentary_idea`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `community`
--
ALTER TABLE `community`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `idea`
--
ALTER TABLE `idea`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_community`
--
ALTER TABLE `user_community`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vote_user_idea`
--
ALTER TABLE `vote_user_idea`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `commentary_idea`
--
ALTER TABLE `commentary_idea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `community`
--
ALTER TABLE `community`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `idea`
--
ALTER TABLE `idea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT pour la table `user_community`
--
ALTER TABLE `user_community`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `vote_user_idea`
--
ALTER TABLE `vote_user_idea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
