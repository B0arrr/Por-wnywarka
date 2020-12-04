-- MySQL dump 10.16  Distrib 10.1.26-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: db
-- ------------------------------------------------------
-- Server version	10.1.26-MariaDB-0+deb9u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dbo.Categories`
--

DROP TABLE IF EXISTS `dbo.Categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dbo.Categories` (
  `ID` tinyint(4) DEFAULT NULL,
  `NameOfCategory` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dbo.Categories`
--

LOCK TABLES `dbo.Categories` WRITE;
/*!40000 ALTER TABLE `dbo.Categories` DISABLE KEYS */;
INSERT INTO `dbo.Categories` VALUES (1,'Bijatyka'),(2,'Strzelanka'),(3,'Przygodowa'),(4,'Fantazy'),(5,'MMO'),(6,'RPG'),(7,'MOBA'),(8,'FPS'),(9,'Muzyczna'),(10,'OpenWorld'),(11,'Sportowa'),(12,'Wyścigi'),(13,'Taktyka'),(14,'Versus'),(15,'Battleroyale');
/*!40000 ALTER TABLE `dbo.Categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dbo.Follows`
--

DROP TABLE IF EXISTS `dbo.Follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dbo.Follows` (
  `ID` varchar(0) DEFAULT NULL,
  `ID_User` varchar(0) DEFAULT NULL,
  `ID_Game` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dbo.Follows`
--

LOCK TABLES `dbo.Follows` WRITE;
/*!40000 ALTER TABLE `dbo.Follows` DISABLE KEYS */;
/*!40000 ALTER TABLE `dbo.Follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dbo.Games`
--

DROP TABLE IF EXISTS `dbo.Games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dbo.Games` (
  `ID` tinyint(4) DEFAULT NULL,
  `Name` varchar(27) DEFAULT NULL,
  `Producent` varchar(14) DEFAULT NULL,
  `Category` tinyint(4) DEFAULT NULL,
  `Shop` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dbo.Games`
--

LOCK TABLES `dbo.Games` WRITE;
/*!40000 ALTER TABLE `dbo.Games` DISABLE KEYS */;
INSERT INTO `dbo.Games` VALUES (26,'Counter Strike','VALVE',1,1),(27,'Good OF War','VALVE',1,1),(28,'Among Us','VALVE',13,1),(29,'Darkest Dungeon','VALVE',13,1),(31,'Don`t Starve Together','VALVE',3,2),(32,'Pummel Party','VALVE',14,4),(33,'Ultimate Chicken Horse','VALVE',14,11),(34,'COD WARZONE','VALVE',15,11),(35,'World of Warcraft','VALVE',6,5),(36,'Wiedźmin 3','CD Project Red',6,12),(37,'Terrarria','...',3,1),(38,'Heroes of Might and Magic 3','...',13,10),(39,'For Honor','...',14,9),(40,'Lego Hobbit','...',3,7),(41,'Team Fortress 2 ','...',14,4),(42,'Spellforce ','...',5,5),(43,'Sekiro','...',6,6),(44,'Dark Souls 3','...',6,6),(45,'Battlefield V ','...',2,2),(46,'Endless Space ','...',13,2);
/*!40000 ALTER TABLE `dbo.Games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dbo.Shops`
--

DROP TABLE IF EXISTS `dbo.Shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dbo.Shops` (
  `ID` tinyint(4) DEFAULT NULL,
  `NameOfShop` varchar(11) DEFAULT NULL,
  `Price` decimal(6,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dbo.Shops`
--

LOCK TABLES `dbo.Shops` WRITE;
/*!40000 ALTER TABLE `dbo.Shops` DISABLE KEYS */;
INSERT INTO `dbo.Shops` VALUES (1,'Allegro',10.0000),(2,'MediaExpert',10.0000),(4,'MediaArena',10.0000),(5,'G2A',10.0000),(6,'Steam',10.0000),(7,'Kinguin',10.0000),(8,'Origin',10.0000),(9,'Grymel',10.0000),(10,'Ultima',10.0000),(11,'Muve',10.0000),(12,'3kropki',10.0000);
/*!40000 ALTER TABLE `dbo.Shops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dbo.Users`
--

DROP TABLE IF EXISTS `dbo.Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dbo.Users` (
  `ID` varchar(0) DEFAULT NULL,
  `FirstName` varchar(0) DEFAULT NULL,
  `LastName` varchar(0) DEFAULT NULL,
  `Email` varchar(0) DEFAULT NULL,
  `Password` varchar(0) DEFAULT NULL,
  `Newsletter` varchar(0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dbo.Users`
--

LOCK TABLES `dbo.Users` WRITE;
/*!40000 ALTER TABLE `dbo.Users` DISABLE KEYS */;
/*!40000 ALTER TABLE `dbo.Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-08-22 15:20:25