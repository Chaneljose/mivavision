<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['BUSCAR'];



$sql="SELECT b.ID_VENTA
,		 CONCAT(s.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) NOTA
,		 s.FECHA_SOLICITUD
,		 a.ARTICULO
,		 b.CANTIDAD
,		 b.PRECIO_VENTA
,		 b.TOTAL
FROM venta b JOIN solicitud_venta s ON b.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA 
			   JOIN articulo a ON b.ID_ARTICULO = a.ID_ARTICULO";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

?>
<!doctype html>
<html lang="es">
<head>
	<title>REPORTE VENTAS CREDITO</title>
    <link rel="stylesheet" href="../css/start/jquery-ui-1.9.2.custom.css">
    <link rel="stylesheet" href="../css/principal.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/estilo_form.css" >
    <link rel="stylesheet" href="../css/estilo_tabla.css" >
    
    <!-- JQUERY -->
        <!-- SCRIPT DE CONFIRMACION PARA BORRAR -->
        <script src="../js/js_confirma_borrar.js"></script>   
        <!-- LLAMADA DE SCRIPTS JS -->
		<script src="../js/jquery-1.8.3.js"></script>
        <script src="../js/jquery-ui-1.9.2.custom.min.js"></script>
        <!-- JQUERY BOTON -->
		<script src="../js/js_boton.js"></script>
        <!-- JQUERY AUTOCOMPLETAR -->
		<script src="../js/js_autocompletar.js"></script>
        <!-- JQUERY CALENDARIO -->
		<script src="../js/js_calendario.js"></script>
        <!-- SCRIPT DE CONFIRMACION PARA ANULAR BOLETA -->
        <script src="../js/js_confirma_anular.js"></script>
        
</head>
<body class="ui-widget"><header class="ui-widget-header">
    	<h2>VENTA CREDITO</h2>
    </header>
    	<?PHP //include('../menu.php'); ?>
    <section>
        <form action="" >
            <div><a class="impresion" href="ValeImpresion.php?CODIGO=<?PHP echo $codigo; ?>">Impresion</a></div>
        </form>
    </section>
    <hr />
    	<h2>FECHA <?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y') ?></h2>
    <div class="formulario ui-corner-all">
    <table class="ui-tinytbl ui-corner-all">
        <thead class="ui-widget-header ui-corner-all">
            <tr>
                <!--<th>ID</th>-->
                <th>NOTA</th>
                <th>FECHA DEVOLUCION</th>
                <th>PRODUCTO</th>
                <th>CANTIDAD</th>
                <th>PRECIO VENTA</th>
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
                    <!--<td align="center"><?PHP echo $row_pedido['ID_VENTA_CREDITO']; ?></td>-->
                    <td align="center"><?PHP echo $row_pedido['NOTA']; ?></td>
                    <td align="center"><?PHP echo $row_pedido['FECHA_SOLICITUD']; ?></td>
                    <td><?PHP echo $row_pedido['ARTICULO']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['CANTIDAD']; ?></td>
                    <td align="right"><?PHP echo round($row_pedido['PRECIO_VENTA'],2); ?></td>
                    <td align="right"><?PHP echo round($row_pedido['TOTAL'],2); ?></td>
                    <td align="right"><?PHP echo $row_pedido['OBS']; ?></td>
                </tr>
            <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
        </tbody>
    </table>
    </div>
        <div class="salto"></div>

</body>
</html>