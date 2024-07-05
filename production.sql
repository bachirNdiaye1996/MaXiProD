-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 05 juil. 2024 à 13:03
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `production`
--

-- --------------------------------------------------------

--
-- Structure de la table `cranteuseechantillon`
--

CREATE TABLE `cranteuseechantillon` (
  `idcranteuseechantillon` int(11) NOT NULL,
  `echandiametre` varchar(255) DEFAULT NULL,
  `echanlongueur` varchar(255) DEFAULT NULL,
  `idfichecranteuseq1` varchar(255) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `echandf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cranteuseechantillon`
--

INSERT INTO `cranteuseechantillon` (`idcranteuseechantillon`, `echandiametre`, `echanlongueur`, `idfichecranteuseq1`, `actif`, `echandf`) VALUES
(1, '', '', '14', 1, NULL),
(2, '5.5', '150', '14', 1, NULL),
(3, '5.5', '', '17', 1, ''),
(4, '5.5', '44', '17', 1, ''),
(5, '4.5', '44', '18', 1, '15'),
(6, '4.5', '55', '18', 1, '15'),
(7, '6.6', '44', '22', 1, 'DF039'),
(8, '', '', '23', 1, ''),
(9, '', '', '24', 1, ''),
(10, '4.8', '44', '25', 1, 'DF039'),
(11, '4.4', '44', '26', 1, 'DF040'),
(12, '5', '44', '27', 1, 'DF040'),
(13, '4.5', '55', '28', 1, 'DF039'),
(14, '4.4', '44', '29', 1, 'DF039'),
(15, '8', '50', '29', 1, 'DF040'),
(16, '7.5', '44', '30', 1, 'DF039');

-- --------------------------------------------------------

--
-- Structure de la table `cranteuseq1`
--

CREATE TABLE `cranteuseq1` (
  `idcranteuseq1` int(11) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `dateajout` timestamp NULL DEFAULT NULL,
  `quart` int(11) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `dateCreation` varchar(255) DEFAULT NULL,
  `compteurdebut` varchar(255) DEFAULT NULL,
  `compteurfin` varchar(255) DEFAULT NULL,
  `controleur1` varchar(255) DEFAULT NULL,
  `controleur2` varchar(255) DEFAULT NULL,
  `controleur3` varchar(255) DEFAULT NULL,
  `machine` varchar(255) DEFAULT NULL,
  `observationdebut` varchar(500) DEFAULT NULL,
  `heuredepartquart` varchar(255) DEFAULT NULL,
  `heurefinquart` varchar(255) DEFAULT NULL,
  `saisisseur` varchar(255) DEFAULT NULL,
  `vitesse` varchar(255) DEFAULT NULL,
  `observationfin` varchar(500) DEFAULT NULL,
  `poidsestimetravaillenonnote` varchar(255) DEFAULT NULL,
  `accepteprodmodif` int(11) NOT NULL DEFAULT 0,
  `actifapprouvprod` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cranteuseq1`
--

INSERT INTO `cranteuseq1` (`idcranteuseq1`, `user`, `dateajout`, `quart`, `actif`, `dateCreation`, `compteurdebut`, `compteurfin`, `controleur1`, `controleur2`, `controleur3`, `machine`, `observationdebut`, `heuredepartquart`, `heurefinquart`, `saisisseur`, `vitesse`, `observationfin`, `poidsestimetravaillenonnote`, `accepteprodmodif`, `actifapprouvprod`) VALUES
(1, 'Mouhamadoul Bachir Ndiaye', '2024-05-11 21:39:34', 1, 1, '2024-05-11', '15', '17', 'skksllq', 'qkkqk', 'kqkqk', 'Cranteuse 2', 'Ras.', '15:57', '18:57', 'Mouhamadoul Bachir Ndiaye', '3', 'RAS1. 89', '38', 0, 0),
(2, 'Mouhamadoul Bachir Ndiaye', '2024-05-15 07:27:01', 1, 1, '2024-05-12', '175000', '177000', 'Bachir Ndiaye', 'Badou Diop', '', 'Cranteuse 1', 'RAS debut.', '08:00', '18:00', 'Mouhamadoul Bachir Ndiaye', '3', '2 bobines 5.5 sont disloquées.', '170', 1, 1),
(3, 'Mbaye Ndiago Thiam', '2024-05-16 12:53:15', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(4, 'Mbaye Ndiago Thiam', '2024-05-23 14:41:08', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `cranteuseq1arret`
--

CREATE TABLE `cranteuseq1arret` (
  `idcranteuseq1arret` int(11) NOT NULL,
  `debutarret` varchar(255) DEFAULT NULL,
  `finarret` varchar(255) DEFAULT NULL,
  `raison` varchar(500) DEFAULT NULL,
  `idfichecranteuseq1` int(11) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cranteuseq1arret`
--

INSERT INTO `cranteuseq1arret` (`idcranteuseq1arret`, `debutarret`, `finarret`, `raison`, `idfichecranteuseq1`, `actif`) VALUES
(55, '11:52', '12:47', 'Raison 1', 22, 1),
(56, '17:00', '17:17', 'Raison 1', 23, 1),
(57, '09:00', '09:27', 'Raison 1', 24, 1),
(58, '09:15', '09:38', 'Raison 2', 25, 1),
(59, '09:15', '09:17', 'Raison 1', 26, 1),
(60, '09:45', '10:17', 'Raison 2', 26, 1),
(61, '01:14', '01:57', 'Raison 1', 27, 1),
(62, '09:12', '09:18', 'Raison 1', 28, 1),
(63, '09:15', '09:48', 'Raison 1', 29, 1),
(64, '17:12', '17:45', 'Raison 1', 30, 1),
(65, '18:15', '18:20', 'Raison 2', 30, 1),
(66, '19:15', '19:45', 'Raison 3', 30, 1),
(67, '22:24', '23:19', 'Raison 1', 30, 1),
(68, '09:15', '09:45', 'Raison 1', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `cranteuseq1consommation`
--

CREATE TABLE `cranteuseq1consommation` (
  `idcranteuseq1consommation` int(11) NOT NULL,
  `diametre` varchar(255) DEFAULT NULL,
  `numerofin` varchar(255) DEFAULT NULL,
  `poids` varchar(255) DEFAULT NULL,
  `dechet` varchar(255) DEFAULT NULL,
  `codeReception` varchar(255) DEFAULT NULL,
  `idfichecranteuseq1` int(11) DEFAULT NULL,
  `actif` int(11) DEFAULT 1,
  `nbbobine` int(11) DEFAULT NULL,
  `heuremontagebobine` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cranteuseq1consommation`
--

INSERT INTO `cranteuseq1consommation` (`idcranteuseq1consommation`, `diametre`, `numerofin`, `poids`, `dechet`, `codeReception`, `idfichecranteuseq1`, `actif`, `nbbobine`, `heuremontagebobine`) VALUES
(42, '4.5', '182', '1200', '200', '50', 25, 1, NULL, '09:19'),
(43, '12', '256', '1200', '120', NULL, 26, 1, NULL, '09:15'),
(44, '4.5', '174', '1100', '100', NULL, 26, 1, NULL, '12:00'),
(45, '5.5', '162', '1100', '100', NULL, 27, 1, NULL, '00:50'),
(46, '10.5', '175', '1000', '100', NULL, 28, 1, NULL, '12:45'),
(47, '5.5', '172', '1000', '10', NULL, 26, 1, NULL, '16:00'),
(48, '7.5', '195', '1200', '15', NULL, 26, 1, NULL, '17:00'),
(49, '5.5', '173', '1150', '120', NULL, 29, 1, NULL, '09:00'),
(50, '9', '171', '1100', '100', NULL, 29, 1, NULL, '09:15'),
(51, '7.5', '199', '1100', '120', NULL, 30, 1, NULL, '17:15'),
(52, '7.5', '198', '1000', '100', NULL, 30, 1, NULL, '19:45');

-- --------------------------------------------------------

--
-- Structure de la table `cranteuseq1production`
--

CREATE TABLE `cranteuseq1production` (
  `idcranteuseq1production` int(11) NOT NULL,
  `proddiametre` varchar(255) DEFAULT NULL,
  `prodnumerofin` varchar(255) DEFAULT NULL,
  `prodpoids` varchar(255) DEFAULT NULL,
  `proddechet` varchar(255) DEFAULT NULL,
  `prodcodeReception` int(11) DEFAULT NULL,
  `idfichecranteuseq1` int(11) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `prodnbbobine` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cranteuseq1production`
--

INSERT INTO `cranteuseq1production` (`idcranteuseq1production`, `proddiametre`, `prodnumerofin`, `prodpoids`, `proddechet`, `prodcodeReception`, `idfichecranteuseq1`, `actif`, `prodnbbobine`) VALUES
(23, '5.4', '182', '1000', NULL, NULL, 25, 1, 1),
(24, '12.8', '256', '1000', NULL, NULL, 26, 1, 0),
(25, '5.1', '174', '1000', NULL, 0, 26, 1, 1),
(26, '5.5', '162', '1000', NULL, NULL, 27, 1, 1),
(27, '11.2', '175', '900', NULL, NULL, 28, 1, 1),
(28, '5.8', '172', '990', NULL, NULL, 26, 1, 1),
(29, '7.9', '195', '1185', NULL, NULL, 26, 1, 1),
(30, '5.9', '173', '1003', NULL, NULL, 29, 1, 1),
(31, '9.4', '171', '1000', NULL, NULL, 29, 1, 1),
(32, '8', '199', '1000', NULL, NULL, 30, 1, 0),
(33, '7.5', '198', '900', NULL, NULL, 30, 1, 1),
(34, '8', '199', '900', NULL, NULL, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `detailproduction`
--

CREATE TABLE `detailproduction` (
  `idtravail` int(11) NOT NULL,
  `codeproduit` varchar(255) NOT NULL,
  `numerobobinefabriquee` varchar(255) NOT NULL,
  `quantite` varchar(255) NOT NULL,
  `idproduction` int(11) NOT NULL,
  `poids` int(11) NOT NULL,
  `longueur` int(11) NOT NULL,
  `epaisseur` int(11) NOT NULL,
  `idbobine` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `dresseusearret`
--

CREATE TABLE `dresseusearret` (
  `iddresseusearret` int(11) NOT NULL,
  `debutarret` varchar(255) DEFAULT NULL,
  `finarret` varchar(255) DEFAULT NULL,
  `raison` varchar(500) DEFAULT NULL,
  `idfichedresseuse` varchar(255) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `dresseusearret`
--

INSERT INTO `dresseusearret` (`iddresseusearret`, `debutarret`, `finarret`, `raison`, `idfichedresseuse`, `actif`) VALUES
(1, '09:15', '09:45', 'Raison 1', '1', 1),
(2, '09:15', '09:45', 'Raison 1', '1', 1),
(3, '11:00', '11:47', 'Raison 1', '1', 1),
(4, '09:15', '09:18', 'Raison 1', '2', 1),
(5, '09:00', '09:17', 'Raison 1', '3', 1),
(6, '08:49', '10:14', 'Raison 1', '4', 1),
(7, '09:00', '09:18', 'Raison 1', '5', 1),
(8, '11:11', '11:27', 'Raison 1', '5', 1),
(9, '08:11', '09:45', 'Raison 1', '6', 1),
(10, '11:14', '11:25', 'Raison 1', '7', 1);

-- --------------------------------------------------------

--
-- Structure de la table `dresseuseconsommation`
--

CREATE TABLE `dresseuseconsommation` (
  `iddresseuseconsommation` int(11) NOT NULL,
  `diametre` varchar(255) DEFAULT NULL,
  `numerofin` varchar(255) DEFAULT NULL,
  `poids` varchar(255) DEFAULT NULL,
  `idfichedresseuse` varchar(255) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `heuremontagebobine` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `dresseuseconsommation`
--

INSERT INTO `dresseuseconsommation` (`iddresseuseconsommation`, `diametre`, `numerofin`, `poids`, `idfichedresseuse`, `actif`, `heuremontagebobine`) VALUES
(1, '8', '199', '1000', '1', 1, '09:15'),
(2, '6', '198', '1200', '1', 1, '11:12'),
(6, '8', '199', '1000', '2', 1, '09:00'),
(7, '7.9', '195', '1185', '3', 1, '09:10'),
(8, '5.5', '162', '1000', '4', 1, '08:50'),
(9, '8', '199', '1000', '5', 1, '09:00'),
(10, '2', '173', '1100', '5', 1, '11:00'),
(11, '8', '199', '1000', '6', 1, '09:50'),
(12, '5', '175', '1800', '6', 1, '14:25'),
(13, '5.9', '173', '1003', '7', 1, '11:00');

-- --------------------------------------------------------

--
-- Structure de la table `dresseuseproduction`
--

CREATE TABLE `dresseuseproduction` (
  `iddresseuseproduction` int(11) NOT NULL,
  `proddiametre` varchar(255) DEFAULT NULL,
  `prodnumerofin` varchar(255) DEFAULT NULL,
  `prodpoids` varchar(255) DEFAULT NULL,
  `idfichedresseuse` varchar(255) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `prodnbBarreColis` varchar(255) DEFAULT NULL,
  `prodnbcolis` varchar(255) DEFAULT NULL,
  `prodnbbarrerestant` varchar(255) DEFAULT NULL,
  `proddechet` varchar(255) DEFAULT NULL,
  `prodlongueurbarre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `dresseuseproduction`
--

INSERT INTO `dresseuseproduction` (`iddresseuseproduction`, `proddiametre`, `prodnumerofin`, `prodpoids`, `idfichedresseuse`, `actif`, `prodnbBarreColis`, `prodnbcolis`, `prodnbbarrerestant`, `proddechet`, `prodlongueurbarre`) VALUES
(2, '8', '199', '900', '1', 1, '20', '32', '22', '100', '17'),
(3, '6', '198', '1100', '1', 1, '12', '14', '11', '100', '12'),
(5, '8', '199', '900', '2', 1, '17', '12', '15', '100', '12'),
(6, '7.9', '195', '1185', '3', 1, '12', '15', '17', '20', '12'),
(7, '5.5', '162', '900', '4', 1, '14', '18', '15', '100', '12'),
(8, '8', '199', '900', '5', 1, '14', '10', '27', '100', '12'),
(9, '2', '173', '1000', '5', 1, '10', '19', '17', '100', '14'),
(10, '8', '199', '900', '6', 1, '14', '12', '8', '100', '12'),
(11, '9', '175', '1700', '6', 1, '17', '17', '9', '100', '13'),
(12, '5.9', '173', '900', '7', 1, '32', '15', '11', '103', '12.5');

-- --------------------------------------------------------

--
-- Structure de la table `epaisseur`
--

CREATE TABLE `epaisseur` (
  `id` int(11) NOT NULL,
  `3` int(11) NOT NULL DEFAULT 0,
  `3.5` int(11) NOT NULL DEFAULT 0,
  `4` int(11) NOT NULL DEFAULT 0,
  `4.5` int(11) NOT NULL DEFAULT 0,
  `5` int(11) NOT NULL DEFAULT 0,
  `5.5` int(11) NOT NULL DEFAULT 0,
  `6` int(11) NOT NULL DEFAULT 0,
  `6.5` int(11) NOT NULL DEFAULT 0,
  `7` int(11) NOT NULL DEFAULT 0,
  `7.5` int(11) NOT NULL DEFAULT 0,
  `8` int(11) NOT NULL DEFAULT 0,
  `8.5` int(11) NOT NULL DEFAULT 0,
  `9` int(11) NOT NULL DEFAULT 0,
  `9.5` int(11) NOT NULL DEFAULT 0,
  `10` int(11) NOT NULL DEFAULT 0,
  `10.5` int(11) NOT NULL DEFAULT 0,
  `11` int(11) NOT NULL DEFAULT 0,
  `11.5` int(11) NOT NULL DEFAULT 0,
  `12` int(11) NOT NULL DEFAULT 0,
  `12.5` int(11) NOT NULL DEFAULT 0,
  `13` int(11) NOT NULL DEFAULT 0,
  `13.5` int(11) NOT NULL DEFAULT 0,
  `14` int(11) NOT NULL DEFAULT 0,
  `14.5` int(11) NOT NULL DEFAULT 0,
  `15` int(11) NOT NULL DEFAULT 0,
  `15.5` int(11) NOT NULL DEFAULT 0,
  `16` int(11) NOT NULL DEFAULT 0,
  `16.5` int(11) NOT NULL DEFAULT 0,
  `17` int(11) NOT NULL DEFAULT 0,
  `lieu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `epaisseur`
--

INSERT INTO `epaisseur` (`id`, `3`, `3.5`, `4`, `4.5`, `5`, `5.5`, `6`, `6.5`, `7`, `7.5`, `8`, `8.5`, `9`, `9.5`, `10`, `10.5`, `11`, `11.5`, `12`, `12.5`, `13`, `13.5`, `14`, `14.5`, `15`, `15.5`, `16`, `16.5`, `17`, `lieu`) VALUES
(1, 0, 0, 0, 7, 0, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Metal1'),
(3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15, 0, 0, 8, 0, 0, 0, 0, 0, 18, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Niambour'),
(4, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Cranteuse'),
(5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Tréfilage'),
(6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Metal Mbao');

-- --------------------------------------------------------

--
-- Structure de la table `etatproduction`
--

CREATE TABLE `etatproduction` (
  `idetatproduction` int(11) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `dateajout` varchar(255) DEFAULT NULL,
  `idficheproduction` int(11) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `exportation`
--

CREATE TABLE `exportation` (
  `idexportation` int(11) NOT NULL,
  `dateajout` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` varchar(255) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `commentaire` varchar(500) DEFAULT NULL,
  `saisisseur` varchar(255) DEFAULT NULL,
  `dateexportation` varchar(255) DEFAULT NULL,
  `transporteur` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `exportationdetails`
--

CREATE TABLE `exportationdetails` (
  `idexportationdetail` int(11) NOT NULL,
  `poidspese` int(11) DEFAULT NULL,
  `dateajout` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` varchar(255) DEFAULT NULL,
  `nbbobine` int(11) NOT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `pointdepart` varchar(255) DEFAULT NULL,
  `idexportation` int(11) DEFAULT NULL,
  `epaisseur` varchar(255) NOT NULL,
  `etatbobine` varchar(255) DEFAULT NULL,
  `poidsdeclare` int(11) DEFAULT NULL,
  `commentaire` varchar(500) DEFAULT NULL,
  `pointarrive` varchar(255) DEFAULT NULL,
  `actifapprouvexportation` int(11) NOT NULL DEFAULT 0,
  `acceptereceptionmodif` int(11) NOT NULL DEFAULT 0,
  `idmatieredepart` int(11) DEFAULT NULL,
  `idmatierearrive` int(11) DEFAULT NULL,
  `couleurhistorique` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `exportationdetails`
--

INSERT INTO `exportationdetails` (`idexportationdetail`, `poidspese`, `dateajout`, `user`, `nbbobine`, `actif`, `pointdepart`, `idexportation`, `epaisseur`, `etatbobine`, `poidsdeclare`, `commentaire`, `pointarrive`, `actifapprouvexportation`, `acceptereceptionmodif`, `idmatieredepart`, `idmatierearrive`, `couleurhistorique`) VALUES
(16, 0, '2024-05-07 19:42:47', NULL, 3, 1, 'Niambour', 5, '7.5', 'Normale', 1200, 'Je teste', '', 0, 0, 310, 315, 0),
(17, 0, '2024-05-07 19:42:47', NULL, 2, 1, 'Niambour', 5, '7.5', 'Normale', 1000, 'Je teste', 'SOBOA', 0, 0, 310, 315, 0),
(18, 0, '2024-05-07 19:43:17', NULL, 3, 1, 'Niambour', 5, '7.5', 'Normale', 1200, 'Je teste', '', 0, 0, 310, 315, 0),
(19, 0, '2024-05-07 19:43:17', NULL, 2, 1, 'Niambour', 5, '7.5', 'Normale', 1000, 'Je teste', 'SOBOA', 0, 0, 310, 315, 0),
(20, 0, '2024-05-07 19:43:47', NULL, 3, 1, 'Niambour', 5, '7.5', 'Normale', 1200, 'Je teste', '', 0, 0, 310, 315, 0),
(21, 0, '2024-05-07 19:43:47', NULL, 7, 1, 'Metal Mbao', 5, '10', 'Normale', 1200, 'Je teste', '', 0, 0, 311, 315, 0),
(22, 0, '2024-05-07 19:46:03', NULL, 7, 1, 'Metal Mbao', 5, '10', 'Normale', 1200, 'Je teste', '', 0, 0, 311, 315, 0),
(23, 0, '2024-05-07 20:15:36', NULL, 1, 1, 'Metal1', 5, '5.5', 'Normale', 1200, 'Je teste', '', 0, 0, 309, 315, 0);

-- --------------------------------------------------------

--
-- Structure de la table `fichecranteuseq1`
--

CREATE TABLE `fichecranteuseq1` (
  `idfichecranteuseq1` int(11) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `dateajout` timestamp NOT NULL DEFAULT current_timestamp(),
  `quart` varchar(255) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `dateCreation` varchar(255) DEFAULT NULL,
  `compteurdebut` varchar(255) DEFAULT NULL,
  `compteurfin` varchar(255) DEFAULT NULL,
  `controleur1` varchar(255) DEFAULT NULL,
  `controleur2` varchar(255) DEFAULT NULL,
  `controleur3` varchar(255) DEFAULT NULL,
  `machine` varchar(255) DEFAULT NULL,
  `observationdebut` varchar(500) DEFAULT NULL,
  `heuredepartquart` varchar(255) DEFAULT NULL,
  `heurefinquart` varchar(255) DEFAULT NULL,
  `saisisseur` varchar(255) DEFAULT NULL,
  `vitesse` varchar(255) DEFAULT NULL,
  `observationfin` varchar(500) DEFAULT NULL,
  `poidsestimetravaillenonnote` varchar(255) DEFAULT NULL,
  `accepteprodmodif` int(11) NOT NULL DEFAULT 0,
  `actifapprouvprod` int(11) NOT NULL DEFAULT 0,
  `idcranteuseq1` int(11) DEFAULT NULL,
  `couleurhistorique` int(11) NOT NULL DEFAULT 0,
  `couleurhistoriqueSup` int(11) NOT NULL DEFAULT 0,
  `couleurhistoriquemodif` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `fichecranteuseq1`
--

INSERT INTO `fichecranteuseq1` (`idfichecranteuseq1`, `user`, `dateajout`, `quart`, `actif`, `dateCreation`, `compteurdebut`, `compteurfin`, `controleur1`, `controleur2`, `controleur3`, `machine`, `observationdebut`, `heuredepartquart`, `heurefinquart`, `saisisseur`, `vitesse`, `observationfin`, `poidsestimetravaillenonnote`, `accepteprodmodif`, `actifapprouvprod`, `idcranteuseq1`, `couleurhistorique`, `couleurhistoriqueSup`, `couleurhistoriquemodif`) VALUES
(25, 'Mbaye Ndiago Thiam', '2024-06-04 08:23:46', '3', 0, '2024-06-04', '1400', '1500', 'Balla Gaye', 'balla Diouf', NULL, 'Cranteuse 1', 'RAS debut.', '08:00', '18:45', 'Mbaye Ndiago Thiam', '3', 'RAS FIN.', '100', 0, 0, NULL, 0, 1, 0),
(26, 'Mbaye Ndiago Thiam', '2024-06-05 07:38:16', '1', 1, '2024-06-04', '181', '191', 'Bachir Ndiaye 1', 'Babacar Diop 1', NULL, 'Cranteuse 1', 'Ras.', '08:00', '18:00', 'Mbaye Ndiago Thiam', '2', 'ras plus 195', '100', 0, 0, NULL, 0, 0, 1),
(27, 'Mbaye Ndiago Thiam', '2024-06-05 12:20:42', '3', 1, '2024-06-04', '1470', '1490', 'Bachir Ndiaye', 'balla Diouf', NULL, 'Cranteuse 2', 'RAS debut.', '00:00', '07:45', 'Mbaye Ndiago Thiam', '3', 'Ras fin.', '120', 0, 0, NULL, 0, 0, 1),
(28, 'Mbaye Ndiago Thiam', '2024-06-05 14:37:25', '1', 1, '2024-06-04', '178', '300', 'Balla Gaye', 'balla Diouf', NULL, 'Cranteuse 2', 'RAS', '08:00', '16:00', 'Mbaye Ndiago Thiam', '3', 'J\'ai changer 173 en 175', '175', 0, 0, NULL, 0, 0, 1),
(29, 'Mbaye Ndiago Thiam', '2024-06-11 15:04:05', '3', 1, '2024-06-10', '140', '200', 'Bachir Ndiaye', 'Babacar Diop', NULL, 'Cranteuse 1', 'ras', '08:00', '17:00', 'Mbaye Ndiago Thiam', '3', 'ras', '120', 0, 0, NULL, 0, 0, 1),
(30, 'Mbaye Ndiago Thiam', '2024-06-12 07:35:40', '2', 1, '2024-06-04', '178', '200', 'Bachir Ndiaye', 'Babacar Diop 1', NULL, 'Cranteuse 2', 'RAS debut.', '16:00', '23:00', 'Mbaye Ndiago Thiam', '3', 'RAS fin.', '120', 0, 0, NULL, 0, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `fichedresseuse`
--

CREATE TABLE `fichedresseuse` (
  `idfichedresseuse` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `dateajout` timestamp NOT NULL DEFAULT current_timestamp(),
  `quart` varchar(255) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `dateCreation` varchar(255) DEFAULT NULL,
  `compteurdebut` varchar(255) DEFAULT NULL,
  `compteurfin` varchar(255) DEFAULT NULL,
  `controleur1` varchar(255) DEFAULT NULL,
  `controleur2` varchar(255) DEFAULT NULL,
  `controleur3` varchar(255) DEFAULT NULL,
  `machine` varchar(255) DEFAULT NULL,
  `observationdebut` varchar(255) DEFAULT NULL,
  `heuredepartquart` varchar(255) DEFAULT NULL,
  `heurefinquart` varchar(255) DEFAULT NULL,
  `saisisseur` varchar(255) DEFAULT NULL,
  `vitesse` varchar(255) DEFAULT NULL,
  `observationfin` varchar(255) DEFAULT NULL,
  `poidsestimetravaillenonnote` varchar(255) DEFAULT NULL,
  `accepteprodmodif` int(11) NOT NULL DEFAULT 0,
  `actifapprouvprod` int(11) NOT NULL DEFAULT 0,
  `idcranteuseq1` varchar(255) NOT NULL,
  `couleurhistorique` int(11) NOT NULL DEFAULT 0,
  `couleurhistoriqueSup` int(11) NOT NULL DEFAULT 0,
  `couleurhistoriquemodif` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `fichedresseuse`
--

INSERT INTO `fichedresseuse` (`idfichedresseuse`, `user`, `dateajout`, `quart`, `actif`, `dateCreation`, `compteurdebut`, `compteurfin`, `controleur1`, `controleur2`, `controleur3`, `machine`, `observationdebut`, `heuredepartquart`, `heurefinquart`, `saisisseur`, `vitesse`, `observationfin`, `poidsestimetravaillenonnote`, `accepteprodmodif`, `actifapprouvprod`, `idcranteuseq1`, `couleurhistorique`, `couleurhistoriqueSup`, `couleurhistoriquemodif`) VALUES
(1, 'Mbaye Ndiago Thiam', '2024-06-14 08:46:26', '1', 1, '2024-06-17', '143', '156', 'Balla Gaye 1', 'balla Diouf 1', NULL, 'Dresseuse 1', 'RAS debut 1.', '09:00', '17:45', 'Mbaye Ndiago Thiam', '3', 'Ras fin 15.', '129', 0, 0, '', 0, 0, 1),
(2, 'Mbaye Ndiago Thiam', '2024-06-22 10:39:23', '3', 1, '2024-06-17', '179', '250', 'Balla Gaye', 'Babacar Diop 1', NULL, 'Dresseuse 2', 'RAS.', '08:00', '17:25', 'Mbaye Ndiago Thiam', '3', 'RAS.', '140', 0, 0, '', 0, 0, 0),
(3, 'Mbaye Ndiago Thiam', '2024-06-22 11:14:40', '1', 1, '2024-06-17', '178', '250', 'Balla Gaye', 'Babacar Diop 1', NULL, 'Dresseuse 4', 'RAS.', '08:00', '19:00', 'Mbaye Ndiago Thiam', '3', 'RAS', '140', 0, 0, '', 0, 0, 0),
(4, 'Mbaye Ndiago Thiam', '2024-06-22 11:31:27', '2', 1, '2024-06-17', '190', '200', 'Balla Gaye1', 'balla Diouf', NULL, 'Dresseuse 5', 'ras', '08:00', '16:45', 'Mbaye Ndiago Thiam', '2', 'ras', '120', 0, 0, '', 0, 0, 0),
(5, 'Mbaye Ndiago Thiam', '2024-06-24 14:03:35', '1', 1, '2024-06-17', '177', '200', 'Bachir Ndiaye', 'balla Diouf', NULL, 'Dresseuse 6', 'RAS .', '08:00', '17:00', 'Mbaye Ndiago Thiam', '3', 'RAS fin.', '120', 0, 0, '', 0, 0, 1),
(6, 'Mbaye Ndiago Thiam', '2024-06-24 14:45:18', '3', 1, '2024-06-17', '145', '200', 'Balla Gaye', 'Babacar Diop', NULL, 'Dresseuse 7', 'RAS', '08:00', '19:00', 'Mbaye Ndiago Thiam', '3', 'RAS.', '140', 0, 0, '', 0, 0, 0),
(7, 'Mbaye Ndiago Thiam', '2024-06-25 15:36:24', '3', 1, '2024-06-17', '147', '299', 'Balla Gaye 1', 'Babacar Diop', NULL, 'Dresseuse 1', 'Test début.', '08:00', '18:30', 'Mbaye Ndiago Thiam', '3', 'Test fin.', '120', 0, 0, '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `fichetrefilage`
--

CREATE TABLE `fichetrefilage` (
  `idfichetrefilage` int(11) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `dateajout` timestamp NULL DEFAULT NULL,
  `quart` varchar(255) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `dateCreation` varchar(255) DEFAULT NULL,
  `compteurdebut` varchar(255) DEFAULT NULL,
  `compteurfin` varchar(255) DEFAULT NULL,
  `controleur1` varchar(255) DEFAULT NULL,
  `controleur2` varchar(255) DEFAULT NULL,
  `controleur3` varchar(255) DEFAULT NULL,
  `machine` varchar(255) DEFAULT NULL,
  `observationdebut` varchar(500) DEFAULT NULL,
  `heuredepartquart` varchar(255) DEFAULT NULL,
  `heurefinquart` varchar(255) DEFAULT NULL,
  `saisisseur` varchar(255) DEFAULT NULL,
  `vitesse` varchar(255) DEFAULT NULL,
  `observationfin` varchar(500) DEFAULT NULL,
  `poidsestimetravaillenonnote` varchar(255) DEFAULT NULL,
  `accepteprodmodif` int(11) NOT NULL DEFAULT 0,
  `couleurhistorique` int(11) NOT NULL DEFAULT 0,
  `couleurhistoriqueSup` int(11) NOT NULL DEFAULT 0,
  `couleurhistoriquemodif` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `logcranteusearret`
--

CREATE TABLE `logcranteusearret` (
  `idlogcranteusearret` int(11) NOT NULL,
  `debutarret` varchar(255) DEFAULT NULL,
  `finarret` varchar(255) DEFAULT NULL,
  `raison` varchar(500) DEFAULT NULL,
  `idfichecranteuseq1` int(11) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `logcranteusearret`
--

INSERT INTO `logcranteusearret` (`idlogcranteusearret`, `debutarret`, `finarret`, `raison`, `idfichecranteuseq1`, `actif`) VALUES
(1, '9', '9', '', 5, 1),
(2, '9', '9', 'a', 6, 1),
(3, '9', '9', 'a', 7, 1),
(4, '09:12', '09:18', 'Raison 2', 8, 1),
(5, '09:12', '09:18', 'Raison 1', 9, 1),
(6, '18:15', '18:42', 'Raison 1', 10, 1),
(7, '19:17', '20:18', 'Raison 2', 10, 1),
(8, '09:15', '09:17', 'Raison 1', 11, 1),
(9, '09:45', '10:17', 'Raison 2', 11, 1),
(10, '17:12', '17:45', 'Raison 1', 12, 1),
(11, '18:15', '18:20', 'Raison 2', 12, 1),
(12, '19:15', '19:45', 'Raison 3', 12, 1),
(13, '22:24', '23:19', 'Raison 1', 12, 1),
(14, '17:12', '17:45', 'Raison 1', 13, 1),
(15, '18:15', '18:20', 'Raison 2', 13, 1),
(16, '19:15', '19:45', 'Raison 3', 13, 1),
(17, '22:24', '23:19', 'Raison 1', 13, 1),
(18, '09:15', '09:48', 'Raison 1', 14, 1),
(19, '09:12', '09:18', 'Raison 1', 15, 1),
(20, '01:14', '01:57', 'Raison 1', 16, 1);

-- --------------------------------------------------------

--
-- Structure de la table `logcranteuseconsommation`
--

CREATE TABLE `logcranteuseconsommation` (
  `idlogcranteuseconsommation` int(11) NOT NULL,
  `diametre` varchar(255) DEFAULT NULL,
  `numerofin` varchar(255) DEFAULT NULL,
  `poids` varchar(255) DEFAULT NULL,
  `dechet` varchar(255) DEFAULT NULL,
  `codeReception` int(11) DEFAULT NULL,
  `idfichecranteuseq1` int(11) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `nbbobine` varchar(255) DEFAULT NULL,
  `heuremontagebobine` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `logcranteuseconsommation`
--

INSERT INTO `logcranteuseconsommation` (`idlogcranteuseconsommation`, `diametre`, `numerofin`, `poids`, `dechet`, `codeReception`, `idfichecranteuseq1`, `actif`, `nbbobine`, `heuremontagebobine`) VALUES
(1, '0', '8', '0', '0', NULL, 7, 1, NULL, '2'),
(2, '10.5', '175', '1000', '100', NULL, 8, 1, NULL, '12:45'),
(3, '10.5', '173', '1000', '100', NULL, 9, 1, NULL, '12:45'),
(4, '12', '256', '1200', '120', NULL, 10, 1, NULL, '17:15'),
(5, '4.5', '174', '1100', '100', NULL, 10, 1, NULL, '20:18'),
(6, '12', '256', '1200', '120', NULL, 11, 1, NULL, '09:15'),
(7, '4.5', '174', '1100', '100', NULL, 11, 1, NULL, '12:00'),
(8, '5.5', '172', '1000', '10', NULL, 11, 1, NULL, '16:00'),
(9, '7.5', '199', '1100', '120', NULL, 12, 1, NULL, '17:15'),
(10, '7.5', '199', '1100', '120', NULL, 13, 1, NULL, '17:15'),
(11, '7.5', '198', '1000', '100', NULL, 13, 1, NULL, '19:45'),
(12, '5.5', '173', '1150', '120', NULL, 14, 1, NULL, '09:00'),
(13, '9', '171', '1100', '100', NULL, 14, 1, NULL, '09:15'),
(14, '10.5', '175', '1000', '100', NULL, 15, 1, NULL, '12:45'),
(15, '5.5', '162', '1100', '100', NULL, 16, 1, NULL, '00:50');

-- --------------------------------------------------------

--
-- Structure de la table `logcranteuseechantillon`
--

CREATE TABLE `logcranteuseechantillon` (
  `idlogcranteuseechantillon` int(11) NOT NULL,
  `echandiametre` varchar(255) DEFAULT NULL,
  `echanlongueur` varchar(255) DEFAULT NULL,
  `idfichecranteuseq1` varchar(255) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `echandf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `logcranteuseechantillon`
--

INSERT INTO `logcranteuseechantillon` (`idlogcranteuseechantillon`, `echandiametre`, `echanlongueur`, `idfichecranteuseq1`, `actif`, `echandf`) VALUES
(1, '4.4', '44', '11', 1, 'DF040'),
(2, '7.5', '44', '12', 1, 'DF039'),
(3, '7.5', '44', '13', 1, 'DF039'),
(4, '4.4', '44', '14', 1, 'DF039'),
(5, '8', '50', '14', 1, 'DF040'),
(6, '4.5', '55', '15', 1, 'DF039'),
(7, '5', '44', '16', 1, 'DF040');

-- --------------------------------------------------------

--
-- Structure de la table `logcranteuseproduction`
--

CREATE TABLE `logcranteuseproduction` (
  `idlogcranteuseproduction` int(11) NOT NULL,
  `proddiametre` varchar(255) DEFAULT NULL,
  `prodnumerofin` varchar(255) DEFAULT NULL,
  `prodpoids` varchar(255) DEFAULT NULL,
  `proddechet` varchar(255) DEFAULT NULL,
  `prodcodeReception` int(11) DEFAULT NULL,
  `idfichecranteuseq1` int(11) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `prodnbbobine` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `logcranteuseproduction`
--

INSERT INTO `logcranteuseproduction` (`idlogcranteuseproduction`, `proddiametre`, `prodnumerofin`, `prodpoids`, `proddechet`, `prodcodeReception`, `idfichecranteuseq1`, `actif`, `prodnbbobine`) VALUES
(1, '', '', '', NULL, NULL, 7, 1, NULL),
(2, '', '', '', NULL, NULL, 8, 1, NULL),
(3, '11.2', '173', '900', NULL, NULL, 9, 1, NULL),
(4, '12.8', '256', '1000', NULL, NULL, 10, 1, NULL),
(5, '5.1', '174', '1000', NULL, NULL, 10, 1, NULL),
(6, '12.8', '256', '1000', NULL, NULL, 11, 1, NULL),
(7, '5.1', '174', '1000', NULL, NULL, 11, 1, NULL),
(8, '5.8', '172', '990', NULL, NULL, 11, 1, NULL),
(9, '8', '199', '1000', NULL, NULL, 12, 1, NULL),
(10, '8', '199', '1000', NULL, NULL, 13, 1, NULL),
(11, '7.5', '198', '900', NULL, NULL, 13, 1, NULL),
(12, '5.9', '173', '1003', NULL, NULL, 14, 1, NULL),
(13, '9.4', '171', '1000', NULL, NULL, 14, 1, NULL),
(14, '11.2', '175', '900', NULL, NULL, 15, 1, NULL),
(15, '5.5', '162', '1000', NULL, NULL, 16, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `logdresseusearret`
--

CREATE TABLE `logdresseusearret` (
  `idlogdresseusearret` int(11) NOT NULL,
  `debutarret` varchar(255) DEFAULT NULL,
  `finarret` varchar(255) DEFAULT NULL,
  `raison` varchar(500) DEFAULT NULL,
  `idfichedresseuse` int(11) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `logdresseusearret`
--

INSERT INTO `logdresseusearret` (`idlogdresseusearret`, `debutarret`, `finarret`, `raison`, `idfichedresseuse`, `actif`) VALUES
(1, '09:15', '09:45', 'Raison 1', 1, 1),
(2, '09:15', '09:45', 'Raison 1', 2, 1),
(3, '09:15', '09:45', 'Raison 1', 2, 1),
(4, '11:00', '11:47', 'Raison 2', 2, 1),
(5, '09:15', '09:45', 'Raison 1', 3, 1),
(6, '09:15', '09:45', 'Raison 1', 3, 1),
(7, '11:00', '11:47', 'Raison 2', 3, 1),
(8, '09:15', '09:45', 'Raison 1', 4, 1),
(9, '09:15', '09:45', 'Raison 1', 4, 1),
(10, '11:00', '11:47', 'Raison 1', 4, 1),
(11, '09:15', '09:45', 'Raison 1', 5, 1),
(12, '09:15', '09:45', 'Raison 1', 5, 1),
(13, '11:00', '11:47', 'Raison 1', 5, 1),
(14, '09:00', '09:18', 'Raison 1', 6, 1),
(15, '11:11', '11:27', 'Raison 1', 6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `logdresseuseconsommation`
--

CREATE TABLE `logdresseuseconsommation` (
  `idlogdresseuseconsommation` int(11) NOT NULL,
  `diametre` varchar(255) DEFAULT NULL,
  `numerofin` varchar(255) DEFAULT NULL,
  `poids` varchar(255) DEFAULT NULL,
  `idfichedresseuse` int(11) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `heuremontagebobine` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `logdresseuseconsommation`
--

INSERT INTO `logdresseuseconsommation` (`idlogdresseuseconsommation`, `diametre`, `numerofin`, `poids`, `idfichedresseuse`, `actif`, `heuremontagebobine`) VALUES
(1, '8', '199', '1000', 1, 1, '09:15'),
(2, '8', '199', '1000', 2, 1, '09:15'),
(3, '4', '198', '1200', 2, 1, '11:12'),
(4, '8', '199', '1000', 3, 1, '09:15'),
(5, '5', '198', '1200', 3, 1, '11:12'),
(6, '8', '199', '1000', 4, 1, '09:15'),
(7, '6', '198', '1200', 4, 1, '11:12'),
(8, '7', '172', '1150', 4, 1, '14:00'),
(9, '8', '199', '1000', 5, 1, '09:15'),
(10, '6', '198', '1200', 5, 1, '11:12'),
(11, '7', '172', '1150', 5, 1, '14:00'),
(12, '9', '162', '1000', 5, 1, '15:00'),
(13, '8', '199', '1000', 6, 1, '09:00'),
(14, '2', '', '1100', 6, 1, '11:00');

-- --------------------------------------------------------

--
-- Structure de la table `logdresseuseproduction`
--

CREATE TABLE `logdresseuseproduction` (
  `idlogdresseuseproduction` int(11) NOT NULL,
  `proddiametre` varchar(255) DEFAULT NULL,
  `prodnumerofin` varchar(255) DEFAULT NULL,
  `prodpoids` varchar(255) DEFAULT NULL,
  `idfichedresseuse` int(11) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `prodnbBarreColis` varchar(255) DEFAULT NULL,
  `prodnbcolis` varchar(255) DEFAULT NULL,
  `prodnbbarrerestant` varchar(255) DEFAULT NULL,
  `proddechet` varchar(255) DEFAULT NULL,
  `prodlongueurbarre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `logdresseuseproduction`
--

INSERT INTO `logdresseuseproduction` (`idlogdresseuseproduction`, `proddiametre`, `prodnumerofin`, `prodpoids`, `idfichedresseuse`, `actif`, `prodnbBarreColis`, `prodnbcolis`, `prodnbbarrerestant`, `proddechet`, `prodlongueurbarre`) VALUES
(1, '8', '199', '', 1, 1, '20', '32', '22', '10', ''),
(2, '8', '199', '', 2, 1, '20', '32', '22', '10', ''),
(3, '8', '199', '', 2, 1, '20', '32', '22', '100', '17'),
(4, '4', '198', '', 2, 1, '12', '14', '11', '100', '12'),
(5, '8', '199', '', 3, 1, '20', '32', '22', '10', '48'),
(6, '8', '199', '', 3, 1, '20', '32', '22', '100', '17'),
(7, '5', '198', '', 3, 1, '12', '14', '11', '100', '12'),
(8, '8', '199', '', 4, 1, '20', '32', '22', '10', '48'),
(9, '8', '199', '', 4, 1, '20', '32', '22', '100', '17'),
(10, '6', '198', '', 4, 1, '12', '14', '11', '100', '12'),
(11, '7', '172', '', 4, 1, '14', '19', '20', '150', '11'),
(12, '8', '199', '', 5, 1, '20', '32', '22', '10', '48'),
(13, '8', '199', '', 5, 1, '20', '32', '22', '100', '17'),
(14, '6', '198', '', 5, 1, '12', '14', '11', '100', '12'),
(15, '7', '172', '', 5, 1, '14', '19', '20', '150', '11'),
(16, '8', '199', '', 6, 1, '14', '10', '27', '', '12'),
(17, '2', '173', '', 6, 1, '10', '19', '17', '', '14');

-- --------------------------------------------------------

--
-- Structure de la table `logfichecranteuse`
--

CREATE TABLE `logfichecranteuse` (
  `idlogfichecranteuse` int(11) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `dateajout` timestamp NOT NULL DEFAULT current_timestamp(),
  `quart` varchar(255) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `dateCreation` varchar(255) DEFAULT NULL,
  `compteurdebut` varchar(255) DEFAULT NULL,
  `compteurfin` varchar(255) DEFAULT NULL,
  `controleur1` varchar(255) DEFAULT NULL,
  `controleur2` varchar(255) DEFAULT NULL,
  `controleur3` varchar(255) DEFAULT NULL,
  `machine` varchar(255) DEFAULT NULL,
  `observationdebut` varchar(255) DEFAULT NULL,
  `heuredepartquart` varchar(255) DEFAULT NULL,
  `heurefinquart` varchar(255) DEFAULT NULL,
  `saisisseur` varchar(255) DEFAULT NULL,
  `vitesse` varchar(255) DEFAULT NULL,
  `observationfin` varchar(255) DEFAULT NULL,
  `poidsestimetravaillenonnote` varchar(255) DEFAULT NULL,
  `accepteprodmodif` int(11) NOT NULL DEFAULT 0,
  `actifapprouvprod` int(11) NOT NULL DEFAULT 0,
  `idcranteuseq1` int(11) DEFAULT NULL,
  `couleurhistorique` int(11) NOT NULL DEFAULT 0,
  `couleurhistoriqueSup` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `logfichecranteuse`
--

INSERT INTO `logfichecranteuse` (`idlogfichecranteuse`, `user`, `dateajout`, `quart`, `actif`, `dateCreation`, `compteurdebut`, `compteurfin`, `controleur1`, `controleur2`, `controleur3`, `machine`, `observationdebut`, `heuredepartquart`, `heurefinquart`, `saisisseur`, `vitesse`, `observationfin`, `poidsestimetravaillenonnote`, `accepteprodmodif`, `actifapprouvprod`, `idcranteuseq1`, `couleurhistorique`, `couleurhistoriqueSup`) VALUES
(9, 'Mbaye Ndiago Thiam', '2024-06-08 19:39:49', '1', 1, '2024-06-04', '178', '300', 'Balla Gaye', 'balla Diouf', NULL, 'Cranteuse 2', 'RAS', '08:00', '16:00', 'Mbaye Ndiago Thiam', '3', 'J\'ai changer 175 en 173', '175', 0, 0, 28, 0, 0),
(10, 'Mbaye Ndiago Thiam', '2024-06-11 07:41:06', '2', 1, '2024-06-04', '180', '190', 'Bachir Ndiaye', 'Babacar Diop', NULL, 'Cranteuse 2', 'Ras.', '17:00', '23:00', 'Mbaye Ndiago Thiam', '3', 'ras', '100', 0, 0, 26, 0, 0),
(11, 'Mbaye Ndiago Thiam', '2024-06-11 08:01:44', '1', 1, '2024-06-04', '181', '191', 'Bachir Ndiaye 1', 'Babacar Diop 1', NULL, 'Cranteuse 1', 'Ras.', '08:00', '17:00', 'Mbaye Ndiago Thiam', '3', 'ras plus 172', '100', 0, 0, 26, 0, 0),
(12, 'Mbaye Ndiago Thiam', '2024-06-12 08:57:23', '2', 1, '2024-06-04', '178', '200', 'Bachir Ndiaye', 'Babacar Diop 1', NULL, 'Cranteuse 2', 'RAS debut.', '16:00', '23:00', 'Mbaye Ndiago Thiam', '3', 'RAS fin.', '120', 0, 0, 30, 0, 0),
(13, 'Mbaye Ndiago Thiam', '2024-06-20 08:46:49', '2', 1, '2024-06-04', '178', '200', 'Bachir Ndiaye', 'Babacar Diop 1', NULL, 'Cranteuse 2', 'RAS debut.', '16:00', '23:00', 'Mbaye Ndiago Thiam', '3', 'RAS fin.', '120', 0, 0, 30, 0, 0),
(14, 'Mbaye Ndiago Thiam', '2024-06-20 08:47:43', '3', 1, '2024-06-10', '140', '200', 'Bachir Ndiaye', 'Babacar Diop', NULL, 'Cranteuse 1', 'ras', '08:00', '17:00', 'Mbaye Ndiago Thiam', '3', 'ras', '120', 0, 0, 29, 0, 0),
(15, 'Mbaye Ndiago Thiam', '2024-06-20 08:49:34', '1', 1, '2024-06-04', '178', '300', 'Balla Gaye', 'balla Diouf', NULL, 'Cranteuse 2', 'RAS', '08:00', '16:00', 'Mbaye Ndiago Thiam', '3', 'J\'ai changer 173 en 175', '175', 0, 0, 28, 0, 0),
(16, 'Mbaye Ndiago Thiam', '2024-06-20 08:50:02', '3', 1, '2024-06-04', '1470', '1490', 'Bachir Ndiaye', 'balla Diouf', NULL, 'Cranteuse 2', 'RAS debut.', '00:00', '07:45', 'Mbaye Ndiago Thiam', '3', 'Ras fin.', '120', 0, 0, 27, 0, 0),
(17, '', '2024-06-20 14:49:11', '', 1, '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', 0, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `logfichedresseuse`
--

CREATE TABLE `logfichedresseuse` (
  `idlogfichedresseuse` int(11) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `dateajout` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `quart` varchar(255) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `dateCreation` varchar(255) DEFAULT NULL,
  `compteurdebut` varchar(255) DEFAULT NULL,
  `compteurfin` varchar(255) DEFAULT NULL,
  `controleur1` varchar(255) DEFAULT NULL,
  `controleur2` varchar(255) DEFAULT NULL,
  `machine` varchar(255) DEFAULT NULL,
  `observationdebut` varchar(500) DEFAULT NULL,
  `heuredepartquart` varchar(255) DEFAULT NULL,
  `heurefinquart` varchar(255) DEFAULT NULL,
  `saisisseur` varchar(255) DEFAULT NULL,
  `vitesse` varchar(255) DEFAULT NULL,
  `observationfin` varchar(500) DEFAULT NULL,
  `poidsestimetravaillenonnote` varchar(255) DEFAULT NULL,
  `idfichedresseuse` int(11) DEFAULT NULL,
  `accepteprodmodif` int(11) NOT NULL DEFAULT 0,
  `actifapprouvprod` int(11) NOT NULL DEFAULT 0,
  `couleurhistoriqueSup` int(11) NOT NULL DEFAULT 0,
  `couleurhistorique` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `logfichedresseuse`
--

INSERT INTO `logfichedresseuse` (`idlogfichedresseuse`, `user`, `dateajout`, `quart`, `actif`, `dateCreation`, `compteurdebut`, `compteurfin`, `controleur1`, `controleur2`, `machine`, `observationdebut`, `heuredepartquart`, `heurefinquart`, `saisisseur`, `vitesse`, `observationfin`, `poidsestimetravaillenonnote`, `idfichedresseuse`, `accepteprodmodif`, `actifapprouvprod`, `couleurhistoriqueSup`, `couleurhistorique`) VALUES
(1, 'Mbaye Ndiago Thiam', '2024-06-21 12:00:20', '1', 1, '2024-06-13', '142', '150', 'Balla Gaye', 'balla Diouf', 'Dresseuse 2', 'RAS debut.', '08:00', '16:45', 'Mbaye Ndiago Thiam', '3', 'Ras fin', '120', 1, 0, 0, 0, 0),
(2, 'Mbaye Ndiago Thiam', '2024-06-21 12:38:46', '1', 1, '2024-06-17', '143', '151', 'Balla Gaye 1', 'balla Diouf 1', 'Dresseuse 1', 'RAS debut 1.', '09:00', '17:45', 'Mbaye Ndiago Thiam', '2', 'Ras fin 1.', '125', 1, 0, 0, 0, 0),
(3, 'Mbaye Ndiago Thiam', '2024-06-21 13:59:26', '1', 1, '2024-06-17', '143', '151', 'Balla Gaye 1', 'balla Diouf 1', 'Dresseuse 1', 'RAS debut 1.', '09:00', '17:45', 'Mbaye Ndiago Thiam', '2', 'Ras fin 1.', '125', 1, 0, 0, 0, 0),
(4, 'Mbaye Ndiago Thiam', '2024-06-21 14:25:37', '1', 1, '2024-06-17', '143', '159', 'Balla Gaye 1', 'balla Diouf 1', 'Dresseuse 1', 'RAS debut 1.', '09:00', '17:45', 'Mbaye Ndiago Thiam', '3', 'Ras fin 15.', '129', 1, 0, 0, 0, 0),
(5, 'Mbaye Ndiago Thiam', '2024-06-21 14:28:24', '1', 1, '2024-06-17', '143', '159', 'Balla Gaye 1', 'balla Diouf 1', 'Dresseuse 1', 'RAS debut 1.', '09:00', '17:45', 'Mbaye Ndiago Thiam', '3', 'Ras fin 15.', '129', 1, 0, 0, 0, 0),
(6, 'Mbaye Ndiago Thiam', '2024-06-24 14:13:45', '1', 1, '2024-06-17', '177', '200', 'Bachir Ndiaye', 'balla Diouf', 'Dresseuse 6', 'RAS .', '08:00', '17:00', 'Mbaye Ndiago Thiam', '3', 'RAS fin.', '120', 5, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

CREATE TABLE `matiere` (
  `idmatiere` int(11) NOT NULL,
  `largeur` varchar(255) DEFAULT NULL,
  `poidsdeclare` varchar(255) NOT NULL,
  `poidspese` varchar(255) DEFAULT NULL,
  `dateajout` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user` varchar(255) DEFAULT NULL,
  `nbbobine` int(11) NOT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `actifapprouvreception` int(11) NOT NULL DEFAULT 0,
  `lieutransfert` varchar(255) NOT NULL,
  `idreception` int(11) DEFAULT NULL,
  `epaisseur` varchar(255) NOT NULL,
  `etatbobine` varchar(255) DEFAULT NULL,
  `transporteur` varchar(255) DEFAULT NULL,
  `acceptereceptionmodif` int(11) DEFAULT 0,
  `nbbobineactuel` int(11) NOT NULL DEFAULT 0,
  `couleurhistorique` int(11) DEFAULT 0,
  `numbobine` varchar(255) DEFAULT NULL,
  `idmatierereception` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `matiere`
--

INSERT INTO `matiere` (`idmatiere`, `largeur`, `poidsdeclare`, `poidspese`, `dateajout`, `user`, `nbbobine`, `actif`, `actifapprouvreception`, `lieutransfert`, `idreception`, `epaisseur`, `etatbobine`, `transporteur`, `acceptereceptionmodif`, `nbbobineactuel`, `couleurhistorique`, `numbobine`, `idmatierereception`) VALUES
(337, NULL, '1200', '', '2024-06-12 07:20:46', 'C', 15, 1, 0, 'Metal1', 50, '5.5', 'Normale', NULL, 0, 9, 0, NULL, NULL),
(338, NULL, '1300', '', '2024-06-12 07:19:39', 'a', 18, 1, 0, 'Niambour', 50, '7.5', 'Normale', NULL, 0, 14, 0, NULL, NULL),
(339, NULL, '1400', '', '2024-06-04 10:36:09', 'm', 19, 1, 0, 'Niambour', 45, '12', 'Normale', NULL, 0, 18, 0, NULL, NULL),
(340, NULL, '1300', '', '2024-06-19 10:57:54', 'C', 8, 1, 0, 'Metal1', 49, '4.5', 'Normale', NULL, 0, 6, 0, NULL, NULL),
(341, NULL, '1100', '', '2024-06-07 07:10:38', 'a', 9, 1, 0, 'Niambour', 49, '9', 'Normale', NULL, 0, 8, 0, NULL, NULL),
(342, NULL, '1000', '', '2024-06-04 10:32:00', 'm', 6, 1, 0, 'Metal1', 49, '10.5', 'Normale', NULL, 0, 4, 0, NULL, NULL),
(343, NULL, '1200', '', '2024-06-12 11:23:22', NULL, 1, 1, 0, 'Cranteuse', 50, '10.5', 'Normale', NULL, 0, 1, 0, '145', '342'),
(344, NULL, '1250', '', '2024-06-12 11:23:10', NULL, 1, 1, 0, 'Cranteuse', 50, '10.5', 'Normale', NULL, 0, 1, 0, '189', '342'),
(345, NULL, '1300', '', '2024-06-12 11:22:40', NULL, 1, 1, 0, 'Cranteuse', 50, '10.5', 'Normale', NULL, 0, 0, 0, '255', '342'),
(346, NULL, '1000', '', '2024-06-12 11:21:50', NULL, 1, 1, 0, 'Metal1', 50, '5.5', 'Normale', NULL, 0, 1, 0, '155', '337'),
(347, NULL, '1000', '', '2024-06-20 08:50:02', NULL, 1, 1, 0, 'Cranteuse', 50, '5.5', 'Normale', NULL, 0, 0, 0, '162', '337'),
(348, NULL, '1200', '', '2024-06-12 11:21:17', NULL, 1, 1, 0, 'Cranteuse', 50, '4.5', 'Normale', NULL, 0, 0, 0, '174', '340'),
(349, NULL, '1200', '', '2024-06-12 11:20:54', NULL, 1, 1, 0, 'Cranteuse', 50, '4.5', 'Normale', NULL, 0, 0, 0, '182', '340'),
(350, NULL, '1200', '', '2024-06-12 11:20:23', NULL, 1, 1, 0, 'Cranteuse', 50, '7.5', 'Normale', NULL, 0, 0, 0, '195', '338'),
(351, NULL, '1300', '0', '2024-06-12 11:19:57', NULL, 1, 1, 0, 'Cranteuse', 49, '12', 'Normale', NULL, 0, 0, 0, '256', '339'),
(352, NULL, '1100', '', '2024-06-20 08:47:43', NULL, 1, 1, 0, 'Cranteuse', 49, '9', 'Normale', NULL, 0, 0, 0, '171', '341'),
(353, NULL, '1000', '', '2024-06-12 11:18:52', NULL, 1, 1, 0, 'Cranteuse', 50, '5.5', 'Normale', NULL, 0, 0, 0, '172', '337'),
(354, NULL, '1150', '', '2024-06-20 08:47:43', NULL, 1, 1, 0, 'Cranteuse', 50, '5.5', 'Normale', NULL, 0, 0, 0, '173', '337'),
(355, NULL, '1200', '', '2024-06-20 08:49:34', NULL, 1, 1, 0, 'Cranteuse', 50, '5.5', 'Normale', NULL, 0, 0, 0, '175', '337'),
(356, NULL, '1000', '', '2024-06-20 08:46:49', NULL, 1, 1, 0, 'Cranteuse', 50, '7.5', 'Normale', NULL, 0, 0, 0, '198', '338'),
(357, NULL, '1100', '', '2024-06-20 08:46:49', NULL, 1, 1, 0, 'Cranteuse', 50, '7.5', 'Normale', NULL, 0, 0, 0, '199', '338'),
(358, NULL, '1000', '', '2024-06-12 11:16:22', NULL, 1, 1, 0, 'Cranteuse', 50, '5.5', 'Normale', NULL, 0, 1, 0, '114', '337'),
(359, NULL, '1000', '', '2024-06-19 10:57:54', NULL, 1, 1, 0, 'Cranteuse', 49, '4.5', 'Normale', NULL, 0, 0, 0, '141', '340');

-- --------------------------------------------------------

--
-- Structure de la table `matiereplanifie`
--

CREATE TABLE `matiereplanifie` (
  `idmatiereplanifie` int(11) NOT NULL,
  `epaisseur` varchar(255) NOT NULL,
  `poidsdeclare` varchar(255) DEFAULT NULL,
  `dateajout` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nbbobine` int(11) NOT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `lieutransfert` varchar(255) DEFAULT NULL,
  `idreception` int(11) DEFAULT NULL,
  `datereception` varchar(255) DEFAULT NULL,
  `poidsbrut` varchar(255) DEFAULT NULL,
  `actifRectifie` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `matiereplanifie`
--

INSERT INTO `matiereplanifie` (`idmatiereplanifie`, `epaisseur`, `poidsdeclare`, `dateajout`, `nbbobine`, `actif`, `lieutransfert`, `idreception`, `datereception`, `poidsbrut`, `actifRectifie`) VALUES
(100, '3', '1000.50', '2024-05-02 07:30:20', 10, 1, '', 49, NULL, '1000', 1),
(101, '3', '1400.80', '2024-05-02 07:30:20', 14, 1, '', 49, NULL, '1400', 1),
(102, '3', '2000.90', '2024-05-02 07:30:20', 15, 1, '', 49, NULL, '2000', 1),
(103, '3', '1000.80', '2024-05-02 07:30:20', 9, 1, '', 49, NULL, '1000', 1),
(104, '3.5', '1000', '2024-05-11 09:05:33', 12, 1, '', 50, NULL, '1000', 1),
(105, '6.5', '1200', '2024-05-11 09:05:33', 25, 1, '', 50, NULL, '1200', 1);

-- --------------------------------------------------------

--
-- Structure de la table `production`
--

CREATE TABLE `production` (
  `idproduction` int(11) NOT NULL,
  `dateproduction` varchar(255) NOT NULL,
  `matricule` varchar(255) NOT NULL,
  `matricule2` varchar(255) NOT NULL,
  `idordre` int(11) NOT NULL,
  `idquart` int(11) NOT NULL,
  `referencemachine` varchar(255) NOT NULL,
  `etat` varchar(255) NOT NULL,
  `ch_debut` varchar(255) NOT NULL,
  `ch_fin` varchar(255) NOT NULL,
  `date_saisie` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `idmachine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reception`
--

CREATE TABLE `reception` (
  `idreception` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Nouvelle reception',
  `datecreation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user` varchar(255) NOT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `actifapprouvreception` int(11) NOT NULL DEFAULT 1,
  `acceptereception` int(11) NOT NULL DEFAULT 0,
  `nomrecepteur` varchar(255) DEFAULT NULL,
  `entetedf` varchar(255) DEFAULT NULL,
  `commentaire` varchar(500) DEFAULT NULL,
  `matriculecamion` varchar(255) DEFAULT NULL,
  `poidscamion` varchar(255) DEFAULT NULL,
  `datereception` varchar(255) DEFAULT NULL,
  `bl` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reception`
--

INSERT INTO `reception` (`idreception`, `status`, `datecreation`, `user`, `actif`, `actifapprouvreception`, `acceptereception`, `nomrecepteur`, `entetedf`, `commentaire`, `matriculecamion`, `poidscamion`, `datereception`, `bl`) VALUES
(49, 'En cours de reception', '2024-04-25 20:35:07', 'Mouhamadoul Bachir Ndiaye', 1, 1, 0, 'diop', 'DF189', 'une bobine 8.5 est disloquée pendant la decharge. Les bobines de 8.5 sont aussi disloquées.', 'AA1547T', '15000', '2024-04-24', '14238'),
(50, 'En cours de reception', '2024-06-03 15:46:33', 'Mouhamadoul Bachir Ndiaye', 1, 1, 0, 'Baba Ndiaye', 'DF190', 'Ras', 'AA1547T ', '15000', '2024-05-07', '15081');

-- --------------------------------------------------------

--
-- Structure de la table `receptionplanifiee`
--

CREATE TABLE `receptionplanifiee` (
  `idreception` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `datecreation` timestamp NULL DEFAULT NULL,
  `user` varchar(255) NOT NULL,
  `actif` varchar(255) NOT NULL,
  `datereception` varchar(255) DEFAULT NULL,
  `entetedf` varchar(255) DEFAULT NULL,
  `commentaire` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `receptionplanifiee`
--

INSERT INTO `receptionplanifiee` (`idreception`, `status`, `datecreation`, `user`, `actif`, `datereception`, `entetedf`, `commentaire`) VALUES
(49, 'Réception planifiée', '2024-04-25 20:24:38', 'Mouhamadoul Bachir Ndiaye', '1', '2024-04-28', 'DF189', 'A recevoir avec précaution. '),
(50, 'Réception planifiée', '2024-05-11 08:57:49', 'Mouhamadoul Bachir Ndiaye', '1', '2024-05-24', 'DF190', 'Reception.');

-- --------------------------------------------------------

--
-- Structure de la table `transfert`
--

CREATE TABLE `transfert` (
  `idtransfert` int(11) NOT NULL,
  `dateajout` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user` varchar(255) NOT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `commentaire` varchar(500) DEFAULT NULL,
  `saisisseur` varchar(255) DEFAULT NULL,
  `datetransfert` varchar(255) DEFAULT NULL,
  `transporteur` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `transfert`
--

INSERT INTO `transfert` (`idtransfert`, `dateajout`, `user`, `actif`, `commentaire`, `saisisseur`, `datetransfert`, `transporteur`) VALUES
(71, '2024-04-25 20:46:22', 'Camara', 1, '', 'Assane', '2024-04-24', 'Diop Fall'),
(72, '2024-05-02 08:19:25', 'Camara', 1, 'Je fais ce commentaire pour le transfert.', 'Bachir Ndiaye', '2024-05-02', 'Modou'),
(73, '2024-05-27 14:53:55', 'Camara', 1, 'Ras.', 'Bachir Diop', '2024-05-03', 'Gaye');

-- --------------------------------------------------------

--
-- Structure de la table `transfertdetails`
--

CREATE TABLE `transfertdetails` (
  `idtransfertdetail` int(11) NOT NULL,
  `poidspese` int(11) DEFAULT NULL,
  `dateajout` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` varchar(255) DEFAULT NULL,
  `nbbobine` int(11) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT 1,
  `pointdepart` varchar(255) NOT NULL,
  `idtransfert` int(11) NOT NULL,
  `epaisseur` varchar(255) NOT NULL,
  `etatbobine` varchar(255) NOT NULL,
  `poidsdeclare` int(11) DEFAULT NULL,
  `commentaire` varchar(500) DEFAULT NULL,
  `pointarrive` varchar(255) DEFAULT NULL,
  `actifapprouvtransfert` int(11) NOT NULL DEFAULT 0,
  `acceptereceptionmodif` int(11) NOT NULL DEFAULT 0,
  `idmatieredepart` int(11) DEFAULT NULL,
  `idmatierearrive` int(11) DEFAULT NULL,
  `couleurhistorique` int(11) DEFAULT 0,
  `codereception` varchar(255) DEFAULT NULL,
  `numbobine` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `transfertdetails`
--

INSERT INTO `transfertdetails` (`idtransfertdetail`, `poidspese`, `dateajout`, `user`, `nbbobine`, `actif`, `pointdepart`, `idtransfert`, `epaisseur`, `etatbobine`, `poidsdeclare`, `commentaire`, `pointarrive`, `actifapprouvtransfert`, `acceptereceptionmodif`, `idmatieredepart`, `idmatierearrive`, `couleurhistorique`, `codereception`, `numbobine`) VALUES
(127, 0, '2024-06-03 16:01:46', NULL, 1, 1, 'Metal1', 73, '10.5', 'Normale', 1200, 'Ras.', 'Cranteuse', 0, 0, 342, 343, 0, NULL, '145'),
(128, 0, '2024-06-03 16:01:46', NULL, 1, 1, 'Metal1', 73, '10.5', 'Normale', 1250, 'Ras.', 'Cranteuse', 0, 0, 342, 344, 0, NULL, '189'),
(129, 0, '2024-06-03 16:01:46', NULL, 1, 1, 'Niambour', 73, '12', 'Normale', 1300, 'Ras.', 'Cranteuse', 0, 0, 339, 351, 2, NULL, '256'),
(130, 0, '2024-06-03 16:01:46', NULL, 1, 1, 'Metal1', 73, '5.5', 'Normale', 1000, 'Ras.', 'Metal1', 0, 0, 337, 346, 0, NULL, '155'),
(131, 0, '2024-06-03 16:01:46', NULL, 1, 1, 'Metal1', 73, '5.5', 'Normale', 1000, 'Ras.', 'Cranteuse', 0, 0, 337, 347, 0, NULL, '162'),
(132, 0, '2024-06-03 16:01:46', NULL, 1, 1, 'Metal1', 73, '4.5', 'Normale', 1200, 'Ras.', 'Cranteuse', 0, 0, 340, 348, 0, NULL, '174'),
(133, 0, '2024-06-03 16:01:46', NULL, 1, 0, 'Metal1', 73, '4.5', 'Normale', 1200, 'Ras.', 'Cranteuse', 1, 0, 340, 349, 1, NULL, '182'),
(134, 0, '2024-06-04 10:06:35', NULL, 1, 1, 'Niambour', 73, '7.5', 'Normale', 1200, 'Ras.', 'Cranteuse', 0, 0, 338, 350, 0, NULL, '195'),
(135, 0, '2024-06-07 07:10:38', NULL, 1, 1, 'Niambour', 73, '9', 'Normale', 1100, 'Ras.', 'Cranteuse', 0, 0, 341, 352, 0, NULL, '171'),
(136, 0, '2024-06-07 07:15:36', NULL, 1, 1, 'Metal1', 73, '5.5', 'Normale', 1000, 'Ras.', 'Cranteuse', 0, 0, 337, 353, 0, NULL, '172'),
(137, 0, '2024-06-07 07:15:36', NULL, 1, 1, 'Metal1', 73, '5.5', 'Normale', 1150, 'Ras.', 'Cranteuse', 0, 0, 337, 354, 0, NULL, '173'),
(138, 0, '2024-06-07 07:15:36', NULL, 1, 1, 'Metal1', 73, '5.5', 'Normale', 1200, 'Ras.', 'Cranteuse', 0, 0, 337, 355, 0, NULL, '175'),
(139, 0, '2024-06-12 07:19:39', NULL, 1, 1, 'Niambour', 73, '7.5', 'Normale', 1000, 'Ras.', 'Cranteuse', 0, 0, 338, 356, 0, NULL, '198'),
(140, 0, '2024-06-12 07:19:39', NULL, 1, 1, 'Niambour', 73, '7.5', 'Normale', 1100, 'Ras.', 'Cranteuse', 0, 0, 338, 357, 0, NULL, '199'),
(141, 0, '2024-06-12 07:20:46', NULL, 1, 1, 'Metal1', 73, '5.5', 'Normale', 1000, 'Ras.', 'Cranteuse', 0, 0, 337, 358, 0, NULL, '114'),
(142, 0, '2024-06-12 11:12:24', NULL, 1, 1, 'Metal1', 73, '4.5', 'Normale', 1000, 'Ras.', 'Cranteuse', 1, 0, 340, 359, 0, NULL, '141');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomcomplet` varchar(255) NOT NULL,
  `niveau` varchar(255) NOT NULL,
  `matricule` varchar(255) NOT NULL,
  `datecreation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `actif` int(11) NOT NULL DEFAULT 1,
  `numTelephone` varchar(255) DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `username`, `password`, `email`, `nomcomplet`, `niveau`, `matricule`, `datecreation`, `actif`, `numTelephone`, `section`) VALUES
(12, 'bndiaye', 'cef68bb63ddf6ee9d4ff3cee9d675fbdb83a94a9', 'mouhamadoulbachir2@gmail.com', 'Mouhamadoul Bachir Ndiaye', 'admin', '125', '2024-04-24 21:29:25', 1, '708000000', 'IT'),
(13, 'camara', 'cef68bb63ddf6ee9d4ff3cee9d675fbdb83a94a9', 'mbndiaye@metalafrique.com', 'Camara', 'pontbascule', '125', '2024-04-24 21:28:06', 1, '708000000', 'Pont bascule'),
(18, 'mthiam', 'cef68bb63ddf6ee9d4ff3cee9d675fbdb83a94a9', 'mouhamadoulbachirndiaye@esp.sn', 'Mbaye Ndiago Thiam', 'chefquart', '125', '2024-05-15 14:14:33', 1, '708000000', 'Production');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cranteuseechantillon`
--
ALTER TABLE `cranteuseechantillon`
  ADD PRIMARY KEY (`idcranteuseechantillon`);

--
-- Index pour la table `cranteuseq1`
--
ALTER TABLE `cranteuseq1`
  ADD PRIMARY KEY (`idcranteuseq1`);

--
-- Index pour la table `cranteuseq1arret`
--
ALTER TABLE `cranteuseq1arret`
  ADD PRIMARY KEY (`idcranteuseq1arret`);

--
-- Index pour la table `cranteuseq1consommation`
--
ALTER TABLE `cranteuseq1consommation`
  ADD PRIMARY KEY (`idcranteuseq1consommation`);

--
-- Index pour la table `cranteuseq1production`
--
ALTER TABLE `cranteuseq1production`
  ADD PRIMARY KEY (`idcranteuseq1production`);

--
-- Index pour la table `detailproduction`
--
ALTER TABLE `detailproduction`
  ADD PRIMARY KEY (`idtravail`);

--
-- Index pour la table `dresseusearret`
--
ALTER TABLE `dresseusearret`
  ADD PRIMARY KEY (`iddresseusearret`);

--
-- Index pour la table `dresseuseconsommation`
--
ALTER TABLE `dresseuseconsommation`
  ADD PRIMARY KEY (`iddresseuseconsommation`);

--
-- Index pour la table `dresseuseproduction`
--
ALTER TABLE `dresseuseproduction`
  ADD PRIMARY KEY (`iddresseuseproduction`);

--
-- Index pour la table `epaisseur`
--
ALTER TABLE `epaisseur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `etatproduction`
--
ALTER TABLE `etatproduction`
  ADD PRIMARY KEY (`idetatproduction`);

--
-- Index pour la table `exportation`
--
ALTER TABLE `exportation`
  ADD PRIMARY KEY (`idexportation`);

--
-- Index pour la table `exportationdetails`
--
ALTER TABLE `exportationdetails`
  ADD PRIMARY KEY (`idexportationdetail`);

--
-- Index pour la table `fichecranteuseq1`
--
ALTER TABLE `fichecranteuseq1`
  ADD PRIMARY KEY (`idfichecranteuseq1`);

--
-- Index pour la table `fichedresseuse`
--
ALTER TABLE `fichedresseuse`
  ADD PRIMARY KEY (`idfichedresseuse`);

--
-- Index pour la table `fichetrefilage`
--
ALTER TABLE `fichetrefilage`
  ADD PRIMARY KEY (`idfichetrefilage`);

--
-- Index pour la table `logcranteusearret`
--
ALTER TABLE `logcranteusearret`
  ADD PRIMARY KEY (`idlogcranteusearret`);

--
-- Index pour la table `logcranteuseconsommation`
--
ALTER TABLE `logcranteuseconsommation`
  ADD PRIMARY KEY (`idlogcranteuseconsommation`);

--
-- Index pour la table `logcranteuseechantillon`
--
ALTER TABLE `logcranteuseechantillon`
  ADD PRIMARY KEY (`idlogcranteuseechantillon`);

--
-- Index pour la table `logcranteuseproduction`
--
ALTER TABLE `logcranteuseproduction`
  ADD PRIMARY KEY (`idlogcranteuseproduction`);

--
-- Index pour la table `logdresseusearret`
--
ALTER TABLE `logdresseusearret`
  ADD PRIMARY KEY (`idlogdresseusearret`);

--
-- Index pour la table `logdresseuseconsommation`
--
ALTER TABLE `logdresseuseconsommation`
  ADD PRIMARY KEY (`idlogdresseuseconsommation`);

--
-- Index pour la table `logdresseuseproduction`
--
ALTER TABLE `logdresseuseproduction`
  ADD PRIMARY KEY (`idlogdresseuseproduction`);

--
-- Index pour la table `logfichecranteuse`
--
ALTER TABLE `logfichecranteuse`
  ADD PRIMARY KEY (`idlogfichecranteuse`);

--
-- Index pour la table `logfichedresseuse`
--
ALTER TABLE `logfichedresseuse`
  ADD PRIMARY KEY (`idlogfichedresseuse`);

--
-- Index pour la table `matiere`
--
ALTER TABLE `matiere`
  ADD PRIMARY KEY (`idmatiere`);

--
-- Index pour la table `matiereplanifie`
--
ALTER TABLE `matiereplanifie`
  ADD PRIMARY KEY (`idmatiereplanifie`);

--
-- Index pour la table `production`
--
ALTER TABLE `production`
  ADD PRIMARY KEY (`idproduction`);

--
-- Index pour la table `reception`
--
ALTER TABLE `reception`
  ADD PRIMARY KEY (`idreception`);

--
-- Index pour la table `receptionplanifiee`
--
ALTER TABLE `receptionplanifiee`
  ADD PRIMARY KEY (`idreception`);

--
-- Index pour la table `transfert`
--
ALTER TABLE `transfert`
  ADD PRIMARY KEY (`idtransfert`);

--
-- Index pour la table `transfertdetails`
--
ALTER TABLE `transfertdetails`
  ADD PRIMARY KEY (`idtransfertdetail`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cranteuseechantillon`
--
ALTER TABLE `cranteuseechantillon`
  MODIFY `idcranteuseechantillon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `cranteuseq1`
--
ALTER TABLE `cranteuseq1`
  MODIFY `idcranteuseq1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `cranteuseq1arret`
--
ALTER TABLE `cranteuseq1arret`
  MODIFY `idcranteuseq1arret` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT pour la table `cranteuseq1consommation`
--
ALTER TABLE `cranteuseq1consommation`
  MODIFY `idcranteuseq1consommation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `cranteuseq1production`
--
ALTER TABLE `cranteuseq1production`
  MODIFY `idcranteuseq1production` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `detailproduction`
--
ALTER TABLE `detailproduction`
  MODIFY `idtravail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dresseusearret`
--
ALTER TABLE `dresseusearret`
  MODIFY `iddresseusearret` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `dresseuseconsommation`
--
ALTER TABLE `dresseuseconsommation`
  MODIFY `iddresseuseconsommation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `dresseuseproduction`
--
ALTER TABLE `dresseuseproduction`
  MODIFY `iddresseuseproduction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `epaisseur`
--
ALTER TABLE `epaisseur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `etatproduction`
--
ALTER TABLE `etatproduction`
  MODIFY `idetatproduction` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `exportation`
--
ALTER TABLE `exportation`
  MODIFY `idexportation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `exportationdetails`
--
ALTER TABLE `exportationdetails`
  MODIFY `idexportationdetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `fichecranteuseq1`
--
ALTER TABLE `fichecranteuseq1`
  MODIFY `idfichecranteuseq1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `fichedresseuse`
--
ALTER TABLE `fichedresseuse`
  MODIFY `idfichedresseuse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `fichetrefilage`
--
ALTER TABLE `fichetrefilage`
  MODIFY `idfichetrefilage` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `logcranteusearret`
--
ALTER TABLE `logcranteusearret`
  MODIFY `idlogcranteusearret` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `logcranteuseconsommation`
--
ALTER TABLE `logcranteuseconsommation`
  MODIFY `idlogcranteuseconsommation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `logcranteuseechantillon`
--
ALTER TABLE `logcranteuseechantillon`
  MODIFY `idlogcranteuseechantillon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `logcranteuseproduction`
--
ALTER TABLE `logcranteuseproduction`
  MODIFY `idlogcranteuseproduction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `logdresseusearret`
--
ALTER TABLE `logdresseusearret`
  MODIFY `idlogdresseusearret` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `logdresseuseconsommation`
--
ALTER TABLE `logdresseuseconsommation`
  MODIFY `idlogdresseuseconsommation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `logdresseuseproduction`
--
ALTER TABLE `logdresseuseproduction`
  MODIFY `idlogdresseuseproduction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `logfichecranteuse`
--
ALTER TABLE `logfichecranteuse`
  MODIFY `idlogfichecranteuse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `logfichedresseuse`
--
ALTER TABLE `logfichedresseuse`
  MODIFY `idlogfichedresseuse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `matiere`
--
ALTER TABLE `matiere`
  MODIFY `idmatiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=360;

--
-- AUTO_INCREMENT pour la table `matiereplanifie`
--
ALTER TABLE `matiereplanifie`
  MODIFY `idmatiereplanifie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT pour la table `production`
--
ALTER TABLE `production`
  MODIFY `idproduction` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reception`
--
ALTER TABLE `reception`
  MODIFY `idreception` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `receptionplanifiee`
--
ALTER TABLE `receptionplanifiee`
  MODIFY `idreception` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `transfert`
--
ALTER TABLE `transfert`
  MODIFY `idtransfert` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT pour la table `transfertdetails`
--
ALTER TABLE `transfertdetails`
  MODIFY `idtransfertdetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
