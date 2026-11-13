<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Funciones/Funciones.php');
require_once('../Definiciones/Titulo.php'); 

//session_start(); 
$var_tipo = '';
$var_active = "contabilidad";
if(isset($_SESSION['SES_TIPO'])){
    $var_tipo = $_SESSION['SES_TIPO'];
}   

mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['BUSCAR'];
$inicio = fecha_amd($_REQUEST['INICIO']);
$fin = fecha_amd($_REQUEST['FIN']);

$var = 1;

 $sql="SELECT CODIGO,
			 ARTICULO,
			 SUM(DEBE) ENTRADA,
			 SUM(HABER) SALIDA,
			 SUM(DEBE) - SUM(HABER) SALDO_PROD,
			 ROUND((PC*$var),2) PC,
			 ROUND((PV*$var),2) PV,
			 ROUND(SUM(DEBE) * (PC*$var),2) PC_SALDO,
			 ROUND(SUM(HABER) * (PV*$var),2) PV_SALDO,
			 ROUND((SUM(DEBE) * (PC*$var))-(SUM(HABER) * (PV*$var)),2) UTILIDAD
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
			 ROUND((PC*$var),2) PC,
			 ROUND((PV*$var),2) PV,
			 ROUND(SUM(DEBE) * (PC*$var),2) PC_SALDO,
			 ROUND(SUM(HABER) * (PV*$var),2) PV_SALDO,
			 ROUND((SUM(DEBE) * (PC*$var))-(SUM(HABER) * (PV*$var)),2) UTILIDAD
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

$sql3 = "SELECT ID_GESTION
		 FROM gestion
		 ORDER BY 1 DESC";
$gestion = mysqli_query($cnx_compras, $sql3) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_gestion = mysqli_fetch_assoc($gestion);
$num_gestion = mysqli_num_rows($gestion);
?>
<!doctype html>
<html lang="es">

<?PHP head1(menu_cont); ?>
<body>
    	<?PHP 
			include('../menu.php');
			require_once('../NavsideContador.php');
		  navbar(menu_cont, $var_tipo, $var_active);
		  navside(kardex_imp);
			?>
        
        <div class="container-fluid">
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
               <h2 class="sub-header"><?PHP echo kardex;?></h2>
                    <form action="" >
                        <fieldset>
                      		<div class="form-group">
            			    	<div class="col-sm-7">
                       				<label class="col-sm-4 control-label">FECHA</label>
                                    	<input type="text" name="INICIO" class="calendario"/> AL <input type="text" name="FIN" class="calendario"/>
                                        <button class="btn btn-success" id="submit">BUSCAR</button><a id="impresion" class="btn btn-primary" href="ReporteKardexImporteImpresion.php?INICIO=<?PHP echo $inicio ?>&FIN=<?PHP echo $fin ?>">IMPRESION</a>
                                        <a class="excel" href="ReporteKardexImporteExcel.php?INICIO=<?PHP echo $inicio ?>&FIN=<?PHP echo $fin ?>">Excel</a>
                            	</div>
                            </div>
                        </fieldset>
                    </form>
    <hr />
    	<!--<h2>FECHA <?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y') ?></h2>-->
    	<h3>DEL <?PHP echo fecha_dma($inicio) ?> AL <?PHP echo fecha_dma($fin) ?></h3>
    	<h3>TOTAL COMPRAS: <?PHP echo $row_suma['PC_SALDO_SUM'] ?></h3>
    	<h3>TOTAL VENTAS: <?PHP echo $row_suma['PV_SALDO_SUM'] ?></h3>
    	<h3>SALDO: <?PHP echo round($row_suma['PC_SALDO_SUM'] - $row_suma['PV_SALDO_SUM'],2) ?></h3>
        <!--<h3>
        	<table>
            	<tbody>
                    <tr>
                        <td align="right" style="background-color: #0F0"><= 10 U</td>
                        <td align="right" style="background-color: #FF0">= 0 U</td>
                        <td align="right" style="background-color: #F00">< 0 U</td>
                    </tr>
               	</tbody>
             </table>
        </h3>-->
    <div class="table-responsive" >
    	<table  class="table table-striped table-hover table-bordered table-condensed">
        	<thead>
                <tr>
                    <th rowspan="2">CODIGO</th>
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
                    <td align="right"><?PHP echo $row_pedido['CODIGO']; ?></td>
                    <td><a href="../Reportes/Item.php?BUSCAR=<?PHP echo $row_pedido['CODIGO']; ?>"><?PHP echo $row_pedido['ARTICULO']; ?></a></td>
                    <td align="right"><?PHP echo $row_pedido['ENTRADA']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['PC']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['PC_SALDO']; ?></td>
                    
                    <td align="right"><?PHP echo $row_pedido['SALIDA']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['PV']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['PV_SALDO']; ?></td>
                    <?PHP if($row_pedido['SALDO_PROD'] == 0){ ?>
                    	<td align="right" style="background-color: #FF0"><?PHP echo $row_pedido['SALDO_PROD']; ?></td>
                    <?PHP }else if($row_pedido['SALDO_PROD'] < 0) { ?>
                    	<td align="right" style="background-color:#F00"><?PHP echo $row_pedido['SALDO_PROD']; ?></td>
                    <?PHP }else if($row_pedido['SALDO_PROD'] <= 10) { ?>
                    	<td align="right" style="background-color: #0F0"><?PHP echo $row_pedido['SALDO_PROD']; ?></td>
                    <?PHP }else { ?>
                    	<td align="right"><?PHP echo $row_pedido['SALDO_PROD']; ?></td>
                    <?PHP } ?>
                    
                    <?PHP if($row_pedido['UTILIDAD']<0){ ?>
						<td align="right" style="background-color:#F00"><?PHP echo $row_pedido['UTILIDAD']; ?></td>
                    <?PHP }else if($row_pedido['UTILIDAD'] == 0){ ?>
						<td align="right" style="background-color:#FF0"><?PHP echo $row_pedido['UTILIDAD']; ?></td>
					<?PHP } else { ?>
                    	<td align="right"><?PHP echo $row_pedido['UTILIDAD']; ?></td>
                    <?PHP }?>
					
					
                </tr>
            <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
        </tbody>
    </table>
    </div>
               
    </div>
</div>

</body>
</html>