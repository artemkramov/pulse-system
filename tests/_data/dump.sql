-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 02, 2016 at 11:08 AM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aunexumsafe`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `returnNumericOnly`(`str` VARCHAR(1000)) RETURNS varchar(1000) CHARSET utf8
BEGIN
  DECLARE counter INT DEFAULT 0;
  DECLARE strLength INT DEFAULT 0;
  DECLARE strChar VARCHAR(1000) DEFAULT '' ;
  DECLARE retVal VARCHAR(1000) DEFAULT '';
  SET strLength = LENGTH(str);
  WHILE strLength > 0 DO
    SET counter = counter+1;
    SET strChar = SUBSTRING(str,counter,1);
    IF strChar REGEXP('[0-9]+') = 1
      THEN SET retVal = CONCAT(retVal,strChar);
    END IF;
    SET strLength = strLength -1;
    SET strChar = NULL;
  END WHILE;
RETURN retVal;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `bank_account_number` varchar(255) NOT NULL,
  `bank_account_name` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `date_registrated` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_data_uploaded` tinyint(1) NOT NULL,
  `incasso` tinyint(1) NOT NULL DEFAULT '0',
  `company` varchar(10) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `user_id`, `number`, `name`, `bank_account_number`, `bank_account_name`, `notes`, `date_registrated`, `is_active`, `is_data_uploaded`, `incasso`, `company`) VALUES
(1, 30, 'G0000000001', 'Artem Kramov', 'BG80BNBG96611020345678', 'NB1235453', '', '2013-05-16', 1, 1, 0, 'G'),
(17, NULL, 'H0000000002', 'Kramov Artem', 'BG80BNBG96611020345678', 'gfhfgh', '', '2016-06-14', 1, 0, 0, 'H'),
(18, NULL, 'A0000000003', 'Name', 'BG80BNBG96611020345678', '<<', '', '2016-06-10', 1, 0, 0, 'A'),
(19, NULL, 'G0000000004', 'Customer New', 'AL47212110090000000235698741', 'VVV', 'Good customer', '2016-06-09', 1, 0, 0, 'G');

-- --------------------------------------------------------

--
-- Table structure for table `customer_product`
--

CREATE TABLE IF NOT EXISTS `customer_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `date_created` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`,`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `bullion_type_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `bullion_description_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `pallet` varchar(255) DEFAULT NULL,
  `bar_number` varchar(255) DEFAULT NULL,
  `weight_amount` double NOT NULL,
  `weight_measure` varchar(10) NOT NULL,
  `percentage` double NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_registrated` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `location_id` (`location_id`),
  KEY `bullion_type_id` (`bullion_type_id`),
  KEY `bullion_description_id` (`bullion_description_id`),
  KEY `brand_id` (`brand_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `location_id`, `bullion_type_id`, `amount`, `bullion_description_id`, `brand_id`, `pallet`, `bar_number`, `weight_amount`, `weight_measure`, `percentage`, `name`, `date_registrated`, `is_active`) VALUES
(1, 1, 1, 2, 4, 1, '34', '333', 1000, 'gramm', 23.34, 'Product 1', '2016-06-09', 1),
(8, 1, 2, 23, 3, 1, '23', '2', 22, 'gramm', 23, 'Product 32', '2016-06-01', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_product`
--
ALTER TABLE `customer_product`
  ADD CONSTRAINT `customer_product_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`bullion_type_id`) REFERENCES `bullion_type` (`id`),
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`bullion_description_id`) REFERENCES `bullion_type_description` (`id`),
  ADD CONSTRAINT `product_ibfk_4` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
