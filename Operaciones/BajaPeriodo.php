<?PHP require_once('../cnx/cnx_compras.php');
	  include_once('../Funciones/funciones.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['BUSCAR'];

$sql2 = "SELECT v.ID_ARTICULO,
				 CASE WHEN a.ARTICULO IS NULL THEN 'TOTAL' ELSE a.ARTICULO END ARTICULO,
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'JAN') THEN round(CANTIDAD,2) END) 'ENERO CANTIDAD',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'JAN') THEN round(TOTAL,2) END) 'ENERO TOTAL',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'FEB') THEN round(CANTIDAD,2) END) 'FEBRERO CANTIDAD',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'FEB') THEN round(TOTAL,2) END) 'FEBRERO TOTAL',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'MAR') THEN round(CANTIDAD,2) END) 'MARZO CANTIDAD',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'MAR') THEN round(TOTAL,2) END) 'MARZO TOTAL',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'APR') THEN round(CANTIDAD,2) END) 'ABRIL CANTIDAD',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'APR') THEN round(TOTAL,2) END) 'ABRIL TOTAL',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'MAY') THEN round(CANTIDAD,2) END) 'MAYO CANTIDAD',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'MAY') THEN round(TOTAL,2) END) 'MAYO TOTAL',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'JUN') THEN round(CANTIDAD,2) END) 'JUNIO CANTIDAD',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'JUN') THEN round(TOTAL,2) END) 'JUNIO TOTAL',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'JUL') THEN round(CANTIDAD,2) END) 'JULIO CANTIDAD',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'JUL') THEN round(TOTAL,2) END) 'JULIO TOTAL',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'AUG') THEN round(CANTIDAD,2) END) 'AGOSTO CANTIDAD',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'AUG') THEN round(TOTAL,2) END) 'AGOSTO TOTAL',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'SEP') THEN round(CANTIDAD,2) END) 'SEPTIEMBRE CANTIDAD',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'SEP') THEN round(TOTAL,2) END) 'SEPTIEMBRE TOTAL',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'OCT') THEN round(CANTIDAD,2) END) 'OCTUBRE CANTIDAD',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'OCT') THEN round(TOTAL,2) END) 'OCTUBRE TOTAL',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'NOV') THEN round(CANTIDAD,2) END) 'NOVIEMBRE CANTIDAD',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'NOV') THEN round(TOTAL,2) END) 'NOVIEMBRE TOTAL',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'DEC') THEN round(CANTIDAD,2) END) 'DICIEMBRE CANTIDAD',
				 SUM(CASE WHEN (DATE_FORMAT(s.FECHA_SOLICITUD,'%b') = 'DEC') THEN round(TOTAL,2) END) 'DICIEMBRE TOTAL',
				 SUM(round(CANTIDAD,2)) CANTIDAD_TOTAL,
				 SUM(round(TOTAL,2)) TOTAL_BS
		FROM venta v JOIN solicitud_salida s ON v.ID_SOLICITUD_SALIDA = s.ID_SOLICITUD_SALIDA
						 JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
		GROUP BY a.ARTICULO with rollup";
$solicitud = mysqli_query($cnx_compras, $sql2) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_solicitud = mysqli_fetch_assoc($solicitud);
$num_solicitud = mysqli_num_rows($solicitud);

