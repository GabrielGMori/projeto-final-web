CREATE DATABASE  IF NOT EXISTS `web_loja_de_roupas` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `web_loja_de_roupas`;
-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: web_loja_de_roupas
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
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `id_pk` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id_pk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peca`
--

DROP TABLE IF EXISTS `peca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `peca` (
  `id_pk` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `estoque` int(11) NOT NULL,
  `Categoria_id_pk` int(11) NOT NULL,
  PRIMARY KEY (`id_pk`),
  KEY `fk_Peca_Categoria` (`Categoria_id_pk`),
  CONSTRAINT `fk_Peca_Categoria` FOREIGN KEY (`Categoria_id_pk`) REFERENCES `categoria` (`id_pk`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peca`
--

LOCK TABLES `peca` WRITE;
/*!40000 ALTER TABLE `peca` DISABLE KEYS */;
/*!40000 ALTER TABLE `peca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reposicao`
--

DROP TABLE IF EXISTS `reposicao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reposicao` (
  `id_pk` int(11) NOT NULL AUTO_INCREMENT,
  `data_horario` datetime NOT NULL,
  PRIMARY KEY (`id_pk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reposicao`
--

LOCK TABLES `reposicao` WRITE;
/*!40000 ALTER TABLE `reposicao` DISABLE KEYS */;
/*!40000 ALTER TABLE `reposicao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reposicao_tem_peca`
--

DROP TABLE IF EXISTS `reposicao_tem_peca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reposicao_tem_peca` (
  `Reposicao_id_fk_pk` int(11) NOT NULL,
  `Peca_id_fk_pk` int(11) NOT NULL,
  `preco` decimal(2,0) NOT NULL,
  `quantidade` int(11) NOT NULL,
  PRIMARY KEY (`Reposicao_id_fk_pk`,`Peca_id_fk_pk`),
  KEY `fk_Reposicao_has_Peca_Peca1` (`Peca_id_fk_pk`),
  CONSTRAINT `fk_Reposicao_has_Peca_Peca1` FOREIGN KEY (`Peca_id_fk_pk`) REFERENCES `peca` (`id_pk`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Reposicao_has_Peca_Reposicao1` FOREIGN KEY (`Reposicao_id_fk_pk`) REFERENCES `reposicao` (`id_pk`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reposicao_tem_peca`
--

LOCK TABLES `reposicao_tem_peca` WRITE;
/*!40000 ALTER TABLE `reposicao_tem_peca` DISABLE KEYS */;
/*!40000 ALTER TABLE `reposicao_tem_peca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_pk` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `permissao` varchar(5) NOT NULL,
  PRIMARY KEY (`id_pk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venda`
--

DROP TABLE IF EXISTS `venda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venda` (
  `id_pk` int(11) NOT NULL AUTO_INCREMENT,
  `data_horario` datetime NOT NULL,
  PRIMARY KEY (`id_pk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venda`
--

LOCK TABLES `venda` WRITE;
/*!40000 ALTER TABLE `venda` DISABLE KEYS */;
/*!40000 ALTER TABLE `venda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venda_tem_peca`
--

DROP TABLE IF EXISTS `venda_tem_peca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venda_tem_peca` (
  `Venda_id_fk_pk` int(11) NOT NULL,
  `Peca_id_fk_pk` int(11) NOT NULL,
  `preco` decimal(2,0) NOT NULL,
  `quantidade` int(11) NOT NULL,
  PRIMARY KEY (`Venda_id_fk_pk`,`Peca_id_fk_pk`),
  KEY `fk_Venda_has_Peca_Peca1` (`Peca_id_fk_pk`),
  CONSTRAINT `fk_Venda_has_Peca_Peca1` FOREIGN KEY (`Peca_id_fk_pk`) REFERENCES `peca` (`id_pk`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Venda_has_Peca_Venda1` FOREIGN KEY (`Venda_id_fk_pk`) REFERENCES `venda` (`id_pk`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venda_tem_peca`
--

LOCK TABLES `venda_tem_peca` WRITE;
/*!40000 ALTER TABLE `venda_tem_peca` DISABLE KEYS */;
/*!40000 ALTER TABLE `venda_tem_peca` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-02 19:04:47
