-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         13.0.2-MariaDB-log - MariaDB Server
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.22.0.7382
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para a0210180_miva
CREATE DATABASE IF NOT EXISTS `a0210180_miva` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;
USE `a0210180_miva`;

-- Volcando estructura para tabla a0210180_miva.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `ID_CATEGORIA` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_CATEGORIA`)
);

-- Volcando datos para la tabla a0210180_miva.categoria: ~4 rows (aproximadamente)
INSERT INTO `categoria` (`ID_CATEGORIA`, `NOMBRE`) VALUES
	(1, 'VIDEO VIGILANCIA'),
	(2, 'REDES'),
	(3, 'COMPUTO'),
	(4, 'ALARMAS Y DOMOTICA');

-- Volcando estructura para tabla a0210180_miva.unidad
CREATE TABLE IF NOT EXISTS `unidad` (
  `ID_UNIDAD` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_UNIDAD`)
);

-- Volcando datos para la tabla a0210180_miva.unidad: ~3 rows (aproximadamente)
INSERT INTO `unidad` (`ID_UNIDAD`, `NOMBRE`) VALUES
	(1, 'UNIDAD'),
	(2, 'BOLSA 10 UND'),
	(3, 'BOLSA 100 UND'),
	(4, 'PAQUETE 10 UND');

-- Volcando estructura para tabla a0210180_miva.tipo_venta
CREATE TABLE IF NOT EXISTS `tipo_venta` (
  `ID_TIPO_VENTA` varchar(10) NOT NULL,
  `TIPO` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_TIPO_VENTA`)
);

-- Volcando datos para la tabla a0210180_miva.tipo_venta: ~6 rows (aproximadamente)
INSERT INTO `tipo_venta` (`ID_TIPO_VENTA`, `TIPO`) VALUES
	('BJA', 'BAJA'),
	('CNT', 'CONTADO'),
	('CRD', 'CREDITO'),
	('CSM', 'CONSUMO'),
	('DEV', 'DEVOLUCION'),
	('QR', 'PAGO QR');

-- Volcando estructura para tabla a0210180_miva.tipo_usr
CREATE TABLE IF NOT EXISTS `tipo_usr` (
  `ID_TIPO_USR` int(11) NOT NULL AUTO_INCREMENT,
  `TIPO_USR` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_TIPO_USR`)
);

-- Volcando datos para la tabla a0210180_miva.tipo_usr: ~2 rows (aproximadamente)
INSERT INTO `tipo_usr` (`ID_TIPO_USR`, `TIPO_USR`) VALUES
	(1, 'ADMINISTRADOR'),
	(2, 'VENTAS');

-- Volcando estructura para tabla a0210180_miva.usr
CREATE TABLE IF NOT EXISTS `usr` (
  `ID_USR` int(11) NOT NULL AUTO_INCREMENT,
  `USR` varchar(50) NOT NULL,
  `PSWR` varchar(200) NOT NULL,
  `NOMBRE` varchar(50) NOT NULL,
  `APELLIDOP` varchar(50) NOT NULL,
  `APELLIDOM` varchar(50) NOT NULL,
  `FECHA_NAC` date NOT NULL,
  `CI` varchar(50) NOT NULL,
  `ID_TIPO_USR` int(11) NOT NULL,
  PRIMARY KEY (`ID_USR`),
  UNIQUE KEY `USR` (`USR`),
  KEY `ID_TIPO_USR` (`ID_TIPO_USR`),
  FOREIGN KEY (`ID_TIPO_USR`) REFERENCES `tipo_usr` (`ID_TIPO_USR`)
);

-- Volcando datos para la tabla a0210180_miva.usr: ~0 rows (aproximadamente)
INSERT INTO `usr` (`ID_USR`, `USR`, `PSWR`, `NOMBRE`, `APELLIDOP`, `APELLIDOM`, `FECHA_NAC`, `CI`, `ID_TIPO_USR`) VALUES
	(1, 'ADMIN', '$2y$10$w7ycSJ9WbB11Zg7dZpM8m.cwmW/zUf1pMHWWsl2UajpoHAEeowX4G', 'CHANEL JOSE', 'CONDORI', 'YUCRA', '1984-07-14', '5290570', 1);

-- Volcando estructura para tabla a0210180_miva.tipo_cliente
CREATE TABLE IF NOT EXISTS `tipo_cliente` (
  `ID_TIPO_CLIENTE` varchar(10) NOT NULL,
  `TIPO` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_TIPO_CLIENTE`)
);

-- Volcando datos para la tabla a0210180_miva.tipo_cliente: ~2 rows (aproximadamente)
INSERT INTO `tipo_cliente` (`ID_TIPO_CLIENTE`, `TIPO`) VALUES
	('NS', 'NO SOCIO'),
	('S', 'SOCIO');

-- Volcando estructura para tabla a0210180_miva.solicitud_dev
CREATE TABLE IF NOT EXISTS `solicitud_dev` (
  `ID_SOLICITUD_DEV` int(11) NOT NULL AUTO_INCREMENT,
  `NRO_NOTA` int(11) DEFAULT NULL,
  `FECHA_SOLICITUD` datetime NOT NULL,
  `ID_TIPO_VENTA` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_SOLICITUD_DEV`),
  KEY `ID_TIPO_VENTA` (`ID_TIPO_VENTA`),
  FOREIGN KEY (`ID_TIPO_VENTA`) REFERENCES `tipo_venta` (`ID_TIPO_VENTA`)
);

