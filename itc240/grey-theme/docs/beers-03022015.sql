-- Adminer 4.2.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `Beers`;
CREATE TABLE `Beers` (
  `BeerID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Beer` varchar(255) DEFAULT NULL,
  `Category` varchar(50) DEFAULT NULL,
  `Style` varchar(80) DEFAULT NULL,
  `Brewer` varchar(80) DEFAULT NULL,
  `Appearance` varchar(255) DEFAULT NULL,
  `Description` text,
  `AlcoholContent` float(10,2) DEFAULT NULL,
  `Calories` int(10) DEFAULT NULL,
  PRIMARY KEY (`BeerID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `Beers` (`BeerID`, `Beer`, `Category`, `Style`, `Brewer`, `Appearance`, `Description`, `AlcoholContent`, `Calories`) VALUES
(1,	'Miller Lite',	'Commercial',	'Pilsner',	'SAB Miller',	'Light Yellow',	'Description goes here',	4.50,	110),
(2,	'Ikea Birchwood',	'Craft',	'Ale',	'Ikea',	'Light Yellow',	'Description goes here',	5.00,	140),
(3,	'Fuzzy Baby Ducks',	'Craft',	'IPA',	'New England Brewing',	'Light Yellow',	'Description goes here',	6.20,	200),
(4,	'Breakaway IPA',	'Craft',	'IPA',	'American Brewing',	'Light Yellow',	'Description goes here',	6.70,	250),
(5,	'Pliny the Elder',	'Craft',	'Double IPA',	'Russian River Brewing',	'Yellow',	'Description goes here',	8.00,	350);

-- 2015-03-02 21:55:27
