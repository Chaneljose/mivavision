<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP include_once('../Funciones/funciones.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

//$inicio= $_REQUEST['INICIO'];
//$fin= $_REQUEST['FIN'];
$buscar =$_REQUEST['ARTICULO'];

$sql="SELECT FECHA_REGISTRO
,		  NOTA
,		 FISICO_INGRESO ENTRADA
,		 FISICO_SALIDA SALIDA
,		 0 FISICO_SALDO
,        0 PU
,        VALOR_INGRESO
,		 0 VALOR_SALIDA
,		 0 VALOR_SALDO
,		 ID_ALMACEN
,        ID_COMPRA
,		 ID_ARTICULO
,		 ARTICULO
,		 ID_TIPO_VENTA
FROM (
		SELECT   c.FECHA_REGISTRO
		,		 CONCAT('F-',LPAD(c.NRO_FACTURA,'7','0')) NOTA
		,		 c.CANTIDAD FISICO_INGRESO
		,		 0 FISICO_SALIDA
		,		 0 FISICO_SALDO
		,		 0 PU
		,		 c.TOTAL*0.87 VALOR_INGRESO
		,		 0 VALOR_SALIDA
		,		 0 VALOR_SALDO
		,		 0 ID_ALMACEN
		,      c.ID_COMPRA
		,		 c.ID_ARTICULO
		,		 a.ARTICULO
		,		 'F' ID_TIPO_VENTA
		FROM COMPRA c JOIN ARTICULO a ON c.ID_ARTICULO = a.ID_ARTICULO
		WHERE c.ID_ARTICULO ='$buscar'
		UNION
		SELECT   s.FECHA_SOLICITUD
		,		 CONCAT(s.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) NOTA
		,		 0 FISICO_INGRESO
		,		 v.CANTIDAD FISICO_SALIDA
		,		 0 FISICO_SALDO
		,		 0 PU
		,		 0 VALOR_INGRESO
		,		 0 VALOR_SALIDA
		,		 0 VALOR_SALDO
		,		 v.ID_ALMACEN
		,        v.ID_COMPRA
		,		 v.ID_ARTICULO
		,		 a.ARTICULO
		,		 s.ID_TIPO_VENTA
		FROM VENTA v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
						 JOIN ARTICULO a ON v.ID_ARTICULO = a.ID_ARTICULO 
		WHERE v.ID_ARTICULO = '$buscar'
		ORDER BY 1) k";
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
        <td width="388"><img src="../Iconos/logo_marol.png"width="100" height="100" alt="MAROL" /></td>
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
  	<td><strong>ARTICULO </strong><?PHP if(isset($row_pedido['ARTICULO'])){echo $row_pedido['ARTICULO'];} ?></td>
  </tr>
  <!--<tr>
            	<td><strong>UNIDAD: </strong></td>
            </tr>-->
            <tr>
            	<td><strong>CODIGO: </strong><?PHP if(isset($row_pedido['ID_ARTICULO'])){echo $row_pedido['ID_ARTICULO'];} ?></td>
            </tr>
            <!--<tr>
            	<td><strong>TOTAL EXISTENCIAS: </strong></td></tr>
            <tr>
            	<td>SALDO: </td>
            </tr>-->
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
                	<th rowspan="2">FECHA</th>
                    <th rowspan="2">NRO. COMPROBANTE</th>
                    <th colspan="3">FISICO</th>
                    <th rowspan="2">P/UNIT.</th>
                    <th colspan="3">VALORADO</th>
                </tr>
                <tr>
                    <th>INGRESO</th>
                    <th>SALIDA</th>
                    <th>SALDO</th>
                    <th>INGRESO</th>
                    <th>SALIDA</th>
                    <th>SALDO</th>
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
               <tr>
                <?php if(isset($row_pedido['FECHA_REGISTRO'])){?>
                    <td><?PHP echo date('d-m-Y H:i:s',strtotime($row_pedido['FECHA_REGISTRO'])); ?></td>
                        <td align="right"><?PHP echo $row_pedido['NOTA']; ?></td>
                        <td align="right"><?PHP echo $row_pedido['ENTRADA']; ?></td>
                        <td align="right"><?PHP echo $row_pedido['SALIDA']; ?></td>
                        <td align="right"><?PHP echo $total_fisico = $total_fisico + $row_pedido['ENTRADA'] - $row_pedido['SALIDA']; ?></td>
                        <td align="right"><?PHP if($total_fisico == 0)
													echo 0;
												else
													echo round($pu=$total_valorado/$total_fisico,4);?></td>
                        <td align="right"><?PHP echo round($row_pedido['VALOR_INGRESO'],4); ?></td>
                        <td align="right"><?PHP echo round($pu*$row_pedido['SALIDA'],4); ?></td>
                        <td align="right"><?PHP echo round($total_valorado = $total_valorado + $row_pedido['VALOR_INGRESO'] - $pu*$row_pedido['SALIDA'],4);} ?></td>
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
   <td align="center" class="fuente"><p>Farmacia Marol, Cochabamba <?PHP date_default_timezone_set('America/La_Paz'); 
                        echo date('Y');?>. Todos los Derechos Resevervados</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>