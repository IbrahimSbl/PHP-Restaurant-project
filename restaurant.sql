-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 17, 2022 at 07:27 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `CLIENT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FIRST_NAME` text COLLATE utf8_bin NOT NULL,
  `LAST_NAME` text COLLATE utf8_bin NOT NULL,
  `PHONE` text COLLATE utf8_bin NOT NULL,
  `EMAIL` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`CLIENT_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`CLIENT_ID`, `FIRST_NAME`, `LAST_NAME`, `PHONE`, `EMAIL`) VALUES
(1, 'Ibrahim', 'AL Siblani', '12345', 'bob@gmail.com'),
(2, 'Omar', 'Owiety', '56789', 'dbomar@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `drinks`
--

DROP TABLE IF EXISTS `drinks`;
CREATE TABLE IF NOT EXISTS `drinks` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MENU_ID` int(11) NOT NULL,
  `NAME` text COLLATE utf8_bin NOT NULL,
  `SPRICE` float DEFAULT NULL,
  `MPRICE` float DEFAULT NULL,
  `LPRICE` float DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MENU_ID` (`MENU_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `drinks`
--

INSERT INTO `drinks` (`ID`, `MENU_ID`, `NAME`, `SPRICE`, `MPRICE`, `LPRICE`) VALUES
(3, 1, 'Jalab', 1, 1.5, 2),
(7, 1, 'Lemon Juice', 1.5, NULL, 2),
(8, 4, 'Jalab', 1, 1.5, 2),
(10, 4, 'Pine Apple', NULL, 5, 7),
(15, 1, 'Milk shake', NULL, 4, 7);

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

DROP TABLE IF EXISTS `meals`;
CREATE TABLE IF NOT EXISTS `meals` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MENU_ID` int(11) NOT NULL,
  `NAME` text COLLATE utf8_bin NOT NULL,
  `SPRICE` float DEFAULT NULL,
  `MPRICE` float DEFAULT NULL,
  `LPRICE` float DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MENU_ID` (`MENU_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`ID`, `MENU_ID`, `NAME`, `SPRICE`, `MPRICE`, `LPRICE`) VALUES
(1, 1, 'Chicken and Potato', NULL, 12, 17),
(2, 1, 'Kafte', NULL, 11, 14),
(3, 1, 'Lamb Shawarma', NULL, 15, 20),
(4, 1, 'Kebeh', 9, NULL, 13),
(5, 1, 'Meat Pies', 7, 9, 12);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `MENU_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MNAME` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`MENU_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`MENU_ID`, `MNAME`) VALUES
(1, 'Ramadan\'s Menu'),
(4, 'Lunch Menu');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `ORDER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CLIENT_ID` int(11) NOT NULL,
  `DATE` datetime NOT NULL,
  `ADDRESS` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`ORDER_ID`),
  KEY `CLIENT_ID` (`CLIENT_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ORDER_ID`, `CLIENT_ID`, `DATE`, `ADDRESS`) VALUES
(1, 1, '2022-05-17 14:00:00', 'bierut'),
(2, 1, '2022-05-15 00:00:00', 'Baalbeck');

-- --------------------------------------------------------

--
-- Table structure for table `orders-info`
--