-- Volcando datos para la tabla a0210180_miva.solicitud_dev: ~0 rows (aproximadamente)

-- Volcando estructura para tabla a0210180_miva.solicitud_compra
CREATE TABLE IF NOT EXISTS `solicitud_compra` (
  `ID_SOLICITUD_COMPRA` int(11) NOT NULL AUTO_INCREMENT,
  `NRO_NOTA` int(11) NOT NULL DEFAULT 0,
  `FECHA_SOLICITUD` date NOT NULL,
  `FECHA_FACTURA` date NOT NULL,
  `ID_USR` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID_SOLICITUD_COMPRA`),
  KEY `ID_USR` (`ID_USR`),
  FOREIGN KEY (`ID_USR`) REFERENCES `usr` (`ID_USR`)
);

-- Volcando datos para la tabla a0210180_miva.solicitud_compra: ~0 rows (aproximadamente)

-- Volcando estructura para tabla a0210180_miva.solicitud_baja
CREATE TABLE IF NOT EXISTS `solicitud_baja` (
  `ID_SOLICITUD_BAJA` int(11) NOT NULL AUTO_INCREMENT,
  `NRO_NOTA` int(11) DEFAULT NULL,
  `FECHA_SOLICITUD` datetime NOT NULL,
  `ID_TIPO_VENTA` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_SOLICITUD_BAJA`),
  KEY `ID_TIPO_VENTA` (`ID_TIPO_VENTA`),
  FOREIGN KEY (`ID_TIPO_VENTA`) REFERENCES `tipo_venta` (`ID_TIPO_VENTA`)
);

-- Volcando datos para la tabla a0210180_miva.solicitud_baja: ~0 rows (aproximadamente)

-- Volcando estructura para tabla a0210180_miva.marca
CREATE TABLE IF NOT EXISTS `marca` (
  `ID_MARCA` int(11) NOT NULL AUTO_INCREMENT,
  `MARCA` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_MARCA`)
);

-- Volcando datos para la tabla a0210180_miva.marca: ~12 rows (aproximadamente)
INSERT INTO `marca` (`ID_MARCA`, `MARCA`) VALUES
	(1, 'BILLION RESERVOIR'),
	(2, 'DAHUA'),
	(3, 'DIMAX'),
	(4, 'GENERICO'),
	(5, 'HAVIT'),
	(6, 'IMOU'),
	(7, 'SEAGATE'),
	(8, 'TAPO'),
	(9, 'TP-LINK'),
	(10, 'UGREEN'),
	(11, 'WESTERN DIGITAL'),
	(12, 'ZKTECO');

-- Volcando estructura para tabla a0210180_miva.mes
CREATE TABLE IF NOT EXISTS `mes` (
  `ID_MES` int(11) NOT NULL AUTO_INCREMENT,
  `MES` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_MES`)
);

-- Volcando datos para la tabla a0210180_miva.mes: ~12 rows (aproximadamente)
INSERT INTO `mes` (`ID_MES`, `MES`) VALUES
	(1, 'ENERO'),
	(2, 'FEBRERO'),
	(3, 'MARZO'),
	(4, 'ABRIL'),
	(5, 'MAYO'),
	(6, 'JUNIO'),
	(7, 'JULIO'),
	(8, 'AGOSTO'),
	(9, 'SEPTIEMBRE'),
	(10, 'OCTUBRE'),
	(11, 'NOVIEMBRE'),
	(12, 'DICIEMBRE');

-- Volcando estructura para tabla a0210180_miva.gestion
CREATE TABLE IF NOT EXISTS `gestion` (
  `ID_GESTION` int(11) NOT NULL,
  PRIMARY KEY (`ID_GESTION`)
);

-- Volcando datos para la tabla a0210180_miva.gestion: ~0 rows (aproximadamente)
INSERT INTO `gestion` (`ID_GESTION`) VALUES
	(2026);

-- Volcando estructura para tabla a0210180_miva.grupo
CREATE TABLE IF NOT EXISTS `grupo` (
  `ID_GRUPO` varchar(10) NOT NULL,
  `GRUPO` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_GRUPO`)
);

-- Volcando datos para la tabla a0210180_miva.grupo: ~2 rows (aproximadamente)
INSERT INTO `grupo` (`ID_GRUPO`, `GRUPO`) VALUES
	('PROD', 'PRODUCTO'),
	('SERV', 'SERVICIO');

-- Volcando estructura para tabla a0210180_miva.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `ID_EMPRESA` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_EMPRESA` varchar(50) DEFAULT NULL COMMENT 'NOMBRE DE LA EMPRESA',
  `NIT` bigint(20) DEFAULT NULL COMMENT 'NUMERO DE IDENTIFICACION TRIBUTARIA',
  `INICIO_GESTION` int(11) DEFAULT NULL COMMENT 'AÑO DE INICIO',
  `INICIO_MES` int(11) DEFAULT NULL COMMENT 'REPRESENTAR EL MES EN NUMERAL',
  `DIRECCION` varchar(200) DEFAULT NULL,
  `CIUDAD` varchar(50) DEFAULT NULL,
  `TELEFONO` int(11) DEFAULT NULL,
  `NOTA` varchar(500) DEFAULT NULL COMMENT 'NOTA PARA IMPRESION DE BOLETA',
  `TEMA` varchar(100) DEFAULT NULL COMMENT 'COLOR DE LA PAGINA',
  `LOGO` varchar(100) DEFAULT NULL COMMENT 'LOGO DE LA PAGINA',
  `LOGO_CABECERA` varchar(100) DEFAULT NULL COMMENT 'CABECERA PARA IMPRESION DE LA PAGINA',
  PRIMARY KEY (`ID_EMPRESA`)
);

-- Volcando datos para la tabla a0210180_miva.empresa: ~0 rows (aproximadamente)
INSERT INTO `empresa` (`ID_EMPRESA`, `NOMBRE_EMPRESA`, `NIT`, `INICIO_GESTION`, `INICIO_MES`, `DIRECCION`, `CIUDAD`, `TELEFONO`, `NOTA`, `TEMA`, `LOGO`, `LOGO_CABECERA`) VALUES
	(1, 'MIVAVISION', 5290570017, 2026, 11, 'CALLE ESTEBAN ARZE #1354 GALERIA FLORITA LOCAL 8 PLANTA BAJA', 'COCHABAMBA', 62612761, 'LA GARANTIA ES DE 1 AÑO EN EQUIPOS NUEVOS', 'verde', '../Iconos/logo_empresa.png', '../Iconos/logo_cabecera.png');

-- Volcando estructura para tabla a0210180_miva.deposito
CREATE TABLE IF NOT EXISTS `deposito` (
  `ID_DEPOSITO` int(11) NOT NULL AUTO_INCREMENT,
  `FECHA_DEPOSITO` date NOT NULL,
  `MONTO` double NOT NULL,
  `LITERAL` varchar(250) NOT NULL,
  `OBS` varchar(250) NOT NULL,
  `GESTION` int(11) NOT NULL,
  `PERIODO` int(11) NOT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  PRIMARY KEY (`ID_DEPOSITO`)
);

-- Volcando datos para la tabla a0210180_miva.deposito: ~0 rows (aproximadamente)

-- Volcando estructura para tabla a0210180_miva.compra_aux
CREATE TABLE IF NOT EXISTS `compra_aux` (
  `ID_COMPRA_AUX` int(11) NOT NULL AUTO_INCREMENT,
  `CANTIDAD` int(11) NOT NULL,
  `PRECIO_FACTURA` double NOT NULL,
  `PRECIO_VENTA` double NOT NULL,
  `UM_IMPUESTO` double NOT NULL,
  `VALOR` double NOT NULL,
  `ICE` double NOT NULL,
  `DESCUENTO` double NOT NULL,
  `TOTAL` double NOT NULL,
  `FECHA_CADUCIDAD` date DEFAULT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  `ID_USR` int(11) NOT NULL,
  PRIMARY KEY (`ID_COMPRA_AUX`),
  UNIQUE KEY `ID_ARTICULO` (`ID_ARTICULO`),
  KEY `ID_USR` (`ID_USR`)
);

-- Volcando datos para la tabla a0210180_miva.compra_aux: ~0 rows (aproximadamente)

-- Volcando estructura para tabla a0210180_miva.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `ID_CLIENTE` int(11) NOT NULL AUTO_INCREMENT,
  `TACHO` int(11) NOT NULL,
  `CI` varchar(15) DEFAULT NULL,
  `NOMBRE` varchar(250) NOT NULL,
  `APATERNO` varchar(50) NOT NULL,
  `AMATERNO` varchar(50) NOT NULL,
  `ID_TIPO_CLIENTE` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_CLIENTE`),
  KEY `ID_TIPO_CLIENTE` (`ID_TIPO_CLIENTE`),
  FOREIGN KEY (`ID_TIPO_CLIENTE`) REFERENCES `tipo_cliente` (`ID_TIPO_CLIENTE`)
);

-- Volcando datos para la tabla a0210180_miva.cliente: ~0 rows (aproximadamente)
INSERT INTO `cliente` (`ID_CLIENTE`, `TACHO`, `CI`, `NOMBRE`, `APATERNO`, `AMATERNO`, `ID_TIPO_CLIENTE`) VALUES
	(1, 1, '1', 'VENTAS CONTADO', '', '', 'NS');

-- Volcando estructura para tabla a0210180_miva.solicitud_venta
CREATE TABLE IF NOT EXISTS `solicitud_venta` (
  `ID_SOLICITUD_VENTA` int(11) NOT NULL AUTO_INCREMENT,
  `NRO_NOTA` int(11) DEFAULT NULL,
  `FECHA_SOLICITUD` datetime NOT NULL,
  `ID_USR` int(11) NOT NULL,
  `ID_CLIENTE` int(11) NOT NULL,
  `ID_TIPO_VENTA` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_SOLICITUD_VENTA`),
  KEY `ID_USR` (`ID_USR`),
  KEY `ID_CLIENTE` (`ID_CLIENTE`),
  KEY `ID_TIPO_VENTA` (`ID_TIPO_VENTA`),
  FOREIGN KEY (`ID_USR`) REFERENCES `usr` (`ID_USR`),
  CONSTRAINT `2` FOREIGN KEY (`ID_CLIENTE`) REFERENCES `cliente` (`ID_CLIENTE`),
  CONSTRAINT `3` FOREIGN KEY (`ID_TIPO_VENTA`) REFERENCES `tipo_venta` (`ID_TIPO_VENTA`)
);

-- Volcando datos para la tabla a0210180_miva.solicitud_venta: ~0 rows (aproximadamente)

-- Volcando estructura para tabla a0210180_miva.articulo
CREATE TABLE IF NOT EXISTS `articulo` (
  `ID_ARTICULO` int(11) NOT NULL AUTO_INCREMENT,
  `BARCODE` varchar(250) NOT NULL,
  `IMAGEN` varchar(250) DEFAULT NULL,
  `ARTCODE` varchar(250) NOT NULL,
  `ARTICULO` varchar(300) NOT NULL,
  `NOMBRE_BUSQUEDA` varchar(300) NOT NULL,
  `DESCRIPCION` varchar(250) NOT NULL,
  `PRECIO_COMPRA` double DEFAULT NULL,
  `PRECIO_VENTA` double DEFAULT NULL,
  `ID_MARCA` int(11) NOT NULL,
  `ID_GRUPO` varchar(10) NOT NULL,
  `ID_CATEGORIA` int(11) NOT NULL,
  `ID_UNIDAD` int(11) NOT NULL,
  PRIMARY KEY (`ID_ARTICULO`),
  KEY `ID_GRUPO` (`ID_GRUPO`),
  KEY `ID_MARCA` (`ID_MARCA`),
  KEY `ID_CATEGORIA` (`ID_CATEGORIA`) USING BTREE,
  KEY `ID_UNIDAD` (`ID_UNIDAD`) USING BTREE,
  FOREIGN KEY (`ID_GRUPO`) REFERENCES `grupo` (`ID_GRUPO`),
  FOREIGN KEY (`ID_MARCA`) REFERENCES `marca` (`ID_MARCA`),
  FOREIGN KEY (`ID_CATEGORIA`) REFERENCES `categoria` (`ID_CATEGORIA`),
  FOREIGN KEY (`ID_UNIDAD`) REFERENCES `unidad` (`ID_UNIDAD`)
);

-- Volcando datos para la tabla a0210180_miva.articulo: ~0 rows (aproximadamente)
INSERT INTO `articulo` (`ID_ARTICULO`, `BARCODE`, `IMAGEN`, `ARTCODE`, `ARTICULO`, `NOMBRE_BUSQUEDA`, `DESCRIPCION`, `PRECIO_COMPRA`, `PRECIO_VENTA`, `ID_MARCA`, `ID_GRUPO`, `ID_CATEGORIA`, `ID_UNIDAD`) VALUES
	(1, '', '../imagenes/imagen_IPC-K7FN-3H0WE-IMOU.png', 'IPC-K7FN-3H0WE-IMOU', 'CAMARA IP WIFI CRUISER SC 3MP *TIPO PT', 'CAMARA IP WIFI CRUISER SC 3MP *TIPO PT (IMOU)', 'CÁMARA IP WIFI CRUISER SC 3MP *TIPO PT *FULL COLOR *RASTERO INTELIGENTE *AUDIO BIDIRECCIONAL *1 PUERTO RJ45 *MICRO SD HASTA 512GB *PARA EXTERIORES *DISUASIVA', 0, 540, 6, 'PROD', 1, 1),
	(2, '', '../imagenes/imagen_IPC-K7FN-5H0WE-IMOU.png', 'IPC-K7FN-5H0WE-IMOU', 'CAMARA IP WIFI CRUISER SC+ 5MP', 'CAMARA IP WIFI CRUISER SC+ 5MP (IMOU)', 'CÁMARA IP WIFI CRUISER SC 5MP *TIPO PT *FULL COLOR *RASTERO INTELIGENTE *AUDIO BIDIRECCIONAL *1 PUERTO RJ45 *MICRO SD HASTA 512GB *PARA EXTERIORES *DISUASIVA', 0, 640, 6, 'PROD', 1, 1);

-- Volcando estructura para tabla a0210180_miva.pedido
CREATE TABLE IF NOT EXISTS `pedido` (
  `ID_PEDIDO` int(11) NOT NULL AUTO_INCREMENT,
  `CANTIDAD` int(11) NOT NULL,
  `FECHA_PEDIDO` datetime NOT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  `ID_SOLICITUD_COMPRA` int(11) NOT NULL,
  PRIMARY KEY (`ID_PEDIDO`),
  KEY `ID_ARTICULO` (`ID_ARTICULO`),
  KEY `ID_SOLICITUD_COMPRA` (`ID_SOLICITUD_COMPRA`),
  FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulo` (`ID_ARTICULO`),
  FOREIGN KEY (`ID_SOLICITUD_COMPRA`) REFERENCES `solicitud_compra` (`ID_SOLICITUD_COMPRA`)
);

-- Volcando datos para la tabla a0210180_miva.pedido: ~0 rows (aproximadamente)

-- Volcando estructura para tabla a0210180_miva.compra
CREATE TABLE IF NOT EXISTS `compra` (
  `ID_COMPRA` int(11) NOT NULL AUTO_INCREMENT,
  `NRO_FACTURA` int(11) NOT NULL,
  `FECHA_FACTURA` date NOT NULL,
  `CANTIDAD` int(11) NOT NULL,
  `PRECIO_FACTURA` double NOT NULL,
  `UM_IMPUESTO` double NOT NULL,
  `VALOR` double NOT NULL,
  `ICE` double NOT NULL,
  `DESCUENTO` double NOT NULL,
  `TOTAL` double NOT NULL,
  `FECHA_CADUCIDAD` date DEFAULT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  `ID_USR` int(11) NOT NULL,
  PRIMARY KEY (`ID_COMPRA`),
  KEY `ID_ARTICULO` (`ID_ARTICULO`),
  KEY `ID_USR` (`ID_USR`),
  FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulo` (`ID_ARTICULO`),
  FOREIGN KEY (`ID_USR`) REFERENCES `usr` (`ID_USR`)
);

