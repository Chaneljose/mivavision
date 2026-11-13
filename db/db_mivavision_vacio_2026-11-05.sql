-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         13.0.2-MariaDB-log - MariaDB Server
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.21.0.7344
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para mivavision
CREATE DATABASE IF NOT EXISTS `mivavision` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `mivavision`;

-- Volcando estructura para tabla mivavision.almacen
CREATE TABLE IF NOT EXISTS `almacen` (
  `ID_ALMACEN` int(11) NOT NULL AUTO_INCREMENT,
  `ENTRADA` int(11) NOT NULL,
  `SALIDA` int(11) NOT NULL,
  `SALDO` int(11) NOT NULL,
  `ID_COMPRA` int(11) NOT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  PRIMARY KEY (`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.articulo
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
  `ID_UNIDAD` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_ARTICULO`),
  KEY `Refmarca23` (`ID_MARCA`),
  KEY `Refgrupo24` (`ID_GRUPO`),
  KEY `Refunidad33` (`ID_UNIDAD`),
  CONSTRAINT `Refgrupo24` FOREIGN KEY (`ID_GRUPO`) REFERENCES `grupo` (`ID_GRUPO`) ON UPDATE CASCADE,
  CONSTRAINT `Refmarca23` FOREIGN KEY (`ID_MARCA`) REFERENCES `marca` (`ID_MARCA`) ON UPDATE CASCADE,
  CONSTRAINT `Refunidad33` FOREIGN KEY (`ID_UNIDAD`) REFERENCES `unidad` (`ID_UNIDAD`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.articulo_prueba
CREATE TABLE IF NOT EXISTS `articulo_prueba` (
  `id_articulo_prueba` int(11) NOT NULL,
  `barcode` varchar(250) NOT NULL DEFAULT '',
  `imagen` varchar(250) DEFAULT '',
  `artcode` varchar(250) NOT NULL DEFAULT '',
  `articulo` varchar(250) NOT NULL DEFAULT '',
  `nombre_busqueda` varchar(250) NOT NULL DEFAULT '',
  `descripcion` varchar(250) NOT NULL DEFAULT '',
  `precio_compra` double NOT NULL DEFAULT 0,
  `precio_venta` double NOT NULL DEFAULT 0,
  `id_marca` int(11) NOT NULL DEFAULT 0,
  `id_grupo` varchar(10) NOT NULL DEFAULT '0',
  `id_unidad` varchar(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_articulo_prueba`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.baja
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
  PRIMARY KEY (`ID_BAJA`,`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`,`ID_SOLICITUD_BAJA`),
  KEY `Refsolicitud_baja54` (`ID_SOLICITUD_BAJA`),
  KEY `Refalmacen37` (`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  CONSTRAINT `Refalmacen37` FOREIGN KEY (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) REFERENCES `almacen` (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) ON UPDATE CASCADE,
  CONSTRAINT `Refsolicitud_baja54` FOREIGN KEY (`ID_SOLICITUD_BAJA`) REFERENCES `solicitud_baja` (`ID_SOLICITUD_BAJA`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.bitacora_precio
CREATE TABLE IF NOT EXISTS `bitacora_precio` (
  `ID_BITACORA_PRECIO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ARTICULO` int(11) NOT NULL,
  `ARTICULO` varchar(50) NOT NULL,
  `DESCRIPCION` varchar(250) NOT NULL,
  `PRECIO_COMPRA` double DEFAULT NULL,
  `PRECIO_VENTA` double DEFAULT NULL,
  `ID_MARCA` int(11) NOT NULL,
  `ID_GRUPO` varchar(10) NOT NULL,
  `ID_UNIDAD` varchar(10) NOT NULL,
  `ESTADO` varchar(50) NOT NULL,
  `FECHA_REGISTRO` datetime NOT NULL,
  PRIMARY KEY (`ID_BITACORA_PRECIO`)
) ENGINE=InnoDB AUTO_INCREMENT=312 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `ID_CLIENTE` int(11) NOT NULL AUTO_INCREMENT,
  `TACHO` int(11) NOT NULL,
  `CI` varchar(15) DEFAULT NULL,
  `NOMBRE` varchar(250) NOT NULL,
  `APATERNO` varchar(50) NOT NULL,
  `AMATERNO` varchar(50) NOT NULL,
  `ID_TIPO_CLIENTE` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_CLIENTE`),
  KEY `Reftipo_cliente17` (`ID_TIPO_CLIENTE`),
  CONSTRAINT `Reftipo_cliente17` FOREIGN KEY (`ID_TIPO_CLIENTE`) REFERENCES `tipo_cliente` (`ID_TIPO_CLIENTE`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.cobro_credito
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
  KEY `Refventa_credito62` (`ID_VENTA_CREDITO`,`ID_SOLICITUD_VENTA`,`ID_CLIENTE`,`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  CONSTRAINT `Refventa_credito62` FOREIGN KEY (`ID_VENTA_CREDITO`, `ID_SOLICITUD_VENTA`, `ID_CLIENTE`, `ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) REFERENCES `venta_credito` (`ID_VENTA_CREDITO`, `ID_SOLICITUD_VENTA`, `ID_CLIENTE`, `ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.compra
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
  `ID_USUARIO` int(11) NOT NULL,
  PRIMARY KEY (`ID_COMPRA`,`ID_ARTICULO`),
  KEY `Refarticulo26` (`ID_ARTICULO`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  CONSTRAINT `Refarticulo26` FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulo` (`ID_ARTICULO`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.compra_aux
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
  PRIMARY KEY (`ID_COMPRA_AUX`,`ID_ARTICULO`),
  UNIQUE KEY `ID_ARTICULO` (`ID_ARTICULO`),
  KEY `ID_USR` (`ID_USR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.deposito
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.devolucion
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
  PRIMARY KEY (`ID_DEVOLUCION`,`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`,`ID_SOLICITUD_DEV`),
  KEY `Refsolicitud_dev57` (`ID_SOLICITUD_DEV`),
  KEY `Refalmacen38` (`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  CONSTRAINT `Refalmacen38` FOREIGN KEY (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) REFERENCES `almacen` (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) ON UPDATE CASCADE,
  CONSTRAINT `Refsolicitud_dev57` FOREIGN KEY (`ID_SOLICITUD_DEV`) REFERENCES `solicitud_dev` (`ID_SOLICITUD_DEV`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.empresa
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
  PRIMARY KEY (`ID_EMPRESA`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.gestion
CREATE TABLE IF NOT EXISTS `gestion` (
  `ID_GESTION` int(11) NOT NULL,
  PRIMARY KEY (`ID_GESTION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.grupo
CREATE TABLE IF NOT EXISTS `grupo` (
  `ID_GRUPO` varchar(10) NOT NULL,
  `GRUPO` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_GRUPO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.kardex
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
  PRIMARY KEY (`ID_KARDEX`,`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  KEY `Refalmacen58` (`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  KEY `Reftipo_venta60` (`ID_TIPO_VENTA`),
  CONSTRAINT `Refalmacen58` FOREIGN KEY (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) REFERENCES `almacen` (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) ON UPDATE CASCADE,
  CONSTRAINT `Reftipo_venta60` FOREIGN KEY (`ID_TIPO_VENTA`) REFERENCES `tipo_venta` (`ID_TIPO_VENTA`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.marca
CREATE TABLE IF NOT EXISTS `marca` (
  `ID_MARCA` int(11) NOT NULL AUTO_INCREMENT,
  `MARCA` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_MARCA`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.mes
CREATE TABLE IF NOT EXISTS `mes` (
  `ID_MES` int(11) NOT NULL AUTO_INCREMENT,
  `MES` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_MES`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.pedido
CREATE TABLE IF NOT EXISTS `pedido` (
  `ID_PEDIDO` int(11) NOT NULL AUTO_INCREMENT,
  `CANTIDAD` int(11) NOT NULL,
  `FECHA_PEDIDO` datetime NOT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  `ID_SOLICITUD_COMPRA` int(11) NOT NULL,
  PRIMARY KEY (`ID_PEDIDO`,`ID_SOLICITUD_COMPRA`),
  KEY `Refarticulo30` (`ID_ARTICULO`),
  KEY `Refsolicitud_compra46` (`ID_SOLICITUD_COMPRA`),
  CONSTRAINT `Refarticulo30` FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulo` (`ID_ARTICULO`) ON UPDATE CASCADE,
  CONSTRAINT `Refsolicitud_compra46` FOREIGN KEY (`ID_SOLICITUD_COMPRA`) REFERENCES `solicitud_compra` (`ID_SOLICITUD_COMPRA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.solicitud_baja
CREATE TABLE IF NOT EXISTS `solicitud_baja` (
  `ID_SOLICITUD_BAJA` int(11) NOT NULL AUTO_INCREMENT,
  `NRO_NOTA` int(11) DEFAULT NULL,
  `FECHA_SOLICITUD` datetime NOT NULL,
  `ID_TIPO_VENTA` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_SOLICITUD_BAJA`),
  KEY `Reftipo_venta51` (`ID_TIPO_VENTA`),
  CONSTRAINT `Reftipo_venta51` FOREIGN KEY (`ID_TIPO_VENTA`) REFERENCES `tipo_venta` (`ID_TIPO_VENTA`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.solicitud_compra
CREATE TABLE IF NOT EXISTS `solicitud_compra` (
  `ID_SOLICITUD_COMPRA` int(11) NOT NULL AUTO_INCREMENT,
  `NRO_NOTA` int(11) NOT NULL DEFAULT 0,
  `FECHA_SOLICITUD` date NOT NULL,
  `FECHA_FACTURA` date NOT NULL,
  `ID_USR` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID_SOLICITUD_COMPRA`),
  KEY `ID_USUARIO` (`ID_USR`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.solicitud_dev
CREATE TABLE IF NOT EXISTS `solicitud_dev` (
  `ID_SOLICITUD_DEV` int(11) NOT NULL AUTO_INCREMENT,
  `NRO_NOTA` int(11) DEFAULT NULL,
  `FECHA_SOLICITUD` datetime NOT NULL,
  `ID_TIPO_VENTA` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_SOLICITUD_DEV`),
  KEY `Reftipo_venta56` (`ID_TIPO_VENTA`),
  CONSTRAINT `Reftipo_venta56` FOREIGN KEY (`ID_TIPO_VENTA`) REFERENCES `tipo_venta` (`ID_TIPO_VENTA`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.solicitud_venta
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
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para vista mivavision.stock
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `stock` (
	`ID_ARTICULO` INT(11) NOT NULL,
	`SALDO` DECIMAL(55,0) NULL,
	`ARTICULO` VARCHAR(1) NOT NULL COLLATE 'latin1_swedish_ci',
	`NOMBRE_BUSQUEDA` VARCHAR(1) NOT NULL COLLATE 'latin1_swedish_ci',
	`NOMBRE_VENTA` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci'
);

-- Volcando estructura para tabla mivavision.tipo_cliente
CREATE TABLE IF NOT EXISTS `tipo_cliente` (
  `ID_TIPO_CLIENTE` varchar(10) NOT NULL,
  `TIPO` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_TIPO_CLIENTE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.tipo_usr
CREATE TABLE IF NOT EXISTS `tipo_usr` (
  `ID_TIPO_USR` int(11) NOT NULL AUTO_INCREMENT,
  `TIPO_USR` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_TIPO_USR`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla mivavision.tipo_usr
INSERT INTO `tipo_usr` (`ID_TIPO_USR`, `TIPO_USR`) VALUES
	(1, 'ADMINISTRADOR'),
	(2, 'VENTAS');

-- Volcando estructura para tabla mivavision.tipo_venta
CREATE TABLE IF NOT EXISTS `tipo_venta` (
  `ID_TIPO_VENTA` varchar(10) NOT NULL,
  `TIPO` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_TIPO_VENTA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.unidad
CREATE TABLE IF NOT EXISTS `unidad` (
  `ID_UNIDAD` varchar(10) NOT NULL,
  `UNIDAD` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_UNIDAD`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.usr
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
  PRIMARY KEY (`ID_USR`,`ID_TIPO_USR`),
  UNIQUE KEY `USR` (`USR`),
  KEY `Reftipo_usr63` (`ID_TIPO_USR`),
  CONSTRAINT `Reftipo_usr63` FOREIGN KEY (`ID_TIPO_USR`) REFERENCES `tipo_usr` (`ID_TIPO_USR`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla mivavision.usr
INSERT INTO `usr` (`ID_USR`, `USR`, `PSWR`, `NOMBRE`, `APELLIDOP`, `APELLIDOM`, `FECHA_NAC`, `CI`, `ID_TIPO_USR`) VALUES
	(1, 'ADMIN', '$2y$10$w7ycSJ9WbB11Zg7dZpM8m.cwmW/zUf1pMHWWsl2UajpoHAEeowX4G', 'CHANEL JOSE', 'CONDORI', 'YUCRA', '1984-07-14', '5290570', 1);

-- Volcando estructura para tabla mivavision.vale
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
  PRIMARY KEY (`ID_VALE`,`ID_SOLICITUD_VENTA`,`ID_CLIENTE`),
  KEY `Refalmacen43` (`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  KEY `Refsolicitud_venta44` (`ID_SOLICITUD_VENTA`,`ID_CLIENTE`),
  CONSTRAINT `Refalmacen43` FOREIGN KEY (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) REFERENCES `almacen` (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) ON UPDATE CASCADE,
  CONSTRAINT `Refsolicitud_venta44` FOREIGN KEY (`ID_SOLICITUD_VENTA`, `ID_CLIENTE`) REFERENCES `solicitud_venta` (`ID_SOLICITUD_VENTA`, `ID_CLIENTE`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.venta
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
  PRIMARY KEY (`ID_VENTA`,`ID_SOLICITUD_VENTA`,`ID_CLIENTE`,`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`) USING BTREE,
  KEY `Refsolicitud_venta21` (`ID_SOLICITUD_VENTA`,`ID_CLIENTE`),
  KEY `Refalmacen28` (`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  KEY `ID_USR` (`ID_USR`),
  CONSTRAINT `FK_venta_usr` FOREIGN KEY (`ID_USR`) REFERENCES `usr` (`ID_USR`) ON UPDATE CASCADE,
  CONSTRAINT `Refalmacen28` FOREIGN KEY (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) REFERENCES `almacen` (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) ON UPDATE CASCADE,
  CONSTRAINT `Refsolicitud_venta21` FOREIGN KEY (`ID_SOLICITUD_VENTA`, `ID_CLIENTE`) REFERENCES `solicitud_venta` (`ID_SOLICITUD_VENTA`, `ID_CLIENTE`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.venta_aux
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
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla mivavision.venta_credito
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
  PRIMARY KEY (`ID_VENTA_CREDITO`,`ID_SOLICITUD_VENTA`,`ID_CLIENTE`,`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  KEY `Refsolicitud_venta49` (`ID_SOLICITUD_VENTA`,`ID_CLIENTE`),
  KEY `Refalmacen50` (`ID_ALMACEN`,`ID_COMPRA`,`ID_ARTICULO`),
  CONSTRAINT `Refalmacen50` FOREIGN KEY (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) REFERENCES `almacen` (`ID_ALMACEN`, `ID_COMPRA`, `ID_ARTICULO`) ON UPDATE CASCADE,
  CONSTRAINT `Refsolicitud_venta49` FOREIGN KEY (`ID_SOLICITUD_VENTA`, `ID_CLIENTE`) REFERENCES `solicitud_venta` (`ID_SOLICITUD_VENTA`, `ID_CLIENTE`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para disparador mivavision.TBitacoraInsert
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

-- Volcando estructura para disparador mivavision.TBitacoraUpdate
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

-- Volcando estructura para disparador mivavision.TComprasInsert
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

-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `stock`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `stock` AS select `r`.`ID_ARTICULO` AS `ID_ARTICULO`,`r`.`SALDO` AS `SALDO`,`r`.`ARTICULO` AS `ARTICULO`,`r`.`NOMBRE_BUSQUEDA` AS `NOMBRE_BUSQUEDA`,concat(`r`.`NOMBRE_BUSQUEDA`,' ==> ',`r`.`SALDO`) AS `NOMBRE_VENTA` from (select `m`.`ID_ARTICULO` AS `ID_ARTICULO`,`m`.`COMPRAS` AS `COMPRAS`,`m`.`VENTAS` AS `VENTAS`,(`m`.`COMPRAS` - `m`.`VENTAS`) AS `SALDO`,`m`.`ARTICULO` AS `ARTICULO`,`m`.`NOMBRE_BUSQUEDA` AS `NOMBRE_BUSQUEDA` from (select `z`.`id_articulo` AS `ID_ARTICULO`,sum(`z`.`COMPRAS`) AS `COMPRAS`,sum(`z`.`VENTAS`) AS `VENTAS`,`z`.`ARTICULO` AS `ARTICULO`,`z`.`nombre_busqueda` AS `NOMBRE_BUSQUEDA` from (select `c`.`ID_ARTICULO` AS `id_articulo`,sum(`c`.`CANTIDAD`) AS `COMPRAS`,0 AS `VENTAS`,`a`.`ARTICULO` AS `ARTICULO`,`a`.`NOMBRE_BUSQUEDA` AS `nombre_busqueda` from (`compra` `c` join `articulo` `a` on((`c`.`ID_ARTICULO` = `a`.`ID_ARTICULO`))) group by `c`.`ID_ARTICULO` union all select `v`.`ID_ARTICULO` AS `ID_ARTICULO`,0 AS `COMPRAS`,sum(`v`.`CANTIDAD`) AS `VENTAS`,`a`.`ARTICULO` AS `ARTICULO`,`a`.`NOMBRE_BUSQUEDA` AS `NOMBRE_BUSQUEDA` from (`venta` `v` join `articulo` `a` on((`v`.`ID_ARTICULO` = `a`.`ID_ARTICULO`))) group by `v`.`ID_ARTICULO` union all select `a`.`ID_ARTICULO` AS `ID_ARTICULO`,0 AS `COMPRAS`,0 AS `VENTAS`,`a`.`ARTICULO` AS `ARTICULO`,`a`.`NOMBRE_BUSQUEDA` AS `NOMBRE_BUSQUEDA` from `articulo` `a` group by `a`.`ID_ARTICULO`) `z` group by `z`.`id_articulo`,`z`.`ARTICULO`,`z`.`nombre_busqueda`) `m`) `r` order by `r`.`ID_ARTICULO` 
;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
