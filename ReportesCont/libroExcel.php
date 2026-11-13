<?PHP 
date_default_timezone_set('America/La_Paz');
header('Content-type: application/vnd.ms-excel');  
header("Content-Disposition: attachment; filename=CostoCompraExcel".date("YmdHis").".xls");  
header("Pragma: no-cache");  
header("Expires: 0");
?><?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Definiciones/Titulo.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);
					
//$inicio = fecha_amd($_REQUEST['INICIO']);
//$fin = fecha_amd($_REQUEST['FIN']);
$ges = $_REQUEST['GESTION'];
//$buscar =$_REQUEST['BUSCAR'];
$var_mes = $_REQUEST['MES'];
$var_mes_inicio = 1;

/**************************************** 
 * CONUSLTAS ORIGINALES
 *****************************************/
/*
$sql="	SELECT  0 MES
		,		 CONCAT('SALDO GESTION ',2014 -1 ) FACTURA
		,		 SUM(IMPORTE_NETO) IMPORTE_NETO
		,		 SUM(COSTO_VENTA) COSTO_VENTA
		FROM(SELECT MONTH(c.FECHA_FACTURA) MES
				,	   c.NRO_FACTURA NRO_FACTURA
				,      round(SUM(((c.TOTAL - c.ICE) * 1)+c.ICE),2)  IMPORTE_NETO
				,	   '0' COSTO_VENTA
				FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
				WHERE YEAR(c.FECHA_FACTURA) = '$ges' - 1
				GROUP BY 1,2
				UNION
				select MONTH(s.fecha_SOLICITUD) MES
				,	   0 NRO_FACTURA
				,	   0 IMPORTE_NETO
				,      round(SUM(IFNULL(((((c.TOTAL - c.ICE) * 1)+c.ICE) / c.CANTIDAD),0) * v.CANTIDAD),2) COSTO_VENTA
				FROM venta v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
								 JOIN compra c ON c.ID_COMPRA = v.ID_COMPRA
				WHERE YEAR(s.FECHA_SOLICITUD) = '$ges' - 1 
				GROUP BY 1
				ORDER BY 1 ,3 DESC) ANTERIOR
		UNION
		SELECT MONTH(c.FECHA_FACTURA) MES
				,	   c.NRO_FACTURA
				,      round(SUM(((c.TOTAL - c.ICE) * 1)+c.ICE),2)  IMPORTE_NETO
				,	   '0' COSTO_VENTA
				FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
				WHERE YEAR(c.FECHA_FACTURA) = '$ges' AND MONTH(FECHA_FACTURA) BETWEEN 1 and '$var_mes'
				GROUP BY 1,2
				UNION
				select MONTH(s.fecha_SOLICITUD)
				,	   0
				,	   0 
				,      round(SUM(IFNULL(((((c.TOTAL - c.ICE) * 0.87)+c.ICE) / c.CANTIDAD),0) * v.CANTIDAD),2) COSTO_VENTA
				FROM venta v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
								 JOIN compra c ON c.ID_COMPRA = v.ID_COMPRA
				WHERE YEAR(s.FECHA_SOLICITUD) = '$ges' AND MONTH(s.FECHA_SOLICITUD) BETWEEN 1 and '$var_mes'
				GROUP BY 1
				UNION
				select MONTH(s.fecha_SOLICITUD)
				,	   0
				,	   0 
				,      round(SUM(IFNULL(((((c.TOTAL - c.ICE) * 0.87)+c.ICE) / c.CANTIDAD),0) * v.CANTIDAD),2) COSTO_VENTA
				FROM vale v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
								 JOIN compra c ON c.ID_COMPRA = v.ID_COMPRA
				WHERE YEAR(s.FECHA_SOLICITUD) = '$ges' AND MONTH(s.FECHA_SOLICITUD) BETWEEN 1 and '$var_mes'
				ORDER BY 1 ,3 DESC";
$pedido = mysqli_query($sql, $cnx_compras) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

$sql1="SELECT SUM(IMPORTE_NETO) SUM_IMPORTE_NETO
		,		 SUM(COSTO_VENTA) SUM_COSTO_VENTA
		,		 SUM(IMPORTE_NETO) - SUM(COSTO_VENTA) SUM_DIF
		FROM (SELECT  0 MES
		,		 CONCAT('SALDO GESTION ',2014 -1 ) FACTURA
		,		 SUM(IMPORTE_NETO) IMPORTE_NETO
		,		 SUM(COSTO_VENTA) COSTO_VENTA
		FROM(SELECT MONTH(c.FECHA_FACTURA) MES
				,	   c.NRO_FACTURA NRO_FACTURA
				,      round(SUM(((c.TOTAL - c.ICE) * 1)+c.ICE),2)  IMPORTE_NETO
				,	   '0' COSTO_VENTA
				FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
				WHERE YEAR(c.FECHA_FACTURA) = '$ges' - 1
				GROUP BY 1,2
				UNION
				select MONTH(s.fecha_SOLICITUD) MES
				,	   0 NRO_FACTURA
				,	   0 IMPORTE_NETO
				,      round(SUM(IFNULL(((((c.TOTAL - c.ICE) * 1)+c.ICE) / c.CANTIDAD),0) * v.CANTIDAD),2) COSTO_VENTA
				FROM venta v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
								 JOIN compra c ON c.ID_COMPRA = v.ID_COMPRA
				WHERE YEAR(s.FECHA_SOLICITUD) = '$ges' - 1 
				GROUP BY 1
				ORDER BY 1 ,3 DESC) ANTERIOR
		UNION
		SELECT MONTH(c.FECHA_FACTURA) MES
				,	   c.NRO_FACTURA
				,      round(SUM(((c.TOTAL - c.ICE) * 1)+c.ICE),2)  IMPORTE_NETO
				,	   '0' COSTO_VENTA
				FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
				WHERE YEAR(c.FECHA_FACTURA) = '$ges' AND MONTH(FECHA_FACTURA) BETWEEN 1 and '$var_mes'
				GROUP BY 1,2
				UNION
				select MONTH(s.fecha_SOLICITUD)
				,	   0
				,	   0 
				,      round(SUM(IFNULL(((((c.TOTAL - c.ICE) * 1)+c.ICE) / c.CANTIDAD),0) * v.CANTIDAD),2) COSTO_VENTA
				FROM venta v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
								 JOIN compra c ON c.ID_COMPRA = v.ID_COMPRA
				WHERE YEAR(s.FECHA_SOLICITUD) = '$ges' AND MONTH(s.FECHA_SOLICITUD) BETWEEN 1 and '$var_mes'
				GROUP BY 1
				UNION
				select MONTH(s.fecha_SOLICITUD)
				,	   0
				,	   0 
				,      round(SUM(IFNULL(((((c.TOTAL - c.ICE) * 1)+c.ICE) / c.CANTIDAD),0) * v.CANTIDAD),2) COSTO_VENTA
				FROM vale v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
								 JOIN compra c ON c.ID_COMPRA = v.ID_COMPRA
				WHERE YEAR(s.FECHA_SOLICITUD) = '$ges' AND MONTH(s.FECHA_SOLICITUD) BETWEEN 1 and '$var_mes'
				ORDER BY 1 ,3 DESC) k";
$total = mysqli_query($sql1, $cnx_compras) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_total = mysqli_fetch_assoc($total);
$num_total = mysqli_num_rows($total);
*/


