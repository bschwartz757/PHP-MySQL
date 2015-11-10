/*
favorites-05142015.sql

Fields to store might be: Name, Email, Title, URL, Description, Category, Date Added.




*/

drop table if exists `sp15_Favorites`;

CREATE TABLE `sp15_Favorites` (
  `FavoriteID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `LastName` varchar(50) DEFAULT '',
  `FirstName` varchar(50) DEFAULT '',
  `Email` varchar(120) DEFAULT '',
  `Title` varchar(255) DEFAULT '',  
  `URL` text DEFAULT '',
  `Description` text DEFAULT '',  
  `Category` varchar(255) DEFAULT '',
  `DateAdded` datetime DEFAULT NULL,
  PRIMARY KEY (`FavoriteID`)
) ENGINE=MyISAM CHARSET=utf8;

INSERT INTO `sp15_Favorites` (`FavoriteID`, `LastName`, `FirstName`, `Email`, `Title`, `URL`, `Description`, `Category`, `DateAdded`) VALUES
(1,	'Doe',	'John',	'john@example.com',	'Google',	'http://www.google.com',	'Cool search engine',	'Search Engines',	NOW());