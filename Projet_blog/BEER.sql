-- phpMyAdmin SQL Dump
-- version 4.4.4
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 01 Mai 2015 à 15:02
-- Version du serveur :  10.0.17-MariaDB-log
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
  `URL` varchar(100) NOT NULL,
  `Resume` varchar(300) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Article`
--

INSERT INTO `Article` (`IDArticle`, `Titre`, `DateCreation`, `URL`, `Resume`) VALUES
(1, 'La fabrication de la bière', '2015-03-15 00:00:00', 'articles/article1.html', 'Cet article parle de la fabrication de la bière comme l''indique le titre de l''article. A travers lui, il s''agit de présenter de manière non-exhaustive cette fameuse boisson alcoolisée sous différents angles.');

-- --------------------------------------------------------

--
-- Structure de la table `Commentaire`
--

CREATE TABLE IF NOT EXISTS `Commentaire` (
  `IDCommentaire` int(11) NOT NULL,
  `DateCommentaire` datetime NOT NULL,
  `Commentaire` varchar(200) NOT NULL,
  `IDArticle` int(11) NOT NULL,
  `IDUtilisateur` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Commentaire`
--

INSERT INTO `Commentaire` (`IDCommentaire`, `DateCommentaire`, `Commentaire`, `IDArticle`, `IDUtilisateur`) VALUES
(1, '2015-03-25 00:00:00', 'C''est vraiment très interessant comme article', 1, 2),
(2, '2015-03-21 00:00:00', 'C''était juste pour rien dire', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE IF NOT EXISTS `Utilisateur` (
  `IDUtilisateur` int(11) NOT NULL,
  `Pseudonyme` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`IDUtilisateur`, `Pseudonyme`) VALUES
(1, 'Anonyme 1'),
(2, 'Anonyme 2');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Article`
--
ALTER TABLE `Article`
  ADD PRIMARY KEY (`IDArticle`);

--
-- Index pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  ADD PRIMARY KEY (`IDCommentaire`),
  ADD KEY `FK_Commentaire_IDArticle` (`IDArticle`),
  ADD KEY `FK_Commentaire_IDUtilisateur` (`IDUtilisateur`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`IDUtilisateur`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Article`
--
ALTER TABLE `Article`
  MODIFY `IDArticle` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  MODIFY `IDCommentaire` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `IDUtilisateur` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  ADD CONSTRAINT `FK_Commentaire_IDArticle` FOREIGN KEY (`IDArticle`) REFERENCES `Article` (`IDArticle`),
  ADD CONSTRAINT `FK_Commentaire_IDUtilisateur` FOREIGN KEY (`IDUtilisateur`) REFERENCES `Utilisateur` (`IDUtilisateur`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
