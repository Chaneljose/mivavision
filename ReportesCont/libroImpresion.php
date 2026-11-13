<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP include_once('../Funciones/funciones.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);
					
//$inicio = fecha_amd($_REQUEST['INICIO']);
//$fin = fecha_amd($_REQUEST['FIN']);
$ges = $_REQUEST['GESTION'];
$buscar =$_REQUEST['BUSCAR'];

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
				WHERE YEAR(c.FECHA_FACTURA) = '$ges'
				GROUP BY 1,2
				UNION
				select MONTH(s.fecha_SOLICITUD)
				,	   0
				,	   0 
				,      round(SUM(IFNULL(((((c.TOTAL - c.ICE) * 1)+c.ICE) / c.CANTIDAD),0) * v.CANTIDAD),2) COSTO_VENTA
				FROM venta v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
								 JOIN compra c ON c.ID_COMPRA = v.ID_COMPRA
				WHERE YEAR(s.FECHA_SOLICITUD) = '$ges'
				GROUP BY 1
				ORDER BY 1 ,3 DESC";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

$sql1="SELECT SUM(IMPORTE_NETO) SUM_IMPORTE_NETO
		,		 SUM(COSTO_VENTA) SUM_COSTO_VENTA
		,		 SUM(IMPORTE_NETO) - SUM(COSTO_VENTA) SUM_DIF
		FROM (
				SELECT MONTH(c.FECHA_FACTURA) MES
				,		 c.NRO_FACTURA
				,      round(SUM(((c.TOTAL - c.ICE) * 1)+c.ICE),2) IMPORTE_NETO
				,		 '0' COSTO_VENTA
				FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
				WHERE YEAR(c.FECHA_FACTURA) = '$ges'
				GROUP BY 1,2
				UNION
				select MONTH(s.FECHA_SOLICITUD)
				,		 0
				,		 0 
				,      round(SUM(IFNULL(((((c.TOTAL - c.ICE) *1)+c.ICE) / c.CANTIDAD),0) * v.CANTIDAD),2)  COSTO_VENTA
				FROM venta v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
								 JOIN compra c ON c.ID_COMPRA = v.ID_COMPRA
				WHERE YEAR(s.FECHA_SOLICITUD) = '$ges'
				GROUP BY 1
				ORDER BY 1 ,3 DESC ) k";
$total = mysqli_query($cnx_compras, $sql1) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_total = mysqli_fetch_assoc($total);
$num_total = mysqli_num_rows($total);

$sql3 = "SELECT ID_GESTION
		 FROM gestion
		 ORDER BY 1 DESC";
$gestion = mysqli_query($cnx_compras, $sql3) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_gestion = mysqli_fetch_assoc($gestion);
$num_gestion = mysqli_num_rows($gestion);
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
        <td width="388"><img src="../../Iconos/LOGO_APL_TITULO.PNG"width="388" height="69" alt="APL" /></td>
        <td width="177"> </td>
        <td width="336"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="fuente"><strong>COSTO COMPRA</strong><strong> <?PHP echo $ges; ?></strong></td>
  </tr>
  <tr>
    <td><hr/></td>
  </tr>
  <tr>
    <td><table>
        	<tr>
            	<td><strong>GESTION: </strong><?PHP echo $ges; ?></td>
            </tr>
        	<tr>
            	<td><strong>TOTAL DEBE: </strong><?PHP echo round($row_total['SUM_IMPORTE_NETO'],2); ?></td>
            </tr>
            <tr>
            	<td><strong>TOTAL HABER:  </strong><?PHP echo round($row_total['SUM_COSTO_VENTA'],2); ?></td>
            </tr>
            <tr>
            	<td><strong>SALDO:  </strong><?PHP echo round($row_total['SUM_IMPORTE_NETO'] - $row_total['SUM_COSTO_VENTA'],2); ?></td>
            </tr>
        </table>
</td>
  </tr>
  <tr>
    <td><hr/></td>
  </tr>
  <tr>
    <td><table  border="1" cellpadding="1" cellspacing="0" class="ui-tinytbl ui-corner-all">
            <thead class="ui-widget-header ui-corner-all">
                <tr>
                	<th>MES</th>
                    <th>FACTURA</th>
                    <th>DEBE</th>
                    <th>HABER</th>
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
                        <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                            <td align="right"><?PHP echo $row_pedido['MES']; ?></td>
                            <td align="right"><?PHP echo $row_pedido['FACTURA']; ?></td>
                            <td align="right"><?PHP echo round($row_pedido['IMPORTE_NETO'],2); ?></td>
                            <td align="right"><?PHP echo round($row_pedido['COSTO_VENTA'],2); ?></td>
                            <td align="right"><?PHP echo $total_fisico = $total_fisico + round($row_pedido['IMPORTE_NETO'],2) - round($row_pedido['COSTO_VENTA'],2); ?></td>
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