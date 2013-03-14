# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.28)
# Database: BD_RTV_CONTROL_VEHICULAR
# Generation Time: 2013-03-14 18:21:27 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table CTG_TIPO_COMBUSTIBLE
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CTG_TIPO_COMBUSTIBLE`;

CREATE TABLE `CTG_TIPO_COMBUSTIBLE` (
  `ID_CTG_TIPO_COMBUSTIBLE` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(100) DEFAULT NULL,
  `FECHA_CREADO` datetime DEFAULT NULL,
  `FECHA_MODIFICADO` datetime DEFAULT NULL,
  `USUARIO_CREO` int(11) DEFAULT NULL,
  `USUARIO_MODIFICO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_CTG_TIPO_COMBUSTIBLE`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `CTG_TIPO_COMBUSTIBLE` WRITE;
/*!40000 ALTER TABLE `CTG_TIPO_COMBUSTIBLE` DISABLE KEYS */;

INSERT INTO `CTG_TIPO_COMBUSTIBLE` (`ID_CTG_TIPO_COMBUSTIBLE`, `DESCRIPCION`, `FECHA_CREADO`, `FECHA_MODIFICADO`, `USUARIO_CREO`, `USUARIO_MODIFICO`)
VALUES
	(1,'Gasolina',NULL,NULL,NULL,NULL),
	(2,'Diesel',NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `CTG_TIPO_COMBUSTIBLE` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table CTG_TIPO_UNIDAD
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CTG_TIPO_UNIDAD`;

