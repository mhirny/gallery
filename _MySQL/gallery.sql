-- MySQL dump 10.16  Distrib 10.1.28-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: gallery
-- ------------------------------------------------------
-- Server version	10.1.28-MariaDB

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
-- Table structure for table `basket`
--

DROP TABLE IF EXISTS `basket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `basket` (
  `orderID` bigint(20) NOT NULL AUTO_INCREMENT,
  `personID` bigint(20) DEFAULT NULL,
  `picID` bigint(20) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`orderID`),
  KEY `personID` (`personID`),
  KEY `picID` (`picID`),
  CONSTRAINT `basket_ibfk_1` FOREIGN KEY (`personID`) REFERENCES `users` (`personID`),
  CONSTRAINT `basket_ibfk_2` FOREIGN KEY (`picID`) REFERENCES `pictures` (`picID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `basket`
--

LOCK TABLES `basket` WRITE;
/*!40000 ALTER TABLE `basket` DISABLE KEYS */;
INSERT INTO `basket` VALUES (1,1,2,1);
/*!40000 ALTER TABLE `basket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pictures`
--

DROP TABLE IF EXISTS `pictures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pictures` (
  `picID` bigint(20) NOT NULL AUTO_INCREMENT,
  `location` varchar(100) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `price` decimal(13,2) DEFAULT NULL,
  `tag` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`picID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pictures`
--

LOCK TABLES `pictures` WRITE;
/*!40000 ALTER TABLE `pictures` DISABLE KEYS */;
INSERT INTO `pictures` VALUES (1,'img/vehicles/trabant.jpg','Trabant','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',90.20,'vehicle'),(2,'img/art/gears.jpg','Gears','Lorem ipsum dolor.',19.20,'art'),(3,'img/art/smiles.jpg','Smiles','Lorem ipsum dolor sit amet, consectetur adipisicing elit, unt ut labore et.',1000.00,'art'),(4,'img/art/eiffel.jpg','Eiffel tower','Lorem ipsum sit, consectetur adipisicing elit, unt ut labore et.',0.03,'art'),(5,'img/art/deathsbride.jpg','Death\'s bride','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt, laudantium, quibusdam? Nobis, delectus, commodi, fugi',33.33,'art'),(6,'img/art/housepaint.jpg','Houses','Lorem ipsum dolor sit amet, consectetur adipisicing elit.',3.37,'art'),(7,'img/art/robot.jpg','MrRobot','Lorem ipsum dolor sit elit.',99.99,'art'),(8,'img/art/saltnpepper.jpg','Salt N\' Pepper','Lorem ipsum dolor sit elit. Sunt, laudantium, quibusdam?',19.23,'art'),(9,'img/art/statue.jpg','Statue','Lorem ipsum elit. Sunt, quibusdam?',100000.00,'art'),(10,'img/vehicles/vehicle1.jpg','Galaxie','Lorem ipsum elit. Sunt, quibusdam?',199000.00,'vehicle'),(11,'img/vehicles/vehicle2.jpg','Bentley','Lorem ipsum elit. Sunt, quibusdam?',1500000.00,'vehicle'),(12,'img/vehicles/vehicle3.jpg','Mercedes','Lorem ipsum elit. Facilis consequatur, odio hic minima. Sunt, quibusdam?',1000000.00,'vehicle'),(13,'img/vehicles/vehicle4.jpg','Red-Bus','Lorem ipsum elit. Facilis consequatur, odio hic minima.',500000.00,'vehicle'),(14,'img/vehicles/vehicle5.jpg','Lowrider','Lorem ipsum elit. Facilis consequatur, odio hic minima.',2500000.00,'vehicle'),(15,'img/vehicles/vehicle6.jpg','BMW bike','Lorem ipsum elit. Facilis consequatur, odio hic minima.',752000.00,'vehicle'),(16,'img/vehicles/vehicle7.jpg','Mustang?','Lorem ipsum elit. Facilis consequatur, odio hic minima.',1752000.00,'vehicle'),(17,'img/vehicles/vehicle8.jpg','Lamborghini','Lorem ipsum elit. Facilis consequatur, odio hic minima.',3752000.00,'vehicle'),(18,'img/vehicles/vehicle9.jpg','Chevrolet','Lorem ipsum elit. Facilis consequatur, odio hic minima.',752000.00,'vehicle'),(19,'img/vehicles/vehicle10.jpg','Kawasaki','Lorem ipsum elit. Facilis consequatur, odio hic minima.',820000.00,'vehicle'),(20,'img/vehicles/vehicle11.jpg','Alfa Romeo','Lorem ipsum elit. Facilis consequatur, odio hic minima.',2820000.00,'vehicle');
/*!40000 ALTER TABLE `pictures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `personID` bigint(20) NOT NULL AUTO_INCREMENT,
  `fname` varchar(35) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`personID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Jan','Kowalski','jank@wp.pl');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-26 18:45:40
