/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.5.27-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: patrimonio
-- ------------------------------------------------------
-- Server version	10.5.27-MariaDB
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping routines for database 'patrimonio'
--
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
DELIMITER ;;
CREATE DEFINER=`soldbm`@`localhost` FUNCTION `acentos_upper`(`campo` VARCHAR(255)) RETURNS varchar(255) CHARSET latin1 COLLATE latin1_swedish_ci
BEGIN
while instr(campo,'  ') > 0 do
set campo := replace(campo,'  ',' ');
end while;
return  CONVERT(upper(trim(campo)) using utf8);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
DELIMITER ;;
CREATE DEFINER=`soldbm`@`localhost` FUNCTION `clean_spaces`(`str` VARCHAR(255)) RETURNS varchar(255) CHARSET latin1 COLLATE latin1_swedish_ci
BEGIN
while instr(str,'  ') > 0 do
set str := replace(str,'  ',' ');
end while;
return trim(str);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
DELIMITER ;;
CREATE DEFINER=`soldbm`@`localhost` FUNCTION `CONTAREGISTRO`() RETURNS text CHARSET latin1 COLLATE latin1_swedish_ci
    COMMENT 'Conta registro por registro'
BEGIN
RETURN IF(@CONTANDOREG,@CONTANDOREG:=@CONTANDOREG+1,@CONTANDOREG:=1);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
DELIMITER ;;
CREATE DEFINER=`lafbezer`@`localhost` FUNCTION `extractpart`(string VARCHAR(250), dlmt VARCHAR(16), partnumber INT, spaceout BOOLEAN ) RETURNS varchar(250) CHARSET latin1 COLLATE latin1_swedish_ci
    DETERMINISTIC
BEGIN
    DECLARE lnipnext INT;
    DECLARE lnipfound INT;
    DECLARE lnparti INT;
    DECLARE lncars INT;
    DECLARE lcstrrest VARCHAR(250);
    DECLARE lcstrpart VARCHAR(250);
    DECLARE lcdlmt VARCHAR(1);

    SET lcdlmt = TRIM(dlmt);

    IF spaceout THEN 
        SET lcstrrest = TRIM(string);
    ELSE 
        SET lcstrrest = string;
    END IF;

    SET lnipnext = 1;
    SET lnparti = 1;
    SET lcstrrest = CONCAT(lcstrrest, lcdlmt);
    SET lncars = LENGTH(lcstrrest);

    REPEAT
        SET lnipfound = LOCATE(lcdlmt, lcstrrest, lnipnext);
        SET lcstrpart =  SUBSTR(lcstrrest, lnipnext, (lnipfound - lnipnext));
         
        if lnparti=partnumber THEN 
            RETURN lcstrpart;
        END IF;
        SET lnipnext = lnipfound + 1;
        SET lnparti = lnparti +1;
    UNTIL lnipnext >= lncars END REPEAT;
    RETURN lcstrpart;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
DELIMITER ;;
CREATE DEFINER=`soldbm`@`localhost` FUNCTION `FRemoveAcentos`(texto VARCHAR(1024), tipocaixa CHAR) RETURNS varchar(1024) CHARSET latin1 COLLATE latin1_swedish_ci
BEGIN
DECLARE comacentos VARCHAR(32);
DECLARE semacentos VARCHAR(32);
DECLARE textosemacentos VARCHAR(1024) Default '';
DECLARE ctexto CHAR;
DECLARE ccaixa CHAR;
DECLARE cacento CHAR;
DECLARE i INT Default 0 ;
DECLARE k INT Default 0 ;
DECLARE nacentos INT Default 0 ;
DECLARE ntexto INT Default 0 ;
SET comacentos = 'ÀÂÊÔÎÛÃÕÁÉÍÓÚÇÜ';
SET comacentos = CONCAT(comacentos, LOWER(comacentos));
SET semacentos = 'AAEOIUAOAEIOUCU';
SET semacentos = CONCAT(semacentos, LOWER(semacentos));
SET nacentos = CHAR_LENGTH(comacentos);
SET ntexto = CHAR_LENGTH(texto);
SET ccaixa = UPPER(TRIM(tipocaixa));
for_i: LOOP
   SET i=i+1;
   IF i>ntexto THEN
      LEAVE for_i;
   END IF;
   SET ctexto = SUBSTRING(texto,i,1);
   IF ctexto<>' ' THEN
      SET k = LOCATE(ctexto,comacentos);
      IF k>0 THEN
         SET cacento = SUBSTRING(comacentos,k,1);
         SET ctexto = IF (binary ctexto=cacento,ctexto,SUBSTRING(semacentos,k,1));
      END IF;
   
      CASE ccaixa
         WHEN 'A' THEN SET ctexto = UPPER(ctexto);
         WHEN 'B' THEN SET ctexto = LOWER(ctexto);
         ELSE
            BEGIN
            END;
      END CASE;
      SET textosemacentos = CONCAT(textosemacentos,ctexto);
   ELSE
      SET textosemacentos = CONCAT(textosemacentos,' ');
   END IF;
   
END LOOP for_i;
RETURN textosemacentos;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
DELIMITER ;;
CREATE DEFINER=`soldbm`@`localhost` FUNCTION `regex_replace`(pattern VARCHAR(1000),replacement VARCHAR(1000),original VARCHAR(1000)) RETURNS varchar(1000) CHARSET latin1 COLLATE latin1_swedish_ci
    DETERMINISTIC
BEGIN 
 DECLARE temp VARCHAR(1000); 
DECLARE ch VARCHAR(1);
DECLARE i INT;
 SET i = 1;
