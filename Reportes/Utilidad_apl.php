<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Funciones/Funciones.php');
	  require_once('../Definiciones/Titulo.php'); 
	  	  
//session_start(); 
$var_tipo = $_SESSION['SES_TIPO'];
$var_active = "reportes";
mysqli_select_db($cnx_compras, $database_cnx_compras);
$inicio = "";
//$menu = $_REQUEST['MENU'];

if(isset($_REQUEST['INICIO'])){
    $inicio = fecha_amd($_REQUEST['INICIO']);
}

$date = strtotime($inicio);
$anio = date("Y", $date);
date("m", $date); // Month (12)
$mes = date("m", $date);
$dia= date("d",(mktime(0,0,0, $mes+1,1, $anio)-1));
$fin = $anio.'-'.$mes.'-'.$dia;

/*function nombremes($mes){
 setlocale(LC_TIME, 'spanish');  
 $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
 return $nombre;
} */
function nombremes($mes){
 $meses = array(
    1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril",
    5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto",
    9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"
);
return $meses[(int)$mes];
} 
$mes=nombremes($mes);
$mes = strtoupper($mes);


$sql="select ID_ARTICULO, ARTICULO, PRECIO_VENTA, PRECIO_COMPRA, SUM(ROUND(CANTIDAD,2)) as CANTIDAD, SUM(ROUND((PRECIO_VENTA * CANTIDAD),2)) as TOTAL_VENTA,
 SUM(ROUND(((PRECIO_VENTA - PRECIO_COMPRA) * CANTIDAD),2)) as UTILIDAD
from (select v.ID_ARTICULO, a.ARTICULO, v.PRECIO_VENTA, v.PRECIO_COMPRA, v.CANTIDAD
from venta v, solicitud_venta s, articulo a
where v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA and a.ID_ARTICULO = v.ID_ARTICULO and s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$fin 23:59:59'
union all
select z.ID_ARTICULO, y.ARTICULO, z.PRECIO_VENTA, z.PRECIO_COMPRA, z.CANTIDAD
from vale z, solicitud_venta x, articulo y
where z.ID_SOLICITUD_VENTA = x.ID_SOLICITUD_VENTA and y.ID_ARTICULO = z.ID_ARTICULO and x.FECHA_SOLICITUD between '$inicio 00:00:00' and '$fin 23:59:59' GROUP BY 1,2,3,4,5,6) 
as utilidades
ORDER BY ID_ARTICULO";

echo $sql;

$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 


$sql2="select SUM(ROUND((v.PRECIO_VENTA * v.CANTIDAD),2)) as TOTAL_VENTA
from venta v, solicitud_venta s, articulo a
where v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA and a.ID_ARTICULO = v.ID_ARTICULO and s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$fin 23:59:59'";
$suma = mysqli_query($cnx_compras, $sql2) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_suma = mysqli_fetch_assoc($suma);
$num_suma = mysqli_num_rows($suma);


$sql3="select SUM(ROUND((z.PRECIO_VENTA * z.CANTIDAD),2)) as TOTAL_VALE
from vale z, solicitud_venta x, articulo y
where z.ID_SOLICITUD_VENTA = x.ID_SOLICITUD_VENTA and y.ID_ARTICULO = z.ID_ARTICULO and x.FECHA_SOLICITUD between '$inicio 00:00:00' and '$fin 23:59:59'";
$suma_vales = mysqli_query($cnx_compras, $sql3) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_suma_vales = mysqli_fetch_assoc($suma_vales);
$num_suma_vales = mysqli_num_rows($suma_vales);

$sql4 = "SELECT SUM(ROUND(((v.PRECIO_VENTA - v.PRECIO_COMPRA) * v.CANTIDAD),2)) as UTILIDAD_VENTA
from venta v, solicitud_venta s, articulo a
where v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA and a.ID_ARTICULO = v.ID_ARTICULO and s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$fin 23:59:59'";
$suma_util_venta = mysqli_query($cnx_compras, $sql4) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_suma_util_venta = mysqli_fetch_assoc($suma_util_venta);
$num_suma_util_venta = mysqli_num_rows($suma_util_venta);

$sql5 = "select SUM(ROUND(((z.PRECIO_VENTA - z.PRECIO_COMPRA) * z.CANTIDAD),2)) as UTILIDAD_VALE
from vale z, solicitud_venta x, articulo y
where z.ID_SOLICITUD_VENTA = x.ID_SOLICITUD_VENTA and y.ID_ARTICULO = z.ID_ARTICULO and x.FECHA_SOLICITUD between '$inicio 00:00:00' and '$fin 23:59:59'";
$suma_util_vale = mysqli_query($cnx_compras, $sql5) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_suma_util_vale = mysqli_fetch_assoc($suma_util_vale);
$num_suma_util_vale = mysqli_num_rows($suma_util_vale);


?>



<!doctype html>
<html lang="es">

<?PHP head1('reporte'); ?>
<body>
    	<?PHP include('../menu.php');
			  navbar(reportes, $var_tipo, $var_active);
			  require_once('../NavsideReportes.php');
		  	  navside(utilidad);?>
        
        <div class="container-fluid">
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
               <h2 class="sub-header"><?PHP echo mensual; ?></h2>
                   <form class="form-horizontal" role="form" action="">
                    <fieldset>
                    	<div class="form-group">
                        	<label for="INICIO" class="col-sm-3 control-label">FECHA</label>
                            	<div class="col-sm-2">
                                	<input type="text" class="form-control calendario" id="INICIO" name="INICIO" placeholder="FECHA INICIO"/>
                                </div> 
                                <button class="btn btn-success" id="submit">BUSCAR</button>
                        		<a id="impresion" class="btn btn-primary"  href="ReporteMensualImpresion.php?INICIO=<?PHP echo $inicio; ?>">IMPRESION</a>
								<!-- <a class="btn btn-info" href="ReporteMensualExel.php?INICIO=<?PHP echo $inicio; ?>">EXCEL</a> -->
                        </div>
                        
                    </fieldset>
                </form>
                <hr />
                <!--<h3 class="sub-header">REPORTE MENSUAL DE <?PHP echo fecha_dma($inicio); //fecha_dma($row_pedido['FECHA_SOLICITUD']); ?></h3>-->
				<h3 class="sub-header">REPORTE MENSUAL DE LA UTILIDAD DE  <?PHP echo $mes; //fecha_dma($row_pedido['FECHA_SOLICITUD']); ?></h3>
                <hr/>
    			<div class="table-responsive">
                	<table  class="table table-striped table-hover table-bordered table-condensed">
                        <thead>
                            <th></th>
                            <th>CANTIDAD</th>
                            <th>DETALLE</th>
                            <th>PRECIO VENTA</th>
							<th>PRECIO COMPRA</th>
                            <th>TOTAL VENTAS</th>
                            <th>UTILIDAD</th>
                         </thead>
                        <tbody>
                            <tr>
                                    <td>VENTA MENSUAL</td>
                                    <?PHP
                                        do{
                                    ?>
                                            <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                                <td></td>
                                                <td><?PHP echo $row_pedido['CANTIDAD']; ?></td>
                                                <td><?PHP echo $row_pedido['ARTICULO']; ?></td>
                                                <td align="right"><?PHP echo $row_pedido['PRECIO_VENTA']; ?></td>
												<td align="right"><?PHP echo $row_pedido['PRECIO_COMPRA']; ?></td>
                                                <td align="right"><?PHP echo $row_pedido['TOTAL_VENTA']; ?></td>
												<td align="right"><?PHP echo $row_pedido['UTILIDAD']; ?></td>
												
                                            </tr>
                                    <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
                                            <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                                <td colspan="5" align="center"><strong>TOTAL VENTAS</strong></td>
                                                <td align="right"><strong><?PHP echo $row_suma['TOTAL_VENTA'] + $row_suma_vales['TOTAL_VALE']?></strong></td>
	                                        </tr>
											<tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                                <td colspan="6" align="center"><strong>TOTAL UTILIDAD</strong></td>
                                                <td align="right"><strong><?PHP echo $row_suma_util_venta['UTILIDAD_VENTA'] + $row_suma_util_vale['UTILIDAD_VALE']?></strong></td>
												
	                                        </tr>
                            </tr>
                            
                          
    
</body>
</html>

