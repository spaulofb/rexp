--
-- MySQL dump 10.13  Dicampoib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: pessoal
-- ------------------------------------------------------
-- Server version	5.1.73
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping routines for database 'pessoal'
--
--   retornando o campo  - convertendo a acentuacao, em maiusculo e trim

--  use pessoal;

DROP FUNCTION IF EXISTS  acentos_upper;

/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`soldbm`@`sol.fmrp.usp.br`*/ /*!50003 FUNCTION `acentos_upper`(campo  VARCHAR(255)) RETURNS varchar(255) CHARSET latin1
BEGIN
while instr(campo,'  ') > 0 do
set campo := replace(campo,'  ',' ');
end while;
return  CONVERT(upper(trim(campo)) using utf8);
END */;;
DELIMITER ;