?>
<!doctype html>
<html lang="es">
<head>
	<title>SOLICITUD COMPRA</title>
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
<body class="ui-widget">
		<header class="ui-widget-header">
    		<h1>REPORTE DIARIO DE VENTA</h1>
        </header>
    			<?PHP include('../menu.php'); ?>
    <div>
    <table>
        <thead class="ui-widget-header ui-corner-all">
            <tr>
                <th rowspan="2">PRODUCTO</th>
                <th colspan="2">ENERO</th>
                <th colspan="2">FEBRERO</th>
                <th colspan="2">MARZO</th>
                <th colspan="2">ABRIL</th>
                <th colspan="2">MAYO</th>
                <th colspan="2">JUNIO</th>
                <th colspan="2">JULIO</th>
                <th colspan="2">AGOSTO</th>
                <th colspan="2">SEPTIEMBRE</th>
                <th colspan="2">OCTUBRE</th>
                <th colspan="2">NOVIEMBRE</th>
                <th colspan="2">DICIEMBRE</th>
                <th rowspan="2">CANTIDAD</th>
                <th rowspan="2">TOTAL [Bs.]</th>
            </tr> 
            <tr>
            	<th>CANTIDAD</th>
                <th>TOTAL</th>
            	<th>CANTIDAD</th>
                <th>TOTAL</th>
            	<th>CANTIDAD</th>
                <th>TOTAL</th>
            	<th>CANTIDAD</th>
                <th>TOTAL</th>
            	<th>CANTIDAD</th>
                <th>TOTAL</th>
            	<th>CANTIDAD</th>
                <th>TOTAL</th>
            	<th>CANTIDAD</th>
                <th>TOTAL</th>
            	<th>CANTIDAD</th>
                <th>TOTAL</th>
            	<th>CANTIDAD</th>
                <th>TOTAL</th>
            	<th>CANTIDAD</th>
                <th>TOTAL</th>
            	<th>CANTIDAD</th>
                <th>TOTAL</th>
            	<th>CANTIDAD</th>
                <th>TOTAL</th>
            </tr>     
        </thead>
        <tbody align="right">
            <?PHP
                do{
            ?>
                <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                    <td><?PHP echo $row_solicitud['ARTICULO']; ?></td>
                    <td><?PHP echo $row_solicitud['ENERO CANTIDAD']; ?></td>
                    <td><?PHP echo $row_solicitud['ENERO TOTAL']; ?></td>
                    <td><?PHP echo $row_solicitud['FEBRERO CANTIDAD']; ?></td>
                    <td><?PHP echo $row_solicitud['FEBRERO TOTAL']; ?></td>
                    <td><?PHP echo $row_solicitud['MARZO CANTIDAD']; ?></td>
                    <td><?PHP echo $row_solicitud['MARZO TOTAL']; ?></td>
                    <td><?PHP echo $row_solicitud['ABRIL CANTIDAD']; ?></td>
                    <td><?PHP echo $row_solicitud['ABRIL TOTAL']; ?></td>
                    <td><?PHP echo $row_solicitud['MAYO CANTIDAD']; ?></td>
                    <td><?PHP echo $row_solicitud['MAYO TOTAL']; ?></td>
                    <td><?PHP echo $row_solicitud['JUNIO CANTIDAD']; ?></td>
                    <td><?PHP echo $row_solicitud['JUNIO TOTAL']; ?></td>
                    <td><?PHP echo $row_solicitud['JULIO CANTIDAD']; ?></td>
                    <td><?PHP echo $row_solicitud['JULIO TOTAL']; ?></td>
                    <td><?PHP echo $row_solicitud['AGOSTO CANTIDAD']; ?></td>
                    <td><?PHP echo $row_solicitud['AGOSTO TOTAL']; ?></td>
                    <td><?PHP echo $row_solicitud['SEPTIEMBRE CANTIDAD']; ?></td>
                    <td><?PHP echo $row_solicitud['SEPTIEMBRE TOTAL']; ?></td>
                    <td><?PHP echo $row_solicitud['OCTUBRE CANTIDAD']; ?></td>
                    <td><?PHP echo $row_solicitud['OCTUBRE TOTAL']; ?></td>
                    <td><?PHP echo $row_solicitud['NOVIEMBRE CANTIDAD']; ?></td>
                    <td><?PHP echo $row_solicitud['NOVIEMBRE TOTAL']; ?></td>
                    <td><?PHP echo $row_solicitud['DICIEMBRE CANTIDAD']; ?></td>
                    <td><?PHP echo $row_solicitud['DICIEMBRE TOTAL']; ?></td>
                    <td><?PHP echo $row_solicitud['CANTIDAD_TOTAL']; ?></td>
                    <td><?PHP echo $row_solicitud['TOTAL_BS']; ?></td>
                </tr>
            <?PHP } while($row_solicitud = mysqli_fetch_assoc($solicitud)) ?>
        </tbody>
    </table>
    </div>
        <div class="salto"></div>

</body>
</html>