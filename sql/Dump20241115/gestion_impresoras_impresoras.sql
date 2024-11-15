CREATE DATABASE  IF NOT EXISTS `gestion_impresoras` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `gestion_impresoras`;
-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: gestion_impresoras
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `impresoras`
--

DROP TABLE IF EXISTS `impresoras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `impresoras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contador_negro` int(11) DEFAULT 0,
  `contador_color` int(11) DEFAULT 0,
  `total_impresiones` int(11) GENERATED ALWAYS AS (`contador_negro` + `contador_color`) STORED,
  `fecha_instalacion` date DEFAULT NULL,
  `lugar` varchar(100) DEFAULT NULL,
  `sector` varchar(100) DEFAULT NULL,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` enum('operativa','mantenimiento','fuera de servicio') DEFAULT 'operativa',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `modelo_id` int(11) DEFAULT NULL,
  `nombre_id` int(11) DEFAULT NULL,
  `marca_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `modelo_id` (`modelo_id`),
  KEY `nombre_id` (`nombre_id`),
  CONSTRAINT `impresoras_ibfk_1` FOREIGN KEY (`modelo_id`) REFERENCES `modelos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `impresoras_ibfk_2` FOREIGN KEY (`nombre_id`) REFERENCES `nombres` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `impresoras`
--

LOCK TABLES `impresoras` WRITE;
/*!40000 ALTER TABLE `impresoras` DISABLE KEYS */;
INSERT INTO `impresoras` (`id`, `contador_negro`, `contador_color`, `fecha_instalacion`, `lugar`, `sector`, `fecha_actualizacion`, `estado`, `fecha_registro`, `modelo_id`, `nombre_id`, `marca_id`) VALUES (3,400,200,'2024-11-13','test','test','2024-11-13 23:11:41','operativa','2024-11-13 19:08:04',1,1,0),(4,500,500,'2024-11-13','test','test','2024-11-13 20:32:59','operativa','2024-11-13 20:32:59',2,1,0),(5,144,4444,'0000-00-00','test','test','2024-11-14 17:49:39','operativa','2024-11-14 17:49:39',5,NULL,1),(6,0,0,'0000-00-00','test','test','2024-11-15 02:54:28','operativa','2024-11-15 02:54:28',5,NULL,1);
/*!40000 ALTER TABLE `impresoras` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-15 12:07:37
