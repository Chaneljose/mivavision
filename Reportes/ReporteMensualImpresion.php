<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP include_once('../Funciones/funciones.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$inicio= $_REQUEST['INICIO'];
//$fin= $_REQUEST['FIN'];

$date = strtotime($inicio);
//date("Y", $date); // Year (2003)
//$anio = date("Y", $date);
date("m", $date); // Month (12)
$mes = date("m", $date);
$fin = '2016-'.$mes.'-31';
function nombremes($mes){
 setlocale(LC_TIME, 'spanish');  
 $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
 return $nombre;
} 
$mes=nombremes($mes);
$mes; //devuelve "agosto"
$mes = strtoupper($mes);

$sql="select ID_ARTICULO, ARTICULO, PRECIO_VENTA, PRECIO_COMPRA, SUM(ROUND(CANTIDAD,2)) as CANTIDAD, SUM(ROUND((PRECIO_VENTA * CANTIDAD),2)) as TOTAL_VENTA,
 SUM(ROUND(((PRECIO_VENTA - PRECIO_COMPRA) * CANTIDAD),2)) as UTILIDAD
from (select v.ID_ARTICULO, a.ARTICULO, v.PRECIO_VENTA, v.PRECIO_COMPRA, v.CANTIDAD
from venta v, solicitud_venta s, articulo a
where v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA and a.ID_ARTICULO = v.ID_ARTICULO and s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$fin 23:59:59'
union all
select z.ID_ARTICULO, y.ARTICULO, z.PRECIO_VENTA, z.PRECIO_COMPRA, z.CANTIDAD
from vale z, solicitud_venta x, articulo y
where z.ID_SOLICITUD_VENTA = x.ID_SOLICITUD_VENTA and y.ID_ARTICULO = z.ID_ARTICULO and x.FECHA_SOLICITUD between '$inicio 00:00:00' and '$fin 23:59:59') 
as utilidades
group by ID_ARTICULO
ORDER BY ID_ARTICULO";

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
<html>
<head>
<meta charset="utf-8">
<!--<link rel="stylesheet" href="../css/start/jquery-ui-1.8.21.custom.css">-->
<link rel="stylesheet" href="../css/jquery.ui.tinytbl.css">

<!-- LLAMADA DE SCRIPTS JS -->
<script src="../js/jquery-1.7.2.min.js"></script>
<script src="../js/jquery-ui-1.8.21.custom.min.js"></script>

<!-- EJECUCION DE DIALOGO DE COFIRMACION-->
<script src="../js/js_dialogo.js"></script>

<!-- JQUERY BOTON -->
<script src="../js/js_boton.js"></script>

<!-- JQUERY GRID -->
<link rel="stylesheet" href="../jqgrid/css/ui.jqgrid.css">
<style type="text/css">
.f {	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
}
.fuente {	font-family: Verdana, Geneva, sans-serif;
}
.fuente {	font-family: Verdana, Geneva, sans-serif;
}
.fuente {	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
</style>
<script src="../jqgrid/js/i18n/grid.locale-es.js"></script>
<script src="../jqgrid/js/jquery.jqGrid.min.js"></script>

<!-- JQUERY TABLA -->
<script src="../js/jquery.ui.tinytbl.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.ui-tinytable').tinytbl({
            direction: 'ltr',      // text-direction (default: 'ltr')
            thead:     true,       // fixed table thead
            tfoot:     true,       // fixed table tfoot
            cols:      1,          // fixed number of columns
            width:     'auto',     // table width (default: 'auto')
            height:    'auto'      // table height (default: 'auto')
        });
    });
</script>

<script>
function ConfirmarBorrar()
{
	var agree=confirm("Está seguro de eliminar este registro? Este proceso es irreversible.");
	if (agree)
		return true ;
	else
		return false ;
}
</script>
 
<title>IMPRESION</title>
</head>

<body>
<p>&nbsp;</p>
<table border="0" class="fuente">
  <tr>
    <td><table width="917">
      <tr>
        <td width="388"><img src="../Iconos/logo_marol.png"width="100" height="100" alt="MAROL" /></td>
        <td width="177"> </td>
        <td width="336"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="fuente"><strong>REPORTE MENSUAL DE VENTAS Y UTILIDAD</strong></td>
  </tr>
  
  <tr>
    <td><hr/></td>
  </tr>
  <tr>
    <td align="center" class="fuente"><strong><?php echo $mes;?></strong></td>
  </tr>
  <tr>
    <td><table border="0">
  <tr>
    <!--  <td><p><strong>FECHA </strong><?PHP echo fecha_dma($inicio); ?><strong></p></td>
     <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;</td>
      <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;</td>
       <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;</td>
        <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;</td>
         <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;</td>
    <td></td>  -->
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td><hr/></td>
  </tr>
  <tr>
    <td><table border="1" cellpadding="1" cellspacing="0" class="ui-tinytbl ui-corner-all">
      <thead class="ui-widget-header ui-corner-all">
        <thead>
                            <!--<th></th>-->
                            <th>CANTIDAD</th>
                            <th>DETALLE</th>
                            <th>PRECIO VENTA</th>
							<th>PRECIO COMPRA</th>
                            <th>TOTAL VENTAS</th>
                            <th>UTILIDAD</th>
                         </thead>
                        <tbody>
                            <tr>
                                    <!--<td>VENTA MENSUAL</td>-->
                                    <?PHP
                                        do{
                                    ?>
                                            <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                                <!--<td></td>-->
                                                <td align="center"><?PHP echo $row_pedido['CANTIDAD']; ?></td>
                                                <td><?PHP echo utf8_encode($row_pedido['ARTICULO']); ?></td>
                                                <td align="right"><?PHP echo $row_pedido['PRECIO_VENTA']; ?></td>
												<td align="right"><?PHP echo $row_pedido['PRECIO_COMPRA']; ?></td>
                                                <td align="right"><?PHP echo $row_pedido['TOTAL_VENTA']; ?></td>
												<td align="right"><?PHP echo $row_pedido['UTILIDAD']; ?></td>
												
                                            </tr>
                                    <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
                                            <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                                <td colspan="4" align="center"><strong>TOTAL VENTAS</strong></td>
                                                <td align="right"><strong><?PHP echo $row_suma['TOTAL_VENTA'] + $row_suma_vales['TOTAL_VALE']?></strong></td>
	                                        </tr>
											<tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                                <td colspan="5" align="center"><strong>TOTAL UTILIDAD</strong></td>
                                                <td align="right"><strong><?PHP echo $row_suma_util_venta['UTILIDAD_VENTA'] + $row_suma_util_vale['UTILIDAD_VALE']?></strong></td>
	                                        </tr>
                            </tr>
                        </tbody>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div>
      <hr />
    </div></td>
  </tr>
  <tr>
   <td align="center" class="fuente"><p>Farmacia Marol, Cochabamba <?PHP date_default_timezone_set('America/La_Paz'); 
                        echo date('Y');?>. Todos los Derechos Resevervados</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>