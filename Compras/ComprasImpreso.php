<?PHP 
require_once('../cnx/cnx_compras.php'); 
require_once('../Funciones/Funciones.php');

$nro_factura = $_REQUEST['BUSCAR'];

$sql_empresa = "SELECT * FROM empresa";
$queryEmpresa = $connect->prepare($sql_empresa);
$queryEmpresa->execute();
$empresas = $queryEmpresa->fetchAll(PDO::FETCH_OBJ);

$sql2 = "SELECT  c.ID_COMPRA
		 ,		 c.NRO_FACTURA
		 ,		 c.FECHA_FACTURA
		 ,		 c.CANTIDAD
		 ,		 c.PRECIO_FACTURA
		 ,		 c.UM_IMPUESTO
		 ,		 c.VALOR
		 ,		 c.ICE
		 ,     c.DESCUENTO
		 ,		 c.TOTAL
		 ,		 c.FECHA_CADUCIDAD
		 ,		 c.FECHA_REGISTRO
		 ,		 c.ID_ARTICULO
		 ,		 a.ARTICULO
		 FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
		 WHERE c.NRO_FACTURA = '$nro_factura'
		 ORDER BY c.ID_COMPRA";
$queryCompras = $connect->prepare($sql2);
$queryCompras->execute();
$compras = $queryCompras->fetchAll(PDO::FETCH_OBJ);

$sql1 = "SELECT  SUM(c.ICE) SUM_ICE
		 ,		 SUM(c.VALOR) SUM_VALOR
		 ,		 SUM(c.DESCUENTO) SUM_DESCUENTO
		 ,  	 SUM(c.TOTAL) SUM_TOTAL
		 ,		 SUM(c.TOTAL) - SUM(c.ICE) DIFERENCIA
		 FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
		 WHERE c.NRO_FACTURA =  '$nro_factura'";
$queryTotal = $connect->prepare($sql1);
$queryTotal->execute();
$totales = $queryTotal->fetchAll(PDO::FETCH_OBJ);

$sqlFactura = "SELECT  c.FECHA_FACTURA
		 ,		 c.NRO_FACTURA
		 FROM compra c
		 WHERE c.NRO_FACTURA = '$nro_factura'
		 GROUP BY c.NRO_FACTURA, c.FECHA_FACTURA";
$queryFacturas = $connect->prepare($sqlFactura);
$queryFacturas->execute();
$facturas = $queryFacturas->fetchAll(PDO::FETCH_OBJ);

$ice = 0;
$valor = 0;
$descuento = 0;
$var_total = 0;
$diferecnia = 0;
$fecha_factura = '';
$nombre_empresa = '';
if($queryTotal->rowCount()>0){
  foreach($totales as $total){
    $ice = $total->SUM_ICE;
    $valor = $total->SUM_VALOR;
    $descuento = $total->SUM_DESCUENTO;
    $var_total = $total->SUM_TOTAL;
    $diferecnia = $total->DIFERENCIA;
  }
}
if($queryFacturas->rowCount()>0){
  foreach($facturas as $factura){
    $fecha_factura = $factura->FECHA_FACTURA;
  }
}
if($queryEmpresa->rowCount()>0){
  foreach($empresas as $empresa){
    $nombre_empresa = $empresa->NOMBRE_EMPRESA;
  }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" href="../Iconos/favicon.ico">
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
 
<title>COMPRAS</title>
</head>

<body>
<p>&nbsp;</p>
<table border="0" class="fuente">
  <tr>
    <td><table width="948">
      <tr>
        <td width="388"><img src="../Iconos/logo_cabecera.png"  width="300" height="80" alt="<?php echo "HOLA"; ?>" /></td>
        <td width="177"> </td>
        <!--<td width="336"><strong class="fuente">N&ordm;: 
			<?PHP //echo zerofill($row_pedido['ID_SOLICITUD_SALIDA']) ; ?></strong></td>-->
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="fuente"><strong>REPORTE DE COMPRAS</strong></td>
  </tr>
  <tr>
    <td><hr/></td>
  </tr>
  <tr>
    <td><table border="0">
  </tr>
  <tr>  
  	<td><strong>NRO FACTURA: </strong><?PHP echo $nro_factura; ?></td>
     <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;</td>
      <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;</td>  
        <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;</td>
         <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;</td>
    <td><strong>FECHA: </strong><?PHP echo fecha_dma($fecha_factura); ?></td>
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
                <th>CANTIDAD</th>
                <th>ARTICULO</th>
                <th>PRECIO<br>FACTURA</th>
                <th>UM<br>IMPUESTO</th>
                <th>IMPORTE</th>
                <th>ICE</th>
                <th>DESCUENTO</th>
                <th>TOTAL</th>
            </tr>  
      </thead>
     <tbody>
            <?PHP
                $cont =1;
                if($queryCompras->rowCount()>0){
                  foreach($compras as $compra){
            ?>
                <tr>
                	<td align="center"><?PHP echo $compra->CANTIDAD; ?></td>
                    <td><?PHP echo ($compra->ARTICULO); ?></td>
                    <td align="right"><?PHP echo round($compra->PRECIO_FACTURA,2); ?></td>
                    <td align="right"><?PHP echo round($compra->UM_IMPUESTO,2); ?></td>
                    <td align="right"><?PHP echo round($compra->VALOR,2); ?></td>
                    <td align="right"><?PHP echo round($compra->ICE,2); ?></td>
                    <td align="right"><?PHP echo round($compra->DESCUENTO,2); ?></td>
                    <td align="right"><?PHP echo round($compra->TOTAL,2); ?></td>
                </tr>
            <?PHP $cont++;
					    } 
            }
           ?>
                <tr>
                    <td colspan="4"><strong>TOTAL FACTURA:</strong></td>
                    <td align="right"><strong><?PHP echo round($valor,2); ?></strong></td>
                    <td align="right"><strong><?PHP echo round($ice,2); ?></strong></td>
                    <td align="right"><strong><?PHP echo round($descuento,2); ?></strong></td>
                    <td align="right"><strong><?PHP echo round($var_total,2); ?></strong></td>
                </tr>
                <tr>
                    <td colspan="7"><strong>ICE:</strong></td>
                    <td align="right"><strong><?PHP echo round($ice,2); ?></strong></td>
                </tr>
                <tr>
                    <td colspan="7"><strong>IMPORTE PARA CREDITO FISCAL:</strong></td>
                    <td align="right"><strong><?PHP echo round($diferecnia,2); ?></strong></td>
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
  <!--<tr>
    <td><table border="0" align="center">
      <tr>
      	<td><strong>ENTREGADO POR</strong></td>
        <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;</td>
        <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;</td>
        <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;</td>
        <td><strong>RECIBIDO POR</strong></td>
      </tr>
    </table></td>
  </tr>-->
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div>
      <hr />
    </div></td>
  </tr>
  <tr>
   <td align="center" class="fuente"><p><?php echo $nombre_empresa; ?>, Cochabamba - Bolivia <?PHP date_default_timezone_set('America/La_Paz'); 
                        echo date('Y');?>. Todos los Derechos Resevervados</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>