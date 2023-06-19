-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2023 at 06:17 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pmds`
--

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(200) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`city_id`, `city_name`, `country_id`) VALUES
(1, 'Makati City', 7),
(3, 'Mandaluyong City', 7),
(6, 'Pasay City', 7),
(7, 'Brasilia', 3),
(8, 'Rio De Janeiro', 3),
(9, 'Sao Paulo', 3),
(10, 'Albany', 15),
(11, 'Athens', 15),
(12, 'Augusta', 15);

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `country_name`) VALUES
(1, 'India'),
(2, 'Australia'),
(3, 'Brazil'),
(4, 'Canada'),
(5, 'Indonesia'),
(6, 'New Zealand'),
(7, 'Phillipines'),
(8, 'Qatar'),
(9, 'Singapore'),
(10, 'South Africa'),
(11, 'Sri Lanka'),
(12, 'Turkey'),
(13, 'UAE'),
(14, 'United Kingdom'),
(15, 'United States');

-- --------------------------------------------------------

--
-- Table structure for table `cuisine`
--

CREATE TABLE `cuisine` (
  `cuisine_id` int(11) NOT NULL,
  `cuisine_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cuisine`
--

INSERT INTO `cuisine` (`cuisine_id`, `cuisine_name`) VALUES
(1, 'Asian'),
(2, 'European'),
(3, 'American');

-- --------------------------------------------------------

--
-- Table structure for table `cuisine_detail`
--

CREATE TABLE `cuisine_detail` (
  `detail_id` int(11) NOT NULL,
  `resto_id` int(11) NOT NULL,
  `cuisine_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cuisine_detail`
--

INSERT INTO `cuisine_detail` (`detail_id`, `resto_id`, `cuisine_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1),
(4, 3, 1),
(5, 4, 1),
(6, 5, 1),
(7, 5, 2),
(8, 6, 1),
(9, 6, 2),
(10, 7, 1),
(11, 8, 1),
(12, 9, 2),
(13, 10, 3),
(14, 11, 2),
(15, 12, 1),
(16, 13, 1),
(17, 13, 2),
(18, 13, 3),
(19, 14, 3),
(20, 15, 1),
(21, 16, 3),
(22, 17, 2),
(23, 18, 1),
(24, 18, 2),
(25, 18, 3),
(26, 19, 2);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `rating_id` int(11) NOT NULL,
  `rating_text` varchar(200) NOT NULL,
  `rating_color` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`rating_id`, `rating_text`, `rating_color`) VALUES
(2, 'Excellent', 'Dark Green'),
(3, 'Very Good', 'Green'),
(4, 'Good', 'Yellow'),
(5, 'Average', 'orange'),
(6, 'Poor', 'red'),
(7, 'Not Rated', 'white');

-- --------------------------------------------------------

--
-- Table structure for table `restoran`
--

