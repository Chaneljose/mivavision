<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP include_once('../Funciones/funciones.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$inicio= $_REQUEST['INICIO'];
$fin= $_REQUEST['FIN'];
$buscar =$_REQUEST['ARTICULO'];

$sql="SELECT c.FECHA_REGISTRO, 
			 a.ID_ARTICULO, 
			 r.ARTICULO, 
			 'INGR' TIPO,
			 a.ENTRADA, 
			 a.SALIDA
	  FROM almacen a JOIN articulo r ON a.ID_ARTICULO = r.ID_ARTICULO
					 JOIN compra c ON a.ID_COMPRA = c.ID_COMPRA
	  WHERE a.ID_ARTICULO = '$buscar'
	  UNION
	  SELECT s.FECHA_SOLICITUD, 
	  		 v.ID_ARTICULO, 
			 a.ARTICULO, 
			 t.TIPO,
			 '0', 
			 v.CANTIDAD
	  FROM venta v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
				   JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
				   JOIN tipo_venta t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
	  WHERE v.ID_ARTICULO = '$buscar'
	  UNION
	  SELECT s.FECHA_SOLICITUD, 
	  		 v.ID_ARTICULO, 
			 a.ARTICULO, 
			 t.TIPO,
			 '0', 
			 v.CANTIDAD
	  FROM venta_credito v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
				   JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
				   JOIN tipo_venta t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
	  WHERE v.ID_ARTICULO = '$buscar'
	  UNION
	  SELECT s.FECHA_SOLICITUD, 
	  		 v.ID_ARTICULO, 
			 a.ARTICULO, 
			 t.TIPO,
			 '0', 
			 v.CANTIDAD
	  FROM vale v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
				   JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
				   JOIN tipo_venta t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
	  WHERE v.ID_ARTICULO = '$buscar'
	  UNION
	  SELECT b.FECHA_REGISTRO, 
	  		 b.ID_ARTICULO, 
			 a.ARTICULO, 
			 t.TIPO,
			 '0', 
			 b.CANTIDAD
	  FROM baja b JOIN articulo a On b.ID_ARTICULO = a.ID_ARTICULO
				   JOIN solicitud_BAJA s ON b.ID_SOLICITUD_BAJA = s.ID_SOLICITUD_BAJA
				   JOIN tipo_venta t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
	  WHERE b.ID_ARTICULO = '$buscar'
	  UNION
	  SELECT b.FECHA_REGISTRO, 
	  		 b.ID_ARTICULO, 
			 a.ARTICULO, 
			 t.TIPO,
			 '0', 
			 b.CANTIDAD
	  FROM devolucion b JOIN articulo a On b.ID_ARTICULO = a.ID_ARTICULO
				   JOIN solicitud_DEV s ON b.ID_SOLICITUD_DEV = s.ID_SOLICITUD_DEV
				   JOIN tipo_venta t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
	  WHERE b.ID_ARTICULO = '$buscar'
	  ORDER BY 1";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

$sql="SELECT DISTINCT a.ID_ARTICULO, a.ARTICULO
	  FROM articulo a JOIN almacen c ON a.ID_ARTICULO = c.ID_ARTICULO
	  WHERE a.ID_ARTICULO ='$buscar'
	  ORDER BY 1";
$articulo = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_articulo = mysqli_fetch_assoc($articulo);
$num_articulo = mysqli_num_rows($articulo);

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
        <td width="336"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="fuente"><strong>KARDEX FISICO VALORADO</strong><strong> POR FECHA</strong></td>
  </tr>
  <tr>
    <td><hr/></td>
  </tr>
  <tr>
    <td><table border="0">
  <tr>
  	<td><p><strong>ARTICULO </strong><?PHP echo $row_articulo['ARTICULO']; ?></p></td>
  </tr>
  <tr>
   <!-- <td><p><strong>FECHA </strong><?PHP //echo $inicio; ?><strong> AL </strong><?PHP //echo $fin; ?> </p></td>-->
    <td></td>
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
                    <th>FECHA</th>
                    <th>CODIGO ARTICULO</th>
                    <th>ARTICULO</th>
                    <th>TIPO VENTA</th>
                    <th>ENTRADA</th>
                    <th>SALIDA</th>
                    <th>SALDO</th>
                </tr>  
      </thead>
      <tbody>
            <?PHP
                $cont =1;
                do{
            ?>
               <tr>
                    <td><?PHP echo date('d-m-Y H:i:s',strtotime($row_pedido['FECHA_REGISTRO'])); ?></td>
                        <td align="center"><?PHP echo $row_pedido['ID_ARTICULO']; ?></td>
                        <td><?PHP echo $row_pedido['ARTICULO']; ?></td>
                        <td align="right"><?PHP echo $row_pedido['TIPO']; ?></td>
                        <td align="right"><?PHP echo $row_pedido['ENTRADA']; ?></td>
                        <td align="right"><?PHP echo $row_pedido['SALIDA']; ?></td>
                        <td align="right"><?PHP echo $total = $total + $row_pedido['ENTRADA'] - $row_pedido['SALIDA']; ?></td>
                </tr>
            <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
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
   <td align="center" class="fuente"><p>Asociación de Productores de Leche Del Valle De Cochabamba <?PHP date_default_timezone_set('America/La_Paz'); 
                        echo date('Y');?>. Todos los Derechos Resevervados</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>