-- Volcando datos para la tabla a0210180_miva.compra: ~2 rows (aproximadamente)
INSERT INTO `compra` (`ID_COMPRA`, `NRO_FACTURA`, `FECHA_FACTURA`, `CANTIDAD`, `PRECIO_FACTURA`, `UM_IMPUESTO`, `VALOR`, `ICE`, `DESCUENTO`, `TOTAL`, `FECHA_CADUCIDAD`, `FECHA_REGISTRO`, `ID_ARTICULO`, `ID_USR`) VALUES
	(1, 1, '2026-11-21', 1, 429, 0, 429, 0, 0, 429, '2027-11-15', '2026-11-21 03:06:59', 1, 1),
	(2, 1, '2026-11-21', 2, 519, 0, 519, 0, 0, 1038, '2027-11-15', '2026-11-21 03:06:59', 2, 1);

-- Volcando estructura para tabla a0210180_miva.almacen
CREATE TABLE IF NOT EXISTS `almacen` (
  `ID_ALMACEN` int(11) NOT NULL AUTO_INCREMENT,
  `ENTRADA` int(11) NOT NULL,
  `SALIDA` int(11) NOT NULL,
  `SALDO` int(11) NOT NULL,
  `ID_COMPRA` int(11) NOT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  PRIMARY KEY (`ID_ALMACEN`),
  KEY `ID_COMPRA` (`ID_COMPRA`),
  KEY `ID_ARTICULO` (`ID_ARTICULO`),
  FOREIGN KEY (`ID_COMPRA`) REFERENCES `compra` (`ID_COMPRA`),
  FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulo` (`ID_ARTICULO`)
);

-- Volcando datos para la tabla a0210180_miva.almacen: ~0 rows (aproximadamente)

-- Volcando estructura para tabla a0210180_miva.venta_credito
CREATE TABLE IF NOT EXISTS `venta_credito` (
  `ID_VENTA_CREDITO` int(11) NOT NULL,
  `PRECIO_COMPRA` double NOT NULL,
  `PRECIO_VENTA` double NOT NULL,
  `CANTIDAD` int(11) NOT NULL,
  `TOTAL` double NOT NULL,
  `OBS` varchar(250) NOT NULL,
  `ID_SOLICITUD_VENTA` int(11) NOT NULL,
  `ID_CLIENTE` int(11) NOT NULL,
  `ID_ALMACEN` int(11) NOT NULL,
  `ID_COMPRA` int(11) NOT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  PRIMARY KEY (`ID_VENTA_CREDITO`),
  KEY `ID_ALMACEN` (`ID_ALMACEN`),
  KEY `ID_COMPRA` (`ID_COMPRA`),
  KEY `ID_ARTICULO` (`ID_ARTICULO`),
  KEY `ID_CLIENTE` (`ID_CLIENTE`),
  KEY `ID_SOLICITUD_VENTA` (`ID_SOLICITUD_VENTA`),
  FOREIGN KEY (`ID_ALMACEN`) REFERENCES `almacen` (`ID_ALMACEN`),
  FOREIGN KEY (`ID_COMPRA`) REFERENCES `compra` (`ID_COMPRA`),
  FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulo` (`ID_ARTICULO`),
  FOREIGN KEY (`ID_CLIENTE`) REFERENCES `cliente` (`ID_CLIENTE`),
  FOREIGN KEY (`ID_SOLICITUD_VENTA`) REFERENCES `solicitud_venta` (`ID_SOLICITUD_VENTA`)
);

-- Volcando datos para la tabla a0210180_miva.venta_credito: ~0 rows (aproximadamente)

-- Volcando estructura para tabla a0210180_miva.venta_aux
CREATE TABLE IF NOT EXISTS `venta_aux` (
  `ID_VENTA_AUX` int(11) NOT NULL AUTO_INCREMENT,
  `PRECIO_COMPRA` double NOT NULL,
  `PRECIO_VENTA` double NOT NULL,
  `CANTIDAD` int(11) NOT NULL,
  `TOTAL` double NOT NULL,
  `NRO_NOTA` int(11) DEFAULT NULL,
  `ID_CLIENTE` int(11) NOT NULL,
  `ID_ALMACEN` int(11) NOT NULL,
  `ID_COMPRA` int(11) NOT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  `ID_USR` int(11) NOT NULL,
  `ID_TIPO_VENTA` varchar(10) NOT NULL,
  `CI_TACHO_CLIENTE` varchar(50) DEFAULT NULL,
  `NOMBRE_CLIENTE` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`ID_VENTA_AUX`),
  UNIQUE KEY `ID_ARTICULO` (`ID_ARTICULO`),
  KEY `ID_USR` (`ID_USR`),
  KEY `ID_ALMACEN` (`ID_ALMACEN`),
  KEY `ID_COMPRA` (`ID_COMPRA`),
  KEY `ID_CLIENTE` (`ID_CLIENTE`),
  FOREIGN KEY (`ID_USR`) REFERENCES `usr` (`ID_USR`),
  FOREIGN KEY (`ID_ALMACEN`) REFERENCES `almacen` (`ID_ALMACEN`),
  FOREIGN KEY (`ID_COMPRA`) REFERENCES `compra` (`ID_COMPRA`),
  FOREIGN KEY (`ID_CLIENTE`) REFERENCES `cliente` (`ID_CLIENTE`)
);

