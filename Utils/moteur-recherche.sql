-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 14 déc. 2021 à 13:15
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `moteur-recherche`
--
CREATE DATABASE IF NOT EXISTS `moteur-recherche` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `moteur-recherche`;

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

DROP TABLE IF EXISTS `document`;
CREATE TABLE IF NOT EXISTS `document` (
  `DocumentID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`DocumentID`),
  KEY `idx_Document_Name` (`Name`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `listemot`
--

DROP TABLE IF EXISTS `listemot`;
CREATE TABLE IF NOT EXISTS `listemot` (
  `ListeMotID` int(11) NOT NULL AUTO_INCREMENT,
  `Mot` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Occurence` int(11) NOT NULL,
  `Document` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`ListeMotID`),
  KEY `fk_ListeMot_Document` (`Document`)
) ENGINE=MyISAM AUTO_INCREMENT=3165 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
