-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 04 mars 2024 à 05:39
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
-- Base de données : `tresa_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `private_greenspaces`
--

CREATE TABLE `private_greenspaces` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `Size` decimal(10,2) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `DateEstablished` date DEFAULT NULL,
  `Lat` decimal(10,0) DEFAULT NULL,
  `Long` decimal(10,0) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Type` enum('Backyard','Courtyard','Private Forest','Private Garden','Other') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `public_greenspaces`
--

CREATE TABLE `public_greenspaces` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `Size` decimal(10,2) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `DateEstablished` date DEFAULT NULL,
  `Lat` decimal(10,6) DEFAULT NULL,
  `Long` decimal(10,6) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Type` enum('Park','Garden','Forest','Wetland','Other') NOT NULL,
  `IconPath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `public_greenspaces`
--

INSERT INTO `public_greenspaces` (`ID`, `Name`, `Location`, `Size`, `Description`, `DateEstablished`, `Lat`, `Long`, `Image`, `Type`, `IconPath`) VALUES
(1, 'Higham Street Green', 'Higham St, Bristol BS4 2BJ', 3207, 'Fenceposted green area with trees, grasses and flowers', NULL, 51.444748, -2.579049, NULL, 'Park', NULL),
(2, 'Wells Road Embankment', 'Bellevue Road Bus Stop, Wells Road, Totterdown, Bristol BS3 4RQ', 3194, 'Trees, Flowers and Grasses on Wells Road', NULL, 51.44309873076185, -2.5786215972701387, NULL, 'Park', NULL),
(3, 'The Three Signs Lamps Signpost', '6 Higham St, Totterdown, Bristol BS4 2BJ', 316, 'Small area of grasses and shrubs on the intersection of Wells and Bath Road', NULL, 51.4441209286486, -2.578338132975402, NULL, 'Grass', NULL),
(4, 'Zone A', 'Wells Rd, Totterdown, Bristol BS4 3AL', 1090, 'Dedicated community green area', NULL, 51.4414372039459, -2.576150642288253, NULL, 'Park', NULL),
(5, 'Angers Road Park', 'Totterdown, Bristol BS4 3AG', 3293, 'Park located on County Street, Kingstree Street and Angers Road', NULL, 51.442563079645936, -2.5759799650810056, NULL, 'Park', NULL),
(6, 'School Road Park', 'School Rd, Totterdown, Bristol BS4 3DJ', 3458, 'Park located on School Road', NULL, 51.44032633442105, -2.5728892256551728, NULL, 'Park', NULL),
(7, 'Park Street Community Space', '63-51 Park St, Totterdown, Bristol', 5615, 'Community Space located on a steep hillside', NULL, 51.44183123363889, -2.57249226838304, NULL, 'Community Space', NULL),
(8, 'Wycliffe Row Embankment', 'Wycliffe Row, Bristol BS3 4RZ', 3595, 'Embankment with trees and grasses between Wycliffe Row and St Lukes Road', NULL, 51.442359349729436, -2.583488170490007, NULL, 'Embankment', NULL),
(9, 'Oxford Street Car Park', 'Oxford St, Totterdown, Bristol BS3 4RJ', 1450, 'Hedges and Trees surrounding and within the Oxford Street Car Park', NULL, 51.44172911534412, -2.5789820784308404, NULL, 'Hedges', NULL),
(10, 'St Johns Lane Embankment', 'Totterdown, Bristol BS4 2EG', 3597, 'Grass and Trees with pathsways just off St Johns Lane', NULL, 51.44101239148049, -2.57966945614291, NULL, 'Embankment', NULL),
(11, 'Bushy Park', 'Bushy Park, Totterdown, Bristol BS4 2EG', 1092, 'Bushy Park', NULL, 51.44154892795166, -2.5782951673008636, NULL, 'Park', NULL),
(12, 'St Johns Lane and Wells Road Intersection', '33 Oxford St, Totterdown, Bristol BS3 4RJ', 228, 'Small area of grass next to pedestrian pathway for the intersection', NULL, 51.441850073694866, -2.578304978163266, NULL, 'Grass', NULL),
(13, 'Oxford Street Embankment', 'Oxford St, Totterdown, Bristol', 2992, 'Embankment with grasses and trees inbetween Oxford Street and St Johns Lane', NULL, 51.44112257258446, -2.580225077920557, NULL, 'Embankment', NULL),
(14, 'Winton Street Car Park', 'Winton St, Totterdown, Bristol BS4 2BT', 556, 'Hedges and Trees surround car park on Winton Street', NULL, 51.44110587333831, -2.5762745348363336, NULL, 'Hedges', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `ID` int(11) NOT NULL,
  `GreenspaceID` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `wildlife`
--

CREATE TABLE `wildlife` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Category` enum('Animals','Birds','Insects','Reptiles','Amphibians','Fish','Plants','Other') NOT NULL,
  `Wildlife_lat` decimal(10,6) NOT NULL,
  `Wildlife_long` decimal(10,6) NOT NULL,
  `IconPath` varchar(255) NOT NULL,
  `GreenspaceID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wildlife`
--

INSERT INTO `wildlife` (`ID`, `Name`, `Category`, `Wildlife_lat`, `Wildlife_long`, `IconPath`, `GreenspaceID`) VALUES
(1, 'Dog', 'Animals', 51.442552, -2.576018, '', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `private_greenspaces`
--
ALTER TABLE `private_greenspaces`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `public_greenspaces`
--
ALTER TABLE `public_greenspaces`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `wildlife`
--
ALTER TABLE `wildlife`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `GreenspaceID` (`GreenspaceID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `private_greenspaces`
--
ALTER TABLE `private_greenspaces`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `public_greenspaces`
--
ALTER TABLE `public_greenspaces`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wildlife`
--
ALTER TABLE `wildlife`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `wildlife`
--
ALTER TABLE `wildlife`
  ADD CONSTRAINT `wildlife_ibfk_1` FOREIGN KEY (`GreenspaceID`) REFERENCES `public_greenspaces` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
