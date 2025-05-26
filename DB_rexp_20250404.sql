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
-- Current Database: `rexp`
--

/*!40000 DROP DATABASE IF EXISTS `rexp`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `rexp` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `rexp`;

--
-- Table structure for table `anotacao`
--

DROP TABLE IF EXISTS `anotacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anotacao` (
  `cia` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código de Identificação da Anotação',
  `autor` int(11) NOT NULL COMMENT 'Autor do Experimento. Pessoa Responsável pela realização do Experimento.',
  `supervisor` int(11) DEFAULT NULL COMMENT 'Supervisor/Orientador do autor/executor do experimento.',
  `projeto` int(11) NOT NULL COMMENT 'Código do Projeto de Pesquisa.',
  `numero` int(11) NOT NULL COMMENT 'Número Sequencial do Experimento/Anotação do Projeto (CIP).',
  `titulo` varchar(254) NOT NULL DEFAULT '' COMMENT 'Título da Anotação.',
  `alteraant` int(11) DEFAULT NULL COMMENT 'Número da anotação anterior que é alterada/complementada por essa (atual).',
  `alteradapn` int(11) DEFAULT NULL COMMENT 'Número da anotação que altera essa (atual).',
  `data` datetime NOT NULL COMMENT 'Data da Anotacao',
  `testemunha1` int(11) DEFAULT NULL COMMENT 'Código da Testemunha (1) da realização do experimento.',
  `testemunha2` int(11) DEFAULT NULL COMMENT 'Código da testemunha (2) da realização do experimento.',
  `relatext` varchar(96) DEFAULT NULL COMMENT 'Link do arquivo que contem o relatório externo do experimento (Detalhamento)',
  PRIMARY KEY (`cia`),
  KEY `autor` (`autor`),
  KEY `projeto` (`projeto`),
  KEY `testemunha1` (`testemunha1`),
  KEY `testemunha2` (`testemunha2`),
  CONSTRAINT `anotacao_fk` FOREIGN KEY (`autor`) REFERENCES `pessoal`.`pessoa` (`codigousp`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `anotacao_fk2` FOREIGN KEY (`testemunha1`) REFERENCES `pessoal`.`pessoa` (`codigousp`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `anotacao_fk3` FOREIGN KEY (`testemunha2`) REFERENCES `pessoal`.`pessoa` (`codigousp`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anotacao`
--

LOCK TABLES `anotacao` WRITE;
/*!40000 ALTER TABLE `anotacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `anotacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anotador`
--

DROP TABLE IF EXISTS `anotador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anotador` (
  `anotador_ci` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código de identificação única do anotador',
  `cip` int(11) NOT NULL COMMENT 'Código do Projeto',
  `codigo` int(11) NOT NULL COMMENT 'Anotador = Código do autor (realizador autorizado) de experimento de um determinado projeto - Codigo USP.',
  `pa` int(11) NOT NULL COMMENT 'Privilegio de Acesso',
  `data` datetime NOT NULL COMMENT 'Data da Autorização do Anotador',
  PRIMARY KEY (`anotador_ci`),
  KEY `cip` (`cip`),
  KEY `pa` (`pa`),
  KEY `codigo` (`codigo`),
  CONSTRAINT `anotador_fk` FOREIGN KEY (`cip`) REFERENCES `projeto` (`cip`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `anotador_fk1` FOREIGN KEY (`pa`) REFERENCES `pa` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `anotador_fk2` FOREIGN KEY (`codigo`) REFERENCES `pessoal`.`pessoa` (`codigousp`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anotador`
--

LOCK TABLES `anotador` WRITE;
/*!40000 ALTER TABLE `anotador` DISABLE KEYS */;
/*!40000 ALTER TABLE `anotador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autorexp`
--

DROP TABLE IF EXISTS `autorexp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autorexp` (
  `cip` int(11) NOT NULL COMMENT 'Código do Projeto',
  `autorexp` int(11) NOT NULL COMMENT 'Código do autor (realizador autorizado) de experimento de um determinado projeto.',
  KEY `cip` (`cip`),
  KEY `realizador` (`autorexp`),
  CONSTRAINT `autorexp_fk` FOREIGN KEY (`cip`) REFERENCES `projeto` (`cip`),
  CONSTRAINT `autorexp_fk1` FOREIGN KEY (`autorexp`) REFERENCES `pessoal`.`pessoa` (`codigousp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Realizador do Experimento de um determinado projeto.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autorexp`
--

LOCK TABLES `autorexp` WRITE;
/*!40000 ALTER TABLE `autorexp` DISABLE KEYS */;
/*!40000 ALTER TABLE `autorexp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colabexp`
--

DROP TABLE IF EXISTS `colabexp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colabexp` (
  `projeto` int(11) NOT NULL COMMENT 'Código do Projeto (CIP).',
  `expnum` int(11) NOT NULL COMMENT 'Número do Experimento do respectivo projeto.',
  `colab` int(11) NOT NULL COMMENT 'Código (matricula USP) do colaborador do experimento.',
  KEY `colab` (`colab`),
  KEY `projeto` (`projeto`,`expnum`),
  CONSTRAINT `colabexp_fk` FOREIGN KEY (`projeto`, `expnum`) REFERENCES `experimento` (`projeto`, `expnum`),
  CONSTRAINT `colabexp_fk1` FOREIGN KEY (`colab`) REFERENCES `pessoal`.`pessoa` (`codigousp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabela de Identificação dos colaboradores do experimento.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colabexp`
--

LOCK TABLES `colabexp` WRITE;
/*!40000 ALTER TABLE `colabexp` DISABLE KEYS */;
/*!40000 ALTER TABLE `colabexp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `controle`
--

DROP TABLE IF EXISTS `controle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `controle` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código da legenda de controle.',
  `descricao` char(24) NOT NULL COMMENT 'Descrição do Controle.',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Tabela de Legenda de Controle de Descrição de Ambiente, Mate';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `controle`
--

LOCK TABLES `controle` WRITE;
/*!40000 ALTER TABLE `controle` DISABLE KEYS */;
INSERT INTO `controle` VALUES (1,'Não Controlado'),(2,'Programado'),(3,'Relatório Externo');
/*!40000 ALTER TABLE `controle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coordenador`
--

DROP TABLE IF EXISTS `coordenador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coordenador` (
  `codigousp` int(11) NOT NULL COMMENT 'Código do Coordenador na USP (pessoal.pessoa)',
  `chefe` int(11) DEFAULT NULL COMMENT 'Código USP do chefe/orientador',
  `pa` int(11) NOT NULL COMMENT 'Privilegio de Acesso',
  `data` datetime NOT NULL COMMENT 'Data do Cadastramento do Coordenador',
  PRIMARY KEY (`codigousp`),
  CONSTRAINT `coordenaproj_fk` FOREIGN KEY (`codigousp`) REFERENCES `pessoal`.`pessoa` (`codigousp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Coordenador de Projeto (Privilegio de Acesso = Administrador';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coordenador`
--

LOCK TABLES `coordenador` WRITE;
/*!40000 ALTER TABLE `coordenador` DISABLE KEYS */;
/*!40000 ALTER TABLE `coordenador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `copiaprojeto`
--

DROP TABLE IF EXISTS `copiaprojeto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `copiaprojeto` (
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
  KEY `chefe` (`chefe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabela dos Títulos dos Projetos.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `copiaprojeto`
--

LOCK TABLES `copiaprojeto` WRITE;
/*!40000 ALTER TABLE `copiaprojeto` DISABLE KEYS */;
/*!40000 ALTER TABLE `copiaprojeto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `corespproj`
--

DROP TABLE IF EXISTS `corespproj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `corespproj` (
  `projetoautor` int(11) NOT NULL COMMENT 'Código do Autor Responsável do Projeto.',
  `projnum` int(11) NOT NULL COMMENT 'Número do Projeto do respectivo autor',
  `coresponsavel` int(11) NOT NULL COMMENT 'Código (matricula USP) do co-responsavel pelo projeto.',
  KEY `coautor` (`coresponsavel`),
  KEY `projnum` (`projnum`),
  KEY `projetoautor` (`projetoautor`,`projnum`),
  CONSTRAINT `corespproj_fk` FOREIGN KEY (`projetoautor`, `projnum`) REFERENCES `projeto` (`autor`, `numprojeto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `corespproj_fk1` FOREIGN KEY (`coresponsavel`) REFERENCES `pessoal`.`pessoa` (`codigousp`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabela de coautores do projeto.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `corespproj`
--

LOCK TABLES `corespproj` WRITE;
/*!40000 ALTER TABLE `corespproj` DISABLE KEYS */;
/*!40000 ALTER TABLE `corespproj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cpcorespproj`
--

DROP TABLE IF EXISTS `cpcorespproj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cpcorespproj` (
  `projetoautor` int(11) NOT NULL COMMENT 'Código do Autor Responsável do Projeto.',
  `projnum` int(11) NOT NULL COMMENT 'Número do Projeto do respectivo autor',
  `coresponsavel` int(11) NOT NULL COMMENT 'Código (matricula USP) do co-responsavel pelo projeto.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cpcorespproj`
--

LOCK TABLES `cpcorespproj` WRITE;
/*!40000 ALTER TABLE `cpcorespproj` DISABLE KEYS */;
INSERT INTO `cpcorespproj` VALUES (999999,1,-79),(999999,1,2416911),(2416911,1,2416911),(2416911,1,740232);
/*!40000 ALTER TABLE `cpcorespproj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experimento`
--

DROP TABLE IF EXISTS `experimento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experimento` (
  `ciexp` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código de Identificação de Experimento',
  `instituicao` char(16) DEFAULT NULL COMMENT 'Código da Instituição de Pesquisas.',
  `unidade` char(16) DEFAULT NULL COMMENT 'Identificação da Unidade.',
  `depto` char(16) DEFAULT NULL COMMENT 'Identificação do Depto.',
  `setor` char(16) DEFAULT NULL COMMENT 'Identificação do Setor de Pesquisas.',
  `bloco` char(16) DEFAULT NULL COMMENT 'Identificação do Bloco Predial.',
  `sala` char(16) DEFAULT NULL COMMENT 'Identificação da Sala - Laboratório.',
  `autor` int(11) NOT NULL COMMENT 'Autor do Experimento. Pessoa Responsável pela realização do Experimento.',
  `supervisor` int(11) DEFAULT NULL COMMENT 'Supervisor/Orientador do autor/executor do experimento.',
  `projeto` int(11) NOT NULL COMMENT 'Código do Projeto de Pesquisa.',
  `expnum` int(11) DEFAULT NULL COMMENT 'Número Sequencial do Experimento do Projeto (CIP).',
  `tituloexp` varchar(96) NOT NULL COMMENT 'Título do Experimento.',
  `continuacao` int(11) NOT NULL COMMENT 'Indicador de continuação do experimento. Código (ciexp) do experimento anterior. Zero se não for continuação.',
  `datainicio` datetime NOT NULL COMMENT 'Data de Inicio do Experimento',
  `datafinal` datetime NOT NULL COMMENT 'Data Final do Experimento',
  `colabs` int(11) NOT NULL COMMENT 'Número de colaboradores (co-autores) do experimento.',
  `testemunha1` int(11) DEFAULT NULL COMMENT 'Código da Testemunha (1) da realização do experimento.',
  `testemunha2` int(11) DEFAULT NULL COMMENT 'Código da testemunha (2) da realização do experimento.',
  `ambiente` int(11) DEFAULT NULL COMMENT 'Indicador de controle de ambiente (temperatura, Condições do Recinto, dos Equipamentos, Materiais, etc). Legenda: 0-Não controlado; 1=Controle Programado; 2=Controle em Relatório Externo do Experimento',
  `material` int(11) DEFAULT NULL COMMENT 'Indicador de Descritivo de Material usado no experimento. Legenda: 0-Não controlado; 1=Controle Programado; 2=Controle em Relatório Externo do Experimento',
  `metodo` int(11) DEFAULT NULL COMMENT 'Indicador de Descrição do Método usado. Legenda: 0-Não controlado; 1=Controle Programado; 2=Controle em Relatório Externo do Experimento',
  `resultado` int(11) NOT NULL COMMENT 'Indicador de êxito do experimento (1-Insatisfatório, 2-Inconclusivo, 3-Regular, 4-Bom e 5-Excelente)',
  `finalizado` int(11) NOT NULL COMMENT 'Indicador de finalização do experimento.',
  `relatext` varchar(96) DEFAULT NULL COMMENT 'Link do arquivo que contem o relatório externo do experimento (Detalhamento)',
  PRIMARY KEY (`ciexp`),
  KEY `autor` (`autor`),
  KEY `projeto` (`projeto`),
  KEY `testemunha1` (`testemunha1`),
  KEY `testemunha2` (`testemunha2`),
  KEY `ambiente` (`ambiente`),
  KEY `metodo` (`metodo`),
  KEY `resultado` (`resultado`),
  KEY `material` (`material`),
  KEY `projeto_2` (`projeto`,`expnum`),
  CONSTRAINT `experimento_fk1` FOREIGN KEY (`projeto`) REFERENCES `projeto` (`cip`),
  CONSTRAINT `experimento_fk2` FOREIGN KEY (`testemunha1`) REFERENCES `pessoal`.`pessoa` (`codigousp`),
  CONSTRAINT `experimento_fk3` FOREIGN KEY (`testemunha2`) REFERENCES `pessoal`.`pessoa` (`codigousp`),
  CONSTRAINT `experimento_fk4` FOREIGN KEY (`ambiente`) REFERENCES `controle` (`codigo`),
  CONSTRAINT `experimento_fk5` FOREIGN KEY (`material`) REFERENCES `controle` (`codigo`),
  CONSTRAINT `experimento_fk6` FOREIGN KEY (`metodo`) REFERENCES `controle` (`codigo`),
  CONSTRAINT `experimento_fk7` FOREIGN KEY (`resultado`) REFERENCES `resultado` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabela de Registro de Experimento. Cada experimento deve cor';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experimento`
--

LOCK TABLES `experimento` WRITE;
/*!40000 ALTER TABLE `experimento` DISABLE KEYS */;
/*!40000 ALTER TABLE `experimento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_novo`
--

DROP TABLE IF EXISTS `login_novo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_novo` (
  `id` bigint(20) NOT NULL DEFAULT '0',
  `md5_id` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `nome` varchar(255) NOT NULL COMMENT 'NOme',
  `usuario` varchar(20) NOT NULL COMMENT 'Usuario/Login',
  `e_mail` varchar(200) NOT NULL COMMENT 'Endereco eletronico',
  `user_level` tinyint(4) NOT NULL DEFAULT '1',
  `senha` varchar(100) NOT NULL COMMENT 'Senha',
  `address` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pais` varchar(100) NOT NULL COMMENT 'Pais',
  `fone` varchar(100) NOT NULL COMMENT 'Telefone',
  `fax` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `website` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `datahora` datetime NOT NULL COMMENT 'Data e Hora',
  `users_ip` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `approved` int(1) NOT NULL DEFAULT '0',
  `activation_code` int(10) NOT NULL DEFAULT '0',
  `banned` int(1) NOT NULL DEFAULT '0',
  `ckey` varchar(220) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `ctime` varchar(220) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  UNIQUE KEY `user_name` (`usuario`),
  UNIQUE KEY `full_name` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_novo`
--

LOCK TABLES `login_novo` WRITE;
/*!40000 ALTER TABLE `login_novo` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_novo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `objetivo`
--

DROP TABLE IF EXISTS `objetivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `objetivo` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código do Objetivo do Projeto.',
  `descricao` char(32) NOT NULL COMMENT 'Descrição do objetivo do projeto.',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Tabela de códigos de objetivo do projeto.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `objetivo`
--

LOCK TABLES `objetivo` WRITE;
/*!40000 ALTER TABLE `objetivo` DISABLE KEYS */;
INSERT INTO `objetivo` VALUES (1,'TCC de Graduação'),(2,'Mestrado'),(3,'Doutorado'),(4,'Adjunto'),(5,'Titular'),(6,'Temático'),(7,'Pesquisas Diversas'),(8,'Outro');
/*!40000 ALTER TABLE `objetivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pa`
--

DROP TABLE IF EXISTS `pa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pa` (
  `codigo` int(11) NOT NULL COMMENT 'Código indicando o Privilégio de Acesso aos Procedimento do REXP',
  `descricao` char(48) DEFAULT NULL COMMENT 'Descrição do Código que indica o Privilégio de Acesso aos Procedimento do REXP',
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabela de Codificação de Privilégio de Acesso aos Procedimen';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pa`
--

LOCK TABLES `pa` WRITE;
/*!40000 ALTER TABLE `pa` DISABLE KEYS */;
INSERT INTO `pa` VALUES (0,'Super-Usuário/Administrador'),(10,'Chefe de Departamento'),(15,'Vice-chefe de Departamento'),(20,'Aprovador'),(30,'Orientador de Projeto'),(50,'Anotador de Projeto');
/*!40000 ALTER TABLE `pa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participante`
--

DROP TABLE IF EXISTS `participante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participante` (
  `usuario_ci` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código Sequencial único de usuário do REXP',
  `codigousp` int(11) NOT NULL COMMENT 'Código USP do usuário do rexp',
  `datacad` date DEFAULT NULL COMMENT 'Data do cadastro como usuário do REXP',
  `datavalido` date DEFAULT NULL COMMENT 'Data de Validade desse cadastro',
  `pa` int(11) NOT NULL COMMENT 'Privilegio de Acesso - Define o tipo de permissão: Chefe/Supervisor, Coordenador, Anotador, etc',
  `codigo_ativa` int(11) DEFAULT NULL COMMENT 'Código de Ativação do acesso desse participante',
  `aprovado` int(11) DEFAULT NULL COMMENT 'Código de aprovação do acesso pelo Coordenador',
  `chefe` int(11) DEFAULT NULL COMMENT 'Código USP do chefe',
  UNIQUE KEY `usuario_ci` (`usuario_ci`),
  KEY `chefe` (`chefe`),
  KEY `pa` (`pa`),
  KEY `codigousp` (`codigousp`),
  CONSTRAINT `participante_fk` FOREIGN KEY (`codigousp`) REFERENCES `pessoal`.`pessoa` (`codigousp`) ON DELETE CASCADE,
  CONSTRAINT `usuario_pa_fk` FOREIGN KEY (`pa`) REFERENCES `pa` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COMMENT='Tabela dos autores (realizadores) de experimento por PA';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participante`
--

LOCK TABLES `participante` WRITE;
/*!40000 ALTER TABLE `participante` DISABLE KEYS */;
INSERT INTO `participante` VALUES (1,70253,'2011-06-09','2031-12-31',30,159133,1,NULL),(2,740232,'2007-09-21','2054-12-31',10,NULL,1,NULL),(3,740232,'2011-09-15','2013-12-31',50,969252,0,NULL),(4,740232,'2011-09-01','2013-12-31',30,326472,1,NULL),(6,2416911,'2011-08-30','2031-12-31',50,648820,1,NULL),(7,2416911,'2007-09-21','2066-12-31',10,NULL,1,NULL),(8,2640401,'2011-09-12','2013-12-31',50,942448,0,NULL),(9,2416911,'2012-02-27','2014-12-31',30,547321,0,0),(10,70253,'2012-03-01','2014-12-31',10,189240,1,NULL),(11,1689081,'2017-01-31','2019-01-31',50,2416911,1,0);
/*!40000 ALTER TABLE `participante` ENABLE KEYS */;
UNLOCK TABLES;

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
/*!40000 ALTER TABLE `projeto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projetocopia`
--

DROP TABLE IF EXISTS `projetocopia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projetocopia` (
  `cip` int(11) NOT NULL DEFAULT '0' COMMENT 'Código do Identificação do Projeto',
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
  `anotacao` int(11) NOT NULL COMMENT 'Código Sequencial da Anotação '
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projetocopia`
--

LOCK TABLES `projetocopia` WRITE;
/*!40000 ALTER TABLE `projetocopia` DISABLE KEYS */;
INSERT INTO `projetocopia` VALUES (6,'Projeto número 1 - modificado novamente - OK',7,2416911,1,NULL,1,'FAPESP','1234567','2015-03-01 00:00:00','2017-04-01 00:00:00','P1_Incrementando_o_Shell_com_ER.pdf',2),(12,'Projeto 2 - hoje',3,2416911,2,NULL,1,'CAPES','33557791','2015-09-26 00:00:00','2017-09-26 00:00:00','P2_Projeto 2  Apresentação Programação Nova  - Cópia.pdf',0);
/*!40000 ALTER TABLE `projetocopia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resultado`
--

DROP TABLE IF EXISTS `resultado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resultado` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código do Resultado.',
  `descricao` char(24) NOT NULL COMMENT 'Descrição qualitativa do Resultado.',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Tabela de Indicação do Resultado do Experimento.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resultado`
--

LOCK TABLES `resultado` WRITE;
/*!40000 ALTER TABLE `resultado` DISABLE KEYS */;
INSERT INTO `resultado` VALUES (1,'Insatisfatório'),(2,'Inconclusivo'),(3,'Regular'),(4,'Bom'),(5,'Excelente');
/*!40000 ALTER TABLE `resultado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_alterar_anotacao`
--

DROP TABLE IF EXISTS `temp_alterar_anotacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_alterar_anotacao` (
  `nr` bigint(21) DEFAULT NULL,
  `NA` int(11) NOT NULL COMMENT 'Número Sequencial do Experimento/Anotação do Projeto (CIP).',
  `titulo` varchar(254) NOT NULL DEFAULT '' COMMENT 'Título da Anotação.',
  `Autor` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nome da Pessoa',
  `projeto_titulo` varchar(254) NOT NULL COMMENT 'Titulo do Projeto.',
  `data` varbinary(10) NOT NULL DEFAULT '',
  `Detalhes` varbinary(13) NOT NULL DEFAULT '',
  `Arquivo` varchar(96) DEFAULT NULL COMMENT 'Link do arquivo que contem o relatório externo do experimento (Detalhamento)',
  `projeto_autor` int(11) NOT NULL COMMENT 'Código do Autor Principal/Responsável pelo projeto.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_alterar_anotacao`
--

LOCK TABLES `temp_alterar_anotacao` WRITE;
/*!40000 ALTER TABLE `temp_alterar_anotacao` DISABLE KEYS */;
INSERT INTO `temp_alterar_anotacao` VALUES (1,1,'Anotação 1 do Projeto número 1 - teste agora teste de novo','Sebastião Paulo Framartino Bezerra','Projeto número 1 - modificado novamente - OK','08/05/2018','6#1','P1A1_Capitulo1.pdf',2416911),(2,2,'Anotação 2 do Projeto número 1 - segunda anotação.','Sebastião Paulo Framartino Bezerra','Projeto número 1 - modificado novamente - OK','08/05/2018','6#2','P1A2_Capitulo2.pdf',2416911);
/*!40000 ALTER TABLE `temp_alterar_anotacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_alterar_projeto`
--

DROP TABLE IF EXISTS `temp_alterar_projeto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_alterar_projeto` (
  `nr` bigint(21) DEFAULT NULL,
  `NP` int(11) DEFAULT NULL COMMENT 'Número sequencial de projetos do respectivo responsável (autor)\r\n',
  `Titulo` varchar(80) NOT NULL DEFAULT '',
  `objetivo_descricao` varchar(32) DEFAULT NULL,
  `Fonte_Recurso` char(16) DEFAULT NULL COMMENT 'Fonte de Recurso (Proprio, FAPESP, CNPQ, etc)',
  `Identificacao` char(24) DEFAULT NULL COMMENT 'Identificação do Projeto na Fonte de Recursos.',
  `inicio` varbinary(10) DEFAULT NULL,
  `final` varbinary(10) DEFAULT NULL,
  `Coresp` int(11) DEFAULT NULL COMMENT 'Número de co-responsaveis do Projeto.',
  `anotacao` int(11) NOT NULL COMMENT 'Código Sequencial da Anotação ',
  `cip` int(11) NOT NULL DEFAULT '0' COMMENT 'Código do Identificação do Projeto'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_alterar_projeto`
--

LOCK TABLES `temp_alterar_projeto` WRITE;
/*!40000 ALTER TABLE `temp_alterar_projeto` DISABLE KEYS */;
INSERT INTO `temp_alterar_projeto` VALUES (1,1,'Projeto número 1 - modificado novamente - OK','Pesquisas Diversas','FAPESP','1234567','01/03/2015','01/04/2017',1,2,6),(2,2,'Projeto 2 - hoje','Doutorado','CAPES','33557791','26/09/2015','26/09/2017',1,0,12);
/*!40000 ALTER TABLE `temp_alterar_projeto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_consultar_anotacao`
--

DROP TABLE IF EXISTS `temp_consultar_anotacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_consultar_anotacao` (
  `nr` bigint(21) DEFAULT NULL,
  `na` int(11) NOT NULL COMMENT 'Número Sequencial do Experimento/Anotação do Projeto (CIP).',
  `titulo` varchar(254) NOT NULL DEFAULT '' COMMENT 'Título da Anotação.',
  `Autor` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nome da Pessoa',
  `projeto_titulo` varchar(254) NOT NULL COMMENT 'Titulo do Projeto.',
  `data` varbinary(10) NOT NULL DEFAULT '',
  `Detalhes` varbinary(13) NOT NULL DEFAULT '',
  `Arquivo` varchar(96) DEFAULT NULL COMMENT 'Link do arquivo que contem o relatório externo do experimento (Detalhamento)',
  `projeto_autor` int(11) NOT NULL COMMENT 'Código do Autor Principal/Responsável pelo projeto.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_consultar_anotacao`
--

LOCK TABLES `temp_consultar_anotacao` WRITE;
/*!40000 ALTER TABLE `temp_consultar_anotacao` DISABLE KEYS */;
INSERT INTO `temp_consultar_anotacao` VALUES (1,1,'Anotação 1 do Projeto número 1 - teste agora teste de novo','Sebastião Paulo Framartino Bezerra','Projeto número 1 - modificado novamente - OK','08/05/2018','6#1','P1A1_Capitulo1.pdf',2416911),(2,2,'Anotação 2 do Projeto número 1 - segunda anotação.','Sebastião Paulo Framartino Bezerra','Projeto número 1 - modificado novamente - OK','08/05/2018','6#2','P1A2_Capitulo2.pdf',2416911);
/*!40000 ALTER TABLE `temp_consultar_anotacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_consultar_anotador`
--

DROP TABLE IF EXISTS `temp_consultar_anotador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_consultar_anotador` (
  `nr` bigint(21) DEFAULT NULL,
  `na` int(11) NOT NULL COMMENT 'Número Sequencial do Experimento/Anotação do Projeto (CIP).',
  `Anotador` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nome da Pessoa',
  `Titulo_Anotacao` varchar(254) NOT NULL DEFAULT '' COMMENT 'Título da Anotação.',
  `projeto_titulo` varchar(254) NOT NULL COMMENT 'Titulo do Projeto.',
  `Detalhes` varbinary(13) NOT NULL DEFAULT '',
  `anotadorcod` int(11) NOT NULL COMMENT 'Autor do Experimento. Pessoa Responsável pela realização do Experimento.',
  `Data` varbinary(10) NOT NULL DEFAULT '',
  `Arquivo` varchar(96) DEFAULT NULL COMMENT 'Link do arquivo que contem o relatório externo do experimento (Detalhamento)',
  `projeto_autor` int(11) NOT NULL COMMENT 'Código do Autor Principal/Responsável pelo projeto.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_consultar_anotador`
--

LOCK TABLES `temp_consultar_anotador` WRITE;
/*!40000 ALTER TABLE `temp_consultar_anotador` DISABLE KEYS */;
INSERT INTO `temp_consultar_anotador` VALUES (1,2,'Sebastião Paulo Framartino Bezerra','Anotação 2 do Projeto número 1 - segunda anotação.','Projeto número 1 - modificado novamente - OK','6#2',2416911,'08/05/2018','P1A2_Capitulo2.pdf',2416911),(2,1,'Sebastião Paulo Framartino Bezerra','Anotação 1 do Projeto número 1 - teste agora teste de novo','Projeto número 1 - modificado novamente - OK','6#1',2416911,'08/05/2018','P1A1_Capitulo1.pdf',2416911);
/*!40000 ALTER TABLE `temp_consultar_anotador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_consultar_projeto`
--

DROP TABLE IF EXISTS `temp_consultar_projeto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_consultar_projeto` (
  `nr` bigint(21) DEFAULT NULL,
  `np` int(11) DEFAULT NULL COMMENT 'Número sequencial de projetos do respectivo responsável (autor)\r\n',
  `Titulo` varchar(254) NOT NULL COMMENT 'Titulo do Projeto.',
  `Data` varbinary(10) DEFAULT NULL,
  `codautor` int(11) NOT NULL COMMENT 'Código do Autor Principal/Responsável pelo projeto.',
  `Autor` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nome da Pessoa',
  `Detalhes` int(11) NOT NULL DEFAULT '0' COMMENT 'Código do Identificação do Projeto',
  `Arquivo` char(96) DEFAULT NULL COMMENT 'link para o Relatório Externo do Projeto.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_consultar_projeto`
--

LOCK TABLES `temp_consultar_projeto` WRITE;
/*!40000 ALTER TABLE `temp_consultar_projeto` DISABLE KEYS */;
INSERT INTO `temp_consultar_projeto` VALUES (1,1,'Projeto número 1 - modificado novamente - OK','01/03/2015',2416911,'Sebastião Paulo Framartino Bezerra',6,'P1_Incrementando_o_Shell_com_ER.pdf'),(2,2,'Projeto 2 - hoje','26/09/2015',2416911,'Sebastião Paulo Framartino Bezerra',12,'P2_Projeto 2  Apresentação Programação Nova  - Cópia.pdf');
/*!40000 ALTER TABLE `temp_consultar_projeto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_remover_anotacao`
--

DROP TABLE IF EXISTS `temp_remover_anotacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_remover_anotacao` (
  `nr` bigint(21) DEFAULT NULL,
  `cia` int(11) NOT NULL COMMENT 'Número Sequencial do Experimento/Anotação do Projeto (CIP).',
  `titulo` varchar(254) NOT NULL DEFAULT '' COMMENT 'Título da Anotação.',
  `data` varbinary(10) NOT NULL DEFAULT '',
  `Alterada` int(11) DEFAULT NULL COMMENT 'Número da anotação que altera essa (atual).'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_remover_anotacao`
--

LOCK TABLES `temp_remover_anotacao` WRITE;
/*!40000 ALTER TABLE `temp_remover_anotacao` DISABLE KEYS */;
INSERT INTO `temp_remover_anotacao` VALUES (1,1,'Anotação 1 do Projeto número 1 - teste agora teste de novo','08/05/2018',NULL),(2,2,'Anotação 2 do Projeto número 1 - segunda anotação.','08/05/2018',NULL);
/*!40000 ALTER TABLE `temp_remover_anotacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_remover_projeto`
--

DROP TABLE IF EXISTS `temp_remover_projeto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_remover_projeto` (
  `nr` bigint(21) DEFAULT NULL,
  `np` int(11) DEFAULT NULL COMMENT 'Número sequencial de projetos do respectivo responsável (autor)\r\n',
  `titulo` varchar(254) NOT NULL COMMENT 'Titulo do Projeto.',
  `codautor` int(11) NOT NULL COMMENT 'Código do Autor Principal/Responsável pelo projeto.',
  `Autor` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nome da Pessoa',
  `Data` varbinary(10) DEFAULT NULL,
  `cip` int(11) NOT NULL DEFAULT '0' COMMENT 'Código do Identificação do Projeto',
  `Arquivo` char(96) DEFAULT NULL COMMENT 'link para o Relatório Externo do Projeto.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_remover_projeto`
--

LOCK TABLES `temp_remover_projeto` WRITE;
/*!40000 ALTER TABLE `temp_remover_projeto` DISABLE KEYS */;
INSERT INTO `temp_remover_projeto` VALUES (1,2,'Projeto 2 - hoje',2416911,'Sebastião Paulo Framartino Bezerra','26/09/2015',12,'P2_Projeto 2  Apresentação Programação Nova  - Cópia.pdf'),(2,1,'Projeto número 1 - modificado novamente - OK',2416911,'Sebastião Paulo Framartino Bezerra','01/03/2015',6,'P1_Incrementando_o_Shell_com_ER.pdf');
/*!40000 ALTER TABLE `temp_remover_projeto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_remover_usuario`
--

DROP TABLE IF EXISTS `temp_remover_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_remover_usuario` (
  `cod` int(9) NOT NULL COMMENT 'Código (Matricula) do Usuário na USP',
  `nome` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nome da Pessoa',
  `categoria` char(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Categoria Funcional',
  `E_Mail` char(64) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'E_mail',
  `cargo` char(48) DEFAULT NULL COMMENT 'Descrição do Código que indica o Privilégio de Acesso aos Procedimento do REXP'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_remover_usuario`
--

LOCK TABLES `temp_remover_usuario` WRITE;
/*!40000 ALTER TABLE `temp_remover_usuario` DISABLE KEYS */;
INSERT INTO `temp_remover_usuario` VALUES (70253,'Aguinaldo Luiz Simões','DOC','alsimoes@fmrp.usp.br','Orientador de Projeto'),(999999,'José Fulano','FNM','spaulfb@hotmail.com','Orientador de Projeto'),(740232,'Luiz Antonio Framartino Bezerra','DOC','lafbezer@fmrp.usp.br','Chefe de Departamento');
/*!40000 ALTER TABLE `temp_remover_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'rexp'
--
/*!50003 DROP FUNCTION IF EXISTS `acentos_upper` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`soldbm`@`sol.fmrp.usp.br` FUNCTION `acentos_upper`(campo  VARCHAR(255)) RETURNS varchar(255) CHARSET latin1
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-04 10:06:18