CREATE TABLE `CTG_TIPO_UNIDAD` (
  `ID_CTG_TIPO_UNIDAD` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(200) DEFAULT NULL,
  `FECHA_CREADO` datetime DEFAULT NULL,
  `FECHA_MODIFICADO` datetime DEFAULT NULL,
  `USUARIO_CREO` int(11) DEFAULT NULL,
  `USUARIO_MODIFICO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_CTG_TIPO_UNIDAD`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `CTG_TIPO_UNIDAD` WRITE;
/*!40000 ALTER TABLE `CTG_TIPO_UNIDAD` DISABLE KEYS */;

INSERT INTO `CTG_TIPO_UNIDAD` (`ID_CTG_TIPO_UNIDAD`, `DESCRIPCION`, `FECHA_CREADO`, `FECHA_MODIFICADO`, `USUARIO_CREO`, `USUARIO_MODIFICO`)
VALUES
	(1,'Unidad movil',NULL,NULL,NULL,NULL),
	(2,'Transporte de personal',NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `CTG_TIPO_UNIDAD` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table CTG_TIPO_USUARIO
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CTG_TIPO_USUARIO`;

CREATE TABLE `CTG_TIPO_USUARIO` (
  `ID_CTG_TIPO_USUARIO` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID_CTG_TIPO_USUARIO`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

LOCK TABLES `CTG_TIPO_USUARIO` WRITE;
/*!40000 ALTER TABLE `CTG_TIPO_USUARIO` DISABLE KEYS */;

INSERT INTO `CTG_TIPO_USUARIO` (`ID_CTG_TIPO_USUARIO`, `DESCRIPCION`)
VALUES
	(1,'Administrador'),
	(2,'Registro'),
	(3,'Reportes');

/*!40000 ALTER TABLE `CTG_TIPO_USUARIO` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table CTG_VEHICULOS
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CTG_VEHICULOS`;

CREATE TABLE `CTG_VEHICULOS` (
  `ID_CTG_VEHICULOS` int(11) NOT NULL,
  `PLACAS_VIEJAS` varchar(10) DEFAULT NULL,
  `PLACAS_NUEVAS` varchar(10) DEFAULT NULL,
  `MARCA` varchar(255) DEFAULT NULL,
  `MODELO` varchar(45) DEFAULT NULL,
  `CAPACIDAD_TANQUE` int(11) DEFAULT NULL,
  `KILOMETRAJE_ACTUAL` int(11) DEFAULT NULL,
  `RENDIEMIENTO_KML_AGENCIA` int(11) DEFAULT NULL,
  `NOMBRE_UNIDAD` varchar(200) DEFAULT NULL,
  `LINEA` varchar(45) DEFAULT NULL,
  `DESCRIPCION_VEHICULO` text,
  `NUM_MOTOR` varchar(250) DEFAULT NULL,
  `NUM_SERIE` varchar(250) DEFAULT NULL,
  `ID_CTG_TIPO_UNIDAD` int(11) NOT NULL,
  `ID_CTG_TIPO_COMBUSTIBLE` int(11) NOT NULL,
  `FECHA_CREADO` datetime DEFAULT NULL,
  `FECHA_MODIFICADO` datetime DEFAULT NULL,
  `USUARIO_CREO` int(11) DEFAULT NULL,
  `USUARIO_MODIFICO` int(11) DEFAULT NULL,
  `ACTIVO` tinyint(1) DEFAULT NULL,
  `NUM_ECONOMICO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_CTG_VEHICULOS`),
  KEY `fk_CTG_VEHICULOS_CTG_TIPO_UNIDAD1_idx` (`ID_CTG_TIPO_UNIDAD`),
  KEY `fk_CTG_VEHICULOS_CTG_TIPO_COMBUSTIBLE1_idx` (`ID_CTG_TIPO_COMBUSTIBLE`),
  CONSTRAINT `fk_CTG_VEHICULOS_CTG_TIPO_COMBUSTIBLE1` FOREIGN KEY (`ID_CTG_TIPO_COMBUSTIBLE`) REFERENCES `CTG_TIPO_COMBUSTIBLE` (`ID_CTG_TIPO_COMBUSTIBLE`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CTG_VEHICULOS_CTG_TIPO_UNIDAD1` FOREIGN KEY (`ID_CTG_TIPO_UNIDAD`) REFERENCES `CTG_TIPO_UNIDAD` (`ID_CTG_TIPO_UNIDAD`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table TB_CHOFERES
# ------------------------------------------------------------

DROP TABLE IF EXISTS `TB_CHOFERES`;

CREATE TABLE `TB_CHOFERES` (
  `ID_TB_CHOFERES` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(200) DEFAULT NULL,
  `AP_PATERNO` varchar(200) DEFAULT NULL,
  `AP_MATERNO` varchar(200) DEFAULT NULL,
  `NUM_LICENCIA` varchar(200) DEFAULT NULL,
  `FECHA_CREADO` datetime DEFAULT NULL,
  `FECHA_MODIFICADO` datetime DEFAULT NULL,
  `USUARIO_CREO` int(11) DEFAULT NULL,
  `USUARIO_MODIFICO` int(11) DEFAULT NULL,
  `ACTIVO` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID_TB_CHOFERES`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table TB_ENTRADA
# ------------------------------------------------------------

DROP TABLE IF EXISTS `TB_ENTRADA`;

CREATE TABLE `TB_ENTRADA` (
  `ID_TB_ENTRADA` bigint(20) NOT NULL AUTO_INCREMENT,
  `ID_TB_SALIDA` bigint(20) NOT NULL,
  `KM_ENTRADA` int(11) DEFAULT NULL,
  `NIVEL_ACEITE_MOTOR` varchar(45) DEFAULT NULL,
  `FECHA_MODIFICACION` datetime DEFAULT NULL,
  `FECHA_CREACION` datetime DEFAULT NULL,
  `OBSERVACIONES` text,
  `ESPEJOS_LATERALES` int(11) DEFAULT NULL,
  `ESPEJO_RETROVISOR` tinyint(1) DEFAULT NULL,
  `ANTENA` tinyint(1) DEFAULT NULL,
  `RADIO` tinyint(1) DEFAULT NULL,
  `BAYONETA_ACEITE` tinyint(1) DEFAULT NULL,
  `ENCENDEDOR` tinyint(1) DEFAULT NULL,
  `TAPON_GASOLINA` tinyint(1) DEFAULT NULL,
  `TAPETES` tinyint(1) DEFAULT NULL,
  `TAPONES_RIN` int(11) DEFAULT NULL,
  `EXTINTOR` tinyint(1) DEFAULT NULL,
  `LIMPIADORES` tinyint(1) DEFAULT NULL,
  `LLAVE_CRUZ` tinyint(1) DEFAULT NULL,
  `GATO` tinyint(1) DEFAULT NULL,
  `LLANTA_REFACCION` tinyint(1) DEFAULT NULL,
  `HERRAMIENTAS` tinyint(1) DEFAULT NULL,
  `ESTADO_LLANTAS` varchar(45) DEFAULT NULL,
  `NIVEL_LIQUIDO_ANTICONGELANTE` varchar(45) DEFAULT NULL,
  `NIVEL_LIQUIDO_FRENOS` varchar(45) DEFAULT NULL,
  `NIVEL_ACEITE_DIRECCION` varchar(45) DEFAULT NULL,
  `NIVEL_ACEITE_TRANSMISION` varchar(45) DEFAULT NULL,
  `NIVEL_GASOLINA` varchar(45) DEFAULT NULL,
  `FECHA_CREADO` datetime DEFAULT NULL,
  `FECHA_MODIFICADO` datetime DEFAULT NULL,
  `USUARIO_CREO` int(11) DEFAULT NULL,
  `USUARIO_MODIFICO` int(11) DEFAULT NULL,
  `FACTURA` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID_TB_ENTRADA`),
  KEY `fk_TB_ENTRADA_TB_SALIDA1_idx` (`ID_TB_SALIDA`),
  CONSTRAINT `fk_TB_ENTRADA_TB_SALIDA1` FOREIGN KEY (`ID_TB_SALIDA`) REFERENCES `TB_SALIDA` (`ID_TB_SALIDA`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table TB_FACTURAS
# ------------------------------------------------------------

DROP TABLE IF EXISTS `TB_FACTURAS`;

CREATE TABLE `TB_FACTURAS` (
  `ID_TB_FACTURAS` bigint(20) NOT NULL AUTO_INCREMENT,
  `NUM_FACTURA` varchar(255) DEFAULT NULL,
  `LITROS_CARGA` int(11) DEFAULT NULL,
  `PRECIO` decimal(10,2) DEFAULT NULL,
  `TIPO_COMBUSTIBLE` varchar(45) DEFAULT NULL,
  `GASOLINERA` varchar(255) DEFAULT NULL,
  `CIUDAD` varchar(255) DEFAULT NULL,
  `ESTADO` varchar(255) DEFAULT NULL,
  `FECHA_CREADO` datetime DEFAULT NULL,
  `FECHA_MODIFICADO` datetime DEFAULT NULL,
  `USUARIO_CREO` int(11) DEFAULT NULL,
  `USUARIO_MODIFICO` int(11) DEFAULT NULL,
  `FOLIO_SALIDA` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID_TB_FACTURAS`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table TB_SALIDA
# ------------------------------------------------------------

DROP TABLE IF EXISTS `TB_SALIDA`;

CREATE TABLE `TB_SALIDA` (
  `ID_TB_SALIDA` bigint(20) NOT NULL AUTO_INCREMENT,
  `ID_CTG_VEHICULOS` int(11) NOT NULL,
  `ID_TB_CHOFERES` int(11) NOT NULL,
  `TIPO_SALIDA` varchar(45) DEFAULT NULL,
  `NIVEL_GASOLINA` varchar(45) DEFAULT NULL,
  `NIVEL_ACEITE_MOTOR` varchar(45) DEFAULT NULL,
  `NIVEL_ACEITE_TRANSMISION` varchar(45) DEFAULT NULL,
  `NIVEL_ACEITE_DIRECCION` varchar(45) DEFAULT NULL,
  `NIVEL_LIQUIDO_FRENOS` varchar(45) DEFAULT NULL,
  `NIVEL_LIQUIDO_ANTICONGELANTE` varchar(45) DEFAULT NULL,
  `ESTADO_LLANTAS` varchar(45) DEFAULT NULL,
  `HERRAMIENTAS` tinyint(1) DEFAULT NULL,
  `LLANTA_REFACCION` tinyint(1) DEFAULT NULL,
  `GATO` tinyint(1) DEFAULT NULL,
  `LLAVE_CRUZ` tinyint(1) DEFAULT NULL,
  `LIMPIADORES` tinyint(1) DEFAULT NULL,
  `EXTINTOR` tinyint(1) DEFAULT NULL,
  `TAPONES_RIN` int(11) DEFAULT NULL,
  `TAPETES` tinyint(1) DEFAULT NULL,
  `TAPON_GASOLINA` tinyint(1) DEFAULT NULL,
  `ENCENDEDOR` tinyint(1) DEFAULT NULL,
  `BAYONETA_ACEITE` tinyint(1) DEFAULT NULL,
  `RADIO` tinyint(1) DEFAULT NULL,
  `ANTENA` tinyint(1) DEFAULT NULL,
  `ESPEJO_RETROVISOR` tinyint(1) DEFAULT NULL,
  `ESPEJOS_LATERALES` int(11) DEFAULT NULL,
  `ACTIVIDAD_COMISION` text,
  `LUGAR_COMISION` varchar(200) DEFAULT NULL,
  `OBSERVACIONES` text,
  `FECHA_CREADO` datetime DEFAULT NULL,
  `FECHA_MODIFICADO` datetime DEFAULT NULL,
  `FOLIO` varchar(45) DEFAULT NULL,
  `KM_SALIDA` int(11) DEFAULT NULL,
  `USUARIO_CREO` int(11) DEFAULT NULL,
  `USUARIO_MODIFICO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_TB_SALIDA`),
  KEY `fk_TB_SALIDA_CTG_VEHICULOS1_idx` (`ID_CTG_VEHICULOS`),
  KEY `fk_TB_SALIDA_TB_CHOFERES1_idx` (`ID_TB_CHOFERES`),
  CONSTRAINT `fk_TB_SALIDA_CTG_VEHICULOS1` FOREIGN KEY (`ID_CTG_VEHICULOS`) REFERENCES `CTG_VEHICULOS` (`ID_CTG_VEHICULOS`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_TB_SALIDA_TB_CHOFERES1` FOREIGN KEY (`ID_TB_CHOFERES`) REFERENCES `TB_CHOFERES` (`ID_TB_CHOFERES`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table TB_USUARIOS
# ------------------------------------------------------------

DROP TABLE IF EXISTS `TB_USUARIOS`;

CREATE TABLE `TB_USUARIOS` (
  `ID_TB_USUARIOS` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(200) DEFAULT NULL,
  `AP_PATERNO` varchar(200) DEFAULT NULL,
  `AP_MATERNO` varchar(200) DEFAULT NULL,
  `EMAIL` varchar(200) DEFAULT NULL,
  `USERNAME` varchar(200) DEFAULT NULL,
  `PASSWD` varchar(200) DEFAULT NULL,
  `ID_CTG_TIPO_USUARIO` int(11) NOT NULL,
  `FECHA_CREADO` datetime DEFAULT NULL,
  `FECHA_MODIFICADO` datetime DEFAULT NULL,
  `USUARIO_CREO` int(11) DEFAULT NULL,
  `USUARIO_MODIFICO` int(11) DEFAULT NULL,
  `ACTIVO` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID_TB_USUARIOS`),
  KEY `fk_TB_USUARIOS_CTG_TIPO_USUARIO1_idx` (`ID_CTG_TIPO_USUARIO`),
  CONSTRAINT `fk_TB_USUARIOS_CTG_TIPO_USUARIO1` FOREIGN KEY (`ID_CTG_TIPO_USUARIO`) REFERENCES `CTG_TIPO_USUARIO` (`ID_CTG_TIPO_USUARIO`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `TB_USUARIOS` WRITE;
/*!40000 ALTER TABLE `TB_USUARIOS` DISABLE KEYS */;

INSERT INTO `TB_USUARIOS` (`ID_TB_USUARIOS`, `NOMBRE`, `AP_PATERNO`, `AP_MATERNO`, `EMAIL`, `USERNAME`, `PASSWD`, `ID_CTG_TIPO_USUARIO`, `FECHA_CREADO`, `FECHA_MODIFICADO`, `USUARIO_CREO`, `USUARIO_MODIFICO`, `ACTIVO`)
VALUES
	(1,'Raul','Cuevas','Gorocica','rcuevas@rtv.org.mx','rcuevas','e10adc3949ba59abbe56e057f20f883e',1,'2013-03-12 20:02:17','2013-03-12 20:02:17',1,1,1),
	(2,'Jorge','Peréz','','jperez@rtv.org.mx','jperez','e10adc3949ba59abbe56e057f20f883e',2,'2013-03-14 11:26:20','2013-03-14 11:26:20',1,1,1);

/*!40000 ALTER TABLE `TB_USUARIOS` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