/****************************************NOTA IMPORTANTE ****************/
/* AND MONTH(s.FECHA_SOLICITUD) BETWEEN 6 and '$var_mes'
 * SE AGREGO EL NUMERO 6 YA QUE EL INVENTARIO DE 2014 EMPIEZA EN EL MES  DE JUNIO DE 2014
 * MODIFICARLO PRA LA PROXIMA GESTION
 */
/*************************************************************************/
$sql="	SELECT  0 MES
		,		CONCAT('SALDO GESTION AL 31 DE DICIEMBRE') FACTURA
		,		SUM(IMPORTE_NETO) IMPORTE_NETO
		,		SUM(COSTO_VENTA) COSTO_VENTA
		FROM( SELECT MONTH(c.FECHA_FACTURA) MES
			  ,	   c.NRO_FACTURA NRO_FACTURA
			  ,      round(SUM(((c.TOTAL - c.ICE) * 1)+c.ICE),2)  IMPORTE_NETO
			  ,	   '0' COSTO_VENTA
			  FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
			  WHERE c.FECHA_FACTURA <= '2014-12-31'
			  GROUP BY 1,2
			  UNION
			  select MONTH(s.fecha_SOLICITUD) MES
			  ,	   0 NRO_FACTURA
			  ,	   0 IMPORTE_NETO
			  ,      round(SUM(v.CANTIDAD * (v.PRECIO_COMPRA)),2) COSTO_VENTA
			  FROM venta v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
						   JOIN compra c ON c.ID_COMPRA = v.ID_COMPRA
			  WHERE s.FECHA_SOLICITUD <= '2014-12-31'
			  GROUP BY 1
			  ORDER BY 1 ,3 DESC) ANTERIOR
		UNION
		SELECT MONTH(c.FECHA_FACTURA) MES
		,	   c.NRO_FACTURA FACTURA
		,      round(SUM(((c.TOTAL - c.ICE) * 1)+c.ICE),2)  IMPORTE_NETO
		,	   '0' COSTO_VENTA
		FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
		WHERE YEAR(c.FECHA_FACTURA) = '$ges' AND MONTH(FECHA_FACTURA) BETWEEN '$var_mes_inicio' and '$var_mes'
		GROUP BY 1,2
		UNION
		SELECT MES
		,	   FACTURA
		,	   IMPORTE_NETO
		,	   SUM(COSTO_VENTA)
		FROM( SELECT MONTH(s.fecha_SOLICITUD) MES
			  ,	   	 0 FACTURA
			  ,	     0 IMPORTE_NETO
			  ,      round(SUM(v.CANTIDAD * (v.PRECIO_COMPRA)),2) COSTO_VENTA
			  FROM venta v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
							   JOIN compra c ON c.ID_COMPRA = v.ID_COMPRA
			  WHERE YEAR(s.FECHA_SOLICITUD) = '$ges' AND MONTH(s.FECHA_SOLICITUD) BETWEEN '$var_mes_inicio' and '$var_mes'
			  GROUP BY 1
			  UNION
			  SELECT MONTH(s.fecha_SOLICITUD) MES
			  ,	     0 FACTURA
			  ,	     0 IMPORTE_NETO
			  ,      round(SUM(v.CANTIDAD * (v.PRECIO_COMPRA)),2) COSTO_VENTA
			  FROM vale v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
							   JOIN compra c ON c.ID_COMPRA = v.ID_COMPRA
			  WHERE YEAR(s.FECHA_SOLICITUD) = '$ges' AND MONTH(s.FECHA_SOLICITUD) BETWEEN '$var_mes_inicio' and '$var_mes'
			  GROUP BY 1
			  ORDER BY 1 ,3 DESC) SUMATORIA
			  GROUP BY 1,2,3
			  ORDER BY 1,3 DESC";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

$sql1="SELECT SUM(IMPORTE_NETO) SUM_IMPORTE_NETO
,		 SUM(COSTO_VENTA) SUM_COSTO_VENTA
,		 SUM(IMPORTE_NETO) - SUM(COSTO_VENTA) SUM_DIF
FROM (SELECT  0 MES
,		 CONCAT('SALDO GESTION ',2014 -1 ) FACTURA
,		 SUM(IMPORTE_NETO) IMPORTE_NETO
,		 SUM(COSTO_VENTA) COSTO_VENTA
FROM(SELECT MONTH(c.FECHA_FACTURA) MES
		,	   c.NRO_FACTURA NRO_FACTURA
		,      round(SUM(((c.TOTAL - c.ICE) * 1)+c.ICE),2)  IMPORTE_NETO
		,	   '0' COSTO_VENTA
		FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
		WHERE c.FECHA_FACTURA <= '2014-05-31'
		GROUP BY 1,2
		UNION
		select MONTH(s.fecha_SOLICITUD) MES
		,	   0 NRO_FACTURA
		,	   0 IMPORTE_NETO
		,      round(SUM(v.CANTIDAD * (v.PRECIO_COMPRA)),2) COSTO_VENTA
		FROM venta v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
						 JOIN compra c ON c.ID_COMPRA = v.ID_COMPRA
		WHERE s.FECHA_SOLICITUD <= '2014-05-31'
		GROUP BY 1
		ORDER BY 1 ,3 DESC) ANTERIOR
UNION
SELECT MONTH(c.FECHA_FACTURA) MES
		,	   c.NRO_FACTURA
		,      round(SUM(((c.TOTAL - c.ICE) * 1)+c.ICE),2)  IMPORTE_NETO
		,	   '0' COSTO_VENTA
		FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
		WHERE YEAR(c.FECHA_FACTURA) = '$ges' AND MONTH(FECHA_FACTURA) BETWEEN 6 and '$var_mes'
		GROUP BY 1,2
		UNION
		SELECT MES
		,	   NRO_FACTURA
		,	   IMPORTE_NETO
		,	   COSTO_VENTA
		FROM( select MONTH(s.fecha_SOLICITUD) MES
			  ,	   0 NRO_FACTURA
			  ,	   0 IMPORTE_NETO
			  ,      round(SUM(v.CANTIDAD * (v.PRECIO_COMPRA)),2) COSTO_VENTA
			  FROM venta v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
							   JOIN compra c ON c.ID_COMPRA = v.ID_COMPRA
			  WHERE YEAR(s.FECHA_SOLICITUD) = '$ges' AND MONTH(s.FECHA_SOLICITUD) BETWEEN 6 and '$var_mes'
			  GROUP BY 1
			  UNION
			  select MONTH(s.fecha_SOLICITUD) MES
			  ,	   0 NRO_FACTURA
			  ,	   0 IMPORTE_NETO
			  ,      round(SUM(v.CANTIDAD * (v.PRECIO_COMPRA)),2) COSTO_VENTA
			  FROM vale v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
							   JOIN compra c ON c.ID_COMPRA = v.ID_COMPRA
			  WHERE YEAR(s.FECHA_SOLICITUD) = '$ges' AND MONTH(s.FECHA_SOLICITUD) BETWEEN 6 and '$var_mes'
			  GROUP BY 1
			  ORDER BY 1 ,3 DESC)SUMATORIA) k";
$total = mysqli_query($cnx_compras, $sql1) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_total = mysqli_fetch_assoc($total);
$num_total = mysqli_num_rows($total);

$sql2 =" SELECT	ID_MES
		 , 		MES 
		 FROM mes";
$mes = mysqli_query($cnx_compras, $sql2) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_mes = mysqli_fetch_assoc($mes);
$num_mes = mysqli_num_rows($mes); 

$sql3 =" SELECT	ID_MES
		 , 		MES 
		 FROM mes
		 WHERE ID_MES = MONTH(NOW())";
$mes_actual = mysqli_query($cnx_compras, $sql3) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_mes_actual = mysqli_fetch_assoc($mes_actual);
$num_mes_actual = mysqli_num_rows($mes_actual);

$sql4 =" SELECT	ID_GESTION
		 FROM gestion
		 ORDER BY 1 DESC";
$gestion = mysqli_query($cnx_compras, $sql4) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_gestion = mysqli_fetch_assoc($gestion);
$num_gestion = mysqli_num_rows($gestion);

$sql5 =" SELECT	ID_MES
		 , 		MES 
		 FROM mes
		 WHERE ID_MES = '$var_mes'";
$mes_nombre = mysqli_query($cnx_compras, $sql5) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_mes_nombre = mysqli_fetch_assoc($mes_nombre);
$num_mes_nombre = mysqli_num_rows($mes_nombre);

$nombre_mes = $row_mes_nombre['MES'];

$sql6 =" SELECT DISTINCT LAST_DAY(FECHA_FACTURA) ULTIMO
		 , '2014-01-01' PRIMERO
		 FROM compra
		 WHERE  MONTH(FECHA_FACTURA) = '$var_mes'";
$dias = mysqli_query($cnx_compras, $sql6) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_dias = mysqli_fetch_assoc($dias);
$num_dias = mysqli_num_rows($dias);

$primer_dia = $row_dias['PRIMERO'];
$ultimo_dia = $row_dias['ULTIMO'];
?>
<!doctype html>
<html lang="es">

<body>
    <div class="container-fluid">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        	<!--<h2 class="sub-header"><?PHP echo compras; ?></h2>
             	<h3 class="sub-header">DEL: <?PHP echo $row_dias['PRIMERO']; ?> AL: <?PHP echo $row_dias['ULTIMO']; ?></h3>
   			  	<h3 class="sub-header">TOTAL DEBE: <?PHP echo round($row_total['SUM_IMPORTE_NETO'],2); ?></h3>
    			<h3 class="sub-header">TOTAL HABER: <?PHP echo round($row_total['SUM_COSTO_VENTA'],2); ?></h3>
    			<h3 class="sub-header">SALDO: <?PHP echo round($row_total['SUM_IMPORTE_NETO'] - $row_total['SUM_COSTO_VENTA'],2); ?></h3>-->
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered table-condensed">
                        <thead class="ui-widget-header ui-corner-all">
                            <tr>
                                <th>MES</th>
                                <th>NRO FACTURA</th>
                                <th>COMPRAS</th>
                                <th>COSTO VENTAS MENSUAL</th>
                                <th>SALDO INVENTARIO</th>
                            </tr>      
                        </thead>
                        <tbody>
                            <?PHP
                                $total_fisico = 0;
                                $total_valorado = 0;
                                $pu = 0;
                                $cont =1;
                                do{
                            ?>
                                    <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                        <td align="right"><?PHP if(isset($row_pedido['MES'])){echo $row_pedido['MES'];} ?></td>
                                        <td align="right"><?PHP if(isset($row_pedido['FACTURA'])){echo $row_pedido['FACTURA'];} ?></td>
                                        <td align="right"><?PHP if(isset($row_pedido['IMPORTE_NETO'])){echo round($row_pedido['IMPORTE_NETO'],2);} ?></td>
                                        <td align="right"><?PHP if(isset($row_pedido['COSTO_VENTA'])){echo round($row_pedido['COSTO_VENTA'],2);} ?></td>
                                        <td align="right"><?PHP if(isset($row_pedido['IMPORTE_NETO'])){echo $total_fisico = $total_fisico + round($row_pedido['IMPORTE_NETO'],2) - round($row_pedido['COSTO_VENTA'],2);} ?></td>
                                    </tr>
                            <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
                        </tbody>
                    </table>
                </div>
    
    
        </div>
   	</div><!--
     <script src="../assets/js/docs.js"></script>
	 <script src="../js/jquery-1.8.3.min.js"></script>
	 <script src="../js/bootstrap.min.js"></script>-->
</body>
</html>