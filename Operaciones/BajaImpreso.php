<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Funciones/Funciones.php');
	  require_once('../Definiciones/Titulo.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['BUSCAR'];
//$codigo='12';
$sql2 = "SELECT v.ID_BAJA,
				 v.ID_SOLICITUD_BAJA,
				 s.NRO_NOTA,
		 		 DATE_FORMAT(s.FECHA_SOLICITUD, '%d-%m-%Y %H:%i:%s') FECHA_SOLICITUD,
				 v.ID_ALMACEN,
				 v.ID_COMPRA,
				 v.ID_ARTICULO,
				 a.ARTICULO,
				 a.PRECIO_COMPRA,
				 v.CANTIDAD,
				 v.TOTAL,
				 s.ID_TIPO_VENTA,
		 		 t.TIPO,
				 v.OBS
		FROM BAJA v JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
				     JOIN solicitud_BAJA s ON v.ID_SOLICITUD_BAJA = s.ID_SOLICITUD_BAJA
				     JOIN tipo_venta t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
		WHERE s.ID_SOLICITUD_BAJA = '$codigo'
		ORDER BY 1 DESC LIMIT 1";
$solicitud = mysqli_query($cnx_compras, $sql2) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_solicitud = mysqli_fetch_assoc($solicitud);
$num_solicitud = mysqli_num_rows($solicitud);

$id_solicitud_salida = $row_solicitud['ID_SOLICITUD_BAJA'];

$sql="SELECT v.ID_SOLICITUD_BAJA,
			 v.ID_ARTICULO,
			 r.ARTICULO,
			 r.ID_UNIDAD,
			 r.DESCRIPCION,
			 v.PRECIO_COMPRA,
			 v.CANTIDAD,
			 v.TOTAL,
			 v.OBS
	FROM BAJA v  join articulo r on v.ID_ARTICULO = r.ID_ARTICULO 
	WHERE v.ID_SOLICITUD_BAJA = '$id_solicitud_salida'";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

$sql3="SELECT SUM(v.TOTAL) SUMA
	   FROM BAJA v  join articulo r on v.ID_ARTICULO = r.ID_ARTICULO 
	   WHERE v.ID_SOLICITUD_BAJA = '$id_solicitud_salida'";
$total = mysqli_query($cnx_compras, $sql3) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_total = mysqli_fetch_assoc($total);
$num_total = mysqli_num_rows($total); 
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
        <td width="388"><img src="../Iconos/LOGO_APL_TITULO.PNG"width="388" height="69" alt="APL" /></td>
        <td width="177"> </td>
        <td width="336" align="center"><strong>NRO: <?PHP echo zerofill($row_solicitud['ID_SOLICITUD_BAJA']) ?> </strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="fuente"><strong>BAJA DE PRODUCTOS <?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y') ?></strong></td>
  </tr>
  
  <tr><td><strong>FECHA: </strong><?PHP echo $row_solicitud['FECHA_SOLICITUD'] ?></td></tr>
  <!--<tr><td><strong>OBSERVACION: </strong><?PHP echo $row_solicitud['OBS'] ?></td></tr>-->

</td>
  </tr>
  <tr>
    <td><hr/></td>
  </tr>
  <tr>
    <td><table border="1" cellpadding="1" cellspacing="0" class="ui-tinytbl ui-corner-all">
        <thead class="ui-widget-header ui-corner-all">
            <tr>
              <th>CANT</th>
              <th>DETALLE</th>
              <th>PRECIO COMPRA</th>
              <th>TOTAL Bs.</th>
              <th>OBSERVACION</th>
            </tr>      
        </thead>
        <tbody>
            <?PHP
                $cont =1;
                do{
            ?>
                <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                      <td align="right"><?PHP echo $row_pedido['CANTIDAD']; ?></td>
                      <td><?PHP echo $row_pedido['ARTICULO']; ?></td>
                      <td align="right"><?PHP echo $row_pedido['PRECIO_COMPRA']; ?></td>
                      <td align="right"><?PHP echo $row_pedido['TOTAL']; ?></td>
                      <td align="right"><?PHP echo $row_pedido['OBS']; ?></td>
                </tr>
            <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
             <tr>
                <td colspan="3" align="center"><strong>TOTAL</strong></td>
                <td align="right"><strong><?PHP echo $row_total['SUMA']; ?></strong></td>
            </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table class="fuente" align="center" width="200" border="0">
                    <tr>
                      <td>................................................</td>
                    </tr>
                    <tr>
                      <td align="center"><strong>ENCARGADA DE VENTAS</strong></td>
                    </tr>
                </table></td>
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
   <td align="center" class="fuente"><p>Asociación de Productores de Leche Del Valle De Cochabamba <?PHP date_default_timezone_set('America/La_Paz'); 
                        echo date('Y');?>. Todos los Derechos Resevervados</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>