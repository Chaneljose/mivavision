<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/funciones.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['BUSCAR'];



$sql="SELECT a.ARTICULO
	  ,		 c.FECHA_CADUCIDAD
	  ,		 c.CANTIDAD
	  ,		 SUM(v.CANTIDAD) VENTA
	  ,		 c.CANTIDAD - SUM(v.CANTIDAD) SALDO
	  ,		 DATEDIFF(c.FECHA_CADUCIDAD,now()) DIAS
	  FROM articulo a JOIN compra c ON a.ID_ARTICULO = c.ID_ARTICULO
					  JOIN venta v ON c.ID_COMPRA = v.ID_COMPRA
	  WHERE c.FECHA_CADUCIDAD >= DATE_FORMAT(now(),'%Y-%m-%d') 
	  GROUP BY 1, 2,3
	  ORDER BY 6";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

?>
<!doctype html>
<html lang="es">
<head>
	<title>CADUCIDAD</title>
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
    	<h1>CADUCIDAD DE PRODUCTOS</h1>
    </header>
    	<?PHP include('../menu.php'); ?>
    <section>
        <form action="" >
            <div><a id="impresion" href="CaducoImpresion.php?CODIGO=<?PHP echo $codigo; ?>">Impresion</a></div>
        </form>
    </section>
    <hr />
    	<h2>FECHA <?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y') ?></h2>
        <h3>
        	<table>
            	<tbody>
                    <tr>
                        <td align="right" style="background-color: #0F0"><= 10 U</td>
                        <td align="right" style="background-color: #FF0">= 0 U</td>
                        <td align="right" style="background-color: #F00">< 0 U</td>
                    </tr>
               	</tbody>
             </table>
        </h3>
    <div class="formulario ui-corner-all">
    <table class="ui-tinytbl ui-corner-all">
        <thead class="ui-widget-header ui-corner-all">
            <tr>
                <th>ARTICULO</th>
                <th>FECHA CADUCIDAD</th>
                <th>LOTE</th>
                <th>VENTA</th>
                <th>SALDO</th>
                <th>DIAS</th>
            </tr>      
        </thead>
        <tbody>
            <?PHP
                $cont =1;
                do{
            ?>
                <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                    <td><?PHP echo $row_pedido['ARTICULO']; ?></td>
                    <td><?PHP echo fecha_dma($row_pedido['FECHA_CADUCIDAD']); ?></td>
                    <td><?PHP echo $row_pedido['CANTIDAD']; ?></td>
                    <td><?PHP echo $row_pedido['VENTA']; ?></td>
                    
                    <?PHP if($row_pedido['SALDO'] == 0){ ?>
                    	<td align="right" style="background-color: #FF0"><?PHP echo $row_pedido['SALDO']; ?></td>
                    <?PHP }else if($row_pedido['SALDO'] < 0) { ?>
                    	<td align="right" style="background-color:#F00"><?PHP echo $row_pedido['SALDO']; ?></td>
                    <?PHP }else if($row_pedido['SALDO'] <= 10) { ?>
                    	<td align="right" style="background-color: #0F0"><?PHP echo $row_pedido['SALDO']; ?></td>
                    <?PHP }else { ?>
                    	<td align="right"><?PHP echo $row_pedido['SALDO']; ?></td>
                    <?PHP } ?>
                    
                    <?PHP if($row_pedido['DIAS'] == 0){ ?>
                    	<td align="right" style="background-color: #FF0"><?PHP echo $row_pedido['DIAS']; ?></td>
                    <?PHP }else if($row_pedido['DIAS'] < 0) { ?>
                    	<td align="right" style="background-color:#F00"><?PHP echo $row_pedido['DIAS']; ?></td>
                    <?PHP }else if($row_pedido['DIAS'] <= 10) { ?>
                    	<td align="right" style="background-color: #0F0"><?PHP echo $row_pedido['DIAS']; ?></td>
                    <?PHP }else { ?>
                    	<td align="right"><?PHP echo $row_pedido['DIAS']; ?></td>
                    <?PHP } ?>
                </tr>
            <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
        </tbody>
    </table>
    </div>
        <div class="salto"></div>

</body>
</html>