-- Volcando datos para la tabla a0210180_miva.venta_aux: ~0 rows (aproximadamente)

-- Volcando estructura para tabla a0210180_miva.venta
CREATE TABLE IF NOT EXISTS `venta` (
  `ID_VENTA` int(11) NOT NULL AUTO_INCREMENT,
  `PRECIO_COMPRA` double NOT NULL,
  `PRECIO_VENTA` double NOT NULL,
  `CANTIDAD` int(11) NOT NULL,
  `TOTAL` double DEFAULT NULL,
  `ID_SOLICITUD_VENTA` int(11) NOT NULL,
  `ID_CLIENTE` int(11) NOT NULL,
  `ID_ALMACEN` int(11) NOT NULL,
  `ID_COMPRA` int(11) NOT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  `ID_USR` int(11) NOT NULL,
  `CI_TACHO_CLIENTE` varchar(50) DEFAULT NULL,
  `NOMBRE_CLIENTE` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`ID_VENTA`),
  KEY `ID_USR` (`ID_USR`),
  KEY `ID_ALMACEN` (`ID_ALMACEN`),
  KEY `ID_COMPRA` (`ID_COMPRA`),
  KEY `ID_ARTICULO` (`ID_ARTICULO`),
  KEY `ID_CLIENTE` (`ID_CLIENTE`),
  KEY `ID_SOLICITUD_VENTA` (`ID_SOLICITUD_VENTA`),
  FOREIGN KEY (`ID_USR`) REFERENCES `usr` (`ID_USR`),
  FOREIGN KEY (`ID_ALMACEN`) REFERENCES `almacen` (`ID_ALMACEN`),
  FOREIGN KEY (`ID_COMPRA`) REFERENCES `compra` (`ID_COMPRA`),
  FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulo` (`ID_ARTICULO`),
  FOREIGN KEY (`ID_CLIENTE`) REFERENCES `cliente` (`ID_CLIENTE`),
  FOREIGN KEY (`ID_SOLICITUD_VENTA`) REFERENCES `solicitud_venta` (`ID_SOLICITUD_VENTA`)
);

-- Volcando datos para la tabla a0210180_miva.venta: ~0 rows (aproximadamente)

-- Volcando estructura para tabla a0210180_miva.vale
CREATE TABLE IF NOT EXISTS `vale` (
  `ID_VALE` int(11) NOT NULL AUTO_INCREMENT,
  `PRECIO_COMPRA` double NOT NULL,
  `PRECIO_VENTA` double NOT NULL,
  `CANTIDAD` int(11) NOT NULL,
  `TOTAL` double NOT NULL,
  `OBS` varchar(250) NOT NULL,
  `ID_ALMACEN` int(11) NOT NULL,
  `ID_COMPRA` int(11) NOT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  `ID_SOLICITUD_VENTA` int(11) NOT NULL,
  `ID_CLIENTE` int(11) NOT NULL,
  PRIMARY KEY (`ID_VALE`),
  KEY `ID_ALMACEN` (`ID_ALMACEN`),
  KEY `ID_COMPRA` (`ID_COMPRA`),
  KEY `ID_ARTICULO` (`ID_ARTICULO`),
  KEY `ID_SOLICITUD_VENTA` (`ID_SOLICITUD_VENTA`),
  KEY `ID_CLIENTE` (`ID_CLIENTE`),
  FOREIGN KEY (`ID_ALMACEN`) REFERENCES `almacen` (`ID_ALMACEN`),
  FOREIGN KEY (`ID_COMPRA`) REFERENCES `compra` (`ID_COMPRA`),
  FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulo` (`ID_ARTICULO`),
  FOREIGN KEY (`ID_SOLICITUD_VENTA`) REFERENCES `solicitud_venta` (`ID_SOLICITUD_VENTA`),
  FOREIGN KEY (`ID_CLIENTE`) REFERENCES `cliente` (`ID_CLIENTE`)
);

-- Volcando datos para la tabla a0210180_miva.vale: ~0 rows (aproximadamente)

