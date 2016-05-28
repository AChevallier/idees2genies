-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Sam 28 Mai 2016 à 14:15
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `community`
--

INSERT INTO `community` (`id`, `name`, `description`) VALUES
(1, 'Licence PRISM', 'Le groupe concerne la classe.'),
(7, 'Paris Aéroport', 'Le groupe de la famille'),
(8, 'DUT GEII', 'Un forum d''entre aide.'),
(9, 'Licence SRSI', 'Un groupe de partage.'),
(10, 'Apple', 'Un groupe de partage.'),
(11, 'Bouygues Telecom', 'Un groupe de partage.');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `idea`
--

INSERT INTO `idea` (`id`, `title`, `idea`, `idCommunauty`, `idUser`, `publicateDate`) VALUES
(1, 'Une guitare qui joue de la musique', 'Quo cognito Constantius ultra mortalem modum exarsit ac nequo casu idem Gallus de futuris incertus agitare quaedam conducentia saluti suae per itinera conaretur, remoti sunt omnes de industria milites agentes in civitatibus perviis.', NULL, 2, '2016-05-23 06:31:09'),
(3, 'Un cuisinier qui cuisine', 'Nam sole orto magnitudine angusti gurgitis sed profundi a transitu arcebantur et dum piscatorios quaerunt lenunculos vel innare temere contextis cratibus parant, effusae legiones, quae hiemabant tunc apud Siden, isdem impetu occurrere veloci. et signis pr', 1, 2, '2016-05-23 07:06:05'),
(6, 'Un téléphone qui passe des appels', 'Illud tamen clausos vehementer angebat quod captis navigiis, quae frumenta vehebant per flumen, Isauri quidem alimentorum copiis adfluebant, ipsi vero solitarum rerum cibos iam consumendo inediae propinquantis aerumnas exitialis horrebant.', NULL, 2, '2016-05-24 01:18:29'),
(7, 'Un ordinateur plus puissant que l''humain', 'Quare hoc quidem praeceptum, cuiuscumque est, ad tollendam amicitiam valet; illud potius praecipiendum fuit, ut eam diligentiam adhiberemus in amicitiis comparandis, ut ne quando amare inciperemus eum, quem aliquando odisse possemus. Quin etiam si minus f', 7, 2, '2016-05-27 14:20:33'),
(8, 'Un logiciel de caisse', 'Sed quid est quod in hac causa maxime homines admirentur et reprehendant meum consilium, cum ego idem antea multa decreverim, que magis ad hominis dignitatem quam ad rei publicae necessitatem pertinerent? Supplicationem quindecim dierum decrevi sententia ', 7, 2, '2016-05-27 14:31:44'),
(9, 'Une clé électronique', 'Quanta autem vis amicitiae sit, ex hoc intellegi maxime potest, quod ex infinita societate generis humani, quam conciliavit ipsa natura, ita contracta res est et adducta in angustum ut omnis caritas aut inter duos aut inter paucos iungeretur.', 7, 2, '2016-05-27 14:32:59'),
(10, 'Un chargeur qui permet de charger', 'Homines enim eruditos et sobrios ut infaustos et inutiles vitant, eo quoque accedente quod et nomenclatores adsueti haec et talia venditare, mercede accepta lucris quosdam et prandiis inserunt subditicios ignobiles et obscuros.', 1, 62, '2016-05-27 14:42:51');

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
(2, 'Vandycke', 'Steve', 'svandycke@gmail.com', 'c3284d0f94606de1fd2af172aba15bf3', '63515075dc24006ed00fb7ae98a271c0807644dd', '2016-05-29 11:35:04', 1),
(62, 'Chevallier', 'Alexandre', 'alexandre.chevallier4@gmail.com', '8f8c1ff4ce76e757e2000ed4e6926af4', '8a256e92114be8c7c2ecf92c47d21e3f401456b2', '2016-05-28 14:33:43', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_community`
--

CREATE TABLE `user_community` (
  `id` int(11) NOT NULL,
  `idCommunity` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `user_community`
--

INSERT INTO `user_community` (`id`, `idCommunity`, `idUser`) VALUES
(6, 7, 2),
(7, 1, 62),
(8, 1, 2),
(9, 10, 62),
(10, 9, 62),
(11, 11, 2);

-- --------------------------------------------------------

--
-- Structure de la table `vote_user_idea`
--

CREATE TABLE `vote_user_idea` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idIdea` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `vote_user_idea`
--

INSERT INTO `vote_user_idea` (`id`, `idUser`, `idIdea`) VALUES
(85, 62, 3),
(93, 2, 7),
(95, 2, 9),
(96, 62, 8),
(97, 62, 7),
(98, 62, 1),
(99, 62, 10),
(101, 2, 10),
(104, 2, 8);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `idea`
--
ALTER TABLE `idea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT pour la table `user_community`
--
ALTER TABLE `user_community`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `vote_user_idea`
--
ALTER TABLE `vote_user_idea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=105;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
