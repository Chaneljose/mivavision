<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP include_once('../Funciones/funciones.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['CODIGO'];

$sql="SELECT CODIGO,
			 ARTICULO,
			 SUM(DEBE) ENTRADA,
			 SUM(HABER) SALIDA,
			 SUM(DEBE) - SUM(HABER) SALDO
	  FROM (	SELECT	a.ID_ARTICULO CODIGO, 
					 	r.NOMBRE_BUSQUEDA ARTICULO, 
					 	SUM(a.ENTRADA) DEBE, 
					 	SUM(a.SALIDA) HABER
			  	FROM almacen a JOIN articulo r ON a.ID_ARTICULO = r.ID_ARTICULO
							   JOIN compra c ON a.ID_COMPRA = c.ID_COMPRA
			  	GROUP BY 1
			 	UNION ALL
			  	SELECT	v.ID_ARTICULO CODIGO, 
					 	a.NOMBRE_BUSQUEDA ARTICULO, 
					 	0 DEBE, 
					 	SUM(v.CANTIDAD) HABER
			  	FROM venta v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
			  	GROUP BY 1
			  	UNION ALL
			  	SELECT	v.ID_ARTICULO CODIGO, 
					 	a.NOMBRE_BUSQUEDA ARTICULO, 
					 	0 DEBE, 
					 	SUM(v.CANTIDAD) HABER
			  	FROM venta_credito v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
			  	GROUP BY 1
			  	UNION ALL
				SELECT	v.ID_ARTICULO CODIGO, 
					 	a.NOMBRE_BUSQUEDA ARTICULO, 
					 	0 DEBE, 
					 	SUM(v.CANTIDAD) HABER
			  	FROM vale v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
			  	GROUP BY 1
			  	UNION ALL
			  	SELECT	b.ID_ARTICULO CODIGO, 
					 	a.NOMBRE_BUSQUEDA ARTICULO, 
					 	0 DEBE, 
					 	SUM(b.CANTIDAD) HABER
			  	FROM baja b JOIN articulo a On b.ID_ARTICULO = a.ID_ARTICULO
			  	GROUP BY 1
			  	UNION ALL
			  	SELECT	b.ID_ARTICULO CODIGO, 
					 	a.NOMBRE_BUSQUEDA ARTICULO, 
					 	0 DEBE, 
					 	SUM(b.CANTIDAD) HABER
			  	FROM devolucion b JOIN articulo a On b.ID_ARTICULO = a.ID_ARTICULO
			  	GROUP BY 1
			  	ORDER BY 1
			) KARDEX
		GROUP BY 1,2";
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
    <td align="center" class="fuente"><strong>KARDEX DE PRODUCTOS <?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y H:i:s') ?></strong></td>
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
                <th>CODIGO</th>
                <th>PRODUCTO</th>
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
                <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                    <td align="center"><?PHP if(isset($row_pedido['CODIGO'])){echo $row_pedido['CODIGO'];} ?></td>
                    <td><?PHP if(isset($row_pedido['ARTICULO'])){echo $row_pedido['ARTICULO'];} ?></td>
                    <td align="right"><?PHP if(isset($row_pedido['ENTRADA'])){echo $row_pedido['ENTRADA'];} ?></td>
                    <td align="right"><?PHP if(isset($row_pedido['SALIDA'])){echo $row_pedido['SALIDA'];} ?></td>
                    <td align="right"><?PHP if(isset($row_pedido['SALDO'])){echo $row_pedido['SALDO'];} ?></td>
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