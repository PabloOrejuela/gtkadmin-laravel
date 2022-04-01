-- MySQL dump 10.19  Distrib 10.3.34-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: gtkecuad_teruso
-- ------------------------------------------------------
-- Server version	10.3.34-MariaDB-0ubuntu0.20.04.1

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
-- Table structure for table `accesos`
--

DROP TABLE IF EXISTS `accesos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accesos` (
  `idacceso` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` timestamp NULL DEFAULT NULL,
  `pin` char(6) DEFAULT NULL,
  `expira` varchar(15) DEFAULT NULL,
  `idsocio` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idacceso`),
  KEY `fk_accesos_socios` (`idsocio`),
  CONSTRAINT `fk_accesos_socios` FOREIGN KEY (`idsocio`) REFERENCES `socios` (`idsocio`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accesos`
--

LOCK TABLES `accesos` WRITE;
/*!40000 ALTER TABLE `accesos` DISABLE KEYS */;
/*!40000 ALTER TABLE `accesos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agenda`
--

DROP TABLE IF EXISTS `agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agenda` (
  `idagenda` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` datetime DEFAULT NULL,
  `lugar` varchar(120) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idagenda`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda`
--

LOCK TABLES `agenda` WRITE;
/*!40000 ALTER TABLE `agenda` DISABLE KEYS */;
/*!40000 ALTER TABLE `agenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banco`
--

DROP TABLE IF EXISTS `banco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banco` (
  `idbanco` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `banco` varchar(80) NOT NULL,
  PRIMARY KEY (`idbanco`)
) ENGINE=InnoDB AUTO_INCREMENT=167 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banco`
--

LOCK TABLES `banco` WRITE;
/*!40000 ALTER TABLE `banco` DISABLE KEYS */;
INSERT INTO `banco` VALUES (1,'AMAZONAS'),(2,'AUSTRO'),(3,'BANCO CAPITAL'),(4,'BANCO CENTRAL'),(5,'BANCO D MIRO SA'),(6,'BANCO PARA LA ASISTENCIA COMUNITARIA FINCA S.A.'),(7,'BANCO PROCREDIT'),(8,'BANECUADOR B.P.'),(9,'BOLIVARIANO'),(10,'CITIBANK'),(11,'COMERCIAL DE MANABI'),(12,'COOP  DE AHORRO Y CREDITO LA MERCED LTDA'),(13,'COOP A Y C CADECOG GONZANAMA'),(14,'COOP A Y C ESPERANZA Y PROGRESO DEL VALLE'),(15,'COOP A Y C PROFUTURO LTDA'),(16,'COOP A Y C UNION EL EJIDO'),(17,'COOP A Y C VILCABAMBA CACVIL'),(18,'COOP AH Y CR ANDINA LTDA'),(19,'COOP AH Y CR COCA LTDA'),(20,'COOP AH Y CR CREDIAMIGO'),(21,'Coop Ah y Cr de la Pequena Empresa de Loja CACPE L'),(22,'COOP AH Y CR EDUCADORES DE PASTAZA LTDA'),(23,'COOP AH Y CR POLICIA NACIONAL'),(24,'COOP AH Y CR SAN ANTONIO LTDA.'),(25,'Coop Ah y Credito Ambato Ltda'),(26,'COOP AH Y CRJUAN PIO MORA LTDA'),(27,'COOP AHO Y CRED EDUCADORES DE CHIMBORAZO'),(28,'COOP AHO Y CREDITO  MANUEL GODOY'),(29,'COOP AHO Y CREDITO DESARROLLO PUEBLOS'),(30,'COOP AHO Y CREDITO SAN JOSE'),(31,'COOP AHO Y CREDITO SANTA ROSA'),(32,'COOP AHORRO Y CREDI MUJERES UNIDAS TANTANAKUSHKA W'),(33,'COOP AHORRO Y CREDITO SAN GABRIEL LTDA'),(34,'COOP AHORRO Y CREDITO SAN ISIDRO LTDA'),(35,'COOP DE A Y C FUTURO LAMANENSE'),(36,'COOP DE A Y C SAN JUAN DE COTOGCHOA'),(37,'COOP DE A Y C SANTA ANA DE NAYON'),(38,'COOP DE A Y CR CORPORACION CENTRO LTDA'),(39,'COOP DE A. Y C. ANTORCHA LTDA'),(40,'COOP DE AH Y CR AGRICOLA JUNIN LTDA'),(41,'COOP DE AH Y CR CONSTRUCCION COMERCIO Y PRODUCCION'),(42,'COOP DE AH Y CR DE SERV PUBLIC MINISTERIO EDUC Y C'),(43,'COOP DE AH Y CR ERCO LTDA.'),(44,'COOP DE AH Y CR GUACHAPALA LTDA'),(45,'COOP DE AH Y CR NUEVA ESPERANZA'),(46,'COOP DE AHO Y CRED SAN MIGUEL DE LOS BANCOS'),(47,'COOP DE AHORRO Y CREDITO DE LA PEQUENA EMPRESA DE '),(48,'COOP DE AHORRO Y CREDITO PROVIDA'),(49,'COOP DE AHORRO Y CREDITO SANTA ISABEL LTDA'),(50,'COOP. 29 DE OCTUBRE'),(51,'COOP. A Y C DE LA PEQ. EMP. CACPE ZAMORA LTDA.'),(52,'COOP. AH Y CR NUEVOS HORIZONTES EL ORO LTDA'),(53,'COOP. AHO Y CRED ALIANZA MINAS LTDA.'),(54,'COOP. AHO Y CREDITO 23 DE JULIO'),(55,'COOP. AHO Y CREDITO EL SAGRARIO'),(56,'COOP. AHO Y CREDITO JARDIN AZUAYO'),(57,'COOP. AHO Y CREDITO NACIONAL'),(58,'COOP. AHO Y CREDITO SAN FRANCISCO'),(59,'COOP. AHO Y CREDITO SANTA ANA'),(60,'COOP. AHORRO Y CREDITO 15 DE ABRIL LTDA'),(61,'COOP. AHORRO Y CREDITO AGRARIA MUSHUK KAWSAY LTDA.'),(62,'COOP. AHORRO Y CREDITO CARIAMANGA LTDA.'),(63,'COOP. AHORRO Y CREDITO COOPROGRESO'),(64,'COOP. AHORRO Y CREDITO DE LA PEQUENA EMPRESA GUALA'),(65,'COOP. AHORRO Y CREDITO FUNDESARROLLO'),(66,'COOP. AHORRO Y CREDITO JUAN DE SALINAS LTDA.'),(67,'COOP. AHORRO Y CREDITO MALCHINGUI LTDA.'),(68,'COOP. AHORRO Y CREDITO MANANTIAL DE ORO LTDA.'),(69,'COOP. AHORRO Y CREDITO MI TIERRA'),(70,'COOP. AHORRO Y CREDITO NUEVA JERUSALEN'),(71,'COOP. AHORRO Y CREDITO PUELLARO LTDA'),(72,'COOP. AHORRO Y CREDITO SEMILLA DEL PROGRESO LTDA.'),(73,'COOP. AHORRO Y CREDITO TENA LTDA.'),(74,'COOP. ALIANZA DEL VALLE LTDA.'),(75,'COOP. ANDALUCIA'),(76,'COOP. ATUNTAQUI'),(77,'COOP. CACPECO'),(78,'COOP. CALCETA LTDA.'),(79,'COOP. CHONE LTDA.'),(80,'COOP. COMERCIO LTDA PORTOVIEJO'),(81,'COOP. COTOCOLLAO'),(82,'COOP. DE A Y C GUAMOTE LTDA'),(83,'COOP. DE A Y C. LUZ DEL VALLE'),(84,'COOP. DE A. Y C. 13 DE ABRIL LTDA'),(85,'COOP. DE A. Y C. 16 DE JUNIO'),(86,'COOP. DE A. Y C. 20 DE FEBRERO LTDA.'),(87,'COOP. DE A. Y C. 23 DE MAYO LTDA.'),(88,'COOP. DE A. Y C. ABDON CALDERON LTDA.'),(89,'COOP. DE A. Y C. CAMARA DE COMERCIO SANTO DOMINGO'),(90,'COOP. DE A. Y C. CHIBULEO LTDA.'),(91,'COOP. DE A. Y C. COOPAC AUSTRO LTDA -MIESS'),(92,'COOP. DE A. Y C. CREDISOCIO'),(93,'COOP. DE A. Y C. ESCENCIA INDIGENA LTDA.'),(94,'COOP. DE A. Y C. LUCHA CAMPESINA LTDA.'),(95,'COOP. DE A. Y C. MAQUITA CUSHUNCHIC LTDA.'),(96,'COOP. DE AH Y CR 1 DE JULIO'),(97,'COOP. DE AH Y CR CACEC LTDA. COTOPAXI'),(98,'COOP. DE AH Y CR CACPE CELICA'),(99,'COOP. DE AH Y CR CAMARA DE COMERCIO RIOBAMBA'),(100,'COOP. DE AH Y CR FOCLA'),(101,'COOP. DE AH Y CR FORTALEZA'),(102,'COOP. DE AH Y CR FORTUNA - MIES'),(103,'COOP. DE AH Y CR INDIGENA SAC LTDA'),(104,'COOP. DE AH Y CR LA INMACULADA DE SAN PLACIDO LTDA'),(105,'COOP. DE AH Y CR MAGISTERIO MANABITA LIMITADA'),(106,'COOP. DE AH Y CR MASCOOP'),(107,'COOP. DE AH Y CR ONCE DE JUNIO'),(108,'COOP. DE AH Y CR SANTA LUCIA LTDA'),(109,'COOP. DE AH Y CR TEXTIL 14 DE MARZO'),(110,'COOP. DE AHORRO Y CREDITO 4 DE OCTUBRE LTDA.'),(111,'COOP. DE AHORRO Y CREDITO DE LA PEQ. EMP. CACPE YA'),(112,'COOP. DE AHORRO Y CREDITO HUAICANA LTDA'),(113,'COOP. DE AHORRO Y CREDITO LOS ANDES LATINOS LTDA.'),(114,'COOP. DE AHORRO Y CREDITO MUSHUC RUNA LTDA.'),(115,'COOP. DE AHORRO Y CREDITO NUEVA HUANCAVILCA LTDA.'),(116,'COOP. DE AHORRO Y CREDITO PEDRO MONCAYO LTDA.'),(117,'COOP. DE AHORRO Y CREDITO PILAHUIN TIO LTDA.'),(118,'COOP. DE AHORRO Y CREDITO SAN FRANCISCO DE ASIS LT'),(119,'COOP. DE AHORRO Y CREDITO SAN MIGUEL DE PALLATANGA'),(120,'COOP. DE AHORRO Y CREDITO SR. DE GIRON'),(121,'COOP. GUARANDA'),(122,'COOP. JUVENTUD ECUATORIANA PROGRESISTA LTDA.'),(123,'COOP. LA DOLOROSA'),(124,'COOP. OSCUS'),(125,'COOP. PABLO MUNOZ VEGA'),(126,'COOP. PEQ. EMPRESA DE PASTAZA'),(127,'COOP. PREVISION AHORRO Y DESARROLLO'),(128,'COOP. RIOBAMBA'),(129,'COOP. TULCAN'),(130,'COOP.DE AHORRO Y CREDITO HUAYCO PUNGO LTDA.'),(131,'COOP.DE AHORRO Y CREDITO MICROEMPRESARIAL SUCRE'),(132,'COOPE AHO Y CRED PADRE JULIAN LORENTE LTDA'),(133,'COOPE.CAMARA DE COMERCIO DE AMBATO'),(134,'COOPERATIVA 9 DE OCTUBRE LTDA'),(135,'COOPERATIVA CACPE BIBLIAN LTDA'),(136,'COOPERATIVA DE AHORO Y CREDITO VISION DE LOS ANDES'),(137,'COOPERATIVA DE AHORRO Y CREDITO ARTESANOS LTDA'),(138,'COOPERATIVA DE AHORRO Y CREDITO CREA LTDA -MIES'),(139,'COOPERATIVA DE AHORRO Y CREDITO FERNANDO DAQUILEMA'),(140,'COOPERATIVA DE AHORRO Y CREDITO LA BENEFICA LTDA'),(141,'COOPERATIVA DE AHORRO Y CREDITO LAS LAGUNAS-MIESS'),(142,'COOPERATIVA DE AHORRO Y CREDITO MINGA LTDA'),(143,'COOPERATIVA DE AHORRO Y CREDITO MULTIEMPRESARIAL L'),(144,'COOPERATIVA DE AHORRO Y CREDITO PILAHUIN'),(145,'COOPERATIVA DE AHORRO Y CREDITO PUCARA LTDA'),(146,'COOPERATIVA DE AHORRO Y CREDITO SANTA ANITA LTDA'),(147,'CORPORACION FINANCIERA'),(148,'DEL LITORAL'),(149,'DELBANK S.A.'),(150,'DINERS CLUB'),(151,'DINERS/VISA INTERDIN/DISCOVER - Transferencias EnL'),(152,'ECUATORIANO DE LA VIVIENDA'),(153,'FINANCIERA FINANCOOP'),(154,'GUAYAQUIL'),(155,'INTERNACIONAL'),(156,'LOJA'),(157,'MACHALA'),(158,'MUTUALISTA AMBATO'),(159,'MUTUALISTA AZUAY'),(160,'MUTUALISTA IMBABURA'),(161,'MUTUALISTA PICHINCHA'),(162,'BANCO DEL PACIFICO'),(163,'BANCO PICHINCHA '),(164,'PRODUBANCO'),(165,'RUMINAHUI'),(166,'SOLIDARIO');
/*!40000 ALTER TABLE `banco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciudad`
--

DROP TABLE IF EXISTS `ciudad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciudad` (
  `idciudad` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ciudad` varchar(45) NOT NULL,
  `cod_ciudad` varchar(45) NOT NULL,
  `id_provincia` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`idciudad`),
  KEY `fk_ciudad_provincia_idx` (`id_provincia`),
  CONSTRAINT `fk_ciudad_provincia` FOREIGN KEY (`id_provincia`) REFERENCES `provincias` (`idprovincia`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciudad`
--

LOCK TABLES `ciudad` WRITE;
/*!40000 ALTER TABLE `ciudad` DISABLE KEYS */;
INSERT INTO `ciudad` VALUES (1,'CUENCA','0101',1),(2,'GIRÓN','0102',1),(3,'GUALACEO','0103',1),(4,'NABÓN','0104',1),(5,'PAUTE','0105',1),(6,'PUCARA','0106',1),(7,'SAN FERNANDO','0107',1),(8,'SANTA ISABEL','0108',1),(9,'SIGSIG','0109',1),(10,'OÑA','0110',1),(11,'CHORDELEG','0111',1),(12,'EL PAN','0112',1),(13,'SEVILLA DE ORO','0113',1),(14,'GUACHAPALA','0114',1),(15,'CAMILO PONCE ENRÍQUEZ','0115',1),(16,'GUARANDA','0201',2),(17,'CHILLANES','0202',2),(18,'CHIMBO','0203',2),(19,'ECHEANDÍA','0204',2),(20,'SAN MIGUEL','0205',2),(21,'CALUMA','0206',2),(22,'LAS NAVES','0207',2),(23,'AZOGUES','0301',3),(24,'BIBLIÁN','0302',3),(25,'CAÑAR','0303',3),(26,'LA TRONCAL','0304',3),(27,'EL TAMBO','0305',3),(28,'DÉLEG','0306',3),(29,'SUSCAL','0307',3),(30,'TULCÁN','0401',4),(31,'BOLÍVAR','0402',4),(32,'ESPEJO','0403',4),(33,'MIRA','0404',4),(34,'MONTÚFAR','0405',4),(35,'SAN PEDRO DE HUACA','0406',4),(36,'LATACUNGA','0501',5),(37,'LA MANÁ','0502',5),(38,'PANGUA','0503',5),(39,'PUJILI','0504',5),(40,'SALCEDO','0505',5),(41,'SAQUISILÍ','0506',5),(42,'SIGCHOS','0507',5),(43,'RIOBAMBA','0601',6),(44,'ALAUSI','0602',6),(45,'COLTA','0603',6),(46,'CHAMBO','0604',6),(47,'CHUNCHI','0605',6),(48,'GUAMOTE','0606',6),(49,'GUANO','0607',6),(50,'PALLATANGA','0608',6),(51,'PENIPE','0609',6),(52,'CUMANDÁ','0610',6),(53,'MACHALA','0701',7),(54,'ARENILLAS','0702',7),(55,'ATAHUALPA','0703',7),(56,'BALSAS','0704',7),(57,'CHILLA','0705',7),(58,'EL GUABO','0706',7),(59,'HUAQUILLAS','0707',7),(60,'MARCABELÍ','0708',7),(61,'PASAJE','0709',7),(62,'PIÑAS','0710',7),(63,'PORTOVELO','0711',7),(64,'SANTA ROSA','0712',7),(65,'ZARUMA','0713',7),(66,'LAS LAJAS','0714',7),(67,'ESMERALDAS','0801',8),(68,'ELOY ALFARO','0802',8),(69,'MUISNE','0803',8),(70,'QUININDÉ','0804',8),(71,'SAN LORENZO','0805',8),(72,'ATACAMES','0806',8),(73,'RIOVERDE','0807',8),(74,'LA CONCORDIA','0808',8),(75,'GUAYAQUIL','0901',9),(76,'ALFREDO BAQUERIZO MORENO (JUJÁN)','0902',9),(77,'BALAO','0903',9),(78,'BALZAR','0904',9),(79,'COLIMES','0905',9),(80,'DAULE','0906',9),(81,'DURÁN','0907',9),(82,'EL EMPALME','0908',9),(83,'EL TRIUNFO','0909',9),(84,'MILAGRO','0910',9),(85,'NARANJAL','0911',9),(86,'NARANJITO','0912',9),(87,'PALESTINA','0913',9),(88,'PEDRO CARBO','0914',9),(89,'SAMBORONDÓN','0916',9),(90,'SANTA LUCÍA','0918',9),(91,'SALITRE (URBINA JADO)','0919',9),(92,'SAN JACINTO DE YAGUACHI','0920',9),(93,'PLAYAS','0921',9),(94,'SIMÓN BOLÍVAR','0922',9),(95,'CORONEL MARCELINO MARIDUEÑA','0923',9),(96,'LOMAS DE SARGENTILLO','0924',9),(97,'NOBOL','0925',9),(98,'GENERAL ANTONIO ELIZALDE','0927',9),(99,'ISIDRO AYORA','0928',9),(100,'IBARRA','1001',10),(101,'ANTONIO ANTE','1002',10),(102,'COTACACHI','1003',10),(103,'OTAVALO','1004',10),(104,'PIMAMPIRO','1005',10),(105,'SAN MIGUEL DE URCUQUÍ','1006',10),(106,'LOJA','1101',11),(107,'CALVAS','1102',11),(108,'CATAMAYO','1103',11),(109,'CELICA','1104',11),(110,'CHAGUARPAMBA','1105',11),(111,'ESPÍNDOLA','1106',11),(112,'GONZANAMÁ','1107',11),(113,'MACARÁ','1108',11),(114,'PALTAS','1109',11),(115,'PUYANGO','1110',11),(116,'SARAGURO','1111',11),(117,'SOZORANGA','1112',11),(118,'ZAPOTILLO','1113',11),(119,'PINDAL','1114',11),(120,'QUILANGA','1115',11),(121,'OLMEDO','1116',11),(122,'BABAHOYO','1201',12),(123,'BABA','1202',12),(124,'MONTALVO','1203',12),(125,'PUEBLOVIEJO','1204',12),(126,'QUEVEDO','1205',12),(127,'URDANETA','1206',12),(128,'VENTANAS','1207',12),(129,'VÍNCES','1208',12),(130,'PALENQUE','1209',12),(131,'BUENA FÉ','1210',12),(132,'VALENCIA','1211',12),(133,'MOCACHE','1212',12),(134,'QUINSALOMA','1213',12),(135,'PORTOVIEJO','1301',13),(136,'BOLÍVAR','1302',13),(137,'CHONE','1303',13),(138,'EL CARMEN','1304',13),(139,'FLAVIO ALFARO','1305',13),(140,'JIPIJAPA','1306',13),(141,'JUNÍN','1307',13),(142,'MANTA','1308',13),(143,'MONTECRISTI','1309',13),(144,'PAJÁN','1310',13),(145,'PICHINCHA','1311',13),(146,'ROCAFUERTE','1312',13),(147,'SANTA ANA','1313',13),(148,'SUCRE','1314',13),(149,'TOSAGUA','1315',13),(150,'24 DE MAYO','1316',13),(151,'PEDERNALES','1317',13),(152,'OLMEDO','1318',13),(153,'PUERTO LÓPEZ','1319',13),(154,'JAMA','1320',13),(155,'JARAMIJÓ','1321',13),(156,'SAN VICENTE','1322',13),(157,'MORONA','1401',14),(158,'GUALAQUIZA','1402',14),(159,'LIMÓN INDANZA','1403',14),(160,'PALORA','1404',14),(161,'SANTIAGO','1405',14),(162,'SUCÚA','1406',14),(163,'HUAMBOYA','1407',14),(164,'SAN JUAN BOSCO','1408',14),(165,'TAISHA','1409',14),(166,'LOGROÑO','1410',14),(167,'PABLO SEXTO','1411',14),(168,'TIWINTZA','1412',14),(169,'TENA','1501',15),(170,'ARCHIDONA','1503',15),(171,'EL CHACO','1504',15),(172,'QUIJOS','1507',15),(173,'CARLOS JULIO AROSEMENA TOLA','1509',15),(174,'PASTAZA','1601',16),(175,'MERA','1602',16),(176,'SANTA CLARA','1603',16),(177,'ARAJUNO','1604',16),(178,'QUITO','1701',17),(179,'CAYAMBE','1702',17),(180,'MEJIA','1703',17),(181,'PEDRO MONCAYO','1704',17),(182,'RUMIÑAHUI','1705',17),(183,'SAN MIGUEL DE LOS BANCOS','1707',17),(184,'PEDRO VICENTE MALDONADO','1708',17),(185,'PUERTO QUITO','1709',17),(186,'AMBATO','1801',18),(187,'BAÑOS DE AGUA SANTA','1802',18),(188,'CEVALLOS','1803',18),(189,'MOCHA','1804',18),(190,'PATATE','1805',18),(191,'QUERO','1806',18),(192,'SAN PEDRO DE PELILEO','1807',18),(193,'SANTIAGO DE PÍLLARO','1808',18),(194,'TISALEO','1809',18),(195,'ZAMORA','1901',19),(196,'CHINCHIPE','1902',19),(197,'NANGARITZA','1903',19),(198,'YACUAMBI','1904',19),(199,'YANTZAZA (YANZATZA)','1905',19),(200,'EL PANGUI','1906',19),(201,'CENTINELA DEL CÓNDOR','1907',19),(202,'PALANDA','1908',19),(203,'PAQUISHA','1909',19),(204,'SAN CRISTÓBAL','2001',20),(205,'ISABELA','2002',20),(206,'SANTA CRUZ','2003',20),(207,'LAGO AGRIO','2101',21),(208,'GONZALO PIZARRO','2102',21),(209,'PUTUMAYO','2103',21),(210,'SHUSHUFINDI','2104',21),(211,'SUCUMBÍOS','2105',21),(212,'CASCALES','2106',21),(213,'CUYABENO','2107',21),(214,'ORELLANA','2201',22),(215,'AGUARICO','2202',22),(216,'LA JOYA DE LOS SACHAS','2203',22),(217,'LORETO','2204',22),(218,'SANTO DOMINGO','2301',23),(219,'SANTA ELENA','2401',24),(220,'LA LIBERTAD','2402',24),(221,'SALINAS','2403',24),(222,'LAS GOLONDRINAS','9001',90),(223,'MANGA DEL CURA','9003',90),(224,'EL PIEDRERO','9004',90);
/*!40000 ALTER TABLE `ciudad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `codigo_socio`
--

DROP TABLE IF EXISTS `codigo_socio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `codigo_socio` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo_socio` varchar(45) NOT NULL,
  `patrocinador` int(10) unsigned NOT NULL,
  `fecha_inscripcion` date NOT NULL,
  `idsocio` int(10) unsigned NOT NULL,
  `idrango` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_cod_patrocina_idx` (`patrocinador`),
  KEY `fk_cod_socio_idx` (`idsocio`),
  KEY `fk_codigo_socio_rango_idx` (`idrango`),
  CONSTRAINT `fk_codigo_socio` FOREIGN KEY (`idsocio`) REFERENCES `socios` (`idsocio`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_codigo_socio_rango` FOREIGN KEY (`idrango`) REFERENCES `rangos` (`idrango`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `codigo_socio`
--

LOCK TABLES `codigo_socio` WRITE;
/*!40000 ALTER TABLE `codigo_socio` DISABLE KEYS */;
INSERT INTO `codigo_socio` VALUES (1,'CLTUN-1',0,'2022-03-23',1,8,'2022-03-24 17:28:58');
/*!40000 ALTER TABLE `codigo_socio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comisiones`
--

DROP TABLE IF EXISTS `comisiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comisiones` (
  `idcomision` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `puntos` decimal(7,2) DEFAULT 0.00,
  `comision` decimal(7,2) DEFAULT 0.00,
  `fecha` date DEFAULT NULL,
  `pagado` tinyint(4) NOT NULL DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idcomision`),
  KEY `comisiones_FK` (`id`),
  CONSTRAINT `comisiones_FK` FOREIGN KEY (`id`) REFERENCES `codigo_socio` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comisiones`
--

LOCK TABLES `comisiones` WRITE;
/*!40000 ALTER TABLE `comisiones` DISABLE KEYS */;
/*!40000 ALTER TABLE `comisiones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compras`
--

DROP TABLE IF EXISTS `compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compras` (
  `idcompras` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` int(10) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `recompra` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `pago` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `idpaquete` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`idcompras`),
  KEY `fk_recompras_codigo_socio_idx` (`id`),
  KEY `compras_FK` (`idpaquete`),
  CONSTRAINT `compras_FK` FOREIGN KEY (`idpaquete`) REFERENCES `paquetes` (`idpaquete`) ON UPDATE CASCADE,
  CONSTRAINT `fk_compras_codsocio` FOREIGN KEY (`id`) REFERENCES `codigo_socio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compras`
--

LOCK TABLES `compras` WRITE;
/*!40000 ALTER TABLE `compras` DISABLE KEYS */;
/*!40000 ALTER TABLE `compras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cta_banco`
--

DROP TABLE IF EXISTS `cta_banco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cta_banco` (
  `idcuenta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idsocio` int(10) unsigned NOT NULL,
  `num_cta` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '0000000000',
  `idbanco` smallint(5) unsigned NOT NULL,
  `idtipo_cuenta` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`idcuenta`),
  KEY `fk_socio_cta_idx` (`idsocio`),
  KEY `fk_banco_cta_idx` (`idbanco`),
  KEY `fk_tipo_banco_idx` (`idtipo_cuenta`),
  CONSTRAINT `fk_cta_banco_codigo` FOREIGN KEY (`idsocio`) REFERENCES `socios` (`idsocio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cta_banco`
--

LOCK TABLES `cta_banco` WRITE;
/*!40000 ALTER TABLE `cta_banco` DISABLE KEYS */;
INSERT INTO `cta_banco` VALUES (2,2,'2203907032',163,1),(3,1,'001002003',1,1);
/*!40000 ALTER TABLE `cta_banco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matrices`
--

DROP TABLE IF EXISTS `matrices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matrices` (
  `idmatriz` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `matriz` varchar(45) NOT NULL,
  PRIMARY KEY (`idmatriz`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matrices`
--

LOCK TABLES `matrices` WRITE;
/*!40000 ALTER TABLE `matrices` DISABLE KEYS */;
INSERT INTO `matrices` VALUES (1,'UNINIVEL');
/*!40000 ALTER TABLE `matrices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motivacion`
--

DROP TABLE IF EXISTS `motivacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `motivacion` (
  `idmotivacion` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(30) NOT NULL,
  PRIMARY KEY (`idmotivacion`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motivacion`
--

LOCK TABLES `motivacion` WRITE;
/*!40000 ALTER TABLE `motivacion` DISABLE KEYS */;
INSERT INTO `motivacion` VALUES (1,'tRoZG-jIkwE'),(2,'epiJDHQBvNE'),(3,'XrGdLIp3Q4A'),(4,'rJ9PusdjNVs'),(5,'0WZgzI60aZQ'),(6,'MyuoFAGK3lA'),(7,'RzYy55QtDlc'),(8,'-B3urqsYJ5M'),(9,'-CRH3IPCQA4'),(10,'eU1aXP6Rlrg'),(11,'araS0-PAj0E'),(12,'PxwJp6evuao'),(13,'XPairUhQBG8'),(14,'iaQ-XQSqwNI'),(15,'uXwrJjkJY8g'),(16,'ZeUiurgjqnk'),(17,'ybUieSIGObM'),(18,'3QNImR9BD1s'),(19,'CJ_OsAAPsAY'),(20,'WH88E9g9YNg'),(21,'ktRVzVSZkbc'),(22,'XLzDA8bENaI'),(23,'76rjj99thUk'),(24,'8hn2YW1wnkE'),(25,'1JnVqYPYxt4'),(26,'HgYWztyVBW8'),(27,'ww5_nM9xn_M'),(28,'brF-NtbfP_E');
/*!40000 ALTER TABLE `motivacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paquetes`
--

DROP TABLE IF EXISTS `paquetes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paquetes` (
  `idpaquete` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `idmatrices` int(10) unsigned NOT NULL,
  `paquete` decimal(6,2) unsigned NOT NULL,
  `frascos` tinyint(2) unsigned NOT NULL,
  `extra` tinyint(2) unsigned NOT NULL,
  `puntos` smallint(3) unsigned NOT NULL,
  PRIMARY KEY (`idpaquete`),
  KEY `fk_paquete_matriz_idx` (`idmatrices`),
  CONSTRAINT `fk_paquete_matriz` FOREIGN KEY (`idmatrices`) REFERENCES `matrices` (`idmatriz`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paquetes`
--

LOCK TABLES `paquetes` WRITE;
/*!40000 ALTER TABLE `paquetes` DISABLE KEYS */;
INSERT INTO `paquetes` VALUES (1,1,30.00,1,0,12),(2,1,100.00,4,1,48),(3,1,300.00,12,4,144),(4,1,500.00,20,8,240),(5,1,1000.00,40,20,480);
/*!40000 ALTER TABLE `paquetes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provincias`
--

DROP TABLE IF EXISTS `provincias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provincias` (
  `idprovincia` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `provincia` varchar(70) DEFAULT NULL,
  `cod_provincia` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idprovincia`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provincias`
--

LOCK TABLES `provincias` WRITE;
/*!40000 ALTER TABLE `provincias` DISABLE KEYS */;
INSERT INTO `provincias` VALUES (1,'AZUAY','AZU'),(2,'BOLIVAR','BOL'),(3,'CAÑAR','CAN'),(4,'CARCHI','CAR'),(5,'COTOPAXI','COT'),(6,'CHIMBORAZO','CHI'),(7,'EL ORO','ORO'),(8,'ESMERALDAS','ESM'),(9,'GUAYAS','GUA'),(10,'IMBABURA','IMB'),(11,'LOJA','LOJ'),(12,'LOS RIOS','RIO'),(13,'MANABI','MAN'),(14,'MORONA SANTIAGO','MOR'),(15,'NAPO','NAP'),(16,'PASTAZA','PAS'),(17,'PICHINCHA','PCH'),(18,'TUNGURAHUA','TUN'),(19,'ZAMORA CHINCHIPE','ZAM'),(20,'GALAPAGOS','GAL'),(21,'SUCUMBIOS','SUC'),(22,'ORELLANA','ORE'),(23,'SANTO DOMINGO DE LOS TSACHILAS','STO'),(24,'SANTA ELENA','STA'),(90,'ZONAS NO DELIMITADAS','ZND');
/*!40000 ALTER TABLE `provincias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rangos`
--

DROP TABLE IF EXISTS `rangos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rangos` (
  `idrango` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `rango` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `volumen` varchar(7) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`idrango`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rangos`
--

LOCK TABLES `rangos` WRITE;
/*!40000 ALTER TABLE `rangos` DISABLE KEYS */;
INSERT INTO `rangos` VALUES (1,'DISTRIBUIDOR','0','0'),(2,'ZAFIRO','1000','0'),(3,'RUBÍ','5000','0'),(4,'ESMERALDA','15000','0'),(5,'DIAMANTE','50000','0'),(6,'DIAMANTE AZUL','120000','0'),(7,'DIAMANTE NEGRO','400000','0'),(8,'DIAMANTE CORONA','1000000','0');
/*!40000 ALTER TABLE `rangos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `idrol` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `rol` varchar(25) NOT NULL,
  `administracion` tinyint(1) NOT NULL DEFAULT 0,
  `inicio` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `reportes` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `socios` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'SUPERADMIN',1,1,1,1),(2,'ADMINISTRADOR',1,1,1,1),(3,'SOCIO',0,0,0,0);
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('xyqNLDK1C35lnkvrQzvCbDAIh2MTcKjGl6yF44lq',1,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoibk82dmFSRlRKeVNKUENWMTBhR25LekQxV2VIYmJTOWFMN3hKQUNqNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1648765868);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `socios`
--

DROP TABLE IF EXISTS `socios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `socios` (
  `idsocio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombres` varchar(60) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `cedula` varchar(45) NOT NULL,
  `clave_socio` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT 'email@email.com ',
  `idciudad` int(10) unsigned NOT NULL,
  `direccion` varchar(150) DEFAULT 'N/A',
  `celular` varchar(10) DEFAULT '9999999999',
  `idrol` tinyint(1) unsigned NOT NULL,
  `logged_socio` tinyint(1) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`idsocio`),
  KEY `fk_socios_ciudad_idx` (`idciudad`),
  KEY `fk_socios_rol_idx` (`idrol`),
  CONSTRAINT `fk_socio_ciudad` FOREIGN KEY (`idciudad`) REFERENCES `ciudad` (`idciudad`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_socio_rol` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `socios`
--

LOCK TABLES `socios` WRITE;
/*!40000 ALTER TABLE `socios` DISABLE KEYS */;
INSERT INTO `socios` VALUES (1,'CARLOS','LOPEZ','1802326643','ea105c6e1b00504c8d951a1f429fe92c','hostill@gmail.com',186,'AMBATO',NULL,1,0,'2022-03-24 17:26:42'),(2,'PABLO','OREJUELA','1705520227','888abec6dc2926ee4b684274532750bb','pabloorejuela@hotmail.com',178,'VILLA FLORA','0993422997',1,0,'2022-03-24 17:26:42');
/*!40000 ALTER TABLE `socios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonios`
--

DROP TABLE IF EXISTS `testimonios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testimonios` (
  `idtestimonios` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` datetime DEFAULT NULL,
  `titulo` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `orden` smallint(5) unsigned DEFAULT 0,
  `url` varchar(200) CHARACTER SET utf8 NOT NULL,
  `img` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`idtestimonios`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonios`
--

LOCK TABLES `testimonios` WRITE;
/*!40000 ALTER TABLE `testimonios` DISABLE KEYS */;
INSERT INTO `testimonios` VALUES (1,NULL,'Cancer en el seno. Artritis, diabetes, Diagnostico: Si en 25 dias no se operaba moria','RITA LUCAS - GUAYAQUIL',1,'https://youtu.be/QC4T1UK19O0','pD3lyqtE--g'),(2,NULL,'Paralitica, no podia caminar durante 2 a&ntilde;os. Diagnostico: Nunca volver&iacute;a a caminar','SILVIA SANDOVAL - PILLARO',2,'https://youtu.be/QC4T1UK19O0','QC4T1UK19O0'),(3,NULL,'Derrame Cerebral','VIDAL DAVILA - GUAYAQUIL',3,'https://youtu.be/-I_31Kwci3o','-I_31Kwci3o'),(4,NULL,'Al borde de la muerte, Artritis, Artrosis, Paralisis del cuerpo','ROBERTO ZAPATA - COLOMBIANO',4,'https://youtu.be/QIZBNZ-T1UA','QIZBNZ-T1UA'),(5,NULL,'Mal de Parkinson','GONZALO LOPEZ - PILLARO',5,'','bihvF7HpNBc'),(6,NULL,'PROBLEMAS DE CANCER Y TUBERCULOSIS','LUIS PAREDES - BABAHOYO',6,'','4fGMLt6B0Gw'),(7,NULL,'DISENTERIA, VOMITO Y FIEBRE','MIRIAN ZURITA - BABAHOYO',9,'','UIJLBHYF4mc'),(8,NULL,'PREVENCION DE ENFERMEDADES','TARQUINO MOSQUERA - BABAHOYO',10,'','looRbI9HF1w'),(9,NULL,'DOLORES DE HUESOS Y AHOGOS','RAMON BRAVO - GUAYAQUIL',11,'','aru8ZRxqJiQ'),(10,NULL,'PROBLEMAS DE ARTRITIS Y COLITIS','LUCIANO MAZA - LOJA',12,'','vRW-O0Gsozk'),(11,NULL,'RESTAURACION DE LA VISION','SUSANA BEDON - QUITO',13,'','nqgVEhDxmP4'),(12,NULL,'PROBLEMAS DE CIRUJIAS','VICENTE CUJI - QUITO',14,'','0SFsXP2JZSM'),(13,NULL,'PROBLEMAS DE ACNE','RUBEN RODRIGUEZ - QUITO',15,'','7mgqVge5fe0'),(14,NULL,'PROBLEMAS ESTOMACALES Y OSTEOPOROSIS','SERGIO FLORES - BABAHOYO',16,'','tNqp2id1m6E'),(15,NULL,'DERRAME CEREBRAL Y DIABETES','MATILDE VERA - BABAHOYO',17,'','PSypr3PJaCg'),(16,NULL,'IMSOMIO, SISTEMA INMUNOLOGICO E INSUFICIENCIA RENAL','LAURA MONTERO - BABAHOYO',18,'','usv6e9z7cx0'),(17,NULL,'ENFERMEDAD CARDIACA','ADELA FRANCO - BABAHOYO',19,'i7g7rV2z92o','i7g7rV2z92o'),(18,NULL,'MENOPAUSIA - ARTRITIS','ANA MARTINEZ - MATA DE CACAO',20,'lSAaKG3sdr8','lSAaKG3sdr8'),(19,NULL,'MULTIPLES ENFERMEDADES','BLANCA VILLEGAS - LA TRONCAL, PROVINCIA DEL CA&ntilde;AR',21,'IiSJB3tLzhc','IiSJB3tLzhc'),(20,NULL,'DOLOR DE HUESOS, DE ESTOMAGO, DE CABEZA Y CANSANCIO GENERAL','EUDOMILIA DE LOPEZ - PILLARO',22,'gvQw-oTKX4I','gvQw-oTKX4I'),(21,NULL,'INSOMNIO','VIRGINIA PAUCAR - GUAYAQUIL',23,'RW76MBlK_b0','RW76MBlK_b0'),(22,NULL,'MIGRA&ntilde;AS Y DOLOR DE PIERNAS','NARCISO LOPEZ - LA TRONCAL',24,'YRHyHw4T4vM','YRHyHw4T4vM'),(23,NULL,'LEISHMANIASIS','MARY PAREDES - EL COCA',25,'AkNZNTH-CGg','AkNZNTH-CGg'),(24,NULL,'INFARTO CEREBRAL, DIABETES','MARIELA SUZO - GUAYAQUIL',26,'C-KzRBMoRqA','C-KzRBMoRqA'),(25,NULL,'DOLORES DE CABEZA, VOMITO','LILIANA CUEVA - GUAYAQUIL',27,'jLBCIWzhv5M','jLBCIWzhv5M'),(26,NULL,'PARALISIS CORPORAL','LIDA MORALES - GUAYAQUIL',28,'-9Mb2k0dnv0','-9Mb2k0dnv0'),(27,NULL,'CANCER DE HIGADO, ALCOHOLISMO, DROGADICCION','RITA LUCAS - GUAYAQUIL',29,'40KZMnQ3Dco','40KZMnQ3Dco'),(28,NULL,'DISCAPACITADO, NO PUEDE CAMINAR Y NO PUEDE VER','FABIAN ORTIZ - GUAYAQUIL',30,'bAlwzJADl-Y','bAlwzJADl-Y'),(29,NULL,'GASTRITIS SERVERA','GERMANICO MENDEZ - GUAYAQUIL',31,'MPNNvCaKCU4','MPNNvCaKCU4'),(30,NULL,'HIGADO GRASO Y COLESTEROL ALTO','ISIDRO ESPINOZA - GUAYAQUIL',32,'u1vrvsWMN5M','u1vrvsWMN5M'),(31,NULL,'ARTRITIS Y GASTRITIS','MARIA DIOSELINA CULUMBA',33,'yNicdlt763k','yNicdlt763k'),(32,NULL,'DIABETES, ARTRITIS Y GASTRITIS','BEATRIZ ERAZO',34,'6bl-0jQzQvk','6bl-0jQzQvk'),(33,NULL,'DENGUE PALUDISMO','s/n',35,'f5qFKd_Ex54','f5qFKd_Ex54'),(34,NULL,'PIEL PALIDA Y ENFERMIZA','s/n',36,'NY9AhxBQxJY','NY9AhxBQxJY'),(35,NULL,'CANCER DE UTERO Y CATARATAS','LILIANA CUEVA',37,'qbYqJLRyQZ8','qbYqJLRyQZ8'),(36,NULL,'CALCULOS RENALES Y PROBLEMAS DE LA VISTA','GUILLERMO PITA',38,'fLUw6PbnFhM','fLUw6PbnFhM'),(37,NULL,'DOLORES EN EL CUERPO, NO PODIA CAMINAR','ARGENTINA ALVARES',39,'43P6SN87lMk','43P6SN87lMk'),(38,NULL,'DERRAME CEREBRAL, VITILIGO','DON JUAN REZABALA',40,'k5Bk42rapNU','k5Bk42rapNU'),(39,NULL,'SORIASIS','JUSTINA EULALIA SANTILLAN',41,'41mXTKJXeGA','41mXTKJXeGA'),(40,NULL,'DOLORES HUESOS Y PROBLEMAS EN LA VISION','FRANCISCA OLVERA',42,'bTVQXY67wI8','bTVQXY67wI8'),(41,NULL,'ULCERAS EN LAS PIERNAS, DEBIAN AMPUTARLE','s/n',43,'6vgPKHLeCjM','6vgPKHLeCjM'),(42,NULL,'HEMORRAGIAS, DIABETES, GASES, INSOMNIO','GERMANIA OLVERA',44,'bp_MRajd6MM','bp_MRajd6MM'),(43,NULL,'GASTRITIS, INSOMNIO','GASTRITIS, INSOMNIO',45,'1W3RirehunA','1W3RirehunA'),(44,NULL,'REUMATISMO GRADO DOS, CEGUERA, PACIENTE CON SIDA','CARLOS CEDE&ntilde;O',46,'hUB8d0WgXE8','hUB8d0WgXE8'),(45,NULL,'PROBLEMAS EN LA PROSTATA Y RI&ntilde;ONES','SRA. MARTA',47,'hBuL9NBnGbg','hBuL9NBnGbg'),(46,NULL,'NO PODIA CAMINAR','MIGUEL DELGADO',48,'4TjpUaAo71w','4TjpUaAo71w'),(47,NULL,'VARICES, CALCULOS EN LOS RI&nacute;ONES','ANA BARREIRO',49,'bTkup7xORmM','bTkup7xORmM'),(48,NULL,'MADRE ESTABA POSTRADA Y VOLVIO A CAMINAR','COLOMBIA POVEDA',50,'aPrKukcTeho','aPrKukcTeho'),(49,NULL,'INSOMNIO','s/n',51,'-9-PHaZAwFE','-9-PHaZAwFE'),(50,NULL,'RECUPERO LA VISION, CAIDA DE CABELLO','NATALIA MACIAS',52,'It2XgOSUomM','It2XgOSUomM'),(51,NULL,'PROBLEMAS DE ACN&Eacute;, INTOXICACIONES','PAOLA GUERRERO',53,'VyUTKup2djw','VyUTKup2djw'),(52,NULL,'CANCER, CIRROCIS HEPATICA, DOLORES DE CABEZA, MAREO, CALCULOS, ETAPA TERMINAL, DESAHUCIADA.','FATIMA SOLEDISPA',7,'https://youtu.be/ASkw4lrwt28','ASkw4lrwt28'),(53,'2018-12-11 00:00:00','MULTIPLES ENFERMEDADES, ESTUVO AL BORDE DE LA MUERTE','HERLINDA CHILAN',54,'https://youtu.be/8rugKz60v6c','8rugKz60v6c');
/*!40000 ALTER TABLE `testimonios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_cuenta`
--

DROP TABLE IF EXISTS `tipo_cuenta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_cuenta` (
  `idtipo_cuenta` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_cuenta` varchar(25) NOT NULL,
  PRIMARY KEY (`idtipo_cuenta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_cuenta`
--

LOCK TABLES `tipo_cuenta` WRITE;
/*!40000 ALTER TABLE `tipo_cuenta` DISABLE KEYS */;
INSERT INTO `tipo_cuenta` VALUES (1,'AHORROS'),(2,'CORRIENTE');
/*!40000 ALTER TABLE `tipo_cuenta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'gtkecuad_teruso'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-31 18:15:16
