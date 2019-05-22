# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.3.12-MariaDB)
# Datenbank: booking
# Erstellt am: 2019-04-18 19:45:56 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Export von Tabelle room
# ------------------------------------------------------------

DROP TABLE IF EXISTS `room`;

CREATE TABLE `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `beds` int(11) DEFAULT NULL,
  `floor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `house` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hidden` tinyint(1) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `crdate` int(11) DEFAULT NULL,
  `tstamp` int(11) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_729F519B3301C60` (`booking_id`),
  CONSTRAINT `FK_729F519B3301C60` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `room` WRITE;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;

INSERT INTO `room` (`id`, `name`, `beds`, `floor`, `house`, `hidden`, `deleted`, `crdate`, `tstamp`, `booking_id`)
VALUES
	(1,'Zimmer 1002',2,'EG','House 4',0,0,NULL,1555324465,3),
	(2,'Zimmer 101',4,'EG','House 1',1,0,NULL,1555267075,NULL),
	(3,'Zimmer 102',2,'OG 1','House 2',1,0,NULL,1555310188,6),
	(4,'Zimmer 103',2,'EG','House 2',0,0,1555266848,1555267101,21),
	(5,'Zimmer 104',4,'OG 1','House 3',0,0,1555267831,1555310194,15),
	(6,'Zimmer 200',5,'OG 1','House 2',0,0,1555267884,1555267884,NULL),
	(7,'Zimmer 201',2,'OG 1','House 2',0,0,1555267990,1555267997,NULL),
	(8,'Zimmer 202',3,'OG 1','House 4',0,0,1555325031,1555325039,NULL),
	(9,'Zimmer 203',3,'OG 3','House 4',0,0,1555333403,NULL,NULL),
	(10,'Zimmer 3002',6,'OG 3','House 2',0,0,1555336414,1555336414,NULL),
	(11,'Suite',2,'OG 2','House 2',0,0,1555607828,1555607828,NULL);

/*!40000 ALTER TABLE `room` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
