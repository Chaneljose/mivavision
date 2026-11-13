-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.16.0.7229
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para vista syscompunet.stock
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `stock` (
	`ID_ARTICULO` INT(11) NOT NULL,
	`SALDO` DECIMAL(55,0) NULL,
	`ARTICULO` VARCHAR(1) NOT NULL COLLATE 'latin1_swedish_ci',
	`NOMBRE_BUSQUEDA` VARCHAR(1) NOT NULL COLLATE 'latin1_swedish_ci',
	`NOMBRE_VENTA` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci'
);

-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `stock`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `stock` AS select `r`.`ID_ARTICULO` AS `ID_ARTICULO`,`r`.`SALDO` AS `SALDO`,`r`.`ARTICULO` AS `ARTICULO`,`r`.`NOMBRE_BUSQUEDA` AS `NOMBRE_BUSQUEDA`,  concat(`r`.`NOMBRE_BUSQUEDA`,' ==> ',`r`.`SALDO`) AS `NOMBRE_VENTA` 
from (select `m`.`ID_ARTICULO` AS `ID_ARTICULO`,`m`.`COMPRAS` AS `COMPRAS`,`m`.`VENTAS` AS `VENTAS`,(`m`.`COMPRAS` - `m`.`VENTAS`) AS `SALDO`,`m`.`ARTICULO` AS `ARTICULO`,`m`.`NOMBRE_BUSQUEDA` AS `NOMBRE_BUSQUEDA` 
from (select `z`.`id_articulo` AS `ID_ARTICULO`,sum(`z`.`COMPRAS`) AS `COMPRAS`,sum(`z`.`VENTAS`) AS `VENTAS`,`z`.`ARTICULO` AS `ARTICULO`,`z`.`nombre_busqueda` AS `NOMBRE_BUSQUEDA` 
from (select `c`.`ID_ARTICULO` AS `id_articulo`,sum(`c`.`CANTIDAD`) AS `COMPRAS`,0 AS `VENTAS`,`a`.`ARTICULO` AS `ARTICULO`,`a`.`NOMBRE_BUSQUEDA` AS `nombre_busqueda` 
from (`compra` `c` join `articulo` `a` on((`c`.`ID_ARTICULO` = `a`.`ID_ARTICULO`))) group by `c`.`ID_ARTICULO` 
union all select `v`.`ID_ARTICULO` AS `ID_ARTICULO`,0 AS `COMPRAS`,sum(`v`.`CANTIDAD`) AS `VENTAS`,`a`.`ARTICULO` AS `ARTICULO`,`a`.`NOMBRE_BUSQUEDA` AS `NOMBRE_BUSQUEDA` 
from (`venta` `v` join `articulo` `a` on((`v`.`ID_ARTICULO` = `a`.`ID_ARTICULO`))) group by `v`.`ID_ARTICULO` 
union all select `a`.`ID_ARTICULO` AS `ID_ARTICULO`,0 AS `COMPRAS`,0 AS `VENTAS`,`a`.`ARTICULO` AS `ARTICULO`,`a`.`NOMBRE_BUSQUEDA` AS `NOMBRE_BUSQUEDA` 
from `articulo` `a` group by `a`.`ID_ARTICULO`) `z` group by `z`.`id_articulo`,`z`.`ARTICULO`,`z`.`nombre_busqueda`) `m`) `r` where (`r`.`SALDO` >= 0) order by `r`.`ID_ARTICULO` 
;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
