-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 02 juin 2022 à 15:50
-- Version du serveur : 10.5.15-MariaDB-0ubuntu0.21.10.1
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_village_remplis`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `categorie_ID` int(11) NOT NULL,
  `categorie_nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categorie_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `commentaire_ID` int(11) NOT NULL,
  `commentaire_texte` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentaire_date` datetime NOT NULL,
  `commentaire_etat` enum('actif','supprimé') COLLATE utf8mb4_unicode_ci NOT NULL,
  `proposition_ID` int(11) NOT NULL,
  `villageois_EMAIL` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `periode`
--

CREATE TABLE `periode` (
  `periode_date_debut` date NOT NULL,
  `periode_date_fin` date NOT NULL,
  `type_periode` enum('publier','voter') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `proposition`
--

CREATE TABLE `proposition` (
  `proposition_ID` int(11) NOT NULL,
  `proposition_etat` enum('etat_refusee','etat_validee','etat_encreation','etat_en_attente') COLLATE utf8mb4_unicode_ci NOT NULL,
  `proposition_titre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proposition_description` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `proposition_date` datetime NOT NULL,
  `proposition_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `villageois_EMAIL` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categorie_ID` int(11) DEFAULT NULL,
  `perioded` date DEFAULT NULL,
  `periodef` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `villageois`
--

CREATE TABLE `villageois` (
  `villageois_EMAIL` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `villageois_nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `villageois_prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `villageois_adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `villageois_date_naissance` date NOT NULL,
  `villageois_mot_de_passe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `villageois_privilege` enum('privilege_admin','privilege_user','privilege_moderateur') COLLATE utf8mb4_unicode_ci NOT NULL,
  `villageois_mandat` enum('mandat_habitant','mandat_elu','mandat_delegue') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vote`
--

CREATE TABLE `vote` (
  `fk_villageois_EMAIL` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_proposition_ID` int(11) NOT NULL,
  `points_attribues` enum('1','2','3') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vote_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`categorie_ID`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`commentaire_ID`),
  ADD KEY `fk_villageois_EMAIL` (`villageois_EMAIL`),
  ADD KEY `fk_proposition_ID` (`proposition_ID`);

--
-- Index pour la table `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`periode_date_debut`,`periode_date_fin`) USING BTREE;

--
-- Index pour la table `proposition`
--
ALTER TABLE `proposition`
  ADD PRIMARY KEY (`proposition_ID`),
  ADD KEY `fk_villageois_EMAIL` (`villageois_EMAIL`),
  ADD KEY `fk_periode_date_debut` (`perioded`,`periodef`),
  ADD KEY `fk_categorie_ID` (`categorie_ID`) USING BTREE;

--
-- Index pour la table `villageois`
--
ALTER TABLE `villageois`
  ADD PRIMARY KEY (`villageois_EMAIL`);

--
-- Index pour la table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`fk_villageois_EMAIL`,`fk_proposition_ID`),
  ADD KEY `fk_proposition_ID` (`fk_proposition_ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `categorie_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `commentaire_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `proposition`
--
ALTER TABLE `proposition`
  MODIFY `proposition_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`villageois_EMAIL`) REFERENCES `villageois` (`villageois_EMAIL`),
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`proposition_ID`) REFERENCES `proposition` (`proposition_ID`);

--
-- Contraintes pour la table `proposition`
--
ALTER TABLE `proposition`
  ADD CONSTRAINT `proposition_ibfk_1` FOREIGN KEY (`villageois_EMAIL`) REFERENCES `villageois` (`villageois_EMAIL`),
  ADD CONSTRAINT `proposition_ibfk_2` FOREIGN KEY (`categorie_ID`) REFERENCES `categorie` (`categorie_ID`),
  ADD CONSTRAINT `proposition_ibfk_3` FOREIGN KEY (`perioded`,`periodef`) REFERENCES `periode` (`periode_date_debut`, `periode_date_fin`);

--
-- Contraintes pour la table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`fk_villageois_EMAIL`) REFERENCES `villageois` (`villageois_EMAIL`),
  ADD CONSTRAINT `vote_ibfk_2` FOREIGN KEY (`fk_proposition_ID`) REFERENCES `proposition` (`proposition_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
