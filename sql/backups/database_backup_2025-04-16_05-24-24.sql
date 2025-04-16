-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: cielotico_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `buses`
--

DROP TABLE IF EXISTS `buses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) NOT NULL,
  `tipo_bus_id` int(11) NOT NULL,
  `placa` varchar(20) NOT NULL,
  `estado` enum('activo','mantenimiento','inactivo') DEFAULT 'activo',
  `ano_fabricacion` year(4) DEFAULT NULL,
  `ultima_revision` date DEFAULT NULL,
  `proxima_revision` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  UNIQUE KEY `placa` (`placa`),
  KEY `tipo_bus_id` (`tipo_bus_id`),
  CONSTRAINT `buses_ibfk_1` FOREIGN KEY (`tipo_bus_id`) REFERENCES `tipos_bus` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buses`
--

LOCK TABLES `buses` WRITE;
/*!40000 ALTER TABLE `buses` DISABLE KEYS */;
INSERT INTO `buses` VALUES (1,'LUXBUS-001',1,'LUX-001','activo',2023,NULL,NULL,'2025-04-16 01:18:44','2025-04-16 01:18:44'),(2,'LUXBUS-002',1,'LUX-002','activo',2023,NULL,NULL,'2025-04-16 01:18:44','2025-04-16 01:18:44'),(3,'LUXBUS-003',1,'LUX-003','activo',2023,NULL,NULL,'2025-04-16 01:18:44','2025-04-16 01:18:44'),(4,'EXEBUS-001',2,'EXE-001','activo',2022,NULL,NULL,'2025-04-16 01:18:45','2025-04-16 01:18:45'),(5,'EXEBUS-002',2,'EXE-002','activo',2022,NULL,NULL,'2025-04-16 01:18:45','2025-04-16 01:18:45'),(6,'EXEBUS-003',2,'EXE-003','activo',2022,NULL,NULL,'2025-04-16 01:18:45','2025-04-16 01:18:45'),(7,'TURBUS-001',3,'TUR-001','activo',2021,NULL,NULL,'2025-04-16 01:18:45','2025-04-16 01:18:45'),(8,'TURBUS-002',3,'TUR-002','activo',2021,NULL,NULL,'2025-04-16 01:18:45','2025-04-16 01:18:45'),(9,'TURBUS-003',3,'TUR-003','activo',2021,NULL,NULL,'2025-04-16 01:18:45','2025-04-16 01:18:45'),(10,'LUXBUS-004',1,'LUX-004','activo',2023,NULL,NULL,'2025-04-16 01:28:11','2025-04-16 01:28:11'),(11,'LUXBUS-005',1,'LUX-005','activo',2023,NULL,NULL,'2025-04-16 01:28:11','2025-04-16 01:28:11'),(12,'LUXBUS-006',1,'LUX-006','activo',2023,NULL,NULL,'2025-04-16 01:28:11','2025-04-16 01:28:11'),(13,'LUXBUS-007',1,'LUX-007','activo',2023,NULL,NULL,'2025-04-16 01:28:11','2025-04-16 01:28:11'),(14,'EXEBUS-004',2,'EXE-004','activo',2022,NULL,NULL,'2025-04-16 01:28:11','2025-04-16 01:28:11'),(15,'EXEBUS-005',2,'EXE-005','activo',2022,NULL,NULL,'2025-04-16 01:28:11','2025-04-16 01:28:11'),(16,'EXEBUS-006',2,'EXE-006','activo',2022,NULL,NULL,'2025-04-16 01:28:11','2025-04-16 01:28:11'),(17,'EXEBUS-007',2,'EXE-007','activo',2022,NULL,NULL,'2025-04-16 01:28:11','2025-04-16 01:28:11'),(18,'TURBUS-004',3,'TUR-004','activo',2021,NULL,NULL,'2025-04-16 01:28:11','2025-04-16 01:28:11'),(19,'TURBUS-005',3,'TUR-005','activo',2021,NULL,NULL,'2025-04-16 01:28:11','2025-04-16 01:28:11'),(20,'TURBUS-006',3,'TUR-006','activo',2021,NULL,NULL,'2025-04-16 01:28:11','2025-04-16 01:28:11'),(21,'TURBUS-007',3,'TUR-007','activo',2021,NULL,NULL,'2025-04-16 01:28:11','2025-04-16 01:28:11');
/*!40000 ALTER TABLE `buses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clave` varchar(50) NOT NULL,
  `valor` text NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `actualizado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `clave` (`clave`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracion`
--

LOCK TABLES `configuracion` WRITE;
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
INSERT INTO `configuracion` VALUES (1,'sitio_nombre','Cielo Tico','Nombre del sitio web','2025-04-13 21:01:04'),(2,'sitio_descripcion','Tours y aventuras en Costa Rica','Descripción corta del sitio','2025-04-13 21:01:04'),(3,'email_contacto','contacto@cielotico.com','Email principal de contacto','2025-04-13 21:01:04'),(4,'telefono_contacto','+506 1234-5678','Teléfono principal de contacto','2025-04-13 21:01:04');
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactos`
--

DROP TABLE IF EXISTS `contactos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contactos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `mensaje` text NOT NULL,
  `estado` enum('nuevo','leido','respondido') DEFAULT 'nuevo',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactos`
--

LOCK TABLES `contactos` WRITE;
/*!40000 ALTER TABLE `contactos` DISABLE KEYS */;
INSERT INTO `contactos` VALUES (1,'Jeff Amador','chesterab20@gmail.com','+506 7205-5101','aaa','nuevo','2025-04-16 01:10:58');
/*!40000 ALTER TABLE `contactos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `credenciales`
--

DROP TABLE IF EXISTS `credenciales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `credenciales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','usuario') NOT NULL DEFAULT 'usuario',
  `ultimo_acceso` datetime DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `credenciales`
--

LOCK TABLES `credenciales` WRITE;
/*!40000 ALTER TABLE `credenciales` DISABLE KEYS */;
INSERT INTO `credenciales` VALUES (1,'admin','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin',NULL,'2025-04-14 15:07:07',1);
/*!40000 ALTER TABLE `credenciales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resenas`
--

DROP TABLE IF EXISTS `resenas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resenas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `tour_id` int(11) DEFAULT NULL,
  `titulo` varchar(100) NOT NULL,
  `contenido` text NOT NULL,
  `calificacion` int(11) DEFAULT NULL CHECK (`calificacion` between 1 and 5),
  `estado` enum('pendiente','aprobado','rechazado') DEFAULT 'pendiente',
  `fecha_experiencia` date DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `tour_id` (`tour_id`),
  CONSTRAINT `resenas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `resenas_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resenas`
--

LOCK TABLES `resenas` WRITE;
/*!40000 ALTER TABLE `resenas` DISABLE KEYS */;
/*!40000 ALTER TABLE `resenas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservaciones`
--

DROP TABLE IF EXISTS `reservaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `tour_id` int(11) DEFAULT NULL,
  `fecha_reserva` date NOT NULL,
  `numero_personas` int(11) NOT NULL,
  `estado` enum('pendiente','confirmada','cancelada') DEFAULT 'pendiente',
  `precio_total` decimal(10,2) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `tour_id` (`tour_id`),
  CONSTRAINT `reservaciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `reservaciones_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservaciones`
--

LOCK TABLES `reservaciones` WRITE;
/*!40000 ALTER TABLE `reservaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonios`
--

DROP TABLE IF EXISTS `testimonios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testimonios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_cliente` varchar(100) NOT NULL,
  `tour_id` int(11) DEFAULT NULL,
  `calificacion` int(11) DEFAULT NULL CHECK (`calificacion` between 1 and 5),
  `comentario` text NOT NULL,
  `aprobado` tinyint(1) DEFAULT 0,
  `creado` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `tour_id` (`tour_id`),
  CONSTRAINT `testimonios_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonios`
--

LOCK TABLES `testimonios` WRITE;
/*!40000 ALTER TABLE `testimonios` DISABLE KEYS */;
/*!40000 ALTER TABLE `testimonios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_bus`
--

DROP TABLE IF EXISTS `tipos_bus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipos_bus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `capacidad_pasajeros` int(11) NOT NULL,
  `caracteristicas` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_bus`
--

LOCK TABLES `tipos_bus` WRITE;
/*!40000 ALTER TABLE `tipos_bus` DISABLE KEYS */;
INSERT INTO `tipos_bus` VALUES (1,'Lujo','Bus de lujo con máximo confort y amenidades',30,'Asientos reclinables de cuero, WiFi, TV, Baño, Aire acondicionado, Sistema de entretenimiento','2025-04-16 01:18:44'),(2,'Ejecutivo','Bus ejecutivo con comodidades estándar plus',35,'Asientos reclinables, Aire acondicionado, Baño, Sistema de audio','2025-04-16 01:18:44'),(3,'Turístico','Bus turístico estándar',40,'Asientos estándar, Aire acondicionado, Sistema de audio básico','2025-04-16 01:18:44');
/*!40000 ALTER TABLE `tipos_bus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tours`
--

DROP TABLE IF EXISTS `tours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `precio_turistico` decimal(10,2) NOT NULL,
  `precio_ejecutivo` decimal(10,2) NOT NULL,
  `precio_lujo` decimal(10,2) NOT NULL,
  `duracion` varchar(50) DEFAULT NULL,
  `max_personas` int(11) DEFAULT NULL,
  `imagen_url` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `incluye` text DEFAULT NULL,
  `no_incluye` text DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tours`
--

LOCK TABLES `tours` WRITE;
/*!40000 ALTER TABLE `tours` DISABLE KEYS */;
INSERT INTO `tours` VALUES (1,'Volc?n Arenal','El majestuoso coloso de Costa Rica, rodeado de aguas termales y bosque tropical.',0.00,22000.00,33000.00,44000.00,'1 d?a',40,'../img/slider1.jpg',NULL,NULL,NULL,NULL,'activo',1,'2025-04-16 01:51:32'),(2,'Guanacaste','Playas doradas, puestas de sol espectaculares y cultura guanacasteca.',0.00,44000.00,66000.00,88000.00,'2 d?as',35,'../img/slider2.jpg',NULL,NULL,NULL,NULL,'activo',1,'2025-04-16 01:51:32'),(3,'Cerro Chirrip?','El punto m?s alto de Costa Rica, donde las nubes tocan la tierra.',0.00,44000.00,66000.00,88000.00,'2 d?as',30,'../img/slider3.jpg',NULL,NULL,NULL,NULL,'activo',1,'2025-04-16 01:51:32'),(4,'Manuel Antonio','Donde el bosque se encuentra con el mar, hogar de una incre?ble biodiversidad.',0.00,22000.00,33000.00,44000.00,'1 d?a',40,'../img/slider5.jpg',NULL,NULL,NULL,NULL,'activo',1,'2025-04-16 01:51:32'),(5,'Monteverde','Bosque nuboso m?stico con una biodiversidad ?nica en el mundo.',0.00,44000.00,66000.00,88000.00,'2 d?as',35,'../img/slider6.jpg',NULL,NULL,NULL,NULL,'activo',1,'2025-04-16 01:51:32'),(6,'Puerto Viejo','Para?so caribe?o con rica cultura afrocaribe?a y playas paradis?acas.',0.00,66000.00,99000.00,132000.00,'3 d?as',30,'../img/slider4.jpg',NULL,NULL,NULL,NULL,'activo',1,'2025-04-16 01:51:32'),(7,'R?o Celeste','Descubre el m?gico r?o de aguas turquesas en el Parque Nacional Volc?n Tenorio.',0.00,22000.00,33000.00,44000.00,'1 d?a',40,'../img/tours/rio-celeste.jpg',NULL,NULL,NULL,NULL,'activo',1,'2025-04-16 01:51:32'),(8,'Cahuita','Explora los arrecifes de coral y la exuberante selva tropical del Caribe.',0.00,44000.00,66000.00,88000.00,'2 d?as',35,'../img/tours/cahuita.jpg',NULL,NULL,NULL,NULL,'activo',1,'2025-04-16 01:51:32'),(9,'San Jos?','Recorre la capital y descubre su rica historia, cultura y arquitectura.',0.00,22000.00,33000.00,44000.00,'1 d?a',40,'../img/tours/san-jose.jpg',NULL,NULL,NULL,NULL,'activo',1,'2025-04-16 01:51:32');
/*!40000 ALTER TABLE `tours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `apellidos` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `rol` enum('admin','cliente') DEFAULT 'cliente',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Jeff Amador','chesterab20','','chesterab20@gmail.com','$2y$10$1Ig102djBuyfA/jbJPR8Y.SM8DN4j8MhnwPuQ08O4LOwrwDBzptLO','+506 7205-5101','cliente','2025-04-14 02:39:13'),(2,'Usuario Prueba','test','','test@example.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','+506 2222-2222','cliente','2025-04-14 21:07:07'),(5,'Administrator','admin','','admin@gmail.com','$2y$10$aQ9AxJ6Y2UnWB1kqksZnRuK6CCkcG3BgBuAMyQ0a.QwuhkpE4Xfci','+506 8888-8888','admin','2025-04-15 04:31:57'),(7,'Pedro Piedra','pedropie','','pedropie@gmail.com','$2y$10$KQfckpiOB5ux7et/KY4aF.2hQLzrk2k370Yz6F5d.juNEAy6C4QBq','+506 6005-1201','','2025-04-15 19:45:09');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-15 21:24:25
