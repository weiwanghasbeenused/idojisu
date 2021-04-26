-- MySQL dump 10.13  Distrib 5.7.32, for osx10.14 (x86_64)
--
-- Host: localhost    Database: idojisu_local
-- ------------------------------------------------------
-- Server version	5.7.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` int(1) unsigned NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `object` int(10) unsigned DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `rank` int(10) unsigned DEFAULT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'jpg',
  `caption` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `objects`
--

DROP TABLE IF EXISTS `objects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `objects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` int(1) unsigned NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `rank` int(10) unsigned DEFAULT NULL,
  `name1` tinytext,
  `name2` tinytext,
  `address1` text,
  `address2` text,
  `city` tinytext,
  `state` tinytext,
  `zip` tinytext,
  `country` tinytext,
  `phone` tinytext,
  `fax` tinytext,
  `url` tinytext,
  `email` tinytext,
  `begin` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `head` tinytext,
  `deck` mediumblob,
  `body` mediumblob,
  `notes` mediumblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `objects`
--

LOCK TABLES `objects` WRITE;
/*!40000 ALTER TABLE `objects` DISABLE KEYS */;
INSERT INTO `objects` VALUES (1,1,'2021-04-20 09:40:14','2021-04-20 09:41:01',10,'About',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'about',NULL,NULL,NULL,NULL,NULL,_binary '\r\n																								',_binary '\r\n																								',_binary '\r\n																								'),(2,1,'2021-04-20 09:40:21','2021-04-20 09:41:25',30,'Press',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'press',NULL,NULL,NULL,NULL,NULL,_binary '\r\n																								',_binary '\r\n																								',_binary '\r\n																								'),(3,1,'2021-04-20 09:40:27','2021-04-20 09:43:37',20,'Collection',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'collection',NULL,NULL,NULL,NULL,NULL,_binary '[dropdown]',_binary '\r\n																								\r\n																								',_binary '\r\n																								\r\n																								'),(4,1,'2021-04-20 09:40:44','2021-04-20 09:41:30',40,'Contact',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'contact',NULL,NULL,NULL,NULL,NULL,_binary '\r\n																								',_binary '\r\n																								',_binary '\r\n																								');
/*!40000 ALTER TABLE `objects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wires`
--

DROP TABLE IF EXISTS `wires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wires` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` int(1) unsigned NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `fromid` int(10) unsigned DEFAULT NULL,
  `toid` int(10) unsigned DEFAULT NULL,
  `weight` float NOT NULL DEFAULT '1',
  `notes` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wires`
--

LOCK TABLES `wires` WRITE;
/*!40000 ALTER TABLE `wires` DISABLE KEYS */;
INSERT INTO `wires` VALUES (1,1,'2021-04-20 09:40:14','2021-04-20 09:40:14',0,1,1,NULL),(2,1,'2021-04-20 09:40:21','2021-04-20 09:40:21',0,2,1,NULL),(3,1,'2021-04-20 09:40:28','2021-04-20 09:40:28',0,3,1,NULL),(4,1,'2021-04-20 09:40:44','2021-04-20 09:40:44',0,4,1,NULL);
/*!40000 ALTER TABLE `wires` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-26 16:14:02
