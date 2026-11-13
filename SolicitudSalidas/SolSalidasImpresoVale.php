<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP include_once('../Funciones/funciones.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['BUSCAR'];
//$codigo='12';
$sql2 = "SELECT v.ID_VALE,
				 v.ID_SOLICITUD_VENTA,
				 s.NRO_NOTA,
		 		 DATE_FORMAT(s.FECHA_SOLICITUD, '%d-%m-%Y %H:%i:%s') FECHA_SOLICITUD,
				 v.ID_CLIENTE,
				 CONCAT(c.NOMBRE,' ',c.APATERNO,' ',c.AMATERNO) NOMBRE,
				 v.ID_ALMACEN,
				 v.ID_COMPRA,
				 v.ID_ARTICULO,
				 a.ARTICULO,
				 v.PRECIO_COMPRA,
				 v.CANTIDAD,
				 v.TOTAL,
				 s.ID_TIPO_VENTA,
		 		 t.TIPO
		FROM vale v JOIN cliente c ON v.ID_CLIENTE = c.ID_CLIENTE
				     JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
				     JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
				     JOIN tipo_venta t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
		WHERE s.ID_SOLICITUD_VENTA = '$codigo'
		ORDER BY 1 DESC LIMIT 1";
$solicitud = mysqli_query($cnx_compras, $sql2) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_solicitud = mysqli_fetch_assoc($solicitud);
$num_solicitud = mysqli_num_rows($solicitud);

$id_solicitud_salida = $row_solicitud['ID_SOLICITUD_VENTA'];

$sql="SELECT v.ID_SOLICITUD_VENTA,
			 v.ID_ARTICULO,
			 r.ARTICULO,
			 r.ID_UNIDAD,
			 r.DESCRIPCION,
			 v.PRECIO_COMPRA,
			 v.CANTIDAD,
			 v.TOTAL
	FROM vale v  join articulo r on v.ID_ARTICULO = r.ID_ARTICULO 
	WHERE v.ID_SOLICITUD_VENTA = '$id_solicitud_salida'";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

$sql3="SELECT SUM(v.TOTAL) SUMA
	   FROM venta v  join articulo r on v.ID_ARTICULO = r.ID_ARTICULO 
	   WHERE v.ID_SOLICITUD_VENTA = '$id_solicitud_salida'";
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
.f {font-family: Verdana, Geneva, sans-serif; 
	font-size: 14px;
}
.fuente {	font-family: Verdana, Geneva, sans-serif;}
.fuente {	font-family: Verdana, Geneva, sans-serif;}
.fuente {	font-family: Verdana, Geneva, sans-serif;
			font-size: 10px;
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
 
<title>BOLETA SALIDA</title>
</head>

<body>
<table border="0" class="fuente">
  <tr>
    <td align="center" class="fuente"><strong>ASOCIACION DE PRODUCTORES DE LECHE</strong></td>
  </tr>
  <tr>
  	<td  align="center">Av. MANCO KAPAC #743</td>
  </tr>
  <tr>
  	<td  align="center">TELF:(591-4) 4582190</td>
  </tr>
  <!--<tr>
  	<td  align="center">TELF./FAX:(591-4) 4582189</td>
  </tr>
  <tr>
  	<td  align="center">CASILLA 220</td>
  </tr>
    <tr>
  	<td  align="center">EMAIL: aplcbba@supernet.com.bo</td>
  </tr>-->
  <tr>
    <td><hr/></td>
  </tr>
  <tr>
    <td><table border="0">
  </tr>
   <tr>  
    <td><strong>NRO NOTA: </strong><?PHP echo zerofill($row_solicitud['NRO_NOTA']); ?></td>
  </tr>
   <tr>  
    <td><strong>TIPO VENTA: </strong><?PHP echo $row_solicitud['TIPO']; ?></td>
  </tr>
  <tr>  
    <td><strong>NOMBRE: </strong><?PHP echo $row_solicitud['NOMBRE']; ?></td>
  </tr>
   <tr>
    <td><strong>FECHA: </strong><?PHP echo $row_solicitud['FECHA_SOLICITUD']; ?></td>
    </tr>
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
        <tr>
          <th>CANT</th>
          <th>DETALLE</th>
          <th>P.U.</th>
          <th>TOTAL Bs.</th>
        </tr>
      </thead>
      <tbody>
        <?PHP
			$cont =1;
			do{
		?>
        <tr>
          <td align="right"><?PHP echo $row_pedido['CANTIDAD']; ?></td>
          <td><?PHP echo $row_pedido['ARTICULO']; ?></td>
          <td align="right"><?PHP echo $row_pedido['PRECIO_COMPRA']; ?></td>
          <td align="right"><?PHP echo $row_pedido['TOTAL']; ?></td>
        </tr>
        <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?> 
        <tr>
    		<td><strong>TOTAL</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right"><strong><?PHP echo $row_total['SUMA']; ?></strong></td>
  		</tr>
        
      </tbody>
    </table> 
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>CAJA</p>
    </table>
</body>
</html>