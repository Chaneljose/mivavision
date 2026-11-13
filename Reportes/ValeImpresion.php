<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP include_once('../Funciones/funciones.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['CODIGO'];

$sql="SELECT b.ID_VALE
,		 CONCAT(s.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) NOTA
,		 s.FECHA_SOLICITUD
,		 a.ARTICULO
,		 b.CANTIDAD
,		 b.PRECIO_COMPRA
,		 b.TOTAL
,		 b.OBS
FROM vale b JOIN solicitud_venta s ON b.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA 
			   JOIN articulo a ON b.ID_ARTICULO = a.ID_ARTICULO";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 
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
    <td align="center" class="fuente"><strong>CONSUMO INTERNO <?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y') ?></strong></td>
  </tr>
  
  <tr>
    <td><table border="0">
  
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
                <!--<th>ID</th>-->
                <th>NOTA</th>
                <th>FECHA DEVOLUCION</th>
                <th>PRODUCTO</th>
                <th>CANTIDAD</th>
                <th>PRECIO COMPRA</th>
                <th>TOTAL</th>
                <th>OBSERVACION</th>
            </tr>         
        </thead>
         <tbody>
            <?PHP
                $cont =1;
                do{
            ?>
                <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                    <!--<td align="center"><?PHP echo $row_pedido['ID_VALE']; ?></td>-->
                    <td align="center"><?PHP echo $row_pedido['NOTA']; ?></td>
                    <td align="center"><?PHP echo $row_pedido['FECHA_SOLICITUD']; ?></td>
                    <td><?PHP echo $row_pedido['ARTICULO']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['CANTIDAD']; ?></td>
                    <td align="right"><?PHP echo round($row_pedido['PRECIO_COMPRA'],2); ?></td>
                    <td align="right"><?PHP echo round($row_pedido['TOTAL'],2); ?></td>
                    <td align="right"><?PHP echo $row_pedido['OBS']; ?></td>
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