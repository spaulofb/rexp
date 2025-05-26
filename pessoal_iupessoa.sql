-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: pessoal
-- ------------------------------------------------------
-- Server version	5.1.73

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES latin1 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `pessoal`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `pessoal` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `pessoal`;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `codigo` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'CÃ³digo da Categoria Funcional',
  `descricao` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'DescriÃ§Ã£o sucinta da categoria funcional\r\n',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 322560 kB';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES ('DOC','Docente'),('FNB','Funcionário Nivel Básico'),('FNM','Funcionário Nível Médio'),('FNS','Funcionário Nível Superior'),('GRA','Aluno de Graduação'),('OUT','Outra Categoria'),('PES','Pesquisador Colaborador'),('PGD','Aluno de Pós-Graduação - Doutorado'),('PGM','Aluno de Pós-Graduação - Mestrado'),('PPD','Pós Doutorado');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chefe`
--

DROP TABLE IF EXISTS `chefe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chefe` (
  `idchefe` int(11) NOT NULL AUTO_INCREMENT,
  `chefecodusp` int(9) NOT NULL COMMENT 'Codigo USP - Chefe/Orientador',
  `nome` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nome da Pessoa',
  `categoria` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Categoria Funcional',
  PRIMARY KEY (`idchefe`),
  UNIQUE KEY `idchefe` (`idchefe`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chefe`
--

LOCK TABLES `chefe` WRITE;
/*!40000 ALTER TABLE `chefe` DISABLE KEYS */;
INSERT INTO `chefe` VALUES (1,70131,'Ademilson Espencer Egea Soares','DOC'),(2,70253,'Aguinaldo Luiz Simões','DOC'),(3,-1,'Ana Lilia Alzate Marin','DOC'),(4,-2,'Antonio Claudio Tedesco','DOC'),(5,-3,'Antonio Rossi Filho','DOC'),(6,-4,'Aparecida Maria Fontes','DOC'),(7,81485,'Cacilda Casartelli','DOC'),(8,177229,'Catarina Satie Takahashi','DOC'),(9,-5,'Celso Teixeira Mendes Junior','DOC'),(10,-6,'Claudia Cristina Paro de Paz','DOC'),(11,54442,'David De Jong','DOC'),(12,-7,'Eduardo Antônio Donadi','DOC'),(13,434515,'Elza Tiemi Sakamoto Hojo','DOC'),(14,60554,'Ester Silveira Ramos','DOC'),(15,2083320,'Eucléia Primo Betioli Contel','DOC'),(16,109134,'Fábio de Melo Sene','DOC'),(17,56100,'Geraldo Aleixo da silva Passos Junior','DOC'),(18,-8,'Henrique Nunes de Oliveira','DOC'),(19,7933702,'Houtan Noushmehr','DOC'),(20,2082952,'Jair Licio Ferreira Santos','DOC'),(21,49467,'João Monteiro de Pina Neto','DOC'),(22,-9,'Klaus Hartmann Hartfelder','DOC'),(23,503770,'Lionel Segui Gonçalves','DOC'),(24,82281,'Lucia Regina Martelli','DOC'),(25,740232,'Luiz Antonio Framartino Bezerra','DOC'),(26,-10,'Luiz Gonzaga Tone','DOC'),(27,-11,'Lusânia Maria Greggi Antunes','DOC'),(28,-12,'Marcia Maria Gentile Bitondi','DOC'),(29,-13,'Maria Armênia Ramalho Freitas','DOC'),(30,-14,'Maria Helena de Souza Goldman','DOC'),(31,1471547,'Maura Helena Manfrin','DOC'),(32,35739,'Moacyr Antonio Mestriner','DOC'),(33,75748,'Nilce Maria Martinez Rossi','DOC'),(34,1513550,'Paulo Mazzoncini de Azevedo Marques','DOC'),(35,49317,'Raysildo Barbosa Lôbo','DOC'),(36,2369711,'Ricardo Zorzetto Nicoliello Vêncio','DOC'),(37,-15,'Rodrigo Alexandre Panepucci','DOC'),(38,-16,'Sérgio Britto Garcia','DOC'),(39,1689081,'Silvana Giuliatti','DOC'),(40,-17,'Tiago Campos Pereira','DOC'),(41,-18,'Tiago Mauricio Francoy','DOC'),(42,5096188,'Vanessa da Silva Silveira','DOC'),(43,-19,'Vera Lucia Cardoso','DOC'),(44,1913921,'Victor Evangelista de Faria Ferraz','DOC'),(45,2056632,'Wilson Araujo da Silva Junior','DOC'),(46,527513,'Zilá Luz Paulino Simões','DOC');
/*!40000 ALTER TABLE `chefe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lixo`
--

DROP TABLE IF EXISTS `lixo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lixo` (
  `senha` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Senha do UsuÃ¡rio'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lixo`
--

LOCK TABLES `lixo` WRITE;
/*!40000 ALTER TABLE `lixo` DISABLE KEYS */;
INSERT INTO `lixo` VALUES ('7d05e5ad7f5662bb');
/*!40000 ALTER TABLE `lixo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pessoa`
--

DROP TABLE IF EXISTS `pessoa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pessoa` (
  `iupessoa` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica da pessoa',
  `codigousp` int(9) NOT NULL COMMENT 'Codigo USP - Matricula',
  `cpf` char(11) DEFAULT NULL COMMENT 'CPF da pessoa',
  `passaporte` char(16) DEFAULT NULL COMMENT 'CÃ³digo do Passaporte da Pessoa',
  `nome` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nome da Pessoa',
  `sexo` char(1) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Sexo (M,F)',
  `categoria` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Categoria Funcional',
  `instituicao` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'InstituiÃ§Ã£o',
  `unidade` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Unidade',
  `depto` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Departamento',
  `setor` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Setor',
  `bloco` char(8) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Bloco do Departamento',
  `sala` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Sala',
  `salatipo` char(32) DEFAULT NULL COMMENT 'Tipo da Sala (EscritÃ³rio=Sala Docente, LaboratÃ³rio, Anfiteatro, Sala de Aula, etc)\r\n',
  `fone` char(20) DEFAULT NULL,
  `ramal` char(4) DEFAULT NULL,
  `e_mail` char(64) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'E_mail',
  `chefe` int(9) DEFAULT NULL COMMENT 'Chefe ou Orientador da pessoa cadastrada',
  PRIMARY KEY (`codigousp`),
  UNIQUE KEY `iupessoa` (`iupessoa`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `e_mail` (`e_mail`),
  KEY `categoria` (`categoria`),
  CONSTRAINT `pessoa_fk` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 322560 kB; (`categoria`) REFER `pessoal/categor';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pessoa`
--

LOCK TABLES `pessoa` WRITE;
/*!40000 ALTER TABLE `pessoa` DISABLE KEYS */;
INSERT INTO `pessoa` VALUES (160,-109,NULL,NULL,'Vitor Leão','M','PGM','USP','FMRP','RGE','HEMATO','',NULL,NULL,'(16) 3315-2223',NULL,'leao_vitorleao@yahoo.com.br',NULL),(159,-108,NULL,NULL,'Vanessa Bonatti','F','PGM','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3315-3153',NULL,'vanessa@rge.fmrp.usp.br',NULL),(158,-107,NULL,NULL,'Tiago Rinaldi Jacob','M','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3315-3078',NULL,'tiagorjacob@usp.br',NULL),(157,-106,NULL,NULL,'Tiago Falcón Lopes','M','PGM','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3315-3153',NULL,'tiagofalconlopes@gmail.com',NULL),(156,-105,NULL,NULL,'Tiago Alves Jorge de Souza','M','PGM','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-3082',NULL,'tiagoajs@yahoo.com.br',NULL),(155,-104,NULL,NULL,'Thaís Arouca Fornari','F','PGD','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3206-3246',NULL,'thaisfornari@rge.fmrp.usp.br',NULL),(154,-103,NULL,NULL,'Sarah Blima Paulino Leite','F','PGM','USP','FMRP','RGE','ER','',NULL,NULL,'(16) 3315-3076',NULL,'sblimapl@yahoo.com.br',NULL),(153,-102,NULL,NULL,'Samantha Vieira Abbad','F','PGM','USP','FMRP','RGE','BMP','',NULL,NULL,'(16) 3315-3852',NULL,'samanthabbad@gmail.com',NULL),(152,-101,NULL,NULL,'Sabrina Pereira Santos','F','PGM','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3315-3050',NULL,'sabrina-ps@hotmail.com',NULL),(151,-100,NULL,NULL,'Rômulo Maciel de Moraes Filho','M','PGD','USP','FMRP','RGE','BMP','',NULL,NULL,'(16) 3315-3103',NULL,'romulommfilho@yahoo.com.br',NULL),(150,-99,NULL,NULL,'Rodrigo Guarischi Mattos Amaral de Sousa','M','PGM','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9362',NULL,'rodrigoguarischi@usp.br',NULL),(149,-98,NULL,NULL,'Ricardo Roberto da Silva','M','PGD','USP','FMRP','RGE','PIB','',NULL,NULL,'(16) 3315-0526',NULL,'rsilvabioinfo@gmail.com',NULL),(148,-97,NULL,NULL,'Renata dos Santos Almeida','F','PGM','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3315-3246',NULL,'r.almeida@usp.br',NULL),(147,-96,NULL,NULL,'Rafael Fransak Ferreira','M','PGD','USP','FMRP','RGE','GE','',NULL,NULL,'(16) 3315-3103',NULL,'fransak@gmail.com',NULL),(146,-95,NULL,NULL,'Priscila Maria Manzini Ramos','F','PGD','USP','FMRP','RGE','COI','',NULL,NULL,'(16) 3315-2651',NULL,'primanzini@yahoo.com.br',NULL),(145,-94,NULL,NULL,'Paulo Roberto D\'auria Vieira de Godoy','M','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-3082',NULL,'paulodauria@usp.br',NULL),(144,-93,NULL,NULL,'Paula Takahashi','F','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-3082',NULL,'takahaship@usp.br',NULL),(143,-92,NULL,NULL,'Pablo Rodrigo Sanches','M','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3315-3224',NULL,'pablo@rge.fmrp.usp.br',NULL),(142,-91,NULL,NULL,'Omar Arvey Martinez Caranton','M','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3315-3153',NULL,'omarapis@yahoo.com.br',NULL),(141,-90,NULL,NULL,'Nilson Nicolau Junior','M','PGD','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3315-4588',NULL,'nilsonnicolaujr@gmail.com',NULL),(140,-89,NULL,NULL,'Niege Silva Mendes','F','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3315-3274',NULL,'niege.mendes@usp.br',NULL),(139,-88,NULL,NULL,'Nathalia Moreno Cury','F','PGM','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'nathaliamcury@gmail.com',NULL),(138,-87,NULL,NULL,'Nathalia Joanne Bispo Cezar','F','PGM','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3315-3246',NULL,'nathaliacezar@usp.br',NULL),(137,-86,NULL,NULL,'Natalia Fagundes Cagnin','F','PGD','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3315-3050',NULL,'nacagnin@yahoo.com.br',NULL),(136,-85,NULL,NULL,'Nadia Carolina de Aguiar Fracasso','F','PGM','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3315-3050',NULL,'nadiadeaguiar@usp.br',NULL),(135,-84,NULL,NULL,'Matheus de Oliveira Bazoni','M','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3315-4578',NULL,'bazonibee@usp.br',NULL),(134,-83,NULL,NULL,'Maria Gabriela Fontanetti Rodrigues','F','PGD','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3315-4588',NULL,'gabrielafontanetti@hotmail.com',NULL),(133,-82,NULL,NULL,'MaÍra Pompeu Martins','F','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3315-3078',NULL,'mairapompeu@hotmail.com',NULL),(132,-81,NULL,NULL,'Luiza Ferreira de Araujo','F','PGM','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'luizafaraujo@usp.br',NULL),(131,-80,NULL,NULL,'Luiz Fernando Martins Pignata','M','PGM','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3315-4588',NULL,'fpignata@gmail.com',NULL),(130,-79,NULL,NULL,'Luís Antonio Alves de Toledo Filho','M','PGM','USP','FMRP','RGE','BMP','',NULL,NULL,'(16) 3315-3852',NULL,'biozebu@yahoo.com.br',NULL),(129,-78,NULL,NULL,'Ludmila Serafim de Abreu','F','PGD','USP','FMRP','RGE','GHM','',NULL,NULL,'(16) 3315-3141',NULL,'ludiserafimabreu@gmail.com',NULL),(128,-77,NULL,NULL,'Lisandra Mesquita Batista','F','PGD','USP','FMRP','RGE','GHM','',NULL,NULL,'(16) 3315-3104',NULL,'limesq@gmail.com',NULL),(127,-76,NULL,NULL,'Liliane Maria Frães de Macedo','F','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3315-3153',NULL,'lilimacedo@usp.br',NULL),(126,-75,NULL,NULL,'Leonardo Rippel Salgado','M','PGD','USP','FMRP','RGE','PIB','',NULL,NULL,'(16) 3315-0526',NULL,'leonardo.rippel@yahoo.com.br',NULL),(125,-74,NULL,NULL,'Leonardo Pereira Franchi','M','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-3082',NULL,'leonardofranchi@yahoo.com.br',NULL),(124,-73,NULL,NULL,'Leonardo Barcelos de Paula','M','PGD','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3315-3758',NULL,'barcelos@usp.br',NULL),(123,-72,NULL,NULL,'Leonardo Arduino Marano','M','PGD','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3315-0417',NULL,'leo.arduinomarano@gmail.com',NULL),(122,-71,NULL,NULL,'Larissa Oliveira Guimarães','F','PGD','USP','FMRP','RGE','ER','',NULL,NULL,'(16) 3315-3076',NULL,'larissaguimaraes@usp.br',NULL),(121,-70,NULL,NULL,'Larissa Gomes da Silva','F','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3315-3078',NULL,'larissa.gomes@usp.br',NULL),(120,-69,NULL,NULL,'LARA MARTINELLI ZAPATA','F','PGM','USP','FMRP','RGE','HEMATO','',NULL,NULL,'(16) 3315-2223',NULL,'lara.mzapata@usp.br',NULL),(119,-68,NULL,NULL,'Julio Cesar Cetrulo Lorenzi','M','PGD','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'julioclorenzi@gmail.com',NULL),(118,-67,NULL,NULL,'Juliana Massimino Feres','F','PGD','USP','FMRP','RGE','CRGF','',NULL,NULL,'(16) 3315-3156',NULL,'julianaferes@gmail.com',NULL),(117,-66,NULL,NULL,'Juliana Dourado Grzesiuk','F','PGM','USP','FMRP','RGE','CMH','',NULL,NULL,'(16) 3315-2341',NULL,'juli_dourado@hotmail.com',NULL),(116,-65,NULL,NULL,'Julia Alejandra Pezuk','F','PGD','USP','FMRP','RGE','COI','',NULL,NULL,'(16) 3315-2651',NULL,'juliapezuk@usp.br',NULL),(115,-64,NULL,NULL,'Josiane Lilian dos Santos Schiavinato','F','PGD','USP','FMRP','RGE','HEMATO','',NULL,NULL,'(16) 3315-2223',NULL,'josililian@gmail.com',NULL),(114,-63,NULL,NULL,'Jaqueline Carvalho de Oliveira','F','PGD','USP','FMRP','RGE','COI','',NULL,NULL,'(16) 3315-2651',NULL,'oliveirajc@usp.br',NULL),(113,-62,NULL,NULL,'Janaina de Andréa Dernowsek','F','PGD','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3315-3246',NULL,'jadernowsek@usp.br',NULL),(112,-61,NULL,NULL,'Iuliana Gregãrio Souza Rodrigues','F','PGM','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3315-4588',NULL,'iusouza@usp.br',NULL),(111,-60,NULL,NULL,'Ildercílio Mota de Souza Lima','M','PGM','USP','FMRP','RGE','HEMATO','',NULL,NULL,'(16) 3315-2223',NULL,'ildercilio_lima@yahoo.com.br',NULL),(110,-59,NULL,NULL,'Igor Médici de Mattos','M','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3315-3153',NULL,'igormmattos@usp.br',NULL),(109,-58,NULL,NULL,'Hélida Regina Magalhães','F','PGD','USP','FMRP','RGE','ER','',NULL,NULL,'(16) 3315-3076',NULL,'hrmagalhaes@usp.br',NULL),(108,-57,NULL,NULL,'Gislaine Angélica Rodrigues Silva','F','PGD','USP','FMRP','RGE','GE','',NULL,NULL,'(16) 3315-3103',NULL,'gisangelica@yahoo.com.br',NULL),(107,-56,NULL,NULL,'Giovana da Silva Leandro','F','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-3082',NULL,'giovanasl@usp.br',NULL),(106,-55,NULL,NULL,'Flávia Sacilotto Donaires','F','PGD','USP','FMRP','RGE','','',NULL,NULL,'(16) 3315-3082',NULL,'flaviadonaires@usp.br',NULL),(105,-54,NULL,NULL,'Flávia Porto Pelá ','F','PGM','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3315-3102',NULL,'flaviaportopela@gmail.com',NULL),(104,-53,NULL,NULL,'Flávia Gaona de Oliveira Gennaro','F','PGD','USP','FMRP','RGE','CMH','',NULL,NULL,'(16) 3315-3076',NULL,'flaviagaona@gmail.com',NULL),(103,-52,NULL,NULL,'Flávia Cristina de Paula Freitas','F','PGD','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3315-3153',NULL,'flaviacpfreitas@usp.br',NULL),(102,-51,NULL,NULL,'Filipe Brum Machado','F','PGD','USP','FMRP','RGE','ER','',NULL,NULL,'(16) 3315-3076',NULL,'filipebma@yahoo.com.br',NULL),(101,-50,NULL,NULL,'Fernanda Paula de Carvalho','F','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-3082',NULL,'fe.carvalho@usp.br',NULL),(100,-49,NULL,NULL,'Fernanda Bueno Barbosa','F','PGM','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3600-3050',NULL,'fbuenobarbosa@gmail.com',NULL),(99,-48,NULL,NULL,'Everton de Brito Oliveira Costa','M','PGM','USP','FMRP','RGE','TG','',NULL,NULL,'(16) 2101-9300',NULL,'evertoncosta_biomedicina@yahoo.com.br',NULL),(98,-47,NULL,NULL,'Elza Akie Sakamoto Lang','F','PPD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3315-3078',NULL,'elzalang@usp.br',NULL),(97,-46,NULL,NULL,'Edward José Strini','M','PGD','USP','FMRP','RGE','BMP','',NULL,NULL,'(16) 3315-3852',NULL,'edstrini@usp.br',NULL),(96,-45,NULL,NULL,'Edilene Santos de Andrade','F','PGD','USP','FMRP','RGE','','',NULL,NULL,'(16) 3315-0417',NULL,'edileneandrade@usp.br',NULL),(95,-44,NULL,NULL,'Dora Yovana Barrios Leal','F','PGM','USP','FMRP','RGE','GE','',NULL,NULL,'(16) 3315-3103',NULL,'genyovana@gmail.com',NULL),(94,-43,NULL,NULL,'Danilo Jordão Xavier','M','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-3082',NULL,'danjordan55@yahoo.com.br',NULL),(93,-42,NULL,NULL,'Daniel Macedo de Melo Jorge','M','PGD','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3315-4588',NULL,'danielmacedo.jorge@gmail.com',NULL),(92,-41,NULL,NULL,'Daniel Antunes Moreno','M','PGD','USP','FMRP','RGE','OGH','',NULL,NULL,'(16) 3315-2651',NULL,'danielmoreno@usp.br',NULL),(91,-40,NULL,NULL,'Daiana Almeida De Souza','F','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3601-4578',NULL,'daianasouz@yahoo.com.br',NULL),(90,-39,NULL,NULL,'Claudia Macedo','F','PPD','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3315-3246',NULL,'macedo@rge.fmrp.usp.br',NULL),(89,-38,NULL,NULL,'Claudia Caixeta Franco Andrade','F','PGD','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3315-3050',NULL,'claudiacfa@yahoo.com.br',NULL),(88,-37,NULL,NULL,'Ciro Silveira e Pereira','M','PGD','USP','FMRP','RGE','CMH','',NULL,NULL,'(16) 3315-3081',NULL,'ciro_bm@yahoo.com.br',NULL),(87,-36,NULL,NULL,'Carolina Arruda de Faria','F','PGD','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'cafaria@usp.br',NULL),(86,-35,NULL,NULL,'Camilla Valente Pires','F','PGD','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3315-3153',NULL,'camisvalente@usp.br',NULL),(85,-34,NULL,NULL,'Bruno Braga Sangiorgi','M','PGM','USP','FMRP','RGE','HEMATO','',NULL,NULL,'(16) 3315-2223',NULL,'brunosangiorgi@gmail.com',NULL),(84,-33,NULL,NULL,'Bruna Rodrigues Muys','F','PGM','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'brunamuys@usp.br',NULL),(83,-32,NULL,NULL,'Bruna Ferreira de Souza','F','PGM','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'b_fs7@hotmail.com',NULL),(82,-31,NULL,NULL,'Beatriz Jeronimo Pinto','F','PGM','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3315-4503',NULL,'biajp@usp.br',NULL),(81,-30,NULL,NULL,'Andressa Gois Morales','F','PGD','USP','FMRP','RGE','COI','',NULL,NULL,'(16) 3315-2651',NULL,'agmorales@usp.br',NULL),(80,-29,NULL,NULL,'André Fernando Ditondo Micas','M','PGD','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3315-3153',NULL,'andre.micas@gmail.com',NULL),(79,-28,NULL,NULL,'Anderson Mioranza','M','PGD','USP','FMRP','RGE','GEMAC','',NULL,NULL,'(16) 3315-4909',NULL,'mioranza@usp.br',NULL),(78,-27,NULL,NULL,'Ana Paula de Lima Montaldi','F','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-3082',NULL,'apmontaldi@yahoo.com.br',NULL),(77,-26,NULL,NULL,'Ana Durvalina Bomtorin','F','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3315-3153',NULL,'ana_durva@rge.fmrp.usp.br',NULL),(76,-25,NULL,NULL,'Aline Simoneti Fonseca','F','PGD','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9607',NULL,'alinesimoneti@usp.br',NULL),(75,-24,NULL,NULL,'Aline Patricia Turcatto','F','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3315-4578',NULL,'alinepatricia@usp.br',NULL),(74,-23,NULL,NULL,'Aline Helena da Silva Cruz','F','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3315-3274',NULL,'alinehelena@usp.br',NULL),(73,-22,NULL,NULL,'Aline Carolina Aleixo Silva','F','PGD','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3315-3153',NULL,'alinea@usp.br',NULL),(72,-21,NULL,NULL,'Alexandre Ferro Aissa','M','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-4186',NULL,'afaissa@gmail.com',NULL),(71,-20,NULL,NULL,'Alexandra Galvão Gomes','F','PGM','USP','FMRP','RGE','CMH','',NULL,NULL,'(16) 3315-3081',NULL,'alexandragalvao@usp.br',NULL),(51,-19,NULL,NULL,'Vera Lucia Cardoso','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(50,-18,NULL,NULL,'Tiago Mauricio Francoy','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(49,-17,NULL,NULL,'Tiago Campos Pereira','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(48,-16,NULL,NULL,'Sérgio Britto Garcia','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(47,-15,NULL,NULL,'Rodrigo Alexandre Panepucci','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(46,-14,NULL,NULL,'Maria Helena de Souza Goldman','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(45,-13,NULL,NULL,'Maria Armênia Ramalho Freitas','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(44,-12,NULL,NULL,'Marcia Maria Gentile Bitondi','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(43,-11,NULL,NULL,'Lusânia Maria Greggi Antunes','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(42,-10,NULL,NULL,'Luiz Gonzaga Tone','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(41,-9,NULL,NULL,'Klaus Hartmann Hartfelder','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(40,-8,NULL,NULL,'Henrique Nunes de Oliveira','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(39,-7,NULL,NULL,'Eduardo Antônio Donadi','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(38,-6,NULL,NULL,'Claudia Cristina Paro de Paz','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(37,-5,NULL,NULL,'Celso Teixeira Mendes Junior','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(36,-4,NULL,NULL,'Aparecida Maria Fontes','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,'aparecidamfontes@usp.br',NULL),(35,-3,NULL,NULL,'Antonio Rossi Filho','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(34,-2,NULL,NULL,'Antonio Claudio Tedesco','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(33,-1,NULL,NULL,'Ana Lilia Alzate Marin','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL,NULL),(1,0,NULL,NULL,'Chefia do Departamento','','DOC','USP','FMRP','RGE','RGE','H','10',NULL,NULL,'3293','secgen@rge.fmrp.usp.br',NULL),(2,35739,NULL,NULL,'Moacyr Antonio Mestriner','M','DOC','USP','FMRP','RGE','GHM','B','23',NULL,NULL,'3156','mestriner@rge.fmrp.usp.br',NULL),(3,49317,NULL,NULL,'Raysildo Barbosa Lôbo','M','DOC','USP','FMRP','RGE','GEMAC','C','7',NULL,NULL,'3135','raysildo@gmail.com',NULL),(4,49467,NULL,NULL,'João Monteiro de Pina Neto','M','DOC','USP','FMRP','RGE','GHM','I','4',NULL,NULL,'3104','jmdpneto@fmrp.usp.br',NULL),(5,54442,NULL,NULL,'David De Jong','M','DOC','USP','FMRP','RGE','RGE','A','15',NULL,NULL,'4401','ddjong@fmrp.usp.br',NULL),(6,56100,NULL,NULL,'Geraldo Aleixo da silva Passos Junior','M','DOC','USP','FORP','MORFO','MORFO','B','9',NULL,NULL,'3030','passos@usp.br',NULL),(7,60554,NULL,NULL,'Ester Silveira Ramos','F','DOC','USP','FMRP','RGE','GHM','C','8',NULL,NULL,'4914','esramos@fmrp.usp.br',NULL),(8,70131,NULL,NULL,'Ademilson Espencer Egea Soares','M','DOC','USP','FMRP','RGE','GHM','A','11',NULL,NULL,'3155','aesoares@fmrp.usp.br',NULL),(9,70253,NULL,NULL,'Aguinaldo Luiz Simões','M','DOC','USP','FMRP','RGE','GHM','B','11',NULL,NULL,'3157','alsimoes@fmrp.usp.br',NULL),(10,75748,NULL,NULL,'Nilce Maria Martinez Rossi','F','DOC','USP','FMRP','RGE','GHM','H','3',NULL,NULL,'3150','nmmrossi@usp.br',NULL),(11,81485,NULL,NULL,'Cacilda Casartelli','F','DOC','USP','FMRP','RGE','RGE','D','1',NULL,NULL,'3152','ccasarte@rge.fmrp.usp.br',NULL),(12,82281,NULL,NULL,'Lucia Regina Martelli','F','DOC','USP','FMRP','RGE','GHM','C','6',NULL,NULL,'3164','lrmartel@fmrp.usp.br',NULL),(13,109134,NULL,NULL,'Fábio de Melo Sene','M','DOC','USP','FFCLRP','BIO','BIO','A','13',NULL,NULL,'3104','melosene@rge.fmrp.usp.br',NULL),(14,177229,NULL,NULL,'Catarina Satie Takahashi','F','DOC','USP','FFCLRP','BIO','BIO','G','9',NULL,NULL,'3761','cstakaha@rge.fmrp.usp.br',NULL),(15,434515,NULL,NULL,'Elza Tiemi Sakamoto Hojo','F','DOC','USP','FFCLRP','BIO','BIO','G','8',NULL,NULL,'3827','etshojo@usp.br',NULL),(16,503770,NULL,NULL,'Lionel Segui Gonçalves','M','DOC','USP','FFCLRP','BIO','BIO','A','12',NULL,NULL,'3154','lsgoncal@rge.fmrp.usp.br',NULL),(17,527513,NULL,NULL,'Zilá Luz Paulino Simões','F','DOC','USP','FFCLRP','BIO','BIO','A','29',NULL,NULL,'4332','zlpsimoe@rge.fmrp.usp.br',NULL),(18,740232,NULL,NULL,'Luiz Antonio Framartino Bezerra','M','DOC','USP','FMRP','RGE','GEMAC','C','13',NULL,NULL,'3135','lafbezer@fmrp.usp.br',NULL),(19,999999,NULL,NULL,'José Fulano','M','FNM','USP','FMRP','RGE','ADM','H','10','Secretaria',NULL,'3132','spaulfb@hotmail.com',NULL),(20,1431879,NULL,NULL,'Pedro Roberto Rodrigues Prado','M','FNS','USP','FMRP','RGE','GHM','A','10',NULL,NULL,'3708','pedro@rge.fmrp.usp.br',NULL),(21,1471547,NULL,NULL,'Maura Helena Manfrin','F','DOC','USP','FMRP','RGE','GHM','A','13',NULL,NULL,'4390','mhmanfri@rge.fmrp.usp.br',NULL),(22,1513550,NULL,NULL,'Paulo Mazzoncini de Azevedo Marques','M','DOC','USP','FMRP','INFBIO','INFBIO','','',NULL,NULL,'0','pmarques@fmrp.usp.br',NULL),(23,1689081,NULL,NULL,'Silvana Giuliatti','F','DOC','USP','FMRP','RGE','GHM','G','11',NULL,NULL,'4503','silvana@fmrp.usp.br',NULL),(24,1913921,NULL,NULL,'Victor Evangelista de Faria Ferraz','M','DOC','USP','FMRP','RGE','GHM','I','7',NULL,'(16) 3315-4500','0069','vferraz@usp.br',NULL),(25,2056632,NULL,NULL,'Wilson Araujo da Silva Junior','M','DOC','USP','FMRP','RGE','RGE','','',NULL,'(016) 2101-9300','9362','wilsonjr@usp.br',NULL),(26,2082952,NULL,NULL,'Jair Licio Ferreira Santos','M','DOC','USP','FMRP','RGE','GHM','','',NULL,NULL,'0','jalifesa@usp.br',NULL),(27,2083320,NULL,NULL,'Eucléia Primo Betioli Contel','F','DOC','USP','FMRP','RGE','GHM','B','2',NULL,NULL,'3151','epbcontel@usp.br',NULL),(28,2369711,NULL,NULL,'Ricardo Zorzetto Nicoliello Vêncio','M','DOC','USP','FMRP','RGE','RGE','F','3',NULL,NULL,'3102','rvencio@rge.fmrp.usp.br',NULL),(29,2416911,'06260562845',NULL,'Sebastião Paulo Framartino Bezerra','M','FNB','USP','FMRP','RGE','GEMAC','C','26',NULL,'(16) 3315-3135','3135','spfbezer@fmrp.usp.br',NULL),(30,2470882,NULL,NULL,'Marli Aparecida Vanni Galerani','F','FNM','USP','FMRP','RGE','GHM','C','14',NULL,NULL,'4912','mvanni@rge.fmrp.usp.br',NULL),(31,2640401,NULL,NULL,'Susie Adriana Ribeiro Penha Nalon','F','FNM','USP','FMRP','RGE','GHM','H','11',NULL,NULL,'3102','susie@rge.fmrp.usp.br',NULL),(163,5096188,NULL,NULL,'Vanessa da Silva Silveira','F','DOC','USP','FMRP','RGE','OH','C','','Laboratório','(16) 3315-9054','9054','vsilveira@fmrp.usp.br',NULL),(162,7933702,NULL,NULL,'Houtan Noushmehr','M','DOC','USP','FMRP','RGE','OMICS','C','30','Laboratório','0526','0526','houtan@usp.br',NULL);
/*!40000 ALTER TABLE `pessoa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pessoa_anterior`
--

DROP TABLE IF EXISTS `pessoa_anterior`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pessoa_anterior` (
  `iupessoa` int(11) NOT NULL DEFAULT '0' COMMENT 'IdentificaÃ§Ã£o Ãºnica da pessoa',
  `codigousp` int(9) NOT NULL COMMENT 'Codigo USP - Matricula',
  `cpf` char(11) DEFAULT NULL COMMENT 'CPF da pessoa',
  `passaporte` char(16) DEFAULT NULL COMMENT 'CÃ³digo do Passaporte da Pessoa',
  `nome` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nome da Pessoa',
  `sexo` char(1) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Sexo (M,F)',
  `categoria` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Categoria Funcional',
  `instituicao` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'InstituiÃ§Ã£o',
  `unidade` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Unidade',
  `depto` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Departamento',
  `setor` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Setor',
  `bloco` char(8) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Bloco do Departamento',
  `sala` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Sala',
  `salatipo` char(32) DEFAULT NULL COMMENT 'Tipo da Sala (EscritÃ³rio=Sala Docente, LaboratÃ³rio, Anfiteatro, Sala de Aula, etc)\r\n',
  `fone` varchar(20) DEFAULT NULL COMMENT 'Telefone local ou externo',
  `ramal` int(4) DEFAULT NULL COMMENT 'Ramal',
  `e_mail` char(64) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'E_mail'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pessoa_anterior`
--

LOCK TABLES `pessoa_anterior` WRITE;
/*!40000 ALTER TABLE `pessoa_anterior` DISABLE KEYS */;
INSERT INTO `pessoa_anterior` VALUES (161,-110,'','','Chico Bento','M','OUT','','','','','','','','',0,'spaulfb@hotmail.com'),(160,-109,NULL,NULL,'Vitor Leão','M','PGM','USP','FMRP','RGE','HEMATO','',NULL,NULL,'(16) 3602-2223',NULL,'leao_vitorleao@yahoo.com.br'),(159,-108,NULL,NULL,'Vanessa Bonatti','F','PGM','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3602-3153',NULL,'vanessa@rge.fmrp.usp.br'),(158,-107,NULL,NULL,'Tiago Rinaldi Jacob','M','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3602-3078',NULL,'tiagorjacob@usp.br'),(157,-106,NULL,NULL,'Tiago Falcón Lopes','M','PGM','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3602-3153',NULL,'tiagofalconlopes@gmail.com'),(156,-105,NULL,NULL,'Tiago Alves Jorge de Souza','M','PGM','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3602-3082',NULL,'tiagoajs@yahoo.com.br'),(155,-104,NULL,NULL,'Thaís Arouca Fornari','F','PGD','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3206-3246',NULL,'thaisfornari@rge.fmrp.usp.br'),(154,-103,NULL,NULL,'Sarah Blima Paulino Leite','F','PGM','USP','FMRP','RGE','ER','',NULL,NULL,'(16) 3602-3076',NULL,'sblimapl@yahoo.com.br'),(153,-102,NULL,NULL,'Samantha Vieira Abbad','F','PGM','USP','FMRP','RGE','BMP','',NULL,NULL,'(16) 3602-3852',NULL,'samanthabbad@gmail.com'),(152,-101,NULL,NULL,'Sabrina Pereira Santos','F','PGM','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3602-3050',NULL,'sabrina-ps@hotmail.com'),(151,-100,NULL,NULL,'Rômulo Maciel de Moraes Filho','M','PGD','USP','FMRP','RGE','BMP','',NULL,NULL,'(16) 3602-3103',NULL,'romulommfilho@yahoo.com.br'),(150,-99,NULL,NULL,'Rodrigo Guarischi Mattos Amaral de Sousa','M','PGM','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9362',NULL,'rodrigoguarischi@usp.br'),(149,-98,NULL,NULL,'Ricardo Roberto da Silva','M','PGD','USP','FMRP','RGE','PIB','',NULL,NULL,'(16) 3602-0526',NULL,'rsilvabioinfo@gmail.com'),(148,-97,NULL,NULL,'Renata dos Santos Almeida','F','PGM','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3602-3246',NULL,'r.almeida@usp.br'),(147,-96,NULL,NULL,'Rafael Fransak Ferreira','M','PGD','USP','FMRP','RGE','GE','',NULL,NULL,'(16) 3602-3103',NULL,'fransak@gmail.com'),(146,-95,NULL,NULL,'Priscila Maria Manzini Ramos','F','PGD','USP','FMRP','RGE','COI','',NULL,NULL,'(16) 36022651',NULL,'primanzini@yahoo.com.br'),(145,-94,NULL,NULL,'Paulo Roberto D\'auria Vieira de Godoy','M','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3602-3082',NULL,'paulodauria@usp.br'),(144,-93,NULL,NULL,'Paula Takahashi','F','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3602-3082',NULL,'takahaship@usp.br'),(143,-92,NULL,NULL,'Pablo Rodrigo Sanches','M','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3602-3224',NULL,'pablo@rge.fmrp.usp.br'),(142,-91,NULL,NULL,'Omar Arvey Martinez Caranton','M','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3602-3153',NULL,'omarapis@yahoo.com.br'),(141,-90,NULL,NULL,'Nilson Nicolau Junior','M','PGD','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3602-4588',NULL,'nilsonnicolaujr@gmail.com'),(140,-89,NULL,NULL,'Niege Silva Mendes','F','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16)36023274',NULL,'niege.mendes@usp.br'),(139,-88,NULL,NULL,'Nathalia Moreno Cury','F','PGM','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'nathaliamcury@gmail.com'),(138,-87,NULL,NULL,'Nathalia Joanne Bispo Cezar','F','PGM','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3602-3246',NULL,'nathaliacezar@usp.br'),(137,-86,NULL,NULL,'Natalia Fagundes Cagnin','F','PGD','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3602-3050',NULL,'nacagnin@yahoo.com.br'),(136,-85,NULL,NULL,'Nadia Carolina de Aguiar Fracasso','F','PGM','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3602-3050',NULL,'nadiadeaguiar@usp.br'),(135,-84,NULL,NULL,'Matheus de Oliveira Bazoni','M','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3602-4578',NULL,'bazonibee@usp.br'),(134,-83,NULL,NULL,'Maria Gabriela Fontanetti Rodrigues','F','PGD','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3602-4588',NULL,'gabrielafontanetti@hotmail.com'),(133,-82,NULL,NULL,'MaÍra Pompeu Martins','F','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3602-3078',NULL,'mairapompeu@hotmail.com'),(132,-81,NULL,NULL,'Luiza Ferreira de Araujo','F','PGM','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'luizafaraujo@usp.br'),(131,-80,NULL,NULL,'Luiz Fernando Martins Pignata','M','PGM','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3602-4588',NULL,'fpignata@gmail.com'),(130,-79,NULL,NULL,'Luís Antonio Alves de Toledo Filho','M','PGM','USP','FMRP','RGE','BMP','',NULL,NULL,'(16) 3602-3852',NULL,'biozebu@yahoo.com.br'),(129,-78,NULL,NULL,'Ludmila Serafim de Abreu','F','PGD','USP','FMRP','RGE','GHM','',NULL,NULL,'(16) 3602-3141',NULL,'ludiserafimabreu@gmail.com'),(128,-77,NULL,NULL,'Lisandra Mesquita Batista','F','PGD','USP','FMRP','RGE','GHM','',NULL,NULL,'(16) 3602-3104',NULL,'limesq@gmail.com'),(127,-76,NULL,NULL,'Liliane Maria Frães de Macedo','F','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3602-3153',NULL,'lilimacedo@usp.br'),(126,-75,NULL,NULL,'Leonardo Rippel Salgado','M','PGD','USP','FMRP','RGE','PIB','',NULL,NULL,'(16) 3602-0526',NULL,'leonardo.rippel@yahoo.com.br'),(125,-74,NULL,NULL,'Leonardo Pereira Franchi','M','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3602-3082',NULL,'leonardofranchi@yahoo.com.br'),(124,-73,NULL,NULL,'Leonardo Barcelos de Paula','M','PGD','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3602-3758',NULL,'barcelos@usp.br'),(123,-72,NULL,NULL,'Leonardo Arduino Marano','M','PGD','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3602-0417',NULL,'leo.arduinomarano@gmail.com'),(122,-71,NULL,NULL,'Larissa Oliveira Guimarães','F','PGD','USP','FMRP','RGE','ER','',NULL,NULL,'(16) 3602-3076',NULL,'larissaguimaraes@usp.br'),(121,-70,NULL,NULL,'Larissa Gomes da Silva','F','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3602-3078',NULL,'larissa.gomes@usp.br'),(120,-69,NULL,NULL,'LARA MARTINELLI ZAPATA','F','PGM','USP','FMRP','RGE','HEMATO','',NULL,NULL,'(16) 3602-2223',NULL,'lara.mzapata@usp.br'),(119,-68,NULL,NULL,'Julio Cesar Cetrulo Lorenzi','M','PGD','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'julioclorenzi@gmail.com'),(118,-67,NULL,NULL,'Juliana Massimino Feres','F','PGD','USP','FMRP','RGE','CRGF','',NULL,NULL,'(16) 3602-3156',NULL,'julianaferes@gmail.com'),(117,-66,NULL,NULL,'Juliana Dourado Grzesiuk','F','PGM','USP','FMRP','RGE','CMH','',NULL,NULL,'(16) 3602-2341',NULL,'juli_dourado@hotmail.com'),(116,-65,NULL,NULL,'Julia Alejandra Pezuk','F','PGD','USP','FMRP','RGE','COI','',NULL,NULL,'(16) 3602-2651',NULL,'juliapezuk@usp.br'),(115,-64,NULL,NULL,'Josiane Lilian dos Santos Schiavinato','F','PGD','USP','FMRP','RGE','HEMATO','',NULL,NULL,'(16) 3602-2223',NULL,'josililian@gmail.com'),(114,-63,NULL,NULL,'Jaqueline Carvalho de Oliveira','F','PGD','USP','FMRP','RGE','COI','',NULL,NULL,'(16) 3602-2651',NULL,'oliveirajc@usp.br'),(113,-62,NULL,NULL,'Janaina de Andréa Dernowsek','F','PGD','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3602-3246',NULL,'jadernowsek@usp.br'),(112,-61,NULL,NULL,'Iuliana Gregãrio Souza Rodrigues','F','PGM','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3602-4588',NULL,'iusouza@usp.br'),(111,-60,NULL,NULL,'Ildercílio Mota de Souza Lima','M','PGM','USP','FMRP','RGE','HEMATO','',NULL,NULL,'(16) 3602-2223',NULL,'ildercilio_lima@yahoo.com.br'),(110,-59,NULL,NULL,'Igor Médici de Mattos','M','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3602-3153',NULL,'igormmattos@usp.br'),(109,-58,NULL,NULL,'Hélida Regina Magalhães','F','PGD','USP','FMRP','RGE','ER','',NULL,NULL,'(16) 3602-3076',NULL,'hrmagalhaes@usp.br'),(108,-57,NULL,NULL,'Gislaine Angélica Rodrigues Silva','F','PGD','USP','FMRP','RGE','GE','',NULL,NULL,'(16) 3602-3103',NULL,'gisangelica@yahoo.com.br'),(107,-56,NULL,NULL,'Giovana da Silva Leandro','F','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3602-3082',NULL,'giovanasl@usp.br'),(106,-55,NULL,NULL,'Flávia Sacilotto Donaires','F','PGD','USP','FMRP','RGE','','',NULL,NULL,'(16) 3602-3082',NULL,'flaviadonaires@usp.br'),(105,-54,NULL,NULL,'Flávia Porto Pelá ','F','PGM','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3602-3102',NULL,'flaviaportopela@gmail.com'),(104,-53,NULL,NULL,'Flávia Gaona de Oliveira Gennaro','F','PGD','USP','FMRP','RGE','CMH','',NULL,NULL,'(16) 3602 3076',NULL,'flaviagaona@gmail.com'),(103,-52,NULL,NULL,'Flávia Cristina de Paula Freitas','F','PGD','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3602-3153',NULL,'flaviacpfreitas@usp.br'),(102,-51,NULL,NULL,'Filipe Brum Machado','F','PGD','USP','FMRP','RGE','ER','',NULL,NULL,'(16) 3602-3076',NULL,'filipebma@yahoo.com.br'),(101,-50,NULL,NULL,'Fernanda Paula de Carvalho','F','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3602-3082',NULL,'fe.carvalho@usp.br'),(100,-49,NULL,NULL,'Fernanda Bueno Barbosa','F','PGM','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3600-3050',NULL,'fbuenobarbosa@gmail.com'),(99,-48,NULL,NULL,'Everton de Brito Oliveira Costa','M','PGM','USP','FMRP','RGE','TG','',NULL,NULL,'(16) 2101 9300',NULL,'evertoncosta_biomedicina@yahoo.com.br'),(98,-47,NULL,NULL,'Elza Akie Sakamoto Lang','F','PPD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3602-3078',NULL,'elzalang@usp.br'),(97,-46,NULL,NULL,'Edward José Strini','M','PGD','USP','FMRP','RGE','BMP','',NULL,NULL,'(16) 3602-3852',NULL,'edstrini@usp.br'),(96,-45,NULL,NULL,'Edilene Santos de Andrade','F','PGD','USP','FMRP','RGE','','',NULL,NULL,'(16) 3602-0417',NULL,'edileneandrade@usp.br'),(95,-44,NULL,NULL,'Dora Yovana Barrios Leal','F','PGM','USP','FMRP','RGE','GE','',NULL,NULL,'(16) 3602-3103',NULL,'genyovana@gmail.com'),(94,-43,NULL,NULL,'Danilo Jordão Xavier','M','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3602-3082',NULL,'danjordan55@yahoo.com.br'),(93,-42,NULL,NULL,'Daniel Macedo de Melo Jorge','M','PGD','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3602-4588',NULL,'danielmacedo.jorge@gmail.com'),(92,-41,NULL,NULL,'Daniel Antunes Moreno','M','PGD','USP','FMRP','RGE','OGH','',NULL,NULL,'(16) 3602-2651',NULL,'danielmoreno@usp.br'),(91,-40,NULL,NULL,'Daiana Almeida De Souza','F','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3601-4578',NULL,'daianasouz@yahoo.com.br'),(90,-39,NULL,NULL,'Claudia Macedo','F','PPD','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3602-3246',NULL,'macedo@rge.fmrp.usp.br'),(89,-38,NULL,NULL,'Claudia Caixeta Franco Andrade','F','PGD','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3602-3050',NULL,'claudiacfa@yahoo.com.br'),(88,-37,NULL,NULL,'Ciro Silveira e Pereira','M','PGD','USP','FMRP','RGE','CMH','',NULL,NULL,'(16) 3602-3081',NULL,'ciro_bm@yahoo.com.br'),(87,-36,NULL,NULL,'Carolina Arruda de Faria','F','PGD','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'cafaria@usp.br'),(86,-35,NULL,NULL,'Camilla Valente Pires','F','PGD','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3602-3153',NULL,'camisvalente@usp.br'),(85,-34,NULL,NULL,'Bruno Braga Sangiorgi','M','PGM','USP','FMRP','RGE','HEMATO','',NULL,NULL,'(16) 3602-2223',NULL,'brunosangiorgi@gmail.com'),(84,-33,NULL,NULL,'Bruna Rodrigues Muys','F','PGM','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'brunamuys@usp.br'),(83,-32,NULL,NULL,'Bruna Ferreira de Souza','F','PGM','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101 9368',NULL,'b_fs7@hotmail.com'),(82,-31,NULL,NULL,'Beatriz Jeronimo Pinto','F','PGM','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3602-4503',NULL,'biajp@usp.br'),(81,-30,NULL,NULL,'Andressa Gois Morales','F','PGD','USP','FMRP','RGE','COI','',NULL,NULL,'(16) 3602-2651',NULL,'agmorales@usp.br'),(80,-29,NULL,NULL,'André Fernando Ditondo Micas','M','PGD','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3602-3153',NULL,'andre.micas@gmail.com'),(79,-28,NULL,NULL,'Anderson Mioranza','M','PGD','USP','FMRP','RGE','GEMAC','',NULL,NULL,'(16) 3602-4909',NULL,'mioranza@usp.br'),(78,-27,NULL,NULL,'Ana Paula de Lima Montaldi','F','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3602-3082',NULL,'apmontaldi@yahoo.com.br'),(77,-26,NULL,NULL,'Ana Durvalina Bomtorin','F','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3602-3153',NULL,'ana_durva@rge.fmrp.usp.br'),(76,-25,NULL,NULL,'Aline Simoneti Fonseca','F','PGD','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9607',NULL,'alinesimoneti@usp.br'),(75,-24,NULL,NULL,'Aline Patricia Turcatto','F','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3602-4578',NULL,'alinepatricia@usp.br'),(74,-23,NULL,NULL,'Aline Helena da Silva Cruz','F','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3602-3274',NULL,'alinehelena@usp.br'),(73,-22,NULL,NULL,'Aline Carolina Aleixo Silva','F','PGD','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3602-3153',NULL,'alinea@usp.br'),(72,-21,NULL,NULL,'Alexandre Ferro Aissa','M','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3602-4186',NULL,'afaissa@gmail.com'),(71,-20,NULL,NULL,'Alexandra Galvão Gomes','F','PGM','USP','FMRP','RGE','CMH','',NULL,NULL,'(16) 3602-3081',NULL,'alexandragalvao@usp.br'),(51,-19,NULL,NULL,'Vera Lucia Cardoso','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(50,-18,NULL,NULL,'Tiago Mauricio Francoy','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(49,-17,NULL,NULL,'Tiago Campos Pereira','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(48,-16,NULL,NULL,'Sérgio Britto Garcia','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(47,-15,NULL,NULL,'Rodrigo Alexandre Panepucci','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(46,-14,NULL,NULL,'Maria Helena de Souza Goldman','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(45,-13,NULL,NULL,'Maria Armênia Ramalho Freitas','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(44,-12,NULL,NULL,'Marcia Maria Gentile Bitondi','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(43,-11,NULL,NULL,'Lusânia Maria Greggi Antunes','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(42,-10,NULL,NULL,'Luiz Gonzaga Tone','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(41,-9,NULL,NULL,'Klaus Hartmann Hartfelder','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(40,-8,NULL,NULL,'Henrique Nunes de Oliveira','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(39,-7,NULL,NULL,'Eduardo Antônio Donadi','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(38,-6,NULL,NULL,'Claudia Cristina Paro de Paz','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(37,-5,NULL,NULL,'Celso Teixeira Mendes Junior','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(36,-4,NULL,NULL,'Aparecida Maria Fontes','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(35,-3,NULL,NULL,'Antonio Rossi Filho','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(34,-2,NULL,NULL,'Antonio Claudio Tedesco','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(33,-1,NULL,NULL,'Ana Lilia Alzate Marin','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(1,0,NULL,NULL,'Chefia do Departamento','','DOC','USP','FMRP','RGE','RGE','H','10',NULL,NULL,3293,'secgen@rge.fmrp.usp.br'),(2,35739,NULL,NULL,'Moacyr Antonio Mestriner','M','DOC','USP','FMRP','RGE','GHM','B','23',NULL,NULL,3156,'mestriner@rge.fmrp.usp.br'),(3,49317,NULL,NULL,'Raysildo Barbosa Lôbo','M','DOC','USP','FMRP','RGE','GEMAC','C','7',NULL,NULL,3135,'raysildo@fmrp.usp.br'),(4,49467,NULL,NULL,'João Monteiro de Pina Neto','M','DOC','USP','FMRP','RGE','GHM','I','4',NULL,NULL,3104,'jmdpneto@fmrp.usp.br'),(5,54442,NULL,NULL,'David De Jong','M','DOC','USP','FMRP','RGE','RGE','A','15',NULL,NULL,4401,'ddjong@rge.fmrp.usp.br'),(6,56100,NULL,NULL,'Geraldo Aleixo da silva Passos Junior','M','DOC','USP','FORP','MORFO','MORFO','B','9',NULL,NULL,3030,'passos@rge.fmrp.usp.br'),(7,60554,NULL,NULL,'Ester Silveira Ramos','F','DOC','USP','FMRP','RGE','GHM','C','8',NULL,NULL,4914,'esramos@genbov.fmrp.usp.br'),(8,70131,NULL,NULL,'Ademilson Espencer Egea Soares','M','DOC','USP','FMRP','RGE','GHM','A','11',NULL,NULL,3155,'espencer@rge.fmrp.usp.br'),(9,70253,NULL,NULL,'Aguinaldo Luiz Simões','M','DOC','USP','FMRP','RGE','GHM','B','11',NULL,NULL,3157,'alsimoes@rge.fmrp.usp.br'),(10,75748,NULL,NULL,'Nilce Maria Martinez Rossi','F','DOC','USP','FMRP','RGE','GHM','H','3',NULL,NULL,3150,'nmmrossi@rge.fmrp.usp.br'),(11,81485,NULL,NULL,'Cacilda Casartelli','F','DOC','USP','FMRP','RGE','RGE','D','1',NULL,NULL,3152,'ccasarte@rge.fmrp.usp.br'),(12,82281,NULL,NULL,'Lucia Regina Martelli','F','DOC','USP','FMRP','RGE','GHM','C','6',NULL,NULL,3164,'lrmartel@rge.fmrp.usp.br'),(13,109134,NULL,NULL,'Fábio de Melo Sene','M','DOC','USP','FFCLRP','BIO','BIO','A','13',NULL,NULL,3104,'melosene@rge.fmrp.usp.br'),(14,177229,NULL,NULL,'Catarina Satie Takahashi','F','DOC','USP','FFCLRP','BIO','BIO','G','9',NULL,NULL,3761,'cstakaha@rge.fmrp.usp.br'),(15,434515,NULL,NULL,'Elza Tiemi Sakamoto Hojo','F','DOC','USP','FFCLRP','BIO','BIO','G','8',NULL,NULL,3827,'etshojo@usp.br'),(16,503770,NULL,NULL,'Lionel Segui Gonçalves','M','DOC','USP','FFCLRP','BIO','BIO','A','12',NULL,NULL,3154,'lsgoncal@rge.fmrp.usp.br'),(17,527513,NULL,NULL,'Zilá Luz Paulino Simões','F','DOC','USP','FFCLRP','BIO','BIO','A','29',NULL,NULL,4332,'zlpsimoe@rge.fmrp.usp.br'),(18,740232,NULL,NULL,'Luiz Antonio Framartino Bezerra','M','DOC','USP','FMRP','RGE','GEMAC','C','13',NULL,NULL,3135,'lafbezer@fmrp.usp.br'),(19,999999,NULL,NULL,'José Fulano','','FNM','USP','FMRP','RGE','ADM','H','10','Secretaria',NULL,3132,'era_spaulfb#hotmail'),(20,1431879,NULL,NULL,'Pedro Roberto Rodrigues Prado','M','FNS','USP','FMRP','RGE','GHM','A','10',NULL,NULL,3708,'pedro@rge.fmrp.usp.br'),(21,1471547,NULL,NULL,'Maura Helena Manfrin','F','DOC','USP','FMRP','RGE','GHM','A','13',NULL,NULL,4390,'mhmanfri@rge.fmrp.usp.br'),(22,1513550,NULL,NULL,'Paulo Mazzoncini de Azevedo Marques','M','DOC','USP','FMRP','INFBIO','INFBIO','','',NULL,NULL,0,'pmarques@fmrp.usp.br'),(23,1689081,NULL,NULL,'Silvana Giuliatti','F','DOC','USP','FMRP','RGE','GHM','G','11',NULL,NULL,4503,'silvana@rge.fmrp.usp.br'),(24,1913921,NULL,NULL,'Victor Evangelista de Faria Ferraz','M','DOC','USP','FMRP','RGE','GHM','I','7',NULL,NULL,4500,'vferraz@rge.fmrp.usp.br'),(25,2056632,NULL,NULL,'Wilson Araujo da Silva Junior','M','DOC','USP','FMRP','RGE','RGE','','',NULL,NULL,0,'wilsonjr@rge.fmrp.usp.br'),(26,2082952,NULL,NULL,'Jair Licio Ferreira Santos','M','DOC','USP','FMRP','RGE','GHM','','',NULL,NULL,0,'jalifesa@usp.br'),(27,2083320,NULL,NULL,'Eucléia Primo Betioli Contel','F','DOC','USP','FMRP','RGE','GHM','B','2',NULL,NULL,3151,'epbconte@rge.fmrp.usp.br'),(28,2369711,NULL,NULL,'Ricardo Zorzetto Nicoliello Vêncio','M','DOC','USP','FMRP','RGE','RGE','F','3',NULL,NULL,3102,'rvencio@rge.fmrp.usp.br'),(29,2416911,'06260562845',NULL,'Sebastião Paulo Framartino Bezerra','M','FNB','USP','FMRP','RGE','GEMAC','C','26',NULL,'(16) 3602-3135',3135,'spfbezer@fmrp.usp.br'),(30,2470882,NULL,NULL,'Marli Aparecida Vanni Galerani','F','FNM','USP','FMRP','RGE','GHM','C','14',NULL,NULL,4912,'mvanni@rge.fmrp.usp.br'),(31,2640401,NULL,NULL,'Susie Adriana Ribeiro Penha Nalon','F','FNM','USP','FMRP','RGE','GHM','H','11',NULL,NULL,3102,'susie@rge.fmrp.usp.br');
/*!40000 ALTER TABLE `pessoa_anterior` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pessoa_copia`
--

DROP TABLE IF EXISTS `pessoa_copia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pessoa_copia` (
  `iupessoa` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica da pessoa',
  `codigousp` int(9) NOT NULL COMMENT 'Codigo USP - Matricula',
  `cpf` char(11) DEFAULT NULL COMMENT 'CPF da pessoa',
  `passaporte` char(16) DEFAULT NULL COMMENT 'CÃ³digo do Passaporte da Pessoa',
  `nome` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nome da Pessoa',
  `sexo` char(1) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Sexo (M,F)',
  `categoria` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Categoria Funcional',
  `instituicao` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'InstituiÃ§Ã£o',
  `unidade` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Unidade',
  `depto` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Departamento',
  `setor` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Setor',
  `bloco` char(8) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Bloco do Departamento',
  `sala` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Sala',
  `salatipo` char(32) DEFAULT NULL COMMENT 'Tipo da Sala (EscritÃ³rio=Sala Docente, LaboratÃ³rio, Anfiteatro, Sala de Aula, etc)\r\n',
  `fone` char(20) DEFAULT NULL,
  `ramal` char(4) DEFAULT NULL,
  `e_mail` char(64) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'E_mail',
  PRIMARY KEY (`codigousp`),
  UNIQUE KEY `iupessoa` (`iupessoa`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `e_mail` (`e_mail`),
  KEY `categoria` (`categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 322560 kB; (`categoria`) REFER `pessoal/categor';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pessoa_copia`
--

LOCK TABLES `pessoa_copia` WRITE;
/*!40000 ALTER TABLE `pessoa_copia` DISABLE KEYS */;
INSERT INTO `pessoa_copia` VALUES (160,-109,NULL,NULL,'Vitor Leão','M','PGM','USP','FMRP','RGE','HEMATO','',NULL,NULL,'(16) 3315-2223',NULL,'leao_vitorleao@yahoo.com.br'),(159,-108,NULL,NULL,'Vanessa Bonatti','F','PGM','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3315-3153',NULL,'vanessa@rge.fmrp.usp.br'),(158,-107,NULL,NULL,'Tiago Rinaldi Jacob','M','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3315-3078',NULL,'tiagorjacob@usp.br'),(157,-106,NULL,NULL,'Tiago Falcón Lopes','M','PGM','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3315-3153',NULL,'tiagofalconlopes@gmail.com'),(156,-105,NULL,NULL,'Tiago Alves Jorge de Souza','M','PGM','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-3082',NULL,'tiagoajs@yahoo.com.br'),(155,-104,NULL,NULL,'Thaís Arouca Fornari','F','PGD','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3206-3246',NULL,'thaisfornari@rge.fmrp.usp.br'),(154,-103,NULL,NULL,'Sarah Blima Paulino Leite','F','PGM','USP','FMRP','RGE','ER','',NULL,NULL,'(16) 3315-3076',NULL,'sblimapl@yahoo.com.br'),(153,-102,NULL,NULL,'Samantha Vieira Abbad','F','PGM','USP','FMRP','RGE','BMP','',NULL,NULL,'(16) 3315-3852',NULL,'samanthabbad@gmail.com'),(152,-101,NULL,NULL,'Sabrina Pereira Santos','F','PGM','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3315-3050',NULL,'sabrina-ps@hotmail.com'),(151,-100,NULL,NULL,'Rômulo Maciel de Moraes Filho','M','PGD','USP','FMRP','RGE','BMP','',NULL,NULL,'(16) 3315-3103',NULL,'romulommfilho@yahoo.com.br'),(150,-99,NULL,NULL,'Rodrigo Guarischi Mattos Amaral de Sousa','M','PGM','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9362',NULL,'rodrigoguarischi@usp.br'),(149,-98,NULL,NULL,'Ricardo Roberto da Silva','M','PGD','USP','FMRP','RGE','PIB','',NULL,NULL,'(16) 3315-0526',NULL,'rsilvabioinfo@gmail.com'),(148,-97,NULL,NULL,'Renata dos Santos Almeida','F','PGM','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3315-3246',NULL,'r.almeida@usp.br'),(147,-96,NULL,NULL,'Rafael Fransak Ferreira','M','PGD','USP','FMRP','RGE','GE','',NULL,NULL,'(16) 3315-3103',NULL,'fransak@gmail.com'),(146,-95,NULL,NULL,'Priscila Maria Manzini Ramos','F','PGD','USP','FMRP','RGE','COI','',NULL,NULL,'(16) 3315-2651',NULL,'primanzini@yahoo.com.br'),(145,-94,NULL,NULL,'Paulo Roberto D\'auria Vieira de Godoy','M','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-3082',NULL,'paulodauria@usp.br'),(144,-93,NULL,NULL,'Paula Takahashi','F','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-3082',NULL,'takahaship@usp.br'),(143,-92,NULL,NULL,'Pablo Rodrigo Sanches','M','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3315-3224',NULL,'pablo@rge.fmrp.usp.br'),(142,-91,NULL,NULL,'Omar Arvey Martinez Caranton','M','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3315-3153',NULL,'omarapis@yahoo.com.br'),(141,-90,NULL,NULL,'Nilson Nicolau Junior','M','PGD','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3315-4588',NULL,'nilsonnicolaujr@gmail.com'),(140,-89,NULL,NULL,'Niege Silva Mendes','F','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3315-3274',NULL,'niege.mendes@usp.br'),(139,-88,NULL,NULL,'Nathalia Moreno Cury','F','PGM','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'nathaliamcury@gmail.com'),(138,-87,NULL,NULL,'Nathalia Joanne Bispo Cezar','F','PGM','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3315-3246',NULL,'nathaliacezar@usp.br'),(137,-86,NULL,NULL,'Natalia Fagundes Cagnin','F','PGD','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3315-3050',NULL,'nacagnin@yahoo.com.br'),(136,-85,NULL,NULL,'Nadia Carolina de Aguiar Fracasso','F','PGM','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3315-3050',NULL,'nadiadeaguiar@usp.br'),(135,-84,NULL,NULL,'Matheus de Oliveira Bazoni','M','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3315-4578',NULL,'bazonibee@usp.br'),(134,-83,NULL,NULL,'Maria Gabriela Fontanetti Rodrigues','F','PGD','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3315-4588',NULL,'gabrielafontanetti@hotmail.com'),(133,-82,NULL,NULL,'MaÍra Pompeu Martins','F','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3315-3078',NULL,'mairapompeu@hotmail.com'),(132,-81,NULL,NULL,'Luiza Ferreira de Araujo','F','PGM','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'luizafaraujo@usp.br'),(131,-80,NULL,NULL,'Luiz Fernando Martins Pignata','M','PGM','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3315-4588',NULL,'fpignata@gmail.com'),(130,-79,NULL,NULL,'Luís Antonio Alves de Toledo Filho','M','PGM','USP','FMRP','RGE','BMP','',NULL,NULL,'(16) 3315-3852',NULL,'biozebu@yahoo.com.br'),(129,-78,NULL,NULL,'Ludmila Serafim de Abreu','F','PGD','USP','FMRP','RGE','GHM','',NULL,NULL,'(16) 3315-3141',NULL,'ludiserafimabreu@gmail.com'),(128,-77,NULL,NULL,'Lisandra Mesquita Batista','F','PGD','USP','FMRP','RGE','GHM','',NULL,NULL,'(16) 3315-3104',NULL,'limesq@gmail.com'),(127,-76,NULL,NULL,'Liliane Maria Frães de Macedo','F','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3315-3153',NULL,'lilimacedo@usp.br'),(126,-75,NULL,NULL,'Leonardo Rippel Salgado','M','PGD','USP','FMRP','RGE','PIB','',NULL,NULL,'(16) 3315-0526',NULL,'leonardo.rippel@yahoo.com.br'),(125,-74,NULL,NULL,'Leonardo Pereira Franchi','M','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-3082',NULL,'leonardofranchi@yahoo.com.br'),(124,-73,NULL,NULL,'Leonardo Barcelos de Paula','M','PGD','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3315-3758',NULL,'barcelos@usp.br'),(123,-72,NULL,NULL,'Leonardo Arduino Marano','M','PGD','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3315-0417',NULL,'leo.arduinomarano@gmail.com'),(122,-71,NULL,NULL,'Larissa Oliveira Guimarães','F','PGD','USP','FMRP','RGE','ER','',NULL,NULL,'(16) 3315-3076',NULL,'larissaguimaraes@usp.br'),(121,-70,NULL,NULL,'Larissa Gomes da Silva','F','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3315-3078',NULL,'larissa.gomes@usp.br'),(120,-69,NULL,NULL,'LARA MARTINELLI ZAPATA','F','PGM','USP','FMRP','RGE','HEMATO','',NULL,NULL,'(16) 3315-2223',NULL,'lara.mzapata@usp.br'),(119,-68,NULL,NULL,'Julio Cesar Cetrulo Lorenzi','M','PGD','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'julioclorenzi@gmail.com'),(118,-67,NULL,NULL,'Juliana Massimino Feres','F','PGD','USP','FMRP','RGE','CRGF','',NULL,NULL,'(16) 3315-3156',NULL,'julianaferes@gmail.com'),(117,-66,NULL,NULL,'Juliana Dourado Grzesiuk','F','PGM','USP','FMRP','RGE','CMH','',NULL,NULL,'(16) 3315-2341',NULL,'juli_dourado@hotmail.com'),(116,-65,NULL,NULL,'Julia Alejandra Pezuk','F','PGD','USP','FMRP','RGE','COI','',NULL,NULL,'(16) 3315-2651',NULL,'juliapezuk@usp.br'),(115,-64,NULL,NULL,'Josiane Lilian dos Santos Schiavinato','F','PGD','USP','FMRP','RGE','HEMATO','',NULL,NULL,'(16) 3315-2223',NULL,'josililian@gmail.com'),(114,-63,NULL,NULL,'Jaqueline Carvalho de Oliveira','F','PGD','USP','FMRP','RGE','COI','',NULL,NULL,'(16) 3315-2651',NULL,'oliveirajc@usp.br'),(113,-62,NULL,NULL,'Janaina de Andréa Dernowsek','F','PGD','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3315-3246',NULL,'jadernowsek@usp.br'),(112,-61,NULL,NULL,'Iuliana Gregãrio Souza Rodrigues','F','PGM','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3315-4588',NULL,'iusouza@usp.br'),(111,-60,NULL,NULL,'Ildercílio Mota de Souza Lima','M','PGM','USP','FMRP','RGE','HEMATO','',NULL,NULL,'(16) 3315-2223',NULL,'ildercilio_lima@yahoo.com.br'),(110,-59,NULL,NULL,'Igor Médici de Mattos','M','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3315-3153',NULL,'igormmattos@usp.br'),(109,-58,NULL,NULL,'Hélida Regina Magalhães','F','PGD','USP','FMRP','RGE','ER','',NULL,NULL,'(16) 3315-3076',NULL,'hrmagalhaes@usp.br'),(108,-57,NULL,NULL,'Gislaine Angélica Rodrigues Silva','F','PGD','USP','FMRP','RGE','GE','',NULL,NULL,'(16) 3315-3103',NULL,'gisangelica@yahoo.com.br'),(107,-56,NULL,NULL,'Giovana da Silva Leandro','F','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-3082',NULL,'giovanasl@usp.br'),(106,-55,NULL,NULL,'Flávia Sacilotto Donaires','F','PGD','USP','FMRP','RGE','','',NULL,NULL,'(16) 3315-3082',NULL,'flaviadonaires@usp.br'),(105,-54,NULL,NULL,'Flávia Porto Pelá ','F','PGM','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3315-3102',NULL,'flaviaportopela@gmail.com'),(104,-53,NULL,NULL,'Flávia Gaona de Oliveira Gennaro','F','PGD','USP','FMRP','RGE','CMH','',NULL,NULL,'(16) 3315-3076',NULL,'flaviagaona@gmail.com'),(103,-52,NULL,NULL,'Flávia Cristina de Paula Freitas','F','PGD','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3315-3153',NULL,'flaviacpfreitas@usp.br'),(102,-51,NULL,NULL,'Filipe Brum Machado','F','PGD','USP','FMRP','RGE','ER','',NULL,NULL,'(16) 3315-3076',NULL,'filipebma@yahoo.com.br'),(101,-50,NULL,NULL,'Fernanda Paula de Carvalho','F','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-3082',NULL,'fe.carvalho@usp.br'),(100,-49,NULL,NULL,'Fernanda Bueno Barbosa','F','PGM','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3600-3050',NULL,'fbuenobarbosa@gmail.com'),(99,-48,NULL,NULL,'Everton de Brito Oliveira Costa','M','PGM','USP','FMRP','RGE','TG','',NULL,NULL,'(16) 2101-9300',NULL,'evertoncosta_biomedicina@yahoo.com.br'),(98,-47,NULL,NULL,'Elza Akie Sakamoto Lang','F','PPD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3315-3078',NULL,'elzalang@usp.br'),(97,-46,NULL,NULL,'Edward José Strini','M','PGD','USP','FMRP','RGE','BMP','',NULL,NULL,'(16) 3315-3852',NULL,'edstrini@usp.br'),(96,-45,NULL,NULL,'Edilene Santos de Andrade','F','PGD','USP','FMRP','RGE','','',NULL,NULL,'(16) 3315-0417',NULL,'edileneandrade@usp.br'),(95,-44,NULL,NULL,'Dora Yovana Barrios Leal','F','PGM','USP','FMRP','RGE','GE','',NULL,NULL,'(16) 3315-3103',NULL,'genyovana@gmail.com'),(94,-43,NULL,NULL,'Danilo Jordão Xavier','M','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-3082',NULL,'danjordan55@yahoo.com.br'),(93,-42,NULL,NULL,'Daniel Macedo de Melo Jorge','M','PGD','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3315-4588',NULL,'danielmacedo.jorge@gmail.com'),(92,-41,NULL,NULL,'Daniel Antunes Moreno','M','PGD','USP','FMRP','RGE','OGH','',NULL,NULL,'(16) 3315-2651',NULL,'danielmoreno@usp.br'),(91,-40,NULL,NULL,'Daiana Almeida De Souza','F','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3601-4578',NULL,'daianasouz@yahoo.com.br'),(90,-39,NULL,NULL,'Claudia Macedo','F','PPD','USP','FMRP','RGE','IGM','',NULL,NULL,'(16) 3315-3246',NULL,'macedo@rge.fmrp.usp.br'),(89,-38,NULL,NULL,'Claudia Caixeta Franco Andrade','F','PGD','USP','FMRP','RGE','GB','',NULL,NULL,'(16) 3315-3050',NULL,'claudiacfa@yahoo.com.br'),(88,-37,NULL,NULL,'Ciro Silveira e Pereira','M','PGD','USP','FMRP','RGE','CMH','',NULL,NULL,'(16) 3315-3081',NULL,'ciro_bm@yahoo.com.br'),(87,-36,NULL,NULL,'Carolina Arruda de Faria','F','PGD','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'cafaria@usp.br'),(86,-35,NULL,NULL,'Camilla Valente Pires','F','PGD','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3315-3153',NULL,'camisvalente@usp.br'),(85,-34,NULL,NULL,'Bruno Braga Sangiorgi','M','PGM','USP','FMRP','RGE','HEMATO','',NULL,NULL,'(16) 3315-2223',NULL,'brunosangiorgi@gmail.com'),(84,-33,NULL,NULL,'Bruna Rodrigues Muys','F','PGM','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'brunamuys@usp.br'),(83,-32,NULL,NULL,'Bruna Ferreira de Souza','F','PGM','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9368',NULL,'b_fs7@hotmail.com'),(82,-31,NULL,NULL,'Beatriz Jeronimo Pinto','F','PGM','USP','FMRP','RGE','BI','',NULL,NULL,'(16) 3315-4503',NULL,'biajp@usp.br'),(81,-30,NULL,NULL,'Andressa Gois Morales','F','PGD','USP','FMRP','RGE','COI','',NULL,NULL,'(16) 3315-2651',NULL,'agmorales@usp.br'),(80,-29,NULL,NULL,'André Fernando Ditondo Micas','M','PGD','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3315-3153',NULL,'andre.micas@gmail.com'),(79,-28,NULL,NULL,'Anderson Mioranza','M','PGD','USP','FMRP','RGE','GEMAC','',NULL,NULL,'(16) 3315-4909',NULL,'mioranza@usp.br'),(78,-27,NULL,NULL,'Ana Paula de Lima Montaldi','F','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-3082',NULL,'apmontaldi@yahoo.com.br'),(77,-26,NULL,NULL,'Ana Durvalina Bomtorin','F','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3315-3153',NULL,'ana_durva@rge.fmrp.usp.br'),(76,-25,NULL,NULL,'Aline Simoneti Fonseca','F','PGD','USP','FMRP','RGE','GMBI','',NULL,NULL,'(16) 2101-9607',NULL,'alinesimoneti@usp.br'),(75,-24,NULL,NULL,'Aline Patricia Turcatto','F','PGD','USP','FMRP','RGE','BGA','',NULL,NULL,'(16) 3315-4578',NULL,'alinepatricia@usp.br'),(74,-23,NULL,NULL,'Aline Helena da Silva Cruz','F','PGD','USP','FMRP','RGE','GBMF','',NULL,NULL,'(16) 3315-3274',NULL,'alinehelena@usp.br'),(73,-22,NULL,NULL,'Aline Carolina Aleixo Silva','F','PGD','USP','FMRP','RGE','BDA','',NULL,NULL,'(16) 3315-3153',NULL,'alinea@usp.br'),(72,-21,NULL,NULL,'Alexandre Ferro Aissa','M','PGD','USP','FMRP','RGE','CM','',NULL,NULL,'(16) 3315-4186',NULL,'afaissa@gmail.com'),(71,-20,NULL,NULL,'Alexandra Galvão Gomes','F','PGM','USP','FMRP','RGE','CMH','',NULL,NULL,'(16) 3315-3081',NULL,'alexandragalvao@usp.br'),(51,-19,NULL,NULL,'Vera Lucia Cardoso','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(50,-18,NULL,NULL,'Tiago Mauricio Francoy','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(49,-17,NULL,NULL,'Tiago Campos Pereira','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(48,-16,NULL,NULL,'Sérgio Britto Garcia','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(47,-15,NULL,NULL,'Rodrigo Alexandre Panepucci','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(46,-14,NULL,NULL,'Maria Helena de Souza Goldman','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(45,-13,NULL,NULL,'Maria Armênia Ramalho Freitas','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(44,-12,NULL,NULL,'Marcia Maria Gentile Bitondi','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(43,-11,NULL,NULL,'Lusânia Maria Greggi Antunes','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(42,-10,NULL,NULL,'Luiz Gonzaga Tone','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(41,-9,NULL,NULL,'Klaus Hartmann Hartfelder','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(40,-8,NULL,NULL,'Henrique Nunes de Oliveira','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(39,-7,NULL,NULL,'Eduardo Antônio Donadi','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(38,-6,NULL,NULL,'Claudia Cristina Paro de Paz','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(37,-5,NULL,NULL,'Celso Teixeira Mendes Junior','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(36,-4,NULL,NULL,'Aparecida Maria Fontes','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,'aparecidamfontes@usp.br'),(35,-3,NULL,NULL,'Antonio Rossi Filho','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(34,-2,NULL,NULL,'Antonio Claudio Tedesco','M','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(33,-1,NULL,NULL,'Ana Lilia Alzate Marin','F','DOC','USP','FMRP','RGE','','',NULL,NULL,NULL,NULL,NULL),(1,0,NULL,NULL,'Chefia do Departamento','','DOC','USP','FMRP','RGE','RGE','H','10',NULL,NULL,'3293','secgen@rge.fmrp.usp.br'),(2,35739,NULL,NULL,'Moacyr Antonio Mestriner','M','DOC','USP','FMRP','RGE','GHM','B','23',NULL,NULL,'3156','mestriner@rge.fmrp.usp.br'),(3,49317,NULL,NULL,'Raysildo Barbosa Lôbo','M','DOC','USP','FMRP','RGE','GEMAC','C','7',NULL,NULL,'3135','raysildo@gmail.com'),(4,49467,NULL,NULL,'João Monteiro de Pina Neto','M','DOC','USP','FMRP','RGE','GHM','I','4',NULL,NULL,'3104','jmdpneto@fmrp.usp.br'),(5,54442,NULL,NULL,'David De Jong','M','DOC','USP','FMRP','RGE','RGE','A','15',NULL,NULL,'4401','ddjong@fmrp.usp.br'),(6,56100,NULL,NULL,'Geraldo Aleixo da silva Passos Junior','M','DOC','USP','FORP','MORFO','MORFO','B','9',NULL,NULL,'3030','passos@usp.br'),(7,60554,NULL,NULL,'Ester Silveira Ramos','F','DOC','USP','FMRP','RGE','GHM','C','8',NULL,NULL,'4914','esramos@fmrp.usp.br'),(8,70131,NULL,NULL,'Ademilson Espencer Egea Soares','M','DOC','USP','FMRP','RGE','GHM','A','11',NULL,NULL,'3155','aesoares@fmrp.usp.br'),(9,70253,NULL,NULL,'Aguinaldo Luiz Simões','M','DOC','USP','FMRP','RGE','GHM','B','11',NULL,NULL,'3157','alsimoes@fmrp.usp.br'),(10,75748,NULL,NULL,'Nilce Maria Martinez Rossi','F','DOC','USP','FMRP','RGE','GHM','H','3',NULL,NULL,'3150','nmmrossi@usp.br'),(11,81485,NULL,NULL,'Cacilda Casartelli','F','DOC','USP','FMRP','RGE','RGE','D','1',NULL,NULL,'3152','ccasarte@rge.fmrp.usp.br'),(12,82281,NULL,NULL,'Lucia Regina Martelli','F','DOC','USP','FMRP','RGE','GHM','C','6',NULL,NULL,'3164','lrmartel@fmrp.usp.br'),(13,109134,NULL,NULL,'Fábio de Melo Sene','M','DOC','USP','FFCLRP','BIO','BIO','A','13',NULL,NULL,'3104','melosene@rge.fmrp.usp.br'),(14,177229,NULL,NULL,'Catarina Satie Takahashi','F','DOC','USP','FFCLRP','BIO','BIO','G','9',NULL,NULL,'3761','cstakaha@rge.fmrp.usp.br'),(15,434515,NULL,NULL,'Elza Tiemi Sakamoto Hojo','F','DOC','USP','FFCLRP','BIO','BIO','G','8',NULL,NULL,'3827','etshojo@usp.br'),(16,503770,NULL,NULL,'Lionel Segui Gonçalves','M','DOC','USP','FFCLRP','BIO','BIO','A','12',NULL,NULL,'3154','lsgoncal@rge.fmrp.usp.br'),(17,527513,NULL,NULL,'Zilá Luz Paulino Simões','F','DOC','USP','FFCLRP','BIO','BIO','A','29',NULL,NULL,'4332','zlpsimoe@rge.fmrp.usp.br'),(18,740232,NULL,NULL,'Luiz Antonio Framartino Bezerra','M','DOC','USP','FMRP','RGE','GEMAC','C','13',NULL,NULL,'3135','lafbezer@fmrp.usp.br'),(19,999999,NULL,NULL,'José Fulano','','FNM','USP','FMRP','RGE','ADM','H','10','Secretaria',NULL,'3132','spaulfb@hotmail.com'),(20,1431879,NULL,NULL,'Pedro Roberto Rodrigues Prado','M','FNS','USP','FMRP','RGE','GHM','A','10',NULL,NULL,'3708','pedro@rge.fmrp.usp.br'),(21,1471547,NULL,NULL,'Maura Helena Manfrin','F','DOC','USP','FMRP','RGE','GHM','A','13',NULL,NULL,'4390','mhmanfri@rge.fmrp.usp.br'),(22,1513550,NULL,NULL,'Paulo Mazzoncini de Azevedo Marques','M','DOC','USP','FMRP','INFBIO','INFBIO','','',NULL,NULL,'0','pmarques@fmrp.usp.br'),(23,1689081,NULL,NULL,'Silvana Giuliatti','F','DOC','USP','FMRP','RGE','GHM','G','11',NULL,NULL,'4503','silvana@fmrp.usp.br'),(24,1913921,NULL,NULL,'Victor Evangelista de Faria Ferraz','M','DOC','USP','FMRP','RGE','GHM','I','7',NULL,'(16) 3315-4500','0069','vferraz@usp.br'),(25,2056632,NULL,NULL,'Wilson Araujo da Silva Junior','M','DOC','USP','FMRP','RGE','RGE','','',NULL,'(016) 2101-9300','9362','wilsonjr@usp.br'),(26,2082952,NULL,NULL,'Jair Licio Ferreira Santos','M','DOC','USP','FMRP','RGE','GHM','','',NULL,NULL,'0','jalifesa@usp.br'),(27,2083320,NULL,NULL,'Eucléia Primo Betioli Contel','F','DOC','USP','FMRP','RGE','GHM','B','2',NULL,NULL,'3151','epbcontel@usp.br'),(28,2369711,NULL,NULL,'Ricardo Zorzetto Nicoliello Vêncio','M','DOC','USP','FMRP','RGE','RGE','F','3',NULL,NULL,'3102','rvencio@rge.fmrp.usp.br'),(29,2416911,'06260562845',NULL,'Sebastião Paulo Framartino Bezerra','M','FNB','USP','FMRP','RGE','GEMAC','C','26',NULL,'(16) 3315-3135','3135','spfbezer@fmrp.usp.br'),(30,2470882,NULL,NULL,'Marli Aparecida Vanni Galerani','F','FNM','USP','FMRP','RGE','GHM','C','14',NULL,NULL,'4912','mvanni@rge.fmrp.usp.br'),(31,2640401,NULL,NULL,'Susie Adriana Ribeiro Penha Nalon','F','FNM','USP','FMRP','RGE','GHM','H','11',NULL,NULL,'3102','susie@rge.fmrp.usp.br'),(163,5096188,NULL,NULL,'Vanessa da Silva Silveira','F','DOC','USP','FMRP','RGE','OH','C','','Laboratório','(16) 3315-9054','9054','vsilveira@fmrp.usp.br'),(162,7933702,NULL,NULL,'Houtan Noushmehr','M','DOC','USP','FMRP','RGE','OMICS','C','30','Laboratório','0526','0526','houtan@usp.br');
/*!40000 ALTER TABLE `pessoa_copia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pessoa_inc201203021200`
--

DROP TABLE IF EXISTS `pessoa_inc201203021200`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pessoa_inc201203021200` (
  `codigousp` int(9) NOT NULL COMMENT 'Codigo USP - Matricula',
  `nome` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nome da Pessoa',
  `sexo` char(1) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Sexo (M,F)',
  `categoria` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Categoria Funcional',
  `instituicao` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'InstituiÃ§Ã£o',
  `unidade` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Unidade',
  `depto` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Departamento'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pessoa_inc201203021200`
--

LOCK TABLES `pessoa_inc201203021200` WRITE;
/*!40000 ALTER TABLE `pessoa_inc201203021200` DISABLE KEYS */;
INSERT INTO `pessoa_inc201203021200` VALUES (-1,'Ana Lilia Alzate Marin','F','DOC','USP','FMRP','RGE'),(-2,'Antonio Claudio Tedesco','M','DOC','USP','FMRP','RGE'),(-3,'Antonio Rossi Filho','M','DOC','USP','FMRP','RGE'),(-4,'Aparecida Maria Fontes','F','DOC','USP','FMRP','RGE'),(-5,'Celso Teixeira Mendes Junior','M','DOC','USP','FMRP','RGE'),(-6,'Claudia Cristina Paro de Paz','F','DOC','USP','FMRP','RGE'),(-7,'Eduardo Antônio Donadi','M','DOC','USP','FMRP','RGE'),(-8,'Henrique Nunes de Oliveira','M','DOC','USP','FMRP','RGE'),(-9,'Klaus Hartmann Hartfelder','M','DOC','USP','FMRP','RGE'),(-10,'Luiz Gonzaga Tone','M','DOC','USP','FMRP','RGE'),(-11,'Lusânia Maria Greggi Antunes','F','DOC','USP','FMRP','RGE'),(-12,'Marcia Maria Gentile Bitondi','F','DOC','USP','FMRP','RGE'),(-13,'Maria Armênia Ramalho Freitas','F','DOC','USP','FMRP','RGE'),(-14,'Maria Helena de Souza Goldman','F','DOC','USP','FMRP','RGE'),(-15,'Rodrigo Alexandre Panepucci','M','DOC','USP','FMRP','RGE'),(-16,'Sérgio Britto Garcia','M','DOC','USP','FMRP','RGE'),(-17,'Tiago Campos Pereira','M','DOC','USP','FMRP','RGE'),(-18,'Tiago Mauricio Francoy','M','DOC','USP','FMRP','RGE'),(-19,'Vera Lucia Cardoso','F','DOC','USP','FMRP','RGE');
/*!40000 ALTER TABLE `pessoa_inc201203021200` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pessoa_v201203021157`
--

DROP TABLE IF EXISTS `pessoa_v201203021157`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pessoa_v201203021157` (
  `iupessoa` int(11) NOT NULL DEFAULT '0' COMMENT 'IdentificaÃ§Ã£o Ãºnica da pessoa',
  `codigousp` int(9) NOT NULL COMMENT 'Codigo USP - Matricula',
  `cpf` char(11) DEFAULT NULL COMMENT 'CPF da pessoa',
  `passaporte` char(16) DEFAULT NULL COMMENT 'CÃ³digo do Passaporte da Pessoa',
  `nome` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nome da Pessoa',
  `sexo` char(1) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Sexo (M,F)',
  `categoria` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Categoria Funcional',
  `instituicao` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'InstituiÃ§Ã£o',
  `unidade` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Unidade',
  `depto` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Departamento',
  `setor` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Setor',
  `bloco` char(8) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Bloco do Departamento',
  `sala` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Sala',
  `salatipo` char(32) DEFAULT NULL COMMENT 'Tipo da Sala (EscritÃ³rio=Sala Docente, LaboratÃ³rio, Anfiteatro, Sala de Aula, etc)\r\n',
  `fone` varchar(20) DEFAULT NULL COMMENT 'Telefone local ou externo',
  `ramal` int(4) DEFAULT NULL COMMENT 'Ramal',
  `e_mail` char(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'E_mail'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pessoa_v201203021157`
--

LOCK TABLES `pessoa_v201203021157` WRITE;
/*!40000 ALTER TABLE `pessoa_v201203021157` DISABLE KEYS */;
INSERT INTO `pessoa_v201203021157` VALUES (8,70131,NULL,NULL,'Ademilson Espencer Egea Soares','M','DOC','USP','FMRP','RGE','GHM','A','11',NULL,NULL,3155,'espencer@rge.fmrp.usp.br'),(9,70253,NULL,NULL,'Aguinaldo Luiz Simões','M','DOC','USP','FMRP','RGE','GHM','B','11',NULL,NULL,3157,'alsimoes@rge.fmrp.usp.br'),(11,81485,NULL,NULL,'Cacilda Casartelli','F','DOC','USP','FMRP','RGE','RGE','D','1',NULL,NULL,3152,'ccasarte@rge.fmrp.usp.br'),(14,177229,NULL,NULL,'Catarina Satie Takahashi','F','DOC','USP','FFCLRP','BIO','BIO','G','9',NULL,NULL,3761,'cstakaha@rge.fmrp.usp.br'),(1,0,NULL,NULL,'Chefia do Departamento','','DOC','USP','FMRP','RGE','RGE','H','10',NULL,NULL,3293,'secgen@rge.fmrp.usp.br'),(5,54442,NULL,NULL,'David De Jong','M','DOC','USP','FMRP','RGE','RGE','A','15',NULL,NULL,4401,'ddjong@rge.fmrp.usp.br'),(15,434515,NULL,NULL,'Elza Tiemi Sakamoto Hojo','F','DOC','USP','FFCLRP','BIO','BIO','G','8',NULL,NULL,3827,'etshojo@usp.br'),(7,60554,NULL,NULL,'Ester Silveira Ramos','F','DOC','USP','FMRP','RGE','GHM','C','8',NULL,NULL,4914,'esramos@genbov.fmrp.usp.br'),(27,2083320,NULL,NULL,'Eucléia Primo Betioli Contel','F','DOC','USP','FMRP','RGE','GHM','B','2',NULL,NULL,3151,'epbconte@rge.fmrp.usp.br'),(13,109134,NULL,NULL,'Fábio de Melo Sene','M','DOC','USP','FFCLRP','BIO','BIO','A','13',NULL,NULL,3104,'melosene@rge.fmrp.usp.br'),(6,56100,NULL,NULL,'Geraldo Aleixo da silva Passos Junior','M','DOC','USP','FORP','MORFO','MORFO','B','9',NULL,NULL,3030,'passos@rge.fmrp.usp.br'),(26,2082952,NULL,NULL,'Jair Licio Ferreira Santos','M','DOC','USP','FMRP','RGE','GHM','','',NULL,NULL,0,'jalifesa@usp.br'),(34,-2,NULL,NULL,'Joaquim Nabuco','','DOC','UNICAMP','','','','',NULL,NULL,NULL,9999,'jon@'),(4,49467,NULL,NULL,'João Monteiro de Pina Neto','M','DOC','USP','FMRP','RGE','GHM','I','4',NULL,NULL,3104,'jmdpneto@fmrp.usp.br'),(33,-1,NULL,NULL,'Jose Benedito','','DOC','UNICAMP','','','','',NULL,NULL,NULL,9999,'gemac@genbov.fmrp.usp.br'),(19,999999,NULL,NULL,'José Fulano','','FNM','USP','FMRP','RGE','ADM','H','10','Secretaria',NULL,3132,'era_spaulfb#hotmail'),(16,503770,NULL,NULL,'Lionel Segui Gonçalves','M','DOC','USP','FFCLRP','BIO','BIO','A','12',NULL,NULL,3154,'lsgoncal@rge.fmrp.usp.br'),(12,82281,NULL,NULL,'Lucia Regina Martelli','F','DOC','USP','FMRP','RGE','GHM','C','6',NULL,NULL,3164,'lrmartel@rge.fmrp.usp.br'),(18,740232,NULL,NULL,'Luiz Antonio Framartino Bezerra','M','DOC','USP','FMRP','RGE','GEMAC','C','13',NULL,NULL,3135,'lafbezer@rge.fmrp.usp.br'),(30,2470882,NULL,NULL,'Marli Aparecida Vanni Galerani','F','FNM','USP','FMRP','RGE','GHM','C','14',NULL,NULL,4912,'mvanni@rge.fmrp.usp.br'),(21,1471547,NULL,NULL,'Maura Helena Manfrin','F','DOC','USP','FMRP','RGE','GHM','A','13',NULL,NULL,4390,'mhmanfri@rge.fmrp.usp.br'),(2,35739,NULL,NULL,'Moacyr Antonio Mestriner','M','DOC','USP','FMRP','RGE','GHM','B','23',NULL,NULL,3156,'mestriner@rge.fmrp.usp.br'),(10,75748,NULL,NULL,'Nilce Maria Martinez Rossi','F','DOC','USP','FMRP','RGE','GHM','H','3',NULL,NULL,3150,'nmmrossi@rge.fmrp.usp.br'),(22,1513550,NULL,NULL,'Paulo Mazzoncini de Azevedo Marques','M','DOC','USP','FMRP','INFBIO','INFBIO','','',NULL,NULL,0,'pmarques@fmrp.usp.br'),(20,1431879,NULL,NULL,'Pedro Roberto Rodrigues Prado','M','FNS','USP','FMRP','RGE','GHM','A','10',NULL,NULL,3708,'pedro@rge.fmrp.usp.br'),(3,49317,NULL,NULL,'Raysildo Barbosa Lôbo','M','DOC','USP','FMRP','RGE','GEMAC','C','7',NULL,NULL,3135,'lafbezer@fmrp.usp.br'),(28,2369711,NULL,NULL,'Ricardo Zorzetto Nicoliello Vêncio','M','DOC','USP','FMRP','RGE','RGE','F','3',NULL,NULL,3102,'rvencio@rge.fmrp.usp.br'),(29,2416911,'06260562845',NULL,'Sebastião Paulo Framartino Bezerra','M','FNB','USP','FMRP','RGE','GEMAC','C','26',NULL,'(16) 3602-3135',3135,'spfbezer@rge.fmrp.usp.br'),(23,1689081,NULL,NULL,'Silvana Giuliatti','F','DOC','USP','FMRP','RGE','GHM','G','11',NULL,NULL,4503,'silvana@rge.fmrp.usp.br'),(31,2640401,NULL,NULL,'Susie Adriana Ribeiro Penha Nalon','F','FNM','USP','FMRP','RGE','GHM','H','11',NULL,NULL,3102,'susie@rge.fmrp.usp.br'),(24,1913921,NULL,NULL,'Victor Evangelista de Faria Ferraz','M','DOC','USP','FMRP','RGE','GHM','I','7',NULL,NULL,4500,'vferraz@rge.fmrp.usp.br'),(25,2056632,NULL,NULL,'Wilson Araujo da Silva Junior','M','DOC','USP','FMRP','RGE','RGE','','',NULL,NULL,0,'wilsonjr@rge.fmrp.usp.br'),(17,527513,NULL,NULL,'Zilá Luz Paulino Simões','F','DOC','USP','FFCLRP','BIO','BIO','A','29',NULL,NULL,4332,'zlpsimoe@rge.fmrp.usp.br');
/*!40000 ALTER TABLE `pessoa_v201203021157` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_consultar_pessoal`
--

DROP TABLE IF EXISTS `temp_consultar_pessoal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_consultar_pessoal` (
  `codigousp` int(9) NOT NULL COMMENT 'Codigo USP - Matricula',
  `nome` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nome da Pessoa',
  `categoria` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Categoria Funcional',
  `e_mail` char(64) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'E_mail'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_consultar_pessoal`
--

LOCK TABLES `temp_consultar_pessoal` WRITE;
/*!40000 ALTER TABLE `temp_consultar_pessoal` DISABLE KEYS */;
INSERT INTO `temp_consultar_pessoal` VALUES (2082952,'Jair Licio Ferreira Santos','DOC','jalifesa@usp.br'),(-62,'Janaina de Andréa Dernowsek','PGD','jadernowsek@usp.br'),(-63,'Jaqueline Carvalho de Oliveira','PGD','oliveirajc@usp.br'),(49467,'João Monteiro de Pina Neto','DOC','jmdpneto@fmrp.usp.br'),(999999,'José Fulano','FNM','spaulfb@hotmail.com'),(-64,'Josiane Lilian dos Santos Schiavinato','PGD','josililian@gmail.com'),(-65,'Julia Alejandra Pezuk','PGD','juliapezuk@usp.br'),(-66,'Juliana Dourado Grzesiuk','PGM','juli_dourado@hotmail.com'),(-67,'Juliana Massimino Feres','PGD','julianaferes@gmail.com'),(-68,'Julio Cesar Cetrulo Lorenzi','PGD','julioclorenzi@gmail.com');
/*!40000 ALTER TABLE `temp_consultar_pessoal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_consultar_usuario`
--

DROP TABLE IF EXISTS `temp_consultar_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_consultar_usuario` (
  `codigousp` int(9) NOT NULL COMMENT 'CÃ³digo (Matricula) do UsuÃ¡rio na USP',
  `login` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Login de Acesso do UsuÃ¡rio. OBS. poderÃ¡ ser branco ou nulo',
  `nome` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nome da Pessoa',
  `categoria` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Categoria Funcional',
  `pa` char(48) DEFAULT NULL COMMENT 'DescriÃ§Ã£o do CÃ³digo que indica o PrivilÃ©gio de Acesso aos Procedimento do REXP',
  `e_mail` char(64) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'E_mail'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_consultar_usuario`
--

LOCK TABLES `temp_consultar_usuario` WRITE;
/*!40000 ALTER TABLE `temp_consultar_usuario` DISABLE KEYS */;
INSERT INTO `temp_consultar_usuario` VALUES (70253,'alsimoes','Aguinaldo Luiz Simões','DOC','Orientador de Projeto','alsimoes@fmrp.usp.br'),(999999,'spaulfb','José Fulano','FNM','Orientador de Projeto','spaulfb@hotmail.com');
/*!40000 ALTER TABLE `temp_consultar_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmpalunos`
--

DROP TABLE IF EXISTS `tmpalunos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tmpalunos` (
  `codigousp` int(9) NOT NULL COMMENT 'Codigo USP - Matricula',
  `nome` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nome da Pessoa',
  `sexo` char(1) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Sexo (M,F)',
  `categoria` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Categoria Funcional',
  `instituicao` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'InstituiÃ§Ã£o',
  `unidade` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Unidade',
  `depto` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Departamento',
  `setor` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Setor',
  `fone` varchar(20) DEFAULT NULL COMMENT 'Telefone local ou externo',
  `e_mail` char(64) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'E_mail'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmpalunos`
--

LOCK TABLES `tmpalunos` WRITE;
/*!40000 ALTER TABLE `tmpalunos` DISABLE KEYS */;
INSERT INTO `tmpalunos` VALUES (-20,'Alexandra Galvão Gomes','F','PGM','USP','FMRP','RGE','CMH','(16) 3602-30','alexandragalvao@usp.br'),(-21,'Alexandre Ferro Aissa','M','PGD','USP','FMRP','RGE','CM','(16) 3602-41','afaissa@gmail.com'),(-22,'Aline Carolina Aleixo Silva','F','PGD','USP','FMRP','RGE','BDA','(16) 3602-31','alinea@usp.br'),(-23,'Aline Helena da Silva Cruz','F','PGD','USP','FMRP','RGE','GBMF','(16) 3602-32','alinehelena@usp.br'),(-24,'Aline Patricia Turcatto','F','PGD','USP','FMRP','RGE','BGA','(16) 3602-45','alinepatricia@usp.br'),(-25,'Aline Simoneti Fonseca','F','PGD','USP','FMRP','RGE','GMBI','(16) 2101-96','alinesimoneti@usp.br'),(-26,'Ana Durvalina Bomtorin','F','PGD','USP','FMRP','RGE','BGA','(16) 3602-31','ana_durva@rge.fmrp.usp.br'),(-27,'Ana Paula de Lima Montaldi','F','PGD','USP','FMRP','RGE','CM','(16) 3602-30','apmontaldi@yahoo.com.br'),(-28,'Anderson Mioranza','M','PGD','USP','FMRP','RGE','GEMAC','(16) 3602-49','mioranza@usp.br'),(-29,'André Fernando Ditondo Micas','M','PGD','USP','FMRP','RGE','BDA','(16) 3602-31','andre.micas@gmail.com'),(-30,'Andressa Gois Morales','F','PGD','USP','FMRP','RGE','COI','16 3602-2651','agmorales@usp.br'),(-31,'Beatriz Jeronimo Pinto','F','PGM','USP','FMRP','RGE','BI','(16) 3602-45','biajp@usp.br'),(-32,'Bruna Ferreira de Souza','F','PGM','USP','FMRP','RGE','GMBI','(16) 2101 93','b_fs7@hotmail.com'),(-33,'Bruna Rodrigues Muys','F','PGM','USP','FMRP','RGE','GMBI','(16) 2101-93','brunamuys@usp.br'),(-34,'Bruno Braga Sangiorgi','M','PGM','USP','FMRP','RGE','HEMATO','(16) 3602-22','brunosangiorgi@gmail.com'),(-35,'Camilla Valente Pires','F','PGD','USP','FMRP','RGE','BDA','(16) 3602-31','camisvalente@usp.br'),(-36,'Carolina Arruda de Faria','F','PGD','USP','FMRP','RGE','GMBI','(16) 2101-93','cafaria@usp.br'),(-37,'Ciro Silveira e Pereira','M','PGD','USP','FMRP','RGE','CMH','(16) 3602-30','ciro_bm@yahoo.com.br'),(-38,'Claudia Caixeta Franco Andrade','F','PGD','USP','FMRP','RGE','GB','(16) 3602-30','claudiacfa@yahoo.com.br'),(-39,'Claudia Macedo','F','PPD','USP','FMRP','RGE','IGM','(16) 3602-32','macedo@rge.fmrp.usp.br'),(-40,'Daiana Almeida De Souza','F','PGD','USP','FMRP','RGE','BGA','(16) 3601-45','daianasouz@yahoo.com.br'),(-41,'Daniel Antunes Moreno','M','PGD','USP','FMRP','RGE','OGH','(16) 3602265','danielmoreno@usp.br'),(-42,'Daniel Macedo de Melo Jorge','M','PGD','USP','FMRP','RGE','BI','(16)36024588','danielmacedo.jorge@gmail.com'),(-43,'Danilo Jordão Xavier','M','PGD','USP','FMRP','RGE','CM','(16) 3602-30','danjordan55@yahoo.com.br'),(-44,'Dora Yovana Barrios Leal','F','PGM','USP','FMRP','RGE','GE','(16) 3602-31','genyovana@gmail.com'),(-45,'Edilene Santos de Andrade','F','PGD','USP','FMRP','RGE','','(16) 3602-04','edileneandrade@usp.br'),(-46,'Edward José Strini','M','PGD','USP','FMRP','RGE','BMP','36023852','edstrini@usp.br'),(-47,'Elza Akie Sakamoto Lang','F','PPD','USP','FMRP','RGE','GBMF','(16) 3602-30','elzalang@usp.br'),(-48,'Everton de Brito Oliveira Costa','M','PGM','USP','FMRP','RGE','TG','(16) 2101 93','evertoncosta_biomedicina@yahoo.com.br'),(-49,'Fernanda Bueno Barbosa','F','PGM','USP','FMRP','RGE','GB','(16) 3600-30','fbuenobarbosa@gmail.com'),(-50,'Fernanda Paula de Carvalho','F','PGD','USP','FMRP','RGE','CM','(16) 3602-30','fe.carvalho@usp.br'),(-51,'Filipe Brum Machado','F','PGD','USP','FMRP','RGE','ER','(16) 3602-30','filipebma@yahoo.com.br'),(-52,'Flávia Cristina de Paula Freitas','F','PGD','USP','FMRP','RGE','BDA','3602-3153','flaviacpfreitas@usp.br'),(-53,'Flávia Gaona de Oliveira Gennaro','F','PGD','USP','FMRP','RGE','CMH','(16) 3602 30','flaviagaona@gmail.com'),(-54,'Flávia Porto Pelá ','F','PGM','USP','FMRP','RGE','IGM','(16) 3602-31','flaviaportopela@gmail.com'),(-55,'Flávia Sacilotto Donaires','F','PGD','USP','FMRP','RGE','','(16) 3602-30','flaviadonaires@usp.br'),(-56,'Giovana da Silva Leandro','F','PGD','USP','FMRP','RGE','CM','(16) 3602-30','giovanasl@usp.br'),(-57,'Gislaine Angélica Rodrigues Silva','F','PGD','USP','FMRP','RGE','GE','(16) 3602-31','gisangelica@yahoo.com.br'),(-58,'Hélida Regina Magalhães','F','PGD','USP','FMRP','RGE','ER','(16) 3602-30','hrmagalhaes@usp.br'),(-59,'Igor Médici de Mattos','M','PGD','USP','FMRP','RGE','BGA','(16) 3602-31','igormmattos@usp.br'),(-60,'Ildercílio Mota de Souza Lima','M','PGM','USP','FMRP','RGE','HEMATO','(16) 3602-22','ildercilio_lima@yahoo.com.br'),(-61,'Iuliana Gregãrio Souza Rodrigues','F','PGM','USP','FMRP','RGE','BI','(16) 3602-45','iusouza@usp.br'),(-62,'Janaina de Andréa Dernowsek','F','PGD','USP','FMRP','RGE','IGM','(16) 3602-32','jadernowsek@usp.br'),(-63,'Jaqueline Carvalho de Oliveira','F','PGD','USP','FMRP','RGE','COI','3602 2651','oliveirajc@usp.br'),(-64,'Josiane Lilian dos Santos Schiavinato','F','PGD','USP','FMRP','RGE','HEMATO','(16) 3602-22','josililian@gmail.com'),(-65,'Julia Alejandra Pezuk','F','PGD','USP','FMRP','RGE','COI','(16) 3602-26','juliapezuk@usp.br'),(-66,'Juliana Dourado Grzesiuk','F','PGM','USP','FMRP','RGE','CMH','(16) 3602-23','juli_dourado@hotmail.com'),(-67,'Juliana Massimino Feres','F','PGD','USP','FMRP','RGE','CRGF','(16) 3602-31','julianaferes@gmail.com'),(-68,'Julio Cesar Cetrulo Lorenzi','M','PGD','USP','FMRP','RGE','GMBI','(16) 2101-93','julioclorenzi@gmail.com'),(-69,'LARA MARTINELLI ZAPATA','F','PGM','USP','FMRP','RGE','HEMATO','(16) 3602-22','lara.mzapata@usp.br'),(-70,'Larissa Gomes da Silva','F','PGD','USP','FMRP','RGE','GBMF','(16) 3602-30','larissa.gomes@usp.br'),(-71,'Larissa Oliveira Guimarães','F','PGD','USP','FMRP','RGE','ER','(16) 3602-30','larissaguimaraes@usp.br'),(-72,'Leonardo Arduino Marano','M','PGD','USP','FMRP','RGE','GB','(16) 3602-04','leo.arduinomarano@gmail.com'),(-73,'Leonardo Barcelos de Paula','M','PGD','USP','FMRP','RGE','GB','(16) 3602-37','barcelos@usp.br'),(-74,'Leonardo Pereira Franchi','M','PGD','USP','FMRP','RGE','CM','(16) 3602-30','leonardofranchi@yahoo.com.br'),(-75,'Leonardo Rippel Salgado','M','PGD','USP','FMRP','RGE','PIB','(16) 3602-05','leonardo.rippel@yahoo.com.br'),(-76,'Liliane Maria Frães de Macedo','F','PGD','USP','FMRP','RGE','BGA','(16) 3602-31','lilimacedo@usp.br'),(-77,'Lisandra Mesquita Batista','F','PGD','USP','FMRP','RGE','GHM','(16) 3602-31','limesq@gmail.com'),(-78,'Ludmila Serafim de Abreu','F','PGD','USP','FMRP','RGE','GHM','(16) 3602-31','ludiserafimabreu@gmail.com'),(-79,'Luís Antonio Alves de Toledo Filho','M','PGM','USP','FMRP','RGE','BMP','(16) 3602-38','biozebu@yahoo.com.br'),(-80,'Luiz Fernando Martins Pignata','M','PGM','USP','FMRP','RGE','BI','(16) 3602-45','fpignata@gmail.com'),(-81,'Luiza Ferreira de Araujo','F','PGM','USP','FMRP','RGE','GMBI','(16) 2101-93','luizafaraujo@usp.br'),(-82,'MaÍra Pompeu Martins','F','PGD','USP','FMRP','RGE','GBMF','(16) 3602-30','mairapompeu@hotmail.com'),(-83,'Maria Gabriela Fontanetti Rodrigues','F','PGD','USP','FMRP','RGE','BI','(16) 3602-45','gabrielafontanetti@hotmail.com'),(-84,'Matheus de Oliveira Bazoni','M','PGD','USP','FMRP','RGE','BGA','(16) 3602-45','bazonibee@usp.br'),(-85,'Nadia Carolina de Aguiar Fracasso','F','PGM','USP','FMRP','RGE','GB','(16) 3602-30','nadiadeaguiar@usp.br'),(-86,'Natalia Fagundes Cagnin','F','PGD','USP','FMRP','RGE','GB','(16) 3602-30','nacagnin@yahoo.com.br'),(-87,'Nathalia Joanne Bispo Cezar','F','PGM','USP','FMRP','RGE','IGM','(16) 3602-32','nathaliacezar@usp.br'),(-88,'Nathalia Moreno Cury','F','PGM','USP','FMRP','RGE','GMBI','(16) 2101-93','nathaliamcury@gmail.com'),(-89,'Niege Silva Mendes','F','PGD','USP','FMRP','RGE','GBMF','(16)36023274','niege.mendes@usp.br'),(-90,'Nilson Nicolau Junior','M','PGD','USP','FMRP','RGE','BI','(16) 3602-45','nilsonnicolaujr@gmail.com'),(-91,'Omar Arvey Martinez Caranton','M','PGD','USP','FMRP','RGE','BGA','(16) 3602-31','omarapis@yahoo.com.br'),(-92,'Pablo Rodrigo Sanches','M','PGD','USP','FMRP','RGE','GBMF','(16) 3602-32','pablo@rge.fmrp.usp.br'),(-93,'Paula Takahashi','F','PGD','USP','FMRP','RGE','CM','(16) 3602-30','takahaship@usp.br'),(-94,'Paulo Roberto D\'auria Vieira de Godoy','M','PGD','USP','FMRP','RGE','CM','(16) 3602-30','paulodauria@usp.br'),(-95,'Priscila Maria Manzini Ramos','F','PGD','USP','FMRP','RGE','COI','(16) 3602265','primanzini@yahoo.com.br'),(-96,'Rafael Fransak Ferreira','M','PGD','USP','FMRP','RGE','GE','(16) 3602-31','fransak@gmail.com'),(-97,'Renata dos Santos Almeida','F','PGM','USP','FMRP','RGE','IGM','(16) 3602-32','r.almeida@usp.br'),(-98,'Ricardo Roberto da Silva','M','PGD','USP','FMRP','RGE','PIB','(16) 3602-05','rsilvabioinfo@gmail.com'),(-99,'Rodrigo Guarischi Mattos Amaral de Sousa','M','PGM','USP','FMRP','RGE','GMBI','(16)2101-936','rodrigoguarischi@usp.br'),(-100,'Rômulo Maciel de Moraes Filho','M','PGD','USP','FMRP','RGE','BMP','(16) 3602-31','romulommfilho@yahoo.com.br'),(-101,'Sabrina Pereira Santos','F','PGM','USP','FMRP','RGE','GB','(16) 3602-30','sabrina-ps@hotmail.com'),(-102,'Samantha Vieira Abbad','F','PGM','USP','FMRP','RGE','BMP','(16) 3602-38','samanthabbad@gmail.com'),(-103,'Sarah Blima Paulino Leite','F','PGM','USP','FMRP','RGE','ER','(16) 3602-30','sblimapl@yahoo.com.br'),(-104,'Thaís Arouca Fornari','F','PGD','USP','FMRP','RGE','IGM','(16) 3206-32','thaisfornari@rge.fmrp.usp.br'),(-105,'Tiago Alves Jorge de Souza','M','PGM','USP','FMRP','RGE','CM','(16) 3602-30','tiagoajs@yahoo.com.br'),(-106,'Tiago Falcón Lopes','M','PGM','USP','FMRP','RGE','BDA','(16) 3602-31','tiagofalconlopes@gmail.com'),(-107,'Tiago Rinaldi Jacob','M','PGD','USP','FMRP','RGE','GBMF','16 36023078','tiagorjacob@usp.br'),(-108,'Vanessa Bonatti','F','PGM','USP','FMRP','RGE','BDA','(16) 3602-31','vanessa@rge.fmrp.usp.br'),(-109,'Vitor Leão','M','PGM','USP','FMRP','RGE','HEMATO','(16) 3602-22','leao_vitorleao@yahoo.com.br');
/*!40000 ALTER TABLE `tmpalunos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmpfonecor`
--

DROP TABLE IF EXISTS `tmpfonecor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tmpfonecor` (
  `fone` varchar(20) DEFAULT NULL COMMENT 'Telefone local ou externo',
  `e_mail` char(64) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'E_mail'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmpfonecor`
--

LOCK TABLES `tmpfonecor` WRITE;
/*!40000 ALTER TABLE `tmpfonecor` DISABLE KEYS */;
INSERT INTO `tmpfonecor` VALUES ('(16) 3602-3081','alexandragalvao@usp.br'),('(16) 3602-4186','afaissa@gmail.com'),('(16) 3602-3153','alinea@usp.br'),('(16) 3602-3274','alinehelena@usp.br'),('(16) 3602-4578','alinepatricia@usp.br'),('(16) 2101-9607','alinesimoneti@usp.br'),('(16) 3602-3153','ana_durva@rge.fmrp.usp.br'),('(16) 3602-3082','apmontaldi@yahoo.com.br'),('(16) 3602-4909','mioranza@usp.br'),('(16) 3602-3153','andre.micas@gmail.com'),('(16) 3602-2651','agmorales@usp.br'),('(16) 3602-4503','biajp@usp.br'),('(16) 2101 9368','b_fs7@hotmail.com'),('(16) 2101-9368','brunamuys@usp.br'),('(16) 3602-2223','brunosangiorgi@gmail.com'),('(16) 3602-3153','camisvalente@usp.br'),('(16) 2101-9368','cafaria@usp.br'),('(16) 3602-3081','ciro_bm@yahoo.com.br'),('(16) 3602-3050','claudiacfa@yahoo.com.br'),('(16) 3602-3246','macedo@rge.fmrp.usp.br'),('(16) 3601-4578','daianasouz@yahoo.com.br'),('(16) 3602-2651','danielmoreno@usp.br'),('(16) 3602-4588','danielmacedo.jorge@gmail.com'),('(16) 3602-3082','danjordan55@yahoo.com.br'),('(16) 3602-3103','genyovana@gmail.com'),('(16) 3602-0417','edileneandrade@usp.br'),('(16) 3602-3852','edstrini@usp.br'),('(16) 3602-3078','elzalang@usp.br'),('(16) 2101 9300','evertoncosta_biomedicina@yahoo.com.br'),('(16) 3600-3050','fbuenobarbosa@gmail.com'),('(16) 3602-3082','fe.carvalho@usp.br'),('(16) 3602-3076','filipebma@yahoo.com.br'),('(16) 3602-3153','flaviacpfreitas@usp.br'),('(16) 3602 3076','flaviagaona@gmail.com'),('(16) 3602-3102','flaviaportopela@gmail.com'),('(16) 3602-3082','flaviadonaires@usp.br'),('(16) 3602-3082','giovanasl@usp.br'),('(16) 3602-3103','gisangelica@yahoo.com.br'),('(16) 3602-3076','hrmagalhaes@usp.br'),('(16) 3602-3153','igormmattos@usp.br'),('(16) 3602-2223','ildercilio_lima@yahoo.com.br'),('(16) 3602-4588','iusouza@usp.br'),('(16) 3602-3246','jadernowsek@usp.br'),('(16) 3602-2651','oliveirajc@usp.br'),('(16) 3602-2223','josililian@gmail.com'),('(16) 3602-2651','juliapezuk@usp.br'),('(16) 3602-2341','juli_dourado@hotmail.com'),('(16) 3602-3156','julianaferes@gmail.com'),('(16) 2101-9368','julioclorenzi@gmail.com'),('(16) 3602-2223','lara.mzapata@usp.br'),('(16) 3602-3078','larissa.gomes@usp.br'),('(16) 3602-3076','larissaguimaraes@usp.br'),('(16) 3602-0417','leo.arduinomarano@gmail.com'),('(16) 3602-3758','barcelos@usp.br'),('(16) 3602-3082','leonardofranchi@yahoo.com.br'),('(16) 3602-0526','leonardo.rippel@yahoo.com.br'),('(16) 3602-3153','lilimacedo@usp.br'),('(16) 3602-3104','limesq@gmail.com'),('(16) 3602-3141','ludiserafimabreu@gmail.com'),('(16) 3602-3852','biozebu@yahoo.com.br'),('(16) 3602-4588','fpignata@gmail.com'),('(16) 2101-9368','luizafaraujo@usp.br'),('(16) 3602-3078','mairapompeu@hotmail.com'),('(16) 3602-4588','gabrielafontanetti@hotmail.com'),('(16) 3602-4578','bazonibee@usp.br'),('(16) 3602-3050','nadiadeaguiar@usp.br'),('(16) 3602-3050','nacagnin@yahoo.com.br'),('(16) 3602-3246','nathaliacezar@usp.br'),('(16) 2101-9368','nathaliamcury@gmail.com'),('(16)36023274','niege.mendes@usp.br'),('(16) 3602-4588','nilsonnicolaujr@gmail.com'),('(16) 3602-3153','omarapis@yahoo.com.br'),('(16) 3602-3224','pablo@rge.fmrp.usp.br'),('(16) 3602-3082','takahaship@usp.br'),('(16) 3602-3082','paulodauria@usp.br'),('(16) 36022651','primanzini@yahoo.com.br'),('(16) 3602-3103','fransak@gmail.com'),('(16) 3602-3246','r.almeida@usp.br'),('(16) 3602-0526','rsilvabioinfo@gmail.com'),('(16) 2101-9362','rodrigoguarischi@usp.br'),('(16) 3602-3103','romulommfilho@yahoo.com.br'),('(16) 3602-3050','sabrina-ps@hotmail.com'),('(16) 3602-3852','samanthabbad@gmail.com'),('(16) 3602-3076','sblimapl@yahoo.com.br'),('(16) 3206-3246','thaisfornari@rge.fmrp.usp.br'),('(16) 3602-3082','tiagoajs@yahoo.com.br'),('(16) 3602-3153','tiagofalconlopes@gmail.com'),('(16) 3602-3078','tiagorjacob@usp.br'),('(16) 3602-3153','vanessa@rge.fmrp.usp.br'),('(16) 3602-2223','leao_vitorleao@yahoo.com.br');
/*!40000 ALTER TABLE `tmpfonecor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmppessoa`
--

DROP TABLE IF EXISTS `tmppessoa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tmppessoa` (
  `iupessoa` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IdentificaÃ§Ã£o Ãºnica da pessoa',
  `codigousp` int(9) NOT NULL COMMENT 'Codigo USP - Matricula',
  `cpf` char(11) DEFAULT NULL COMMENT 'CPF da pessoa',
  `passaporte` char(16) DEFAULT NULL COMMENT 'CÃ³digo do Passaporte da Pessoa',
  `nome` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nome da Pessoa',
  `sexo` char(1) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Sexo (M,F)',
  `categoria` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Categoria Funcional',
  `instituicao` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'InstituiÃ§Ã£o',
  `unidade` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Unidade',
  `depto` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Departamento',
  `setor` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Setor',
  `bloco` char(8) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Bloco do Departamento',
  `sala` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Sala',
  `salatipo` char(32) DEFAULT NULL COMMENT 'Tipo da Sala (EscritÃ³rio=Sala Docente, LaboratÃ³rio, Anfiteatro, Sala de Aula, etc)\r\n',
  `fone` varchar(20) DEFAULT NULL COMMENT 'Telefone local ou externo',
  `ramal` int(4) DEFAULT NULL COMMENT 'Ramal',
  `e_mail` char(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'E_mail',
  PRIMARY KEY (`iupessoa`),
  UNIQUE KEY `codigousp` (`codigousp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmppessoa`
--

LOCK TABLES `tmppessoa` WRITE;
/*!40000 ALTER TABLE `tmppessoa` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmppessoa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `login` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Login de Acesso do UsuÃ¡rio. OBS. poderÃ¡ ser branco ou nulo',
  `senha` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Senha do UsuÃ¡rio',
  `datacad` date NOT NULL COMMENT 'Data de Cadastro do UsuÃ¡rio',
  `datavalido` date NOT NULL COMMENT 'Data de Validade do UsuÃ¡rio',
  `codigousp` int(9) NOT NULL COMMENT 'CÃ³digo (Matricula) do UsuÃ¡rio na USP',
  `pa` int(9) NOT NULL COMMENT 'PrivilÃ©gio de acesso a processos (0=SuperUsuÃ¡rio).\r\n',
  `aprovado` int(1) NOT NULL DEFAULT '0',
  `activation_code` int(11) DEFAULT NULL COMMENT 'Ativar codigo de Acesso',
  PRIMARY KEY (`codigousp`),
  CONSTRAINT `usuario_fk` FOREIGN KEY (`codigousp`) REFERENCES `pessoa` (`codigousp`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 322560 kB; (`codigousp`) REFER `pessoal/pessoa`';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES ('alsimoes','7d05e5ad7f5662bb','2011-09-19','2013-12-31',70253,30,1,159133),('lafbezer','0fa31da95675e2c1','2007-09-21','2054-12-31',740232,10,1,0),('spaulfb','39a0d4c26e3b7156','2018-07-23','2020-12-31',999999,30,1,0),('spfbezer','7281e4684b93c594','2007-09-21','2066-12-31',2416911,10,1,547321);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'pessoal'
--
/*!50003 DROP FUNCTION IF EXISTS `clean_spaces` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`soldbm`@`sol.fmrp.usp.br`*/ /*!50003 FUNCTION `clean_spaces`(str VARCHAR(255)) RETURNS varchar(255) CHARSET latin1
BEGIN
while instr(str,'  ') > 0 do
set str := replace(str,'  ',' ');
end while;
return trim(str);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `CONTAREGISTRO` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`soldbm`@`localhost`*/ /*!50003 FUNCTION `CONTAREGISTRO`() RETURNS text CHARSET latin1
    COMMENT 'Conta registro por registro'
BEGIN
RETURN IF(@CONTANDOREG,@CONTANDOREG:=@CONTANDOREG+1,@CONTANDOREG:=1);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `extractpart` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`lafbezer`@`localhost`*/ /*!50003 FUNCTION `extractpart`(string VARCHAR(250), dlmt VARCHAR(16), partnumber INT, spaceout BOOLEAN ) RETURNS varchar(250) CHARSET latin1
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `FRemoveAcentos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`soldbm`@`localhost`*/ /*!50003 FUNCTION `FRemoveAcentos`(texto VARCHAR(1024), tipocaixa CHAR) RETURNS varchar(1024) CHARSET latin1
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `regex_replace` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`soldbm`@`localhost`*/ /*!50003 FUNCTION `regex_replace`(pattern VARCHAR(1000),replacement VARCHAR(1000),original VARCHAR(1000)) RETURNS varchar(1000) CHARSET latin1
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-26 11:53:30