CREATE TABLE `restoran` (
  `resto_id` int(11) NOT NULL,
  `resto_name` varchar(200) NOT NULL,
  `city_id` int(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `has_table_book` tinyint(1) NOT NULL,
  `price_range` int(11) NOT NULL,
  `agg_rating` float NOT NULL,
  `rating_id` int(11) NOT NULL,
  `votes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restoran`
--

INSERT INTO `restoran` (`resto_id`, `resto_name`, `city_id`, `address`, `has_table_book`, `price_range`, `agg_rating`, `rating_id`, `votes`) VALUES
(1, 'Le Petit Souffle', 1, 'Third Floor, Century City Mall, Kalayaan Avenue, Poblacion, Makati City', 1, 3, 4.8, 2, 314),
(2, 'Izakaya Kikufuji', 1, 'Little Tokyo, 2277 Chino Roces Avenue, Legaspi Village, Makati City', 1, 3, 4.5, 2, 591),
(3, 'Ooma', 3, 'Third Floor, Mega Fashion Hall, SM Megamall, Ortigas, Mandaluyong City', 0, 4, 4.9, 2, 365),
(4, 'Heat - Edsa Shangri-La', 3, 'Edsa Shangri-La, 1 Garden Way, Ortigas, Mandaluyong City', 1, 4, 4.4, 3, 270),
(5, 'Buffet 101', 6, 'Building K, SM By The Bay, Sunset Boulevard, Mall of Asia Complex (MOA), Pasay City', 1, 4, 4.4, 3, 520),
(6, 'Vikings', 6, 'Building B, By The Bay, Seaside Boulevard, Mall of Asia Complex (MOA), Pasay City', 1, 4, 4.2, 3, 677),
(7, 'Locavore', 6, 'Brixton Technology Center, 10 Brixton Street, Kapitolyo, Pasig City', 1, 3, 4.8, 2, 532),
(8, 'Sushi Loko', 7, 'SCS 213, Bloco C, Loja 35, Asa Sul, Bras_lia', 0, 3, 3.1, 5, 10),
(9, 'Maori', 7, 'CLN 110, Bloco D, Loja 28, Asa Norte, Bras_lia', 0, 3, 3.8, 4, 11),
(10, 'Cervantes', 8, 'Avenida Prado Junior, 335 B, Copacabana, Rio de Janeiro', 0, 3, 4.5, 2, 29),
(11, 'Garota de Ipanema', 8, 'Rua Vinicius de Moraes, 49, Ipanema, Rio de Janeiro', 0, 4, 4.9, 2, 49),
(12, 'Gopala Hari', 9, 'Rua Antonio Carlos, 429, Consolao, Sao Paulo', 0, 3, 3.1, 5, 5),
(13, 'Skye - Hotel Unique', 9, 'Hotel Unique, Avenida Brigadeiro Lua_s Antonio, 4700, Jardim Paulista, Sao Paulo', 0, 4, 4.8, 2, 59),
(14, 'BJ\'s Country Buffet', 10, '2401 Dawson Rd, Albany, GA 31707', 0, 1, 3.3, 5, 25),
(15, 'Mikata Japanese Steakhouse', 10, '2610 Dawson Rd, Albany, GA 31707', 0, 3, 3.6, 4, 115),
(16, 'Last Resort Grill', 11, '184 W Clayton St, Athens, GA 30601', 0, 3, 4.5, 2, 1821),
(17, 'La Dolce Vita Ristorante', 11, '323 E Broad St, Athens, GA 30601', 0, 3, 4.1, 3, 464),
(18, 'The Bee\'s Knees', 12, '211 10th Street, Augusta, GA 30901', 0, 2, 4.5, 2, 631),
(19, 'Manuel\'s Bread Cafe', 12, '505 Railroad Ave, North Augusta, GA 29841', 0, 3, 3.8, 4, 332);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `cuisine`
--
ALTER TABLE `cuisine`
  ADD PRIMARY KEY (`cuisine_id`);

--
-- Indexes for table `cuisine_detail`
--
ALTER TABLE `cuisine_detail`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `resto_id` (`resto_id`),
  ADD KEY `cuisine_id` (`cuisine_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indexes for table `restoran`
--
ALTER TABLE `restoran`
  ADD PRIMARY KEY (`resto_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `rating_id` (`rating_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cuisine`
--
ALTER TABLE `cuisine`
  MODIFY `cuisine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cuisine_detail`
--
ALTER TABLE `cuisine_detail`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `restoran`
--
ALTER TABLE `restoran`
  MODIFY `resto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`);

--
-- Constraints for table `cuisine_detail`
--
ALTER TABLE `cuisine_detail`
  ADD CONSTRAINT `cuisine_detail_ibfk_1` FOREIGN KEY (`resto_id`) REFERENCES `restoran` (`resto_id`),
  ADD CONSTRAINT `cuisine_detail_ibfk_2` FOREIGN KEY (`cuisine_id`) REFERENCES `cuisine` (`cuisine_id`);

--
-- Constraints for table `restoran`
--
ALTER TABLE `restoran`
  ADD CONSTRAINT `restoran_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`),
  ADD CONSTRAINT `restoran_ibfk_2` FOREIGN KEY (`rating_id`) REFERENCES `rating` (`rating_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
