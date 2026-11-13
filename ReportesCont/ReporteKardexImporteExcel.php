<?PHP 
date_default_timezone_set('America/La_Paz');
header('Content-type: application/vnd.ms-excel');  
header("Content-Disposition: attachment; filename=KardexProductoExcel".date("YmdHis").".xls");  
header("Pragma: no-cache");  
header("Expires: 0");
?>
<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP include_once('../Funciones/funciones.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['CODIGO'];
$inicio = $_REQUEST['INICIO'];
$fin = $_REQUEST['FIN'];



 $sql="SELECT CODIGO,
			 ARTICULO,
			 SUM(DEBE) ENTRADA,
			 SUM(HABER) SALIDA,
			 SUM(DEBE) - SUM(HABER) SALDO_PROD,
			 ROUND((PC*0.87),2) PC,
			 ROUND((PC*0.87),2) PV,
			 ROUND(SUM(DEBE) * (PC*0.87),2) PC_SALDO,
			 ROUND(SUM(HABER) * (PC*0.87),2) PV_SALDO,
			 ROUND((SUM(DEBE) * (PC*0.87))-(SUM(HABER) * (PC*0.87)),2) UTILIDAD
	  FROM (SELECT	a.ID_ARTICULO CODIGO, 
				 	r.ARTICULO ARTICULO, 
				 	SUM(a.ENTRADA) DEBE, 
				 	SUM(a.SALIDA) HABER,
				 	c.PRECIO_FACTURA PC,
				 	r.PRECIO_VENTA PV
		  	FROM almacen a LEFT JOIN articulo r ON a.ID_ARTICULO = r.ID_ARTICULO
						   LEFT JOIN compra c ON a.ID_COMPRA = c.ID_COMPRA
			WHERE c.FECHA_REGISTRO BETWEEN '2010-01-01 00:00:00' and DATE_SUB('$inicio 23:59:59', INTERVAL 1 DAY)
		  	GROUP BY 1
		 	UNION ALL
		  	SELECT	v.ID_ARTICULO CODIGO, 
				 	a.ARTICULO ARTICULO, 
				 	0 DEBE, 
				 	SUM(v.CANTIDAD) HABER,
				 	a.PRECIO_COMPRA PC,
				 	a.PRECIO_VENTA PV
		  	FROM venta v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
					     JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
			WHERE s.FECHA_SOLICITUD BETWEEN '2010-01-01 00:00:00' and DATE_SUB('$inicio 23:59:59', INTERVAL 1 DAY)
		  	GROUP BY 1
			UNION ALL
			SELECT	v.ID_ARTICULO CODIGO, 
					a.ARTICULO ARTICULO, 
					0 DEBE, 
					SUM(v.CANTIDAD) HABER,
					a.PRECIO_COMPRA PC,
					a.PRECIO_VENTA PV
			FROM venta_credito v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
								 JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
			WHERE s.FECHA_SOLICITUD BETWEEN '2010-01-01 00:00:00' and DATE_SUB('$inicio 23:59:59', INTERVAL 1 DAY)
			GROUP BY 1
			UNION ALL
			SELECT	v.ID_ARTICULO CODIGO, 
					a.ARTICULO ARTICULO, 
					0 DEBE, 
					SUM(v.CANTIDAD) HABER,
					a.PRECIO_COMPRA PC,
					a.PRECIO_VENTA PV
			FROM vale v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
						JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
			WHERE s.FECHA_SOLICITUD BETWEEN '2010-01-01 00:00:00' and DATE_SUB('$inicio 23:59:59', INTERVAL 1 DAY)
			GROUP BY 1
			UNION ALL
			SELECT	b.ID_ARTICULO CODIGO, 
					a.ARTICULO ARTICULO, 
					0 DEBE, 
					SUM(b.CANTIDAD) HABER,
					a.PRECIO_COMPRA PC,
					a.PRECIO_VENTA PV
			FROM baja b JOIN articulo a On b.ID_ARTICULO = a.ID_ARTICULO
						JOIN solicitud_baja s ON b.ID_SOLICITUD_BAJA = s.ID_SOLICITUD_BAJA
			WHERE s.FECHA_SOLICITUD BETWEEN '2010-01-01 00:00:00' and DATE_SUB('$inicio 23:59:59', INTERVAL 1 DAY)
			GROUP BY 1
			UNION ALL
			SELECT	b.ID_ARTICULO CODIGO, 
					a.ARTICULO ARTICULO, 
					0 DEBE, 
					SUM(b.CANTIDAD) HABER,
					a.PRECIO_COMPRA PC,
					a.PRECIO_VENTA PV
			FROM devolucion b JOIN articulo a On b.ID_ARTICULO = a.ID_ARTICULO
							  JOIN solicitud_dev s ON b.ID_SOLICITUD_DEV = s.ID_SOLICITUD_DEV
			WHERE s.FECHA_SOLICITUD BETWEEN '2010-01-01 00:00:00' and DATE_SUB('$inicio 23:59:59', INTERVAL 1 DAY)
			GROUP BY 1
			
UNION ALL

SELECT	a.ID_ARTICULO CODIGO, 
				 	r.ARTICULO ARTICULO, 
				 	SUM(a.ENTRADA) DEBE, 
				 	SUM(a.SALIDA) HABER,
				 	c.PRECIO_FACTURA PC,
				 	r.PRECIO_VENTA PV
		  	FROM almacen a JOIN articulo r ON a.ID_ARTICULO = r.ID_ARTICULO
						   JOIN compra c ON a.ID_COMPRA = c.ID_COMPRA
			WHERE c.FECHA_REGISTRO BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'
		  	GROUP BY 1
		 	UNION ALL
		  	SELECT	v.ID_ARTICULO CODIGO, 
				 	a.ARTICULO ARTICULO, 
				 	0 DEBE, 
				 	SUM(v.CANTIDAD) HABER,
				 	a.PRECIO_COMPRA PC,
				 	a.PRECIO_VENTA PV
		  	FROM venta v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
					     JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
			WHERE s.FECHA_SOLICITUD BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'
		  	GROUP BY 1
			UNION ALL
			SELECT	v.ID_ARTICULO CODIGO, 
					a.ARTICULO ARTICULO, 
					0 DEBE, 
					SUM(v.CANTIDAD) HABER,
					a.PRECIO_COMPRA PC,
					a.PRECIO_VENTA PV
			FROM venta_credito v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
								 JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
			WHERE s.FECHA_SOLICITUD BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'
			GROUP BY 1
			UNION ALL
			SELECT	v.ID_ARTICULO CODIGO, 
					a.ARTICULO ARTICULO, 
					0 DEBE, 
					SUM(v.CANTIDAD) HABER,
					a.PRECIO_COMPRA PC,
					a.PRECIO_VENTA PV
			FROM vale v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
						JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
			WHERE s.FECHA_SOLICITUD BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'
			GROUP BY 1
			UNION ALL
			SELECT	b.ID_ARTICULO CODIGO, 
					a.ARTICULO ARTICULO, 
					0 DEBE, 
					SUM(b.CANTIDAD) HABER,
					a.PRECIO_COMPRA PC,
					a.PRECIO_VENTA PV
			FROM baja b JOIN articulo a On b.ID_ARTICULO = a.ID_ARTICULO
						JOIN solicitud_baja s ON b.ID_SOLICITUD_BAJA = s.ID_SOLICITUD_BAJA
			WHERE s.FECHA_SOLICITUD BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'
			GROUP BY 1
			UNION ALL
			SELECT	b.ID_ARTICULO CODIGO, 
					a.ARTICULO ARTICULO, 
					0 DEBE, 
					SUM(b.CANTIDAD) HABER,
					a.PRECIO_COMPRA PC,
					a.PRECIO_VENTA PV
			FROM devolucion b JOIN articulo a On b.ID_ARTICULO = a.ID_ARTICULO
							  JOIN solicitud_dev s ON b.ID_SOLICITUD_DEV = s.ID_SOLICITUD_DEV
			WHERE s.FECHA_SOLICITUD BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'
			GROUP BY 1
			ORDER BY 1) KARDEX
		GROUP BY 1,2";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 


$sql1="SELECT SUM(PC_SALDO) PC_SALDO_SUM
,		 SUM(PV_SALDO) PV_SALDO_SUM
,      SUM(PC_SALDO) - SUM(PV_SALDO)
FROM(SELECT CODIGO,
			 ARTICULO,
			 SUM(DEBE) ENTRADA,
			 SUM(HABER) SALIDA,
			 SUM(DEBE) - SUM(HABER) SALDO_PROD,
			 ROUND((PC*0.87),2) PC,
			 ROUND((PC*0.87),2) PV,
			 ROUND(SUM(DEBE) * (PC*0.87),2) PC_SALDO,
			 ROUND(SUM(HABER) * (PC*0.87),2) PV_SALDO,
			 ROUND((SUM(DEBE) * (PC*0.87))-(SUM(HABER) * (PC*0.87)),2) UTILIDAD
	  FROM (SELECT	a.ID_ARTICULO CODIGO, 
				 	r.ARTICULO ARTICULO, 
				 	SUM(a.ENTRADA) DEBE, 
				 	SUM(a.SALIDA) HABER,
				 	c.PRECIO_FACTURA PC,
				 	r.PRECIO_VENTA PV
		  	FROM almacen a LEFT JOIN articulo r ON a.ID_ARTICULO = r.ID_ARTICULO
						   LEFT JOIN compra c ON a.ID_COMPRA = c.ID_COMPRA
			WHERE c.FECHA_REGISTRO BETWEEN '2010-01-01 00:00:00' and DATE_SUB('$inicio 23:59:59', INTERVAL 1 DAY)
		  	GROUP BY 1
		 	UNION ALL
		  	SELECT	v.ID_ARTICULO CODIGO, 
				 	a.ARTICULO ARTICULO, 
				 	0 DEBE, 
				 	SUM(v.CANTIDAD) HABER,
				 	a.PRECIO_COMPRA PC,
				 	a.PRECIO_VENTA PV
		  	FROM venta v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
					     JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
			WHERE s.FECHA_SOLICITUD BETWEEN '2010-01-01 00:00:00' and DATE_SUB('$inicio 23:59:59', INTERVAL 1 DAY)
		  	GROUP BY 1
			UNION ALL
			SELECT	v.ID_ARTICULO CODIGO, 
					a.ARTICULO ARTICULO, 
					0 DEBE, 
					SUM(v.CANTIDAD) HABER,
					a.PRECIO_COMPRA PC,
					a.PRECIO_VENTA PV
			FROM venta_credito v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
								 JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
			WHERE s.FECHA_SOLICITUD BETWEEN '2010-01-01 00:00:00' and DATE_SUB('$inicio 23:59:59', INTERVAL 1 DAY)
			GROUP BY 1
			UNION ALL
			SELECT	v.ID_ARTICULO CODIGO, 
					a.ARTICULO ARTICULO, 
					0 DEBE, 
					SUM(v.CANTIDAD) HABER,
					a.PRECIO_COMPRA PC,
					a.PRECIO_VENTA PV
			FROM vale v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
						JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
			WHERE s.FECHA_SOLICITUD BETWEEN '2010-01-01 00:00:00' and DATE_SUB('$inicio 23:59:59', INTERVAL 1 DAY)
			GROUP BY 1
			UNION ALL
			SELECT	b.ID_ARTICULO CODIGO, 
					a.ARTICULO ARTICULO, 
					0 DEBE, 
					SUM(b.CANTIDAD) HABER,
					a.PRECIO_COMPRA PC,
					a.PRECIO_VENTA PV
			FROM baja b JOIN articulo a On b.ID_ARTICULO = a.ID_ARTICULO
						JOIN solicitud_baja s ON b.ID_SOLICITUD_BAJA = s.ID_SOLICITUD_BAJA
			WHERE s.FECHA_SOLICITUD BETWEEN '2010-01-01 00:00:00' and DATE_SUB('$inicio 23:59:59', INTERVAL 1 DAY)
			GROUP BY 1
			UNION ALL
			SELECT	b.ID_ARTICULO CODIGO, 
					a.ARTICULO ARTICULO, 
					0 DEBE, 
					SUM(b.CANTIDAD) HABER,
					a.PRECIO_COMPRA PC,
					a.PRECIO_VENTA PV
			FROM devolucion b JOIN articulo a On b.ID_ARTICULO = a.ID_ARTICULO
							  JOIN solicitud_dev s ON b.ID_SOLICITUD_DEV = s.ID_SOLICITUD_DEV
			WHERE s.FECHA_SOLICITUD BETWEEN '2010-01-01 00:00:00' and DATE_SUB('$inicio 23:59:59', INTERVAL 1 DAY)
			GROUP BY 1
			
UNION ALL

SELECT	a.ID_ARTICULO CODIGO, 
				 	r.ARTICULO ARTICULO, 
				 	SUM(a.ENTRADA) DEBE, 
				 	SUM(a.SALIDA) HABER,
				 	c.PRECIO_FACTURA PC,
				 	r.PRECIO_VENTA PV
		  	FROM almacen a JOIN articulo r ON a.ID_ARTICULO = r.ID_ARTICULO
						   JOIN compra c ON a.ID_COMPRA = c.ID_COMPRA
			WHERE c.FECHA_REGISTRO BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'
		  	GROUP BY 1
		 	UNION ALL
		  	SELECT	v.ID_ARTICULO CODIGO, 
				 	a.ARTICULO ARTICULO, 
				 	0 DEBE, 
				 	SUM(v.CANTIDAD) HABER,
				 	a.PRECIO_COMPRA PC,
				 	a.PRECIO_VENTA PV
		  	FROM venta v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
					     JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
			WHERE s.FECHA_SOLICITUD BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'
		  	GROUP BY 1
			UNION ALL
			SELECT	v.ID_ARTICULO CODIGO, 
					a.ARTICULO ARTICULO, 
					0 DEBE, 
					SUM(v.CANTIDAD) HABER,
					a.PRECIO_COMPRA PC,
					a.PRECIO_VENTA PV
			FROM venta_credito v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
								 JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
			WHERE s.FECHA_SOLICITUD BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'
			GROUP BY 1
			UNION ALL
			SELECT	v.ID_ARTICULO CODIGO, 
					a.ARTICULO ARTICULO, 
					0 DEBE, 
					SUM(v.CANTIDAD) HABER,
					a.PRECIO_COMPRA PC,
					a.PRECIO_VENTA PV
			FROM vale v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
						JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
			WHERE s.FECHA_SOLICITUD BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'
			GROUP BY 1
			UNION ALL
			SELECT	b.ID_ARTICULO CODIGO, 
					a.ARTICULO ARTICULO, 
					0 DEBE, 
					SUM(b.CANTIDAD) HABER,
					a.PRECIO_COMPRA PC,
					a.PRECIO_VENTA PV
			FROM baja b JOIN articulo a On b.ID_ARTICULO = a.ID_ARTICULO
						JOIN solicitud_baja s ON b.ID_SOLICITUD_BAJA = s.ID_SOLICITUD_BAJA
			WHERE s.FECHA_SOLICITUD BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'
			GROUP BY 1
			UNION ALL
			SELECT	b.ID_ARTICULO CODIGO, 
					a.ARTICULO ARTICULO, 
					0 DEBE, 
					SUM(b.CANTIDAD) HABER,
					a.PRECIO_COMPRA PC,
					a.PRECIO_VENTA PV
			FROM devolucion b JOIN articulo a On b.ID_ARTICULO = a.ID_ARTICULO
							  JOIN solicitud_dev s ON b.ID_SOLICITUD_DEV = s.ID_SOLICITUD_DEV
			WHERE s.FECHA_SOLICITUD BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'
			GROUP BY 1
			ORDER BY 1) KARDEX
		GROUP BY 1,2) SUMATORIA";
$suma = mysqli_query($cnx_compras, $sql1) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_suma = mysqli_fetch_assoc($suma);
$num_suma = mysqli_num_rows($suma);  
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>IMPRESION</title>
</head>

<body>
<table border="0" class="fuente">
  <tr>
    <td align="center" class="fuente"><strong>KARDEX DE PRODUCTOS <?PHP echo fecha_dma($inicio) ?> AL <?PHP echo fecha_dma($fin) ?></strong></td>
  </tr>
  <tr><td><strong>TOTAL COMPRAS: <?PHP echo $row_suma['PC_SALDO_SUM'] ?></strong></td></tr>
  <tr><td><strong>TOTAL VENTAS: <?PHP echo $row_suma['PV_SALDO_SUM'] ?></strong></td></tr>
  <tr><td><strong>SALDO: <?PHP echo round($row_suma['PC_SALDO_SUM'] - $row_suma['PV_SALDO_SUM'],2) ?></strong></td></tr>
  </tr>
  <tr>
    <td><table border="0">
  
</table>
</td>
  </tr>
  <tr>
    <td><table border="1" cellpadding="1" cellspacing="0" class="ui-tinytbl ui-corner-all">
         <thead class="ui-widget-header ui-corner-all">
            <tr>
            	<th rowspan="2">PRODUCTO</th>
            	<th colspan="3">COMPRAS</th>
            	<th colspan="3">VENTAS</th>
                <th rowspan="2">PROD</th>
                <th rowspan="2">SALDO</th>
            </tr>
            <tr>
                
                <th>ENTRADA</th>
                <th>P.U.</th>
                <th>TOTAL</th>
                <!--
                <th>PRECIO COMPRA</th>
                <th>PC * SALDO</th>-->
                
                <th>SALIDA</th>
                <th>P.U.</th>
                <th>TOTAL</th>
            <!--<th>PRECIO VENTA</th>
                <th>PV * SALDO</th>-->
            </tr>      
        </thead>
        <tbody>
            <?PHP
                $cont =1;
                do{
            ?>
                <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                    <td><?PHP echo $row_pedido['ARTICULO']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['ENTRADA']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['PC']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['PC_SALDO']; ?></td>
                    
                    <td align="right"><?PHP echo $row_pedido['SALIDA']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['PV']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['PV_SALDO']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['SALDO_PROD']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['UTILIDAD']; ?></td>	
					
                </tr>
            <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
        </tbody>
    </table>
</table>
</body>
</html>