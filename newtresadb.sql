-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 14 mars 2024 à 17:52
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
-- Base de données : `newtresadb`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Trees'),
(2, 'Flowers'),
(3, 'Hedges'),
(4, 'Birds'),
(5, 'Insects');

-- --------------------------------------------------------

--
-- Structure de la table `category_has_post`
--

CREATE TABLE `category_has_post` (
  `FK_post_id` int(11) NOT NULL,
  `FK_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `category_has_post`
--

INSERT INTO `category_has_post` (`FK_post_id`, `FK_category_id`) VALUES
(2, 1),
(2, 2),
(4, 1),
(4, 2),
(4, 4),
(4, 5),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `category`, `rating`, `message`, `created_at`) VALUES
(3, 'Rayan', 'rayanlouahche2004@gmail.com', 'Bug', 0, 'TEST TEST TEST TEST', '2024-03-10 03:34:22'),
(5, 'Rayan', 'rayanlouahche2004@gmail.com', 'Bug', 2, 'I was unsatisfied ', '2024-03-11 10:58:41'),
(6, 'Ryan', 'rayanlouahche2004@gmail.com', 'Feature Request', 5, 'I was very satisfied using the map ', '2024-03-11 11:24:12');

-- --------------------------------------------------------

--
-- Structure de la table `privatespace_post`
--

CREATE TABLE `privatespace_post` (
  `post_id` int(11) NOT NULL,
  `post_resident_name` varchar(45) NOT NULL,
  `post_resident_email` varchar(256) NOT NULL,
  `post_lat` float NOT NULL,
  `post_long` float NOT NULL,
  `post_desc` varchar(2000) NOT NULL,
  `post_dimens` varchar(45) NOT NULL,
  `post_image` tinyblob NOT NULL,
  `post_anon` varchar(45) DEFAULT NULL,
  `validated` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `privatespace_post`
--

INSERT INTO `privatespace_post` (`post_id`, `post_resident_name`, `post_resident_email`, `post_lat`, `post_long`, `post_desc`, `post_dimens`, `post_image`, `post_anon`, `validated`) VALUES
(2, 'sampledata', 'carlm@gmail.com', 51.4412, -2.58018, 'ww', '12', 0xffd8ffe000104a46494600010100000100010000ffdb008400090607080706090807080a0a090b0d160f0d0c0c0d1b14151016201d2222201d1f1f2428342c242631271f1f2d3d2d3135373a3a3a232b3f443f384334393a37010a0a0a0d0c0d1a0f0f1a37251f253737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737ffc0001108009e00e403012200021101031101ffc4001b00000105010100000000000000000000000301020405060007ffc400401000020103010406070603070500000000010203000411210512314113225161718106143291a1b1c123425272d1f01533, '1', NULL),
(4, 'ryan', 'ryanlouch8@gmail.com', 51.4423, -2.57761, 'My private garden', '24', 0x666f726d696d616765732f626972642e6a7067, '0', '1'),
(5, 'ryan', 'ryanlouch8@gmail.com', 51.4421, -2.57693, 'My private garden ', '35', 0x666f726d696d616765732f626972642e6a7067, '0', '0');

-- --------------------------------------------------------

--
-- Structure de la table `publicspace_post`
--

CREATE TABLE `publicspace_post` (
  `post_id` int(11) NOT NULL,
  `post_area_name` varchar(45) NOT NULL,
  `post_lat` float NOT NULL,
  `post_long` float NOT NULL,
  `post_desc` varchar(2000) NOT NULL,
  `post_dimens` varchar(45) NOT NULL,
  `post_image` varchar(45) DEFAULT NULL,
  `validated` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `publicspace_post`
--

INSERT INTO `publicspace_post` (`post_id`, `post_area_name`, `post_lat`, `post_long`, `post_desc`, `post_dimens`, `post_image`, `validated`) VALUES
(1, 'Higham Street Green', 51.4447, -2.57905, 'Fenceposted green area with trees, grasses and flowers', '3207', NULL, NULL),
(2, 'Wells Road Embankment', 51.4431, -2.57862, 'Trees, Flowers and Grasses on Wells Road', '3194', NULL, NULL),
(3, 'The Three Signs Lamps Signpost', 51.4441, -2.57834, 'Small area of grasses and shrubs on the intersection of Wells and Bath Road', '316', NULL, NULL),
(4, 'Zone A', 51.4414, -2.57615, 'Dedicated community green area', '1090', NULL, NULL),
(5, 'Angers Road Park', 51.4426, -2.57598, 'Park located on County Street, Kingstree Street and Angers Road', '3293', NULL, NULL),
(6, 'School Road Park', 51.4403, -2.57289, 'Park located on School Road', '3458', NULL, NULL),
(7, 'Park Street Community Space', 51.4418, -2.57249, 'Community Space located on a steep hillside', '5615', NULL, NULL),
(8, 'Wycliffe Row Embankment', 51.4424, -2.58349, 'Embankment with trees and grasses between Wycliffe Row and St Lukes Road', '3595', NULL, NULL),
(9, 'Oxford Street Car Park', 51.4417, -2.57898, 'Hedges and Trees surrounding and within the Oxford Street Car Park', '1450', NULL, NULL),
(10, 'St Johns Lane Embankment', 51.441, -2.57967, 'Grass and Trees with pathways just off St Johns Lane', '3597', NULL, NULL),
(11, 'Bushy Park', 51.4415, -2.5783, 'Bushy Park', '1092', NULL, NULL),
(12, 'St Johns Lane and Wells Road Intersection', 51.4418, -2.57831, 'Small area of grass next to pedestrian pathway for the intersection', '228', NULL, NULL),
(13, 'Oxford Street Embankment', 51.4411, -2.58022, 'Embankment with grasses and trees in between Oxford Street and St Johns Lane', '2992', NULL, NULL),
(14, 'Winton Street Car Park', 51.4411, -2.57627, 'Hedges and Trees surround car park on Winton Street', '556', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Index pour la table `category_has_post`
--
ALTER TABLE `category_has_post`
  ADD PRIMARY KEY (`FK_post_id`,`FK_category_id`),
  ADD KEY `fk_category_has_post_post1_idx` (`FK_post_id`),
  ADD KEY `fk_category_has_post_category_idx` (`FK_category_id`);

--
-- Index pour la table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `privatespace_post`
--
ALTER TABLE `privatespace_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Index pour la table `publicspace_post`
--
ALTER TABLE `publicspace_post`
  ADD PRIMARY KEY (`post_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `privatespace_post`
--
ALTER TABLE `privatespace_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `publicspace_post`
--
ALTER TABLE `publicspace_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `category_has_post`
--
ALTER TABLE `category_has_post`
  ADD CONSTRAINT `fk_category_has_post_category` FOREIGN KEY (`FK_category_id`) REFERENCES `category` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_category_has_post_post1` FOREIGN KEY (`FK_post_id`) REFERENCES `privatespace_post` (`post_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