SET temp = '';
IF original REGEXP pattern THEN
loop_label: LOOP 
IF i>CHAR_LENGTH(original) THEN
LEAVE loop_label; 
END IF;
SET ch = SUBSTRING(original,i,1);
IF NOT ch REGEXP pattern THEN
SET temp = CONCAT(temp,ch);
ELSE
    SET temp = CONCAT(temp,replacement);
END IF;
SET i=i+1;
END LOOP;
ELSE
SET temp=original;
END IF;
RETURN temp;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
DELIMITER ;;
CREATE DEFINER=`soldbm`@`localhost` FUNCTION `remove_accents`(`str` TEXT) RETURNS text CHARSET latin1 COLLATE latin1_swedish_ci
    NO SQL
    DETERMINISTIC
BEGIN

    SET str = REPLACE(str,'Š','S');
    SET str = REPLACE(str,'š','s');
    SET str = REPLACE(str,'Ð','Dj');
    SET str = REPLACE(str,'Ž','Z');
    SET str = REPLACE(str,'ž','z');
    SET str = REPLACE(str,'À','A');
    SET str = REPLACE(str,'Á','A');
    SET str = REPLACE(str,'Â','A');
    SET str = REPLACE(str,'Ã','A');
    SET str = REPLACE(str,'Ä','A');
    SET str = REPLACE(str,'Å','A');
    SET str = REPLACE(str,'Æ','A');
    SET str = REPLACE(str,'Ç','C');
    SET str = REPLACE(str,'È','E');
    SET str = REPLACE(str,'É','E');
    SET str = REPLACE(str,'Ê','E');
    SET str = REPLACE(str,'Ë','E');
    SET str = REPLACE(str,'Ì','I');
    SET str = REPLACE(str,'Í','I');
    SET str = REPLACE(str,'Î','I');
    SET str = REPLACE(str,'Ï','I');
    SET str = REPLACE(str,'Ñ','N');
    SET str = REPLACE(str,'Ò','O');
    SET str = REPLACE(str,'Ó','O');
    SET str = REPLACE(str,'Ô','O');
    SET str = REPLACE(str,'Õ','O');
    SET str = REPLACE(str,'Ö','O');
    SET str = REPLACE(str,'Ø','O');
    SET str = REPLACE(str,'Ù','U');
    SET str = REPLACE(str,'Ú','U');
    SET str = REPLACE(str,'Û','U');
    SET str = REPLACE(str,'Ü','U');
    SET str = REPLACE(str,'Ý','Y');
    SET str = REPLACE(str,'Þ','B');
    SET str = REPLACE(str,'ß','Ss');
    SET str = REPLACE(str,'à','a');
    SET str = REPLACE(str,'á','a');
    SET str = REPLACE(str,'â','a');
    SET str = REPLACE(str,'ã','a');
    SET str = REPLACE(str,'ä','a');
    SET str = REPLACE(str,'å','a');
    SET str = REPLACE(str,'æ','a');
    SET str = REPLACE(str,'ç','c');
    SET str = REPLACE(str,'è','e');
    SET str = REPLACE(str,'é','e');
    SET str = REPLACE(str,'ê','e');
    SET str = REPLACE(str,'ë','e');
    SET str = REPLACE(str,'ì','i');
    SET str = REPLACE(str,'í','i');
    SET str = REPLACE(str,'î','i');
    SET str = REPLACE(str,'ï','i');
    SET str = REPLACE(str,'ð','o');
    SET str = REPLACE(str,'ñ','n');
    SET str = REPLACE(str,'ò','o');
    SET str = REPLACE(str,'ó','o');
    SET str = REPLACE(str,'ô','o');
    SET str = REPLACE(str,'õ','o');
    SET str = REPLACE(str,'ö','o');
    SET str = REPLACE(str,'ø','o');
    SET str = REPLACE(str,'ù','u');
    SET str = REPLACE(str,'ú','u');
    SET str = REPLACE(str,'û','u');
    SET str = REPLACE(str,'ý','y');
    SET str = REPLACE(str,'ý','y');
    SET str = REPLACE(str,'þ','b');
    SET str = REPLACE(str,'ÿ','y');
    SET str = REPLACE(str,'ƒ','f');


    RETURN str;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`soldbm`@`localhost` PROCEDURE `sessao_regs`()
BEGIN


    DECLARE CheckExists int;  
    SET CheckExists = 0;


SELECT  count(*) INTO CheckExists  FROM  patrimonio.sessao WHERE  codigo>2000  ORDER BY codigo ASC;


IF (CheckExists > 0) THEN 
    
    
   
    
    
    
    DROP TABLE IF EXISTS patrimonio.sessao_anterior;
    
    
    
    CREATE TABLE  patrimonio.sessao_anterior like patrimonio.sessao;
    commit;
    
    
    insert into patrimonio.sessao_anterior   Select * from patrimonio.sessao;
    commit;
    
    
    
    
    
    
    
    
    DROP TABLE  if exists patrimonio.sessaotmp;
    commit;
    
    
    
   CREATE TABLE  patrimonio.sessaotmp like patrimonio.sessao;
   commit;
   
   
   INSERT  into patrimonio.sessaotmp  select * from patrimonio.sessao  WHERE  codigo>2000;
   commit;
   
   
   
   
   SET FOREIGN_KEY_CHECKS = 0; 
   
   TRUNCATE TABLE  patrimonio.sessao ;
   commit;
   
   SET FOREIGN_KEY_CHECKS = 1; 
   
   
   
   ALTER TABLE  patrimonio.sessao  AUTO_INCREMENT=1;
   commit;
   
   
   
   
   INSERT INTO patrimonio.sessao ( datahorai,datahoraf,usuario,ipacesso,codacesso)  select datahorai,datahoraf,usuario,ipacesso,codacesso from patrimonio.sessaotmp order by codigo;
   commit;





END IF; 



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-16 15:24:59
