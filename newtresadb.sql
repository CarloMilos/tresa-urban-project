-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2024 at 07:20 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newtresadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Trees'),
(2, 'Flowers'),
(3, 'Hedges'),
(4, 'Grasses'),
(5, 'Ponds'),
(6, 'Other_flora'),
(7, 'Birds'),
(8, 'Insects'),
(9, 'Butterflies'),
(10, 'Bees'),
(11, 'Mammals'),
(12, 'Other_fauna');


-- --------------------------------------------------------

--
-- Table structure for table `category_has_post`
--

CREATE TABLE `category_has_post` (
  `FK_post_id` int(11) NOT NULL,
  `FK_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `privatespace_post`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `publicspace_post`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `publicspace_post`
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
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `category_has_post`
--
ALTER TABLE `category_has_post`
  ADD PRIMARY KEY (`FK_post_id`,`FK_category_id`),
  ADD KEY `fk_category_has_post_post1_idx` (`FK_post_id`),
  ADD KEY `fk_category_has_post_category_idx` (`FK_category_id`);

--
-- Indexes for table `privatespace_post`
--
ALTER TABLE `privatespace_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `publicspace_post`
--
ALTER TABLE `publicspace_post`
  ADD PRIMARY KEY (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `privatespace_post`
--
ALTER TABLE `privatespace_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `publicspace_post`
--
ALTER TABLE `publicspace_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_has_post`
--
ALTER TABLE `category_has_post`
  ADD CONSTRAINT `fk_category_has_post_category` FOREIGN KEY (`FK_category_id`) REFERENCES `category` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_category_has_post_post1` FOREIGN KEY (`FK_post_id`) REFERENCES `privatespace_post` (`post_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
