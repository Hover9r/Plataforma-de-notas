-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: prueba
-- ------------------------------------------------------
-- Server version	8.0.38

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
-- Table structure for table `administradores`
--

DROP TABLE IF EXISTS `administradores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administradores` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `nombres_admin` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos_admin` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero_admin` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cedula_admin` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_admin` int DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  KEY `login_fk_admin_idx` (`login_admin`),
  CONSTRAINT `login_fk_admin` FOREIGN KEY (`login_admin`) REFERENCES `login` (`id_login`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administradores`
--

LOCK TABLES `administradores` WRITE;
/*!40000 ALTER TABLE `administradores` DISABLE KEYS */;
INSERT INTO `administradores` VALUES (1,'Fernanda Lucía','Calderon Casas','F','1748394758',1);
/*!40000 ALTER TABLE `administradores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos` (
  `id_alumnos` int NOT NULL AUTO_INCREMENT,
  `lista_num_alumnos` int NOT NULL,
  `nombres_alumnos` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos_alumnos` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero_alumnos` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grados_alumnos` int DEFAULT NULL,
  `subgrados_alumnos` int DEFAULT NULL,
  `login_alumnos` int DEFAULT NULL,
  `padres_alumnos` int DEFAULT NULL,
  PRIMARY KEY (`id_alumnos`),
  KEY `subgrados_fk_alum_idx` (`subgrados_alumnos`),
  KEY `grados_fk_alum_idx` (`grados_alumnos`),
  KEY `login_fk_alum_idx` (`login_alumnos`),
  KEY `padres_fk_alum_idx` (`padres_alumnos`),
  CONSTRAINT `grados_fk_alum` FOREIGN KEY (`grados_alumnos`) REFERENCES `grados` (`id_grados`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `login_fk_alum` FOREIGN KEY (`login_alumnos`) REFERENCES `login` (`id_login`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `padres_fk_alum` FOREIGN KEY (`padres_alumnos`) REFERENCES `padres` (`id_padres`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `subgrados_fk_alum` FOREIGN KEY (`subgrados_alumnos`) REFERENCES `subgrados` (`id_subgrados`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT INTO `alumnos` VALUES (1,2001,'Sara Cecilia','Almario Perdomo','F',4,1,6,NULL),(2,2002,'Juan Carlos','Pencue Lozada','M',4,3,7,1),(3,2003,'Paula','Puentes Ramirez','F',5,1,8,NULL);
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grado_subgrado_materia`
--

DROP TABLE IF EXISTS `grado_subgrado_materia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grado_subgrado_materia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_grados` int DEFAULT NULL,
  `id_subgrados` int DEFAULT NULL,
  `id_materias` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_grados` (`id_grados`,`id_subgrados`,`id_materias`),
  KEY `id_subgrados` (`id_subgrados`),
  KEY `id_materias` (`id_materias`),
  CONSTRAINT `grado_subgrado_materia_ibfk_1` FOREIGN KEY (`id_grados`) REFERENCES `grados` (`id_grados`),
  CONSTRAINT `grado_subgrado_materia_ibfk_2` FOREIGN KEY (`id_subgrados`) REFERENCES `subgrados` (`id_subgrados`),
  CONSTRAINT `grado_subgrado_materia_ibfk_3` FOREIGN KEY (`id_materias`) REFERENCES `materias` (`id_materias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grado_subgrado_materia`
--

LOCK TABLES `grado_subgrado_materia` WRITE;
/*!40000 ALTER TABLE `grado_subgrado_materia` DISABLE KEYS */;
/*!40000 ALTER TABLE `grado_subgrado_materia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grados`
--

DROP TABLE IF EXISTS `grados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grados` (
  `id_grados` int NOT NULL AUTO_INCREMENT,
  `nombre_grados` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_grados`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grados`
--

LOCK TABLES `grados` WRITE;
/*!40000 ALTER TABLE `grados` DISABLE KEYS */;
INSERT INTO `grados` VALUES (4,'Sexto'),(5,'Septimo'),(6,'Octavo'),(7,'Noveno'),(8,'Decimo');
/*!40000 ALTER TABLE `grados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login` (
  `id_login` int NOT NULL AUTO_INCREMENT,
  `usuario_login` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_login` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol_login` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_login`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (1,'admin','$2y$10$XPPxMmPIN17FNuvShl2FeuOUtHf2f3g2jWiqNqKbSu0knw5rE1rkG','Administrador'),(2,'LopezT','$2y$10$4bRW/PvizOxG4lLDbyXhsOLKydtAJ6chSkQjdiY18l4RXjg1a4EdS','Profesor'),(3,'ArtunP','$2y$10$CAnb0HP2rj3GCxjsN0ioVOZZeLqjC/RwMMwQhNns4.yR/18mOSqUi','Profesor'),(4,'PuyoM','$2y$10$mKkYH7yvKzUjElDsDQiDLu9LxGIFmD765r8js.hev1V9Eowad6rvm','Profesor'),(5,'MosqueR','$2y$10$nXq8uW77m7QNnn0Wd1WBKuvSjJAqdAXffE9MmeErikCrbPNrcvNLK','Profesor'),(6,'AlmarioP','$2y$10$ji5EGYnft4beZuNN3RBVrusxTGLqprDpRpne8NZJ11dUFqnOruIT6','Estudiante'),(7,'PencueL','$2y$10$rr11ZSa04CRg7afevh96UuAxLBN6wGixK63hv6UBs255zwnccAvsS','Estudiante'),(8,'PuentesR','$2y$10$KWRht.DTSY8unrebHO8vj.RZYsO3Z0gwXaUD0zckc/1X5ILS6LIWa','Estudiante'),(9,'PencueS','$2y$10$u0SLHwxZjjopxk0SEdAshOGGpmcZOBHgnep.MJbcvd8/jIkZh/fxq','Padre');
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maestros`
--

DROP TABLE IF EXISTS `maestros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maestros` (
  `id_maestros` int NOT NULL AUTO_INCREMENT,
  `nombres_maestros` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos_maestros` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cedula_maestros` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero_maestros` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_maestros` int DEFAULT NULL,
  PRIMARY KEY (`id_maestros`),
  KEY `login_fk_maestros_idx` (`login_maestros`),
  CONSTRAINT `login_fk_maestros` FOREIGN KEY (`login_maestros`) REFERENCES `login` (`id_login`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maestros`
--

LOCK TABLES `maestros` WRITE;
/*!40000 ALTER TABLE `maestros` DISABLE KEYS */;
INSERT INTO `maestros` VALUES (1,'German','Lopez Trujillo','28749583','M',2),(2,'Martha Elisa','Artunduaga Perdomo','1849305748','F',3),(3,'Camilo ','Puyo Manrrique','1759392','M',4),(4,'Jesus Andres','Mosquera Rodriguez','1748395037','M',5);
/*!40000 ALTER TABLE `maestros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maestros_materias`
--

DROP TABLE IF EXISTS `maestros_materias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maestros_materias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_maestros` int DEFAULT NULL,
  `id_materias` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_maestros` (`id_maestros`,`id_materias`),
  KEY `id_materias` (`id_materias`),
  CONSTRAINT `maestros_materias_ibfk_1` FOREIGN KEY (`id_maestros`) REFERENCES `maestros` (`id_maestros`),
  CONSTRAINT `maestros_materias_ibfk_2` FOREIGN KEY (`id_materias`) REFERENCES `materias` (`id_materias`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maestros_materias`
--

LOCK TABLES `maestros_materias` WRITE;
/*!40000 ALTER TABLE `maestros_materias` DISABLE KEYS */;
INSERT INTO `maestros_materias` VALUES (2,1,2),(1,2,1),(3,3,3),(4,4,4);
/*!40000 ALTER TABLE `maestros_materias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materias`
--

DROP TABLE IF EXISTS `materias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `materias` (
  `id_materias` int NOT NULL AUTO_INCREMENT,
  `nombre_materias` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cant_notas_materias` int NOT NULL,
  `maestros_materias` int DEFAULT NULL,
  PRIMARY KEY (`id_materias`),
  KEY `maestros_fk_materias_idx` (`maestros_materias`),
  CONSTRAINT `maestros_fk_materias` FOREIGN KEY (`maestros_materias`) REFERENCES `maestros` (`id_maestros`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materias`
--

LOCK TABLES `materias` WRITE;
/*!40000 ALTER TABLE `materias` DISABLE KEYS */;
INSERT INTO `materias` VALUES (1,'Lengua Castellana',5,2),(2,'Matemáticas',5,1),(3,'Ingles',5,3),(4,'Sociales',5,4);
/*!40000 ALTER TABLE `materias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notas`
--

DROP TABLE IF EXISTS `notas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notas` (
  `id_notas` int NOT NULL AUTO_INCREMENT,
  `nota_notas` decimal(10,0) NOT NULL,
  `observaciones_notas` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `alumnos_notas` int DEFAULT NULL,
  `materias_notas` int DEFAULT NULL,
  `id_periodo` int DEFAULT NULL,
  PRIMARY KEY (`id_notas`),
  KEY `alumnos_fk_notas_idx` (`alumnos_notas`),
  KEY `materias_fk_notas_idx` (`materias_notas`),
  KEY `periodo_fk_notas` (`id_periodo`),
  CONSTRAINT `alumnos_fk_notas` FOREIGN KEY (`alumnos_notas`) REFERENCES `alumnos` (`id_alumnos`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `materias_fk_notas` FOREIGN KEY (`materias_notas`) REFERENCES `materias` (`id_materias`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `periodo_fk_notas` FOREIGN KEY (`id_periodo`) REFERENCES `periodos` (`id_periodo`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notas`
--

LOCK TABLES `notas` WRITE;
/*!40000 ALTER TABLE `notas` DISABLE KEYS */;
INSERT INTO `notas` VALUES (1,4,'ninguna',1,1,1),(2,3,'ninguna',1,1,1),(3,1,'ninguna',1,1,1),(4,4,'ninguna',1,1,1),(5,4,'ninguna',1,1,1),(6,4,'ninguna',1,2,1),(7,4,'ninguna',1,2,1),(8,4,'ninguna',1,2,1),(9,3,'ninguna',1,2,1),(10,5,'ninguna',1,2,1),(11,4,'Falta mejorar',1,3,1),(12,3,'Falta mejorar',1,3,1),(13,4,'Falta mejorar',1,3,1),(14,3,'Falta mejorar',1,3,1),(15,4,'Falta mejorar',1,3,1),(16,5,'En proceso',1,4,1),(17,4,'En proceso',1,4,1),(18,5,'En proceso',1,4,1),(19,4,'En proceso',1,4,1),(20,1,'En proceso',1,4,1);
/*!40000 ALTER TABLE `notas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `padres`
--

DROP TABLE IF EXISTS `padres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `padres` (
  `id_padres` int NOT NULL AUTO_INCREMENT,
  `nombres_padres` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos_padres` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_padres` int DEFAULT NULL,
  PRIMARY KEY (`id_padres`),
  KEY `login_padres_idx` (`login_padres`),
  CONSTRAINT `login_padres` FOREIGN KEY (`login_padres`) REFERENCES `login` (`id_login`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `padres`
--

LOCK TABLES `padres` WRITE;
/*!40000 ALTER TABLE `padres` DISABLE KEYS */;
INSERT INTO `padres` VALUES (1,'Juan Pablo','Pencue Suarez',9);
/*!40000 ALTER TABLE `padres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `periodos`
--

DROP TABLE IF EXISTS `periodos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `periodos` (
  `id_periodo` int NOT NULL AUTO_INCREMENT,
  `nombre_periodo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_periodo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `periodos`
--

LOCK TABLES `periodos` WRITE;
/*!40000 ALTER TABLE `periodos` DISABLE KEYS */;
INSERT INTO `periodos` VALUES (1,'Primer Periodo'),(2,'Segundo Periodo');
/*!40000 ALTER TABLE `periodos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subgrados`
--

DROP TABLE IF EXISTS `subgrados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subgrados` (
  `id_subgrados` int NOT NULL AUTO_INCREMENT,
  `nombre_subgrados` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grado_id` int DEFAULT NULL,
  PRIMARY KEY (`id_subgrados`),
  KEY `fk_grado_id` (`grado_id`),
  CONSTRAINT `fk_grado_id` FOREIGN KEY (`grado_id`) REFERENCES `grados` (`id_grados`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subgrados`
--

LOCK TABLES `subgrados` WRITE;
/*!40000 ALTER TABLE `subgrados` DISABLE KEYS */;
INSERT INTO `subgrados` VALUES (1,'01',4),(2,'01',5),(3,'02',4);
/*!40000 ALTER TABLE `subgrados` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-07 18:35:22