-- Volcando estructura para tabla a0210180_miva.bitacora_precio
CREATE TABLE IF NOT EXISTS `bitacora_precio` (
  `ID_BITACORA_PRECIO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ARTICULO` int(11) NOT NULL,
  `ARTICULO` varchar(50) NOT NULL,
  `DESCRIPCION` varchar(250) NOT NULL,
  `PRECIO_COMPRA` double DEFAULT NULL,
  `PRECIO_VENTA` double DEFAULT NULL,
  `ID_MARCA` int(11) NOT NULL,
  `ID_GRUPO` varchar(10) NOT NULL,
  `ID_UNIDAD` int(11) NOT NULL,
  `ESTADO` varchar(50) NOT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  PRIMARY KEY (`ID_BITACORA_PRECIO`),
  KEY `ID_ARTICULO` (`ID_ARTICULO`),
  KEY `ID_MARCA` (`ID_MARCA`),
  KEY `ID_GRUPO` (`ID_GRUPO`),
  KEY `ID_UNIDAD` (`ID_UNIDAD`) USING BTREE,
  FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulo` (`ID_ARTICULO`),
  FOREIGN KEY (`ID_MARCA`) REFERENCES `marca` (`ID_MARCA`),
  FOREIGN KEY (`ID_GRUPO`) REFERENCES `grupo` (`ID_GRUPO`),
  FOREIGN KEY (`ID_UNIDAD`) REFERENCES `unidad` (`ID_UNIDAD`)
);

-- Volcando datos para la tabla a0210180_miva.bitacora_precio: ~0 rows (aproximadamente)

-- Volcando estructura para tabla a0210180_miva.kardex
CREATE TABLE IF NOT EXISTS `kardex` (
  `ID_KARDEX` int(11) NOT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  `NRO_NOTA` int(11) NOT NULL,
  `FISICO_INGRESO` int(11) NOT NULL,
  `FISICO_SALIDA` int(11) NOT NULL,
  `FISICO_SALDO` int(11) NOT NULL,
  `PU` double NOT NULL,
  `VALOR_INGRESO` double NOT NULL,
  `VALOR_SALIDA` double NOT NULL,
  `VALOR_SALDO` double NOT NULL,
  `ID_ALMACEN` int(11) NOT NULL,
  `ID_COMPRA` int(11) NOT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  `ID_TIPO_VENTA` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_KARDEX`),
  KEY `ID_ALMACEN` (`ID_ALMACEN`),
  KEY `ID_COMPRA` (`ID_COMPRA`),
  KEY `ID_ARTICULO` (`ID_ARTICULO`),
  KEY `ID_TIPO_VENTA` (`ID_TIPO_VENTA`),
  FOREIGN KEY (`ID_ALMACEN`) REFERENCES `almacen` (`ID_ALMACEN`),
  FOREIGN KEY (`ID_COMPRA`) REFERENCES `compra` (`ID_COMPRA`),
  FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulo` (`ID_ARTICULO`),
  FOREIGN KEY (`ID_TIPO_VENTA`) REFERENCES `tipo_venta` (`ID_TIPO_VENTA`)
);

-- Volcando datos para la tabla a0210180_miva.kardex: ~0 rows (aproximadamente)

-- Volcando estructura para tabla a0210180_miva.devolucion
CREATE TABLE IF NOT EXISTS `devolucion` (
  `ID_DEVOLUCION` int(11) NOT NULL AUTO_INCREMENT,
  `FECHA_DEVOLUCION` char(10) DEFAULT NULL,
  `PRECIO_COMPRA` double NOT NULL,
  `PRECIO_VENTA` double NOT NULL,
  `CANTIDAD` int(11) NOT NULL,
  `TOTAL` double NOT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  `OBS` varchar(250) NOT NULL,
  `ID_ALMACEN` int(11) NOT NULL,
  `ID_COMPRA` int(11) NOT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  `ID_SOLICITUD_DEV` int(11) NOT NULL,
  PRIMARY KEY (`ID_DEVOLUCION`),
  KEY `ID_ALMACEN` (`ID_ALMACEN`),
  KEY `ID_COMPRA` (`ID_COMPRA`),
  KEY `ID_ARTICULO` (`ID_ARTICULO`),
  KEY `ID_SOLICITUD_DEV` (`ID_SOLICITUD_DEV`),
  FOREIGN KEY (`ID_ALMACEN`) REFERENCES `almacen` (`ID_ALMACEN`),
  FOREIGN KEY (`ID_COMPRA`) REFERENCES `compra` (`ID_COMPRA`),
  FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulo` (`ID_ARTICULO`),
  FOREIGN KEY (`ID_SOLICITUD_DEV`) REFERENCES `solicitud_dev` (`ID_SOLICITUD_DEV`)
);

