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
(1, 'Park bath ', 'County.St', 3293.06, 'Normal Park', NULL, 51.442552, -2.576018, 'https://visitbristol.co.uk/dbimgs/All%20Together%20Now%20-%20Joshua%20Perrett.jpg', 'Park', 'https://cdn-icons-png.flaticon.com/512/1183/1183384.png'),
(2, 'Park', 'Park.st', 5615.15, NULL, NULL, 51.441638, -2.572544, NULL, 'Park', 'https://cdn-icons-png.flaticon.com/512/1183/1183384.png'),
(3, 'School Road Park', 'School Rd, Totterdown, Bristol BS4 3DJ, Royaume-Uni', 3457.86, NULL, NULL, 51.440401, -2.572793, NULL, 'Park', 'https://cdn-icons-png.flaticon.com/512/1183/1183384.png'),
(4, 'Zone A', 'Wells Rd, Totterdown, Bristol BS4 3AL, Royaume-Uni', 1090.18, NULL, NULL, 51.441444, -2.576156, NULL, 'Park', 'https://cdn-icons-png.flaticon.com/512/1183/1183384.png'),
(5, 'Greens', '3 Knowle Rd, Totterdown, Bristol BS4 2EB, Royaume-Uni', 556.07, NULL, NULL, 51.441091, -2.576330, NULL, 'Garden', 'https://cdn-icons-png.flaticon.com/512/1183/1183384.png'),
(6, 'Busty Park', 'Bushy Park, Totterdown, Bristol BS4 2EG, Royaume-Uni', 930.89, NULL, '0000-00-00', 51.441555, -2.578356, NULL, 'Park', 'https://cdn-icons-png.flaticon.com/512/1183/1183384.png'),
(7, 'St.John\'s lane', 'Totterdown, Bristol BS4 2EG, Royaume-Uni', 4299.02, NULL, NULL, 51.440920, -2.580070, NULL, 'Other', 'https://cdn-icons-png.flaticon.com/512/1183/1183384.png'),
(8, 'Local Green Space ', '17 Oxford St, Totterdown, Bristol BS3 4RQ, Royaume-Uni', 3194.29, 'Local GreenSpace with a Bus Station ', NULL, 51.443203, -2.578593, NULL, 'Other', NULL),
(9, 'Higham Street Garden', 'Higham St, Bristol BS4 2BJ, Royaume-Uni', 3206.93, NULL, NULL, 51.444748, -2.579049, NULL, 'Garden', NULL),
(10, 'Local GreenSpace of St.Lukes Road', 'Wycliffe Row, Bristol BS3 4RZ, Royaume-Uni', 1793.18, NULL, NULL, 51.442227, -2.583418, NULL, 'Other', NULL);

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
(1, 'Dog', 'Animals', 51.442552, -2.576018, 'https://cdn4.iconfinder.com/data/icons/zoo-17/60/zoo__location__navigation__wild__map-512.png', 1);

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
