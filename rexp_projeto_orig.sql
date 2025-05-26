-- MySQL dump 10.14  Distrib 5.5.68-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: rexp
-- ------------------------------------------------------
-- Server version	5.5.68-MariaDB

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
-- Table structure for table `projeto`
--

DROP TABLE IF EXISTS `projeto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projeto` (
  `cip` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código do Identificação do Projeto',
  `titulo` varchar(254) NOT NULL COMMENT 'Titulo do Projeto.',
  `objetivo` int(11) NOT NULL COMMENT 'Objetivo do Projeto.',
  `autor` int(11) NOT NULL COMMENT 'Código do Autor Principal/Responsável pelo projeto.',
  `numprojeto` int(11) DEFAULT NULL COMMENT 'Número sequencial de projetos do respectivo responsável (autor)\r\n',
  `chefe` int(11) DEFAULT NULL COMMENT 'Código do chefe do autor (matricula USP)',
  `coresponsaveis` int(11) DEFAULT NULL COMMENT 'Número de co-responsaveis do Projeto.',
  `fonterec` char(16) DEFAULT NULL COMMENT 'Fonte de Recurso (Proprio, FAPESP, CNPQ, etc)',
  `fonteprojid` char(24) DEFAULT NULL COMMENT 'Identificação do Projeto na Fonte de Recursos.',
  `datainicio` datetime DEFAULT NULL COMMENT 'Data de Inicio do Projeto.',
  `datafinal` datetime DEFAULT NULL COMMENT 'Data Final do Projeto.',
  `relatproj` char(96) DEFAULT NULL COMMENT 'link para o Relatório Externo do Projeto.',
  `anotacao` int(11) NOT NULL COMMENT 'Código Sequencial da Anotação ',
  PRIMARY KEY (`cip`),
  UNIQUE KEY `autorprojeto` (`autor`,`numprojeto`),
  KEY `autor` (`autor`),
  KEY `objetivo` (`objetivo`),
  KEY `chefe` (`chefe`),
  CONSTRAINT `projeto_fk` FOREIGN KEY (`autor`) REFERENCES `pessoal`.`pessoa` (`codigousp`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `projeto_fk1` FOREIGN KEY (`objetivo`) REFERENCES `objetivo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COMMENT='Tabela dos Títulos dos Projetos.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projeto`
--

LOCK TABLES `projeto` WRITE;
/*!40000 ALTER TABLE `projeto` DISABLE KEYS */;
INSERT INTO `projeto` VALUES (6,'Projeto número 1 - modificado novamente - OK',7,2416911,1,NULL,1,'FAPESP','1234567','2015-03-01 00:00:00','2017-04-01 00:00:00','P1_Incrementando_o_Shell_com_ER.pdf',2),(12,'Projeto 2 - hoje',3,2416911,2,NULL,1,'CAPES','33557791','2015-09-26 00:00:00','2017-09-26 00:00:00','P2_Projeto 2  Apresentação Programação Nova  - Cópia.pdf',0);
/*!40000 ALTER TABLE `projeto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-31 12:47:07