-- Volcando datos para la tabla a0210180_miva.devolucion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla a0210180_miva.cobro_credito
CREATE TABLE IF NOT EXISTS `cobro_credito` (
  `ID_COBRO_CREDITO` varchar(10) NOT NULL,
  `TOTAL_VENTA` double NOT NULL,
  `MONTO_COBRO` double NOT NULL,
  `TOTAL` double NOT NULL,
  `ID_VENTA_CREDITO` int(11) NOT NULL,
  `ID_SOLICITUD_VENTA` int(11) NOT NULL,
  `ID_CLIENTE` int(11) NOT NULL,
  `ID_ALMACEN` int(11) NOT NULL,
  `ID_COMPRA` int(11) NOT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  PRIMARY KEY (`ID_COBRO_CREDITO`),
  KEY `ID_VENTA_CREDITO` (`ID_VENTA_CREDITO`),
  KEY `ID_SOLICITUD_VENTA` (`ID_SOLICITUD_VENTA`),
  KEY `ID_CLIENTE` (`ID_CLIENTE`),
  KEY `ID_ALMACEN` (`ID_ALMACEN`),
  KEY `ID_COMPRA` (`ID_COMPRA`),
  KEY `ID_ARTICULO` (`ID_ARTICULO`),
  FOREIGN KEY (`ID_VENTA_CREDITO`) REFERENCES `venta_credito` (`ID_VENTA_CREDITO`),
  FOREIGN KEY (`ID_SOLICITUD_VENTA`) REFERENCES `solicitud_venta` (`ID_SOLICITUD_VENTA`),
  FOREIGN KEY (`ID_CLIENTE`) REFERENCES `cliente` (`ID_CLIENTE`),
  FOREIGN KEY (`ID_ALMACEN`) REFERENCES `almacen` (`ID_ALMACEN`),
  FOREIGN KEY (`ID_COMPRA`) REFERENCES `compra` (`ID_COMPRA`),
  FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulo` (`ID_ARTICULO`)
);

-- Volcando datos para la tabla a0210180_miva.cobro_credito: ~0 rows (aproximadamente)

-- Volcando estructura para tabla a0210180_miva.baja
CREATE TABLE IF NOT EXISTS `baja` (
  `ID_BAJA` int(11) NOT NULL AUTO_INCREMENT,
  `PRECIO_COMPRA` double NOT NULL,
  `PRECIO_VENTA` double NOT NULL,
  `CANTIDAD` int(11) NOT NULL,
  `TOTAL` double NOT NULL,
  `FECHA_BAJA` date NOT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  `OBS` varchar(250) NOT NULL,
  `ID_ALMACEN` int(11) NOT NULL,
  `ID_COMPRA` int(11) NOT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  `ID_SOLICITUD_BAJA` int(11) NOT NULL,
  PRIMARY KEY (`ID_BAJA`),
  KEY `ID_ALMACEN` (`ID_ALMACEN`),
  KEY `ID_COMPRA` (`ID_COMPRA`),
  KEY `ID_ARTICULO` (`ID_ARTICULO`),
  KEY `ID_SOLICITUD_BAJA` (`ID_SOLICITUD_BAJA`),
  FOREIGN KEY (`ID_ALMACEN`) REFERENCES `almacen` (`ID_ALMACEN`),
  FOREIGN KEY (`ID_COMPRA`) REFERENCES `compra` (`ID_COMPRA`),
  FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulo` (`ID_ARTICULO`),
  FOREIGN KEY (`ID_SOLICITUD_BAJA`) REFERENCES `solicitud_baja` (`ID_SOLICITUD_BAJA`)
);

-- Volcando datos para la tabla a0210180_miva.baja: ~0 rows (aproximadamente)

-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `stock`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `stock` AS select `r`.`ID_ARTICULO` AS `ID_ARTICULO`,`r`.`SALDO` AS `SALDO`,`r`.`ARTICULO` AS `ARTICULO`,`r`.`NOMBRE_BUSQUEDA` AS `NOMBRE_BUSQUEDA`,concat(`r`.`NOMBRE_BUSQUEDA`,' ==> ',`r`.`SALDO`) AS `NOMBRE_VENTA` from (select `m`.`ID_ARTICULO` AS `ID_ARTICULO`,`m`.`COMPRAS` AS `COMPRAS`,`m`.`VENTAS` AS `VENTAS`,(`m`.`COMPRAS` - `m`.`VENTAS`) AS `SALDO`,`m`.`ARTICULO` AS `ARTICULO`,`m`.`NOMBRE_BUSQUEDA` AS `NOMBRE_BUSQUEDA` from (select `z`.`id_articulo` AS `ID_ARTICULO`,sum(`z`.`COMPRAS`) AS `COMPRAS`,sum(`z`.`VENTAS`) AS `VENTAS`,`z`.`ARTICULO` AS `ARTICULO`,`z`.`nombre_busqueda` AS `NOMBRE_BUSQUEDA` from (select `c`.`ID_ARTICULO` AS `id_articulo`,sum(`c`.`CANTIDAD`) AS `COMPRAS`,0 AS `VENTAS`,`a`.`ARTICULO` AS `ARTICULO`,`a`.`NOMBRE_BUSQUEDA` AS `nombre_busqueda` from (`compra` `c` join `articulo` `a` on((`c`.`ID_ARTICULO` = `a`.`ID_ARTICULO`))) group by `c`.`ID_ARTICULO` union all select `v`.`ID_ARTICULO` AS `ID_ARTICULO`,0 AS `COMPRAS`,sum(`v`.`CANTIDAD`) AS `VENTAS`,`a`.`ARTICULO` AS `ARTICULO`,`a`.`NOMBRE_BUSQUEDA` AS `NOMBRE_BUSQUEDA` from (`venta` `v` join `articulo` `a` on((`v`.`ID_ARTICULO` = `a`.`ID_ARTICULO`))) group by `v`.`ID_ARTICULO` union all select `a`.`ID_ARTICULO` AS `ID_ARTICULO`,0 AS `COMPRAS`,0 AS `VENTAS`,`a`.`ARTICULO` AS `ARTICULO`,`a`.`NOMBRE_BUSQUEDA` AS `NOMBRE_BUSQUEDA` from `articulo` `a` group by `a`.`ID_ARTICULO`) `z` group by `z`.`id_articulo`,`z`.`ARTICULO`,`z`.`nombre_busqueda`) `m`) `r` order by `r`.`ID_ARTICULO` 
;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

