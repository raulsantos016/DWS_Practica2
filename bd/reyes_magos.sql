-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: reyes_magos
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `nino_regalo`
--

DROP TABLE IF EXISTS `nino_regalo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nino_regalo` (
  `idNinoFK` int NOT NULL,
  `idRegaloFK` int NOT NULL,
  PRIMARY KEY (`idNinoFK`,`idRegaloFK`),
  KEY `idRegaloFK` (`idRegaloFK`),
  CONSTRAINT `nino_regalo_ibfk_1` FOREIGN KEY (`idNinoFK`) REFERENCES `ninos` (`idNino`),
  CONSTRAINT `nino_regalo_ibfk_2` FOREIGN KEY (`idRegaloFK`) REFERENCES `regalos` (`idRegalo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nino_regalo`
--

LOCK TABLES `nino_regalo` WRITE;
/*!40000 ALTER TABLE `nino_regalo` DISABLE KEYS */;
INSERT INTO `nino_regalo` VALUES (1,1),(2,1),(4,1),(1,2),(3,2),(1,3),(2,3),(3,4),(4,5),(5,6),(1,7),(6,7),(1,8),(2,8),(3,8),(6,8),(1,9),(2,9),(1,10),(3,10),(2,11),(4,11),(4,12),(5,12),(1,13),(2,13),(6,13),(18,21);
/*!40000 ALTER TABLE `nino_regalo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ninos`
--

DROP TABLE IF EXISTS `ninos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ninos` (
  `idNino` int NOT NULL AUTO_INCREMENT,
  `nombreNino` varchar(45) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `apellidosNino` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fechaNino` date DEFAULT NULL,
  `buenoNino` varchar(2) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`idNino`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ninos`
--

LOCK TABLES `ninos` WRITE;
/*!40000 ALTER TABLE `ninos` DISABLE KEYS */;
INSERT INTO `ninos` VALUES (1,'Alberto','Alcántara','2016-10-27','No'),(2,'Beatriz','Bueno','2010-04-18','Sí'),(3,'Carlos','Crespo','2020-12-01','Sí'),(4,'Diana','Domínguez','2013-09-02','No'),(5,'Emilio','Enamorado','2018-08-12','Sí'),(6,'Francisca','Fernández','2012-07-28','Sí'),(18,'Raúl','Santos','2025-11-12','Sí');
/*!40000 ALTER TABLE `ninos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regalos`
--

DROP TABLE IF EXISTS `regalos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `regalos` (
  `idRegalo` int NOT NULL AUTO_INCREMENT,
  `nombreRegalo` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `precioRegalo` decimal(10,2) DEFAULT NULL,
  `idReyFK` int DEFAULT NULL,
  PRIMARY KEY (`idRegalo`),
  KEY `idReyFK` (`idReyFK`),
  CONSTRAINT `regalos_ibfk_1` FOREIGN KEY (`idReyFK`) REFERENCES `reyes` (`idRey`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regalos`
--

LOCK TABLES `regalos` WRITE;
/*!40000 ALTER TABLE `regalos` DISABLE KEYS */;
INSERT INTO `regalos` VALUES (1,'Aula de ciencia: Robot Mini ERP',159.95,1),(2,'Carbón',0.00,2),(3,'Cochecito Classic',99.95,3),(4,'Consola PS5 1 TB',549.90,1),(5,'Lego Villa familiar modular',64.99,2),(6,'Magia Borrás Clásica 150 trucos con luz',32.95,3),(7,'Meccano Excavadora construcción',30.99,1),(8,'Nenuco Hace pompas',29.95,2),(9,'Peluche delfín rosa',34.00,3),(10,'Pequeordenador',22.95,1),(11,'Robot Coji',69.95,2),(12,'Telescopio astronómico terrestre',72.00,3),(13,'Twister',17.95,1),(21,'aaaaaaaaaaaaaaa',8.00,1);
/*!40000 ALTER TABLE `regalos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reyes`
--

DROP TABLE IF EXISTS `reyes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reyes` (
  `idRey` int NOT NULL AUTO_INCREMENT,
  `nombreRey` varchar(45) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`idRey`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reyes`
--

LOCK TABLES `reyes` WRITE;
/*!40000 ALTER TABLE `reyes` DISABLE KEYS */;
INSERT INTO `reyes` VALUES (1,'Melchor'),(2,'Gaspar'),(3,'Baltasar');
/*!40000 ALTER TABLE `reyes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-27  1:29:43
