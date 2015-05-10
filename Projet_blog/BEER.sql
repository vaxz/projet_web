-- phpMyAdmin SQL Dump
-- version 4.4.6
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 10 Mai 2015 à 17:48
-- Version du serveur :  10.0.18-MariaDB-log
-- Version de PHP :  5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `BEER`
--

-- --------------------------------------------------------

--
-- Structure de la table `Article`
--

CREATE TABLE IF NOT EXISTS `Article` (
  `IDArticle` int(11) NOT NULL,
  `Titre` varchar(30) NOT NULL,
  `DateCreation` datetime NOT NULL,
  `URLArticle` varchar(30) NOT NULL,
  `URLImage` varchar(30) DEFAULT NULL,
  `Resume` varchar(300) NOT NULL,
  `IDUtilisateur` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Article`
--

INSERT INTO `Article` (`IDArticle`, `Titre`, `DateCreation`, `URLArticle`, `URLImage`, `Resume`, `IDUtilisateur`) VALUES
(1, 'La fabrication de la bière', '2015-03-15 00:00:00', 'articles/article1', NULL, 'Cet article parle de la fabrication de la bière comme l''indique le titre de l''article. A travers lui, il s''agit de présenter de manière non-exhaustive cette fameuse boisson alcoolisée sous différents angles.', 1),
(2, 'La Quadruple', '2015-05-10 12:32:56', 'articles/article2', 'articles/assets/image2', 'Présentation de la Quadruple', 2);

-- --------------------------------------------------------

--
-- Structure de la table `Commentaire`
--

CREATE TABLE IF NOT EXISTS `Commentaire` (
  `IDArticle` int(11) NOT NULL,
  `IDUtilisateur` int(11) NOT NULL,
  `DateCommentaire` datetime NOT NULL,
  `Commentaire` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Commentaire`
--

INSERT INTO `Commentaire` (`IDArticle`, `IDUtilisateur`, `DateCommentaire`, `Commentaire`) VALUES
(1, 1, '2015-03-21 00:00:00', 'C''était juste pour rien dire'),
(1, 2, '2015-03-25 00:00:00', 'C''est vraiment très interessant comme article');

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE IF NOT EXISTS `Utilisateur` (
  `IDUtilisateur` int(11) NOT NULL,
  `Pseudonyme` varchar(30) NOT NULL,
  `Mot_passe` varchar(30) NOT NULL,
  `Webmaster` tinyint(1) NOT NULL,
  `DateCreationUtilisateur` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`IDUtilisateur`, `Pseudonyme`, `Mot_passe`, `Webmaster`, `DateCreationUtilisateur`) VALUES
(1, 'Anonyme 1', 'a1', 0, '2015-05-04 17:18:39'),
(2, 'Anonyme 2', 'a2', 1, '2015-05-09 13:43:15');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Article`
--
ALTER TABLE `Article`
  ADD PRIMARY KEY (`IDArticle`),
  ADD KEY `FK_Article_IDUtilisateur` (`IDUtilisateur`);

--
-- Index pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  ADD PRIMARY KEY (`DateCommentaire`,`IDArticle`,`IDUtilisateur`),
  ADD KEY `FK_Commentaire_IDArticle` (`IDArticle`),
  ADD KEY `FK_Commentaire_IDUtilisateur` (`IDUtilisateur`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`IDUtilisateur`),
  ADD UNIQUE KEY `Pseudonyme` (`Pseudonyme`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Article`
--
ALTER TABLE `Article`
  MODIFY `IDArticle` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `IDUtilisateur` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Article`
--
ALTER TABLE `Article`
  ADD CONSTRAINT `FK_Article_IDUtilisateur` FOREIGN KEY (`IDUtilisateur`) REFERENCES `Utilisateur` (`IDUtilisateur`);

--
-- Contraintes pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  ADD CONSTRAINT `FK_Commentaire_IDArticle` FOREIGN KEY (`IDArticle`) REFERENCES `Article` (`IDArticle`),
  ADD CONSTRAINT `FK_Commentaire_IDUtilisateur` FOREIGN KEY (`IDUtilisateur`) REFERENCES `Utilisateur` (`IDUtilisateur`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