DROP TABLE IF EXISTS `orders-info`;
CREATE TABLE IF NOT EXISTS `orders-info` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ORDER_ID` int(11) NOT NULL,
  `MENU_ID` int(11) NOT NULL,
  `TABLE_NAME` text COLLATE utf8_bin NOT NULL,
  `PRODUCT_ID` int(11) NOT NULL,
  `QUANTITY` int(11) NOT NULL,
  `DESCRIPTION` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ORDER_ID` (`ORDER_ID`),
  KEY `PRODUCT_ID` (`PRODUCT_ID`),
  KEY `MENU_ID` (`MENU_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `orders-info`
--

INSERT INTO `orders-info` (`ID`, `ORDER_ID`, `MENU_ID`, `TABLE_NAME`, `PRODUCT_ID`, `QUANTITY`, `DESCRIPTION`) VALUES
(1, 1, 1, 'meals', 4, 2, 'small'),
(2, 1, 1, 'meals', 1, 1, 'large'),
(3, 2, 4, 'drinks', 10, 3, 'large');

-- --------------------------------------------------------

--
-- Table structure for table `pizzas`
--

DROP TABLE IF EXISTS `pizzas`;
CREATE TABLE IF NOT EXISTS `pizzas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MENU_ID` int(11) NOT NULL,
  `NAME` text COLLATE utf8_bin NOT NULL,
  `SPRICE` float DEFAULT NULL,
  `MPRICE` float DEFAULT NULL,
  `LPRICE` float DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MENU_ID` (`MENU_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `pizzas`
--

INSERT INTO `pizzas` (`ID`, `MENU_ID`, `NAME`, `SPRICE`, `MPRICE`, `LPRICE`) VALUES
(9, 1, 'Marinara Pizza', NULL, 8.5, 10),
(10, 1, 'Margherita Pizza', 9, 10.5, 11.5),
(11, 1, 'Chicago Pizza', 7, NULL, 10),
(12, 1, 'New York-Style Pizza', 8, 9.5, 11);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `reservation_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `selected_time` datetime NOT NULL,
  `nb_guests` int(11) NOT NULL,
  PRIMARY KEY (`reservation_id`),
  KEY `CLIENT_ID` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `client_id`, `selected_time`, `nb_guests`) VALUES
(4, 1, '2022-05-17 20:13:00', 2),
(6, 2, '2022-05-18 09:03:44', 4),
(7, 1, '2022-05-16 09:03:44', 9);

-- --------------------------------------------------------

--
-- Table structure for table `salads`
--

DROP TABLE IF EXISTS `salads`;
CREATE TABLE IF NOT EXISTS `salads` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MENU_ID` int(11) NOT NULL,
  `NAME` text COLLATE utf8_bin NOT NULL,
  `SPRICE` float DEFAULT NULL,
  `MPRICE` float DEFAULT NULL,
  `LPRICE` float DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MENU_ID` (`MENU_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `salads`
--

INSERT INTO `salads` (`ID`, `MENU_ID`, `NAME`, `SPRICE`, `MPRICE`, `LPRICE`) VALUES
(1, 1, 'Caesar salad', 4, 6, 8),
(2, 1, 'Fatoush', 4, 6, 8),
(3, 1, 'Tabouleh', 4, 5, 7),
(4, 1, 'Greek Salad', 5, 6, 7.5);

-- --------------------------------------------------------

--
-- Table structure for table `sandwiches`
--

DROP TABLE IF EXISTS `sandwiches`;
CREATE TABLE IF NOT EXISTS `sandwiches` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MENU_ID` int(11) NOT NULL,
  `NAME` text COLLATE utf8_bin NOT NULL,
  `SPRICE` float DEFAULT NULL,
  `MPRICE` float DEFAULT NULL,
  `LPRICE` float DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MENU_ID` (`MENU_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `sandwiches`
--

INSERT INTO `sandwiches` (`ID`, `MENU_ID`, `NAME`, `SPRICE`, `MPRICE`, `LPRICE`) VALUES
(1, 1, 'Swiss sandwich', NULL, 4, 6),
(2, 1, 'Burger', 3, 4.5, 7),
(3, 1, 'Steak sandwich', 6, 8, 10.5),
(4, 1, 'Labneh', 2.5, 4.5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sweets`
--

DROP TABLE IF EXISTS `sweets`;
CREATE TABLE IF NOT EXISTS `sweets` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MENU_ID` int(11) NOT NULL,
  `NAME` text COLLATE utf8_bin NOT NULL,
  `SPRICE` float DEFAULT NULL,
  `MPRICE` float DEFAULT NULL,
  `LPRICE` float DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `MENU_ID` (`MENU_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `sweets`
--

INSERT INTO `sweets` (`ID`, `MENU_ID`, `NAME`, `SPRICE`, `MPRICE`, `LPRICE`) VALUES
(1, 1, 'Cake', 2, 3, 5),
(2, 1, 'Brownie Blondie', 1.5, 3, 4),
(3, 1, 'Muffin Cupcake', 2, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `USER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_NAME` text COLLATE utf8_bin NOT NULL,
  `FIRST_NAME` text COLLATE utf8_bin NOT NULL,
  `LAST_NAME` text COLLATE utf8_bin NOT NULL,
  `PHONE` text COLLATE utf8_bin NOT NULL,
  `BIRTHDAY` date NOT NULL,
  `EMAIL` text COLLATE utf8_bin NOT NULL,
  `PASSWORD` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`USER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USER_ID`, `USER_NAME`, `FIRST_NAME`, `LAST_NAME`, `PHONE`, `BIRTHDAY`, `EMAIL`, `PASSWORD`) VALUES
(1, 'bob', 'Ibrahim', 'AL Siblani', '1234', '2001-12-20', 'bob@gmail.com', 'bob1234');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `drinks`
--
ALTER TABLE `drinks`
  ADD CONSTRAINT `drinks_ibfk_1` FOREIGN KEY (`MENU_ID`) REFERENCES `menus` (`MENU_ID`);

--
-- Constraints for table `meals`
--
ALTER TABLE `meals`
  ADD CONSTRAINT `meals_ibfk_1` FOREIGN KEY (`MENU_ID`) REFERENCES `menus` (`MENU_ID`);

--
-- Constraints for table `pizzas`
--
ALTER TABLE `pizzas`
  ADD CONSTRAINT `pizzas_ibfk_1` FOREIGN KEY (`MENU_ID`) REFERENCES `menus` (`MENU_ID`);

--
-- Constraints for table `salads`
--
ALTER TABLE `salads`
  ADD CONSTRAINT `salads_ibfk_1` FOREIGN KEY (`MENU_ID`) REFERENCES `menus` (`MENU_ID`);

--
-- Constraints for table `sandwiches`
--
ALTER TABLE `sandwiches`
  ADD CONSTRAINT `sandwiches_ibfk_1` FOREIGN KEY (`MENU_ID`) REFERENCES `menus` (`MENU_ID`);

--
-- Constraints for table `sweets`
--
ALTER TABLE `sweets`
  ADD CONSTRAINT `sweets_ibfk_1` FOREIGN KEY (`MENU_ID`) REFERENCES `menus` (`MENU_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
