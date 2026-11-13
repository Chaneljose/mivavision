-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.37 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.7.0.6850
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para syscompunet
CREATE DATABASE IF NOT EXISTS `syscompunett` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `syscompunett`;

-- Volcando estructura para tabla syscompunet.almacen
CREATE TABLE IF NOT EXISTS `almacen` (
  `ID_ALMACEN` int NOT NULL AUTO_INCREMENT,
  `ENTRADA` int NOT NULL,
  `SALIDA` int NOT NULL,
  `SALDO` int NOT NULL,
  `ID_COMPRA` int NOT NULL,
  `ID_ARTICULO` int NOT NULL,
  PRIMARY KEY (`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.almacen: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.articulo
CREATE TABLE IF NOT EXISTS `articulo` (
  `ID_ARTICULO` int NOT NULL AUTO_INCREMENT,
  `BARCODE` varchar(250) NOT NULL,
  `ARTCODE` varchar(250) NOT NULL,
  `ARTICULO` varchar(300) NOT NULL,
  `NOMBRE_BUSQUEDA` varchar(300) NOT NULL,
  `DESCRIPCION` varchar(250) NOT NULL,
  `PRECIO_COMPRA` double DEFAULT NULL,
  `PRECIO_VENTA` double DEFAULT NULL,
  `ID_MARCA` int NOT NULL,
  `ID_GRUPO` varchar(10) NOT NULL,
  `ID_UNIDAD` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_ARTICULO`),
  KEY `Refmarca23` (`ID_MARCA`),
  KEY `Refgrupo24` (`ID_GRUPO`),
  KEY `Refunidad33` (`ID_UNIDAD`),
  CONSTRAINT `Refgrupo24` FOREIGN KEY (`ID_GRUPO`) REFERENCES `grupo` (`ID_GRUPO`) ON UPDATE CASCADE,
  CONSTRAINT `Refmarca23` FOREIGN KEY (`ID_MARCA`) REFERENCES `marca` (`ID_MARCA`) ON UPDATE CASCADE,
  CONSTRAINT `Refunidad33` FOREIGN KEY (`ID_UNIDAD`) REFERENCES `unidad` (`ID_UNIDAD`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.articulo: ~1 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.baja
CREATE TABLE IF NOT EXISTS `baja` (
  `ID_BAJA` int NOT NULL AUTO_INCREMENT,
  `PRECIO_COMPRA` double NOT NULL,
  `PRECIO_VENTA` double NOT NULL,
  `CANTIDAD` int NOT NULL,
  `TOTAL` double NOT NULL,
  `FECHA_BAJA` date NOT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  `OBS` varchar(250) NOT NULL,
  `ID_ALMACEN` int NOT NULL,
  `ID_COMPRA` int NOT NULL,
  `ID_ARTICULO` int NOT NULL,
  `ID_SOLICITUD_BAJA` int NOT NULL,
  PRIMARY KEY (`ID_BAJA`,`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`,`ID_SOLICITUD_BAJA`),
  KEY `Refsolicitud_baja54` (`ID_SOLICITUD_BAJA`),
  KEY `Refalmacen37` (`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  CONSTRAINT `Refalmacen37` FOREIGN KEY (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) REFERENCES `almacen` (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) ON UPDATE CASCADE,
  CONSTRAINT `Refsolicitud_baja54` FOREIGN KEY (`ID_SOLICITUD_BAJA`) REFERENCES `solicitud_baja` (`ID_SOLICITUD_BAJA`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.baja: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.bitacora_precio
CREATE TABLE IF NOT EXISTS `bitacora_precio` (
  `ID_BITACORA_PRECIO` int NOT NULL AUTO_INCREMENT,
  `ID_ARTICULO` int NOT NULL,
  `ARTICULO` varchar(50) NOT NULL,
  `DESCRIPCION` varchar(250) NOT NULL,
  `PRECIO_COMPRA` double DEFAULT NULL,
  `PRECIO_VENTA` double DEFAULT NULL,
  `ID_MARCA` int NOT NULL,
  `ID_GRUPO` varchar(10) NOT NULL,
  `ID_UNIDAD` varchar(10) NOT NULL,
  `ESTADO` varchar(50) NOT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  PRIMARY KEY (`ID_BITACORA_PRECIO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.bitacora_precio: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `ID_CLIENTE` int NOT NULL AUTO_INCREMENT,
  `TACHO` int NOT NULL,
  `CI` varchar(15) DEFAULT NULL,
  `NOMBRE` varchar(250) NOT NULL,
  `APATERNO` varchar(50) NOT NULL,
  `AMATERNO` varchar(50) NOT NULL,
  `ID_TIPO_CLIENTE` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_CLIENTE`),
  KEY `Reftipo_cliente17` (`ID_TIPO_CLIENTE`),
  CONSTRAINT `Reftipo_cliente17` FOREIGN KEY (`ID_TIPO_CLIENTE`) REFERENCES `tipo_cliente` (`ID_TIPO_CLIENTE`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.cliente: ~0 rows (aproximadamente)
INSERT INTO `cliente` (`ID_CLIENTE`, `TACHO`, `CI`, `NOMBRE`, `APATERNO`, `AMATERNO`, `ID_TIPO_CLIENTE`) VALUES
	(1, 1, '1', 'VENTAS CONTADO', '', '', 'NS');

-- Volcando estructura para tabla syscompunet.cobro_credito
CREATE TABLE IF NOT EXISTS `cobro_credito` (
  `ID_COBRO_CREDITO` varchar(10) NOT NULL,
  `TOTAL_VENTA` double NOT NULL,
  `MONTO_COBRO` double NOT NULL,
  `TOTAL` double NOT NULL,
  `ID_VENTA_CREDITO` int NOT NULL,
  `ID_SOLICITUD_VENTA` int NOT NULL,
  `ID_CLIENTE` int NOT NULL,
  `ID_ALMACEN` int NOT NULL,
  `ID_COMPRA` int NOT NULL,
  `ID_ARTICULO` int NOT NULL,
  PRIMARY KEY (`ID_COBRO_CREDITO`),
  KEY `Refventa_credito62` (`ID_VENTA_CREDITO`,`ID_SOLICITUD_VENTA`,`ID_CLIENTE`,`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  CONSTRAINT `Refventa_credito62` FOREIGN KEY (`ID_VENTA_CREDITO`, `ID_SOLICITUD_VENTA`, `ID_CLIENTE`, `ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) REFERENCES `venta_credito` (`ID_VENTA_CREDITO`, `ID_SOLICITUD_VENTA`, `ID_CLIENTE`, `ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.cobro_credito: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.compra
CREATE TABLE IF NOT EXISTS `compra` (
  `ID_COMPRA` int NOT NULL AUTO_INCREMENT,
  `NRO_FACTURA` int NOT NULL,
  `FECHA_FACTURA` date NOT NULL,
  `CANTIDAD` int NOT NULL,
  `PRECIO_FACTURA` double NOT NULL,
  `UM_IMPUESTO` double NOT NULL,
  `VALOR` double NOT NULL,
  `ICE` double NOT NULL,
  `DESCUENTO` double NOT NULL,
  `TOTAL` double NOT NULL,
  `FECHA_CADUCIDAD` date DEFAULT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  `ID_ARTICULO` int NOT NULL,
  PRIMARY KEY (`ID_COMPRA`,`ID_ARTICULO`),
  KEY `Refarticulo26` (`ID_ARTICULO`),
  CONSTRAINT `Refarticulo26` FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulo` (`ID_ARTICULO`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.compra: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.compra_aux
CREATE TABLE IF NOT EXISTS `compra_aux` (
  `ID_COMPRA_AUX` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`ID_COMPRA_AUX`,`ID_ARTICULO`),
  UNIQUE KEY `ID_ARTICULO` (`ID_ARTICULO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- Volcando datos para la tabla syscompunet.compra_aux: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.deposito
CREATE TABLE IF NOT EXISTS `deposito` (
  `ID_DEPOSITO` int NOT NULL AUTO_INCREMENT,
  `FECHA_DEPOSITO` date NOT NULL,
  `MONTO` double NOT NULL,
  `LITERAL` varchar(250) NOT NULL,
  `OBS` varchar(250) NOT NULL,
  `GESTION` int NOT NULL,
  `PERIODO` int NOT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  PRIMARY KEY (`ID_DEPOSITO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.deposito: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.devolucion
CREATE TABLE IF NOT EXISTS `devolucion` (
  `ID_DEVOLUCION` int NOT NULL AUTO_INCREMENT,
  `FECHA_DEVOLUCION` char(10) DEFAULT NULL,
  `PRECIO_COMPRA` double NOT NULL,
  `PRECIO_VENTA` double NOT NULL,
  `CANTIDAD` int NOT NULL,
  `TOTAL` double NOT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  `OBS` varchar(250) NOT NULL,
  `ID_ALMACEN` int NOT NULL,
  `ID_COMPRA` int NOT NULL,
  `ID_ARTICULO` int NOT NULL,
  `ID_SOLICITUD_DEV` int NOT NULL,
  PRIMARY KEY (`ID_DEVOLUCION`,`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`,`ID_SOLICITUD_DEV`),
  KEY `Refsolicitud_dev57` (`ID_SOLICITUD_DEV`),
  KEY `Refalmacen38` (`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  CONSTRAINT `Refalmacen38` FOREIGN KEY (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) REFERENCES `almacen` (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) ON UPDATE CASCADE,
  CONSTRAINT `Refsolicitud_dev57` FOREIGN KEY (`ID_SOLICITUD_DEV`) REFERENCES `solicitud_dev` (`ID_SOLICITUD_DEV`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.devolucion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `ID_EMPRESA` int NOT NULL AUTO_INCREMENT,
  `NOMBRE_EMPRESA` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL COMMENT 'NOMBRE DE LA EMPRESA',
  `NIT` bigint DEFAULT NULL COMMENT 'NUMERO DE IDENTIFICACION TRIBUTARIA',
  `INICIO_GESTION` int DEFAULT NULL COMMENT 'AÑO DE INICIO',
  `INICIO_MES` int DEFAULT NULL COMMENT 'REPRESENTAR EL MES EN NUMERAL',
  `DIRECCION` varchar(50) DEFAULT NULL,
  `CIUDAD` varchar(50) DEFAULT NULL,
  `TELEFONO` int DEFAULT NULL,
  PRIMARY KEY (`ID_EMPRESA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.empresa: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.gestion
CREATE TABLE IF NOT EXISTS `gestion` (
  `ID_GESTION` int NOT NULL,
  PRIMARY KEY (`ID_GESTION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.gestion: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.grupo
CREATE TABLE IF NOT EXISTS `grupo` (
  `ID_GRUPO` varchar(10) NOT NULL,
  `GRUPO` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_GRUPO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.grupo: ~2 rows (aproximadamente)
INSERT INTO `grupo` (`ID_GRUPO`, `GRUPO`) VALUES
	('PROD', 'PRODUCTO'),
	('SERV', 'SERVICIO');

-- Volcando estructura para tabla syscompunet.kardex
CREATE TABLE IF NOT EXISTS `kardex` (
  `ID_KARDEX` int NOT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  `NRO_NOTA` int NOT NULL,
  `FISICO_INGRESO` int NOT NULL,
  `FISICO_SALIDA` int NOT NULL,
  `FISICO_SALDO` int NOT NULL,
  `PU` double NOT NULL,
  `VALOR_INGRESO` double NOT NULL,
  `VALOR_SALIDA` double NOT NULL,
  `VALOR_SALDO` double NOT NULL,
  `ID_ALMACEN` int NOT NULL,
  `ID_COMPRA` int NOT NULL,
  `ID_ARTICULO` int NOT NULL,
  `ID_TIPO_VENTA` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_KARDEX`,`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  KEY `Refalmacen58` (`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  KEY `Reftipo_venta60` (`ID_TIPO_VENTA`),
  CONSTRAINT `Refalmacen58` FOREIGN KEY (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) REFERENCES `almacen` (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) ON UPDATE CASCADE,
  CONSTRAINT `Reftipo_venta60` FOREIGN KEY (`ID_TIPO_VENTA`) REFERENCES `tipo_venta` (`ID_TIPO_VENTA`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.kardex: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.marca
CREATE TABLE IF NOT EXISTS `marca` (
  `ID_MARCA` int NOT NULL AUTO_INCREMENT,
  `MARCA` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_MARCA`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.marca: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.mes
CREATE TABLE IF NOT EXISTS `mes` (
  `ID_MES` int NOT NULL AUTO_INCREMENT,
  `MES` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_MES`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.mes: ~12 rows (aproximadamente)
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

-- Volcando estructura para tabla syscompunet.pedido
CREATE TABLE IF NOT EXISTS `pedido` (
  `ID_PEDIDO` int NOT NULL AUTO_INCREMENT,
  `CANTIDAD` int NOT NULL,
  `FECHA_PEDIDO` datetime NOT NULL,
  `ID_ARTICULO` int NOT NULL,
  `ID_SOLICITUD_COMPRA` int NOT NULL,
  PRIMARY KEY (`ID_PEDIDO`,`ID_SOLICITUD_COMPRA`),
  KEY `Refarticulo30` (`ID_ARTICULO`),
  KEY `Refsolicitud_compra46` (`ID_SOLICITUD_COMPRA`),
  CONSTRAINT `Refarticulo30` FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulo` (`ID_ARTICULO`) ON UPDATE CASCADE,
  CONSTRAINT `Refsolicitud_compra46` FOREIGN KEY (`ID_SOLICITUD_COMPRA`) REFERENCES `solicitud_compra` (`ID_SOLICITUD_COMPRA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.pedido: ~0 rows (aproximadamente)

-- Volcando estructura para procedimiento syscompunet.prc_kardex
DELIMITER //
CREATE PROCEDURE `prc_kardex`(IN `var_art` INT)
BEGIN
DECLARE FECHA DATETIME;
DECLARE CODIGO INT(10);
DECLARE ARTICULO VARCHAR(256);
DECLARE TIPO VARCHAR(256);
DECLARE ENTRADA INT(10);
DECLARE SALIDA INT(10);
DECLARE PU DOUBLE;
DECLARE PC DOUBLE;
DECLARE PV DOUBLE;

DECLARE var INT DEFAULT 0;

DECLARE cur_kdx CURSOR FOR
	SELECT *
	FROM KARDEX
	ORDER BY 1 DESC LIMIT 1;

DECLARE cur_compra CURSOR FOR		
		SELECT c.FECHA_REGISTRO
		, 		 a.ID_ARTICULO
		, 		 r.ARTICULO
		, 		 CONCAT('F-',LPAD(c.NRO_FACTURA,'7','0')) TIPO
		,		 a.ENTRADA
		, 		 a.SALIDA
		,		 (c.TOTAL * 0.87)/a.ENTRADA PU
		,		 c.TOTAL * 0.87 PC
		,		 0 PV
		FROM almacen a JOIN articulo r ON a.ID_ARTICULO = r.ID_ARTICULO
						   JOIN compra c ON a.ID_COMPRA = c.ID_COMPRA
		WHERE a.ID_ARTICULO = var_art;
		
DECLARE CONTINUE HANDLER FOR NOT FOUND SET var = 1;

CREATE TEMPORARY TABLE IF NOT EXISTS temp
(
	T_FECHA DATETIME
,	T_CODIGO INT(10)
,	T_ARTICULO VARCHAR(256)
,	T_TIPO VARCHAR(256)
,	T_ENTRADA INT(10)
,	T_SALIDA INT(10)
,	T_PU DOUBLE
,	T_PC DOUBLE
,	T_PV DOUBLE
);

OPEN CUR_COMPRA;
	ciclo:LOOP
		FETCH CUR_COMPRA INTO 	FECHA
							  ,		CODIGO
							  ,		ARTICULO
							  ,		TIPO
							  ,		ENTRADA
							  ,		SALIDA
							  ,		PU
							  ,		PC
							  ,		PV;
			
			IF var=1 THEN
				LEAVE ciclo;
			END IF;
		
		INSERT INTO temp ( T_FECHA
							  , T_CODIGO
							  , T_ARTICULO
							  , T_TIPO
							  , T_ENTRADA
							  , T_SALIDA
							  , T_PU
							  , T_PC
							  , T_PV
							  )
				 VALUES ( FECHA
				 		  , CODIGO
				 		  , ARTICULO
				 		  , TIPO
				 		  , ENTRADA
				 		  , SALIDA
				 		  , PU
				 		  , PC
				 		  , PV
				 		  );
	END LOOP ciclo;
CLOSE CUR_COMPRA;

SELECT *
FROM temp;

DROP TABLE temp;

END//
DELIMITER ;

-- Volcando estructura para tabla syscompunet.solicitud_baja
CREATE TABLE IF NOT EXISTS `solicitud_baja` (
  `ID_SOLICITUD_BAJA` int NOT NULL AUTO_INCREMENT,
  `NRO_NOTA` int DEFAULT NULL,
  `FECHA_SOLICITUD` datetime NOT NULL,
  `ID_TIPO_VENTA` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_SOLICITUD_BAJA`),
  KEY `Reftipo_venta51` (`ID_TIPO_VENTA`),
  CONSTRAINT `Reftipo_venta51` FOREIGN KEY (`ID_TIPO_VENTA`) REFERENCES `tipo_venta` (`ID_TIPO_VENTA`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.solicitud_baja: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.solicitud_compra
CREATE TABLE IF NOT EXISTS `solicitud_compra` (
  `ID_SOLICITUD_COMPRA` int NOT NULL AUTO_INCREMENT,
  `FECHA_SOLICITUD` date NOT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  `ID_ESTADO_SOLICITUD` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_SOLICITUD_COMPRA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.solicitud_compra: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.solicitud_dev
CREATE TABLE IF NOT EXISTS `solicitud_dev` (
  `ID_SOLICITUD_DEV` int NOT NULL AUTO_INCREMENT,
  `NRO_NOTA` int DEFAULT NULL,
  `FECHA_SOLICITUD` datetime NOT NULL,
  `ID_TIPO_VENTA` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_SOLICITUD_DEV`),
  KEY `Reftipo_venta56` (`ID_TIPO_VENTA`),
  CONSTRAINT `Reftipo_venta56` FOREIGN KEY (`ID_TIPO_VENTA`) REFERENCES `tipo_venta` (`ID_TIPO_VENTA`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.solicitud_dev: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.solicitud_venta
CREATE TABLE IF NOT EXISTS `solicitud_venta` (
  `ID_SOLICITUD_VENTA` int(11) NOT NULL AUTO_INCREMENT,
  `NRO_NOTA` int(11) DEFAULT NULL,
  `FECHA_SOLICITUD` datetime NOT NULL,
  `ID_USR` int(11) NOT NULL,
  `ID_CLIENTE` int(11) NOT NULL,
  `ID_TIPO_VENTA` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_SOLICITUD_VENTA`,`ID_CLIENTE`,`ID_USR`) USING BTREE,
  KEY `Refcliente18` (`ID_CLIENTE`),
  KEY `Reftipo_venta45` (`ID_TIPO_VENTA`),
  KEY `Reftipo_usr` (`ID_USR`),
  CONSTRAINT `Reftipo_usr` FOREIGN KEY (`ID_USR`) REFERENCES `usr` (`ID_USR`) ON UPDATE CASCADE,
  CONSTRAINT `Reftipo_venta45` FOREIGN KEY (`ID_TIPO_VENTA`) REFERENCES `tipo_venta` (`ID_TIPO_VENTA`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla syscompunet.solicitud_venta: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.tipo_cliente
CREATE TABLE IF NOT EXISTS `tipo_cliente` (
  `ID_TIPO_CLIENTE` varchar(10) NOT NULL,
  `TIPO` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_TIPO_CLIENTE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.tipo_cliente: ~0 rows (aproximadamente)
INSERT INTO `tipo_cliente` (`ID_TIPO_CLIENTE`, `TIPO`) VALUES
	('NS', 'NO SOCIO'),
	('S', 'SOCIO');

-- Volcando estructura para tabla syscompunet.tipo_usr
CREATE TABLE IF NOT EXISTS `tipo_usr` (
  `ID_TIPO_USR` int NOT NULL AUTO_INCREMENT,
  `TIPO_USR` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_TIPO_USR`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.tipo_usr: ~2 rows (aproximadamente)
INSERT INTO `tipo_usr` (`ID_TIPO_USR`, `TIPO_USR`) VALUES
	(1, 'ADMINISTRADOR'),
	(2, 'VENTAS');

-- Volcando estructura para tabla syscompunet.tipo_venta
CREATE TABLE IF NOT EXISTS `tipo_venta` (
  `ID_TIPO_VENTA` varchar(10) NOT NULL,
  `TIPO` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_TIPO_VENTA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.tipo_venta: ~0 rows (aproximadamente)
INSERT INTO `tipo_venta` (`ID_TIPO_VENTA`, `TIPO`) VALUES
	('BJA', 'BAJA'),
	('CNT', 'CONTADO'),
	('CRD', 'CREDITO'),
	('CSM', 'CONSUMO'),
	('DEV', 'DEVOLUCION'),
	('QR', 'PAGO QR');

-- Volcando estructura para tabla syscompunet.unidad
CREATE TABLE IF NOT EXISTS `unidad` (
  `ID_UNIDAD` varchar(10) NOT NULL,
  `UNIDAD` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_UNIDAD`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.unidad: ~1 rows (aproximadamente)
INSERT INTO `unidad` (`ID_UNIDAD`, `UNIDAD`) VALUES
	('UNI', 'UNIDAD');

-- Volcando estructura para tabla syscompunet.usr
CREATE TABLE IF NOT EXISTS `usr` (
  `ID_USR` int NOT NULL AUTO_INCREMENT,
  `USR` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `PSWR` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `NOMBRE` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `APELLIDOP` varchar(50) NOT NULL,
  `APELLIDOM` varchar(50) NOT NULL,
  `FECHA_NAC` date NOT NULL,
  `CI` varchar(50) NOT NULL,
  `ID_TIPO_USR` int NOT NULL,
  PRIMARY KEY (`ID_USR`,`ID_TIPO_USR`),
  UNIQUE KEY `USR` (`USR`),
  KEY `Reftipo_usr63` (`ID_TIPO_USR`),
  CONSTRAINT `Reftipo_usr63` FOREIGN KEY (`ID_TIPO_USR`) REFERENCES `tipo_usr` (`ID_TIPO_USR`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.usr: ~1 rows (aproximadamente)
INSERT INTO `usr` (`ID_USR`, `USR`, `PSWR`, `NOMBRE`, `APELLIDOP`, `APELLIDOM`, `FECHA_NAC`, `CI`, `ID_TIPO_USR`) VALUES
	(1, 'ADMIN', '$2y$10$w7ycSJ9WbB11Zg7dZpM8m.cwmW/zUf1pMHWWsl2UajpoHAEeowX4G', 'CHANEL JOSE', 'CONDORI', 'YUCRA', '1984-07-14', '5290570', 1);

-- Volcando estructura para tabla syscompunet.vale
CREATE TABLE IF NOT EXISTS `vale` (
  `ID_VALE` int NOT NULL AUTO_INCREMENT,
  `PRECIO_COMPRA` double NOT NULL,
  `PRECIO_VENTA` double NOT NULL,
  `CANTIDAD` int NOT NULL,
  `TOTAL` double NOT NULL,
  `OBS` varchar(250) NOT NULL,
  `ID_ALMACEN` int NOT NULL,
  `ID_COMPRA` int NOT NULL,
  `ID_ARTICULO` int NOT NULL,
  `ID_SOLICITUD_VENTA` int NOT NULL,
  `ID_CLIENTE` int NOT NULL,
  PRIMARY KEY (`ID_VALE`,`ID_SOLICITUD_VENTA`,`ID_CLIENTE`),
  KEY `Refalmacen43` (`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  KEY `Refsolicitud_venta44` (`ID_SOLICITUD_VENTA`,`ID_CLIENTE`),
  CONSTRAINT `Refalmacen43` FOREIGN KEY (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) REFERENCES `almacen` (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) ON UPDATE CASCADE,
  CONSTRAINT `Refsolicitud_venta44` FOREIGN KEY (`ID_SOLICITUD_VENTA`, `ID_CLIENTE`) REFERENCES `solicitud_venta` (`ID_SOLICITUD_VENTA`, `ID_CLIENTE`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.vale: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.venta
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
  PRIMARY KEY (`ID_VENTA`,`ID_SOLICITUD_VENTA`,`ID_CLIENTE`,`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`,`ID_USR`) USING BTREE,
  KEY `Refsolicitud_venta21` (`ID_SOLICITUD_VENTA`,`ID_CLIENTE`),
  KEY `Refalmacen28` (`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  KEY `ID_USR` (`ID_USR`),
  CONSTRAINT `Ref_idusr2` FOREIGN KEY (`ID_USR`) REFERENCES `usr` (`ID_USR`) ON UPDATE CASCADE,
  CONSTRAINT `Refalmacen28` FOREIGN KEY (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) REFERENCES `almacen` (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) ON UPDATE CASCADE,
  CONSTRAINT `Refsolicitud_venta21` FOREIGN KEY (`ID_SOLICITUD_VENTA`, `ID_CLIENTE`) REFERENCES `solicitud_venta` (`ID_SOLICITUD_VENTA`, `ID_CLIENTE`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla syscompunet.venta: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.venta_aux
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
  PRIMARY KEY (`ID_VENTA_AUX`,`ID_CLIENTE`,`ID_ARTICULO`),
  UNIQUE KEY `ID_ARTICULO` (`ID_ARTICULO`),
  KEY `ID_USR` (`ID_USR`),
  CONSTRAINT `Ref_idusr` FOREIGN KEY (`ID_USR`) REFERENCES `usr` (`ID_USR`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- Volcando datos para la tabla syscompunet.venta_aux: ~0 rows (aproximadamente)

-- Volcando estructura para tabla syscompunet.venta_credito
CREATE TABLE IF NOT EXISTS `venta_credito` (
  `ID_VENTA_CREDITO` int NOT NULL,
  `PRECIO_COMPRA` double NOT NULL,
  `PRECIO_VENTA` double NOT NULL,
  `CANTIDAD` int NOT NULL,
  `TOTAL` double NOT NULL,
  `OBS` varchar(250) NOT NULL,
  `ID_SOLICITUD_VENTA` int NOT NULL,
  `ID_CLIENTE` int NOT NULL,
  `ID_ALMACEN` int NOT NULL,
  `ID_COMPRA` int NOT NULL,
  `ID_ARTICULO` int NOT NULL,
  PRIMARY KEY (`ID_VENTA_CREDITO`,`ID_SOLICITUD_VENTA`,`ID_CLIENTE`,`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  KEY `Refsolicitud_venta49` (`ID_SOLICITUD_VENTA`,`ID_CLIENTE`),
  KEY `Refalmacen50` (`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  CONSTRAINT `Refalmacen50` FOREIGN KEY (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) REFERENCES `almacen` (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) ON UPDATE CASCADE,
  CONSTRAINT `Refsolicitud_venta49` FOREIGN KEY (`ID_SOLICITUD_VENTA`, `ID_CLIENTE`) REFERENCES `solicitud_venta` (`ID_SOLICITUD_VENTA`, `ID_CLIENTE`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla syscompunet.venta_credito: ~0 rows (aproximadamente)

-- Volcando estructura para vista syscompunet.stock
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `stock` (
	`ID_ARTICULO` INT(11) NOT NULL,
	`SALDO` DECIMAL(55,0) NULL,
	`ARTICULO` VARCHAR(1) NOT NULL COLLATE 'latin1_swedish_ci',
	`NOMBRE_BUSQUEDA` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
  `NOMBRE_VENTA` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci'
);

-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `stock`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `stock` AS select `r`.`ID_ARTICULO` AS `ID_ARTICULO`,`r`.`SALDO` AS `SALDO`,`r`.`ARTICULO` AS `ARTICULO`,`r`.`NOMBRE_BUSQUEDA` AS `NOMBRE_BUSQUEDA`,concat(`r`.`NOMBRE_BUSQUEDA`,' ==> ',`r`.`SALDO`) AS `NOMBRE_VENTA` from (select `m`.`ID_ARTICULO` AS `ID_ARTICULO`,`m`.`COMPRAS` AS `COMPRAS`,`m`.`VENTAS` AS `VENTAS`,(`m`.`COMPRAS` - `m`.`VENTAS`) AS `SALDO`,`m`.`ARTICULO` AS `ARTICULO`,`m`.`NOMBRE_BUSQUEDA` AS `NOMBRE_BUSQUEDA` from (select `z`.`id_articulo` AS `ID_ARTICULO`,sum(`z`.`COMPRAS`) AS `COMPRAS`,sum(`z`.`VENTAS`) AS `VENTAS`,`z`.`ARTICULO` AS `ARTICULO`,`z`.`nombre_busqueda` AS `NOMBRE_BUSQUEDA` from (select `c`.`ID_ARTICULO` AS `id_articulo`,sum(`c`.`CANTIDAD`) AS `COMPRAS`,0 AS `VENTAS`,`a`.`ARTICULO` AS `ARTICULO`,`a`.`NOMBRE_BUSQUEDA` AS `nombre_busqueda` from (`compra` `c` join `articulo` `a` on((`c`.`ID_ARTICULO` = `a`.`ID_ARTICULO`))) group by `c`.`ID_ARTICULO` union all select `v`.`ID_ARTICULO` AS `ID_ARTICULO`,0 AS `COMPRAS`,sum(`v`.`CANTIDAD`) AS `VENTAS`,`a`.`ARTICULO` AS `ARTICULO`,`a`.`NOMBRE_BUSQUEDA` AS `NOMBRE_BUSQUEDA` from (`venta` `v` join `articulo` `a` on((`v`.`ID_ARTICULO` = `a`.`ID_ARTICULO`))) group by `v`.`ID_ARTICULO` union all select `a`.`ID_ARTICULO` AS `ID_ARTICULO`,0 AS `COMPRAS`,0 AS `VENTAS`,`a`.`ARTICULO` AS `ARTICULO`,`a`.`NOMBRE_BUSQUEDA` AS `NOMBRE_BUSQUEDA` from `articulo` `a` group by `a`.`ID_ARTICULO`) `z` group by `z`.`id_articulo`,`z`.`ARTICULO`,`z`.`nombre_busqueda`) `m`) `r` where (`r`.`SALDO` >= 0) order by `r`.`ID_ARTICULO` 
;


-- Volcando datos para la tabla syscompunet.stock: ~0 rows (aproximadamente)

-- Volcando estructura para disparador syscompunet.TBitacoraInsert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE TRIGGER `TBitacoraInsert` AFTER INSERT ON `articulo` FOR EACH ROW BEGIN
INSERT INTO bitacora_precio( ID_ARTICULO
									, ARTICULO
									, DESCRIPCION
									, PRECIO_COMPRA
									, PRECIO_VENTA
									, ID_MARCA
									, ID_GRUPO
									, ID_UNIDAD
									, ESTADO
									, FECHA_REGISTRO 
									)
						   VALUES( NEW.ID_ARTICULO
						   	   , NEW.ARTICULO
						   	   , NEW.DESCRIPCION
						   	   , NEW.PRECIO_COMPRA
						   	   , NEW.PRECIO_VENTA
						   	   , NEW.ID_MARCA
						   	   , NEW.ID_GRUPO
						   	   , NEW.ID_UNIDAD
						   	   , 'INSERTADO'
						   	   , NOW()
									);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Volcando estructura para disparador syscompunet.TBitacoraUpdate
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE TRIGGER `TBitacoraUpdate` AFTER UPDATE ON `articulo` FOR EACH ROW BEGIN
INSERT INTO bitacora_precio( ID_ARTICULO
									, ARTICULO
									, DESCRIPCION
									, PRECIO_COMPRA
									, PRECIO_VENTA
									, ID_MARCA
									, ID_GRUPO
									, ID_UNIDAD
									, ESTADO
									, FECHA_REGISTRO 
									)
						   VALUES( NEW.ID_ARTICULO
						   	   , NEW.ARTICULO
						   	   , NEW.DESCRIPCION
						   	   , NEW.PRECIO_COMPRA
						   	   , NEW.PRECIO_VENTA
						   	   , NEW.ID_MARCA
						   	   , NEW.ID_GRUPO
						   	   , NEW.ID_UNIDAD
						   	   , 'ACTUALIZADO'
						   	   , NOW()
									);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Volcando estructura para disparador syscompunet.TComprasInsert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE TRIGGER `TComprasInsert` AFTER INSERT ON `compra` FOR EACH ROW BEGIN
INSERT INTO almacen(ENTRADA, SALIDA, SALDO, ID_COMPRA, ID_ARTICULO)
		 VALUES(NEW.CANTIDAD, '0',  NEW.CANTIDAD, NEW.ID_COMPRA, NEW.ID_ARTICULO);

SET @total=0;
UPDATE almacen a
SET a.SALDO = (@total:= (@total + a.ENTRADA) - a.SALIDA)
WHERE a.ID_ARTICULO = NEW.ID_ARTICULO;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
