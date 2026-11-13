<?PHP require_once('../cnx/cnx_compras.php');
	  include_once('../Funciones/funciones.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$inicio = fecha_amd($_REQUEST['INICIO']);
//$fin = fecha_amd($_REQUEST['FIN']);

$sql="SELECT CASE WHEN MONTH(s.FECHA_SOLICITUD) = 1 THEN 'ENERO'
				   WHEN MONTH(s.FECHA_SOLICITUD) = 2 THEN 'FEBRERO'
				   WHEN MONTH(s.FECHA_SOLICITUD) = 3 THEN 'MARZO'
				   WHEN MONTH(s.FECHA_SOLICITUD) = 4 THEN 'ABRIL'
				   WHEN MONTH(s.FECHA_SOLICITUD) = 5 THEN 'MAYO'
				   WHEN MONTH(s.FECHA_SOLICITUD) = 6 THEN 'JUNIO'
				   WHEN MONTH(s.FECHA_SOLICITUD) = 7 THEN 'JULIO'
				   WHEN MONTH(s.FECHA_SOLICITUD) = 8 THEN 'AGOSTO'
				   WHEN MONTH(s.FECHA_SOLICITUD) = 9 THEN 'SEPTIEMBRE'
				   WHEN MONTH(s.FECHA_SOLICITUD) = 10 THEN 'OCTUBRE'
				   WHEN MONTH(s.FECHA_SOLICITUD) = 11 THEN 'NOVIEMBRE'
				   WHEN MONTH(s.FECHA_SOLICITUD) = 12 THEN 'DICIEMBRE' END MES,
					MONTH(s.FECHA_SOLICITUD),
			SUM(round(TOTAL,2)) TOTAL_BS
			FROM venta v JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
							JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
			GROUP BY 1
			ORDER BY 2";
$pedido = mysqli_query($cnx_compras,$sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

$sql2="SELECT SUM(round(TOTAL,2)) SUMA
		FROM venta v JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
						 JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$inicio 23:59:59'";
$suma= mysqli_query($cnx_compras, $sql2) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_suma = mysqli_fetch_assoc($suma);
$num_suma = mysqli_num_rows($suma);


$sql3="SELECT v.ID_ARTICULO,
			 a.PRECIO_VENTA,
			 s.FECHA_SOLICITUD,
			 CASE WHEN a.ARTICULO IS NULL THEN 'TOTAL' ELSE a.ARTICULO END ARTICULO,
			 SUM(round(CANTIDAD,2)) CANTIDAD_TOTAL,
			 SUM(round(TOTAL,2)) TOTAL_BS
	FROM venta_credito v JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
					 JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
	WHERE s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$inicio 23:59:59'
	GROUP BY a.ARTICULO";
$credito = mysqli_query($cnx_compras, $sql3) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_credito = mysqli_fetch_assoc($credito);
$num_credito = mysqli_num_rows($credito); 

$sql4="SELECT SUM(round(TOTAL,2)) SUMA
		FROM venta_credito v JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
						 JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$inicio 23:59:59'";
$suma_credito= mysqli_query($cnx_compras, $sql4) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_suma_credito = mysqli_fetch_assoc($suma_credito);
$num_suma_credito = mysqli_num_rows($suma_credito);


$sql5="SELECT v.ID_ARTICULO,
			 v.PRECIO_COMPRA,
			 s.FECHA_SOLICITUD,
			 CASE WHEN a.ARTICULO IS NULL THEN 'TOTAL' ELSE a.ARTICULO END ARTICULO,
			 SUM(round(CANTIDAD,2)) CANTIDAD_TOTAL,
			 SUM(round(TOTAL,2)) TOTAL_BS
	FROM vale v JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
				JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
	WHERE s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$inicio 23:59:59'
	GROUP BY a.ARTICULO";
$vales = mysqli_query($cnx_compras, $sql5) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_vales = mysqli_fetch_assoc($vales);
$num_vales = mysqli_num_rows($vales); 

$sql6="SELECT SUM(round(TOTAL,2)) SUMA
		FROM vale v JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
					JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$inicio 23:59:59'";
$suma_vales= mysqli_query($cnx_compras, $sql6) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_suma_vales = mysqli_fetch_assoc($suma_vales);
$num_suma_vales = mysqli_num_rows($suma_vales);


$sql7="SELECT v.ID_ARTICULO
		,		 v.PRECIO_COMPRA
		,		 v.FECHA_REGISTRO
		,      CASE WHEN a.ARTICULO IS NULL THEN 'TOTAL' ELSE a.ARTICULO END ARTICULO
		,		 SUM(round(CANTIDAD,2)) CANTIDAD_TOTAL
		,      SUM(round(TOTAL,2)) TOTAL_BS
		FROM baja v JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE v.FECHA_REGISTRO between '$inicio 00:00:00' and '$inicio 23:59:59'
		GROUP BY a.ARTICULO";
$baja = mysqli_query($cnx_compras, $sql7) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_baja = mysqli_fetch_assoc($baja);
$num_baja = mysqli_num_rows($baja); 

$sql8="SELECT SUM(round(TOTAL,2)) SUMA
		FROM baja v JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE v.FECHA_REGISTRO between '$inicio 00:00:00' and '$inicio 23:59:59'";
$suma_baja= mysqli_query($cnx_compras, $sql8) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_suma_baja = mysqli_fetch_assoc($suma_baja);
$num_suma_baja = mysqli_num_rows($suma_baja);


$sql9="SELECT v.ID_ARTICULO
		,		 v.PRECIO_COMPRA
		,		 v.FECHA_REGISTRO
		,      CASE WHEN a.ARTICULO IS NULL THEN 'TOTAL' ELSE a.ARTICULO END ARTICULO
		,		 SUM(round(CANTIDAD,2)) CANTIDAD_TOTAL
		,      SUM(round(TOTAL,2)) TOTAL_BS
		FROM devolucion v JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE v.FECHA_REGISTRO between '$inicio 00:00:00' and '$inicio 23:59:59'
		GROUP BY a.ARTICULO";
$dev = mysqli_query($cnx_compras, $sql9) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_dev = mysqli_fetch_assoc($dev);
$num_dev = mysqli_num_rows($dev); 

$sql10="SELECT SUM(round(TOTAL,2)) SUMA
		FROM devolucion v JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE v.FECHA_REGISTRO between '$inicio 00:00:00' and '$inicio 23:59:59'";
$suma_dev= mysqli_query($cnx_compras, $sql10) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_suma_dev = mysqli_fetch_assoc($suma_dev);
$num_suma_dev = mysqli_num_rows($suma_dev);

?>
<!doctype html>
<html lang="es">
<head>
	<title>REPORTE DIARIO</title>
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
        <section>
            <form action="">
                <fieldset>
                    <legend>Reporte Diario</legend>
                        <div  class="formulario ui-corner-all">
                            <label>FECHA</label><input type="text" name="INICIO" class="calendario"/><!--<input type="text" name="FIN" class="calendario" />-->
                            <input type="submit" name="BOTON" value="BUSCAR" />
                            <a id="impresion" href="ReporteDiarioImpresion.php?INICIO=<?PHP echo $inicio; ?>">Impresion</a>
                        </div>
                </fieldset>
            </form>
    	</section>
    <hr />
    <section>
    	<h2>REPORTE DIARIO DEL <?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y') //fecha_dma($row_pedido['FECHA_SOLICITUD']); ?></h2>
    </section>
    
    <section>
    	<table class="ui-tinytbl ui-corner-all">
        	<thead class="ui-widget-header ui-corner-all">
            	<th></th>
                <th>CANTIDAD</th>
                <th>DETALLE</th>
                <th>P.U.</th>
                <th>SUB-TOTAL Bs.</th>
                <th>TOTAL Bs.</th>
             </thead>
            <tbody>
            	<tr>
                		<td>VENTA DIRECTA</td>
						<?PHP
                            do{
                        ?>
                                <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                    <td></td>
                                    <td><?PHP echo $row_pedido['CANTIDAD_TOTAL']; ?></td>
                                    <td><?PHP echo $row_pedido['ARTICULO']; ?></td>
                                    <td align="right"><?PHP echo $row_pedido['PRECIO_VENTA']; ?></td>
                                    <td align="right"><?PHP echo $row_pedido['TOTAL_BS']; ?></td>
                                </tr>
                        <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
                                <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                    <td colspan="5" align="center"><strong>TOTAL VENTA DIRECTA</strong></td>
                                    <td align="right"><strong><?PHP echo $row_suma['SUMA'] ?></strong></td>
                                </tr>
                </tr>
                
                <tr>
               			<td>VENTA CREDITO</td>
                         <?PHP
							do{
						?>
							<tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                            	<td></td>
								<td><?PHP echo $row_credito['CANTIDAD_TOTAL']; ?></td>
								<td><?PHP echo $row_credito['ARTICULO']; ?></td>
								<td align="right"><?PHP echo $row_credito['PRECIO_VENTA']; ?></td>
								<td align="right"><?PHP echo $row_credito['TOTAL_BS']; ?></td>
							</tr>
						<?PHP } while($row_credito = mysqli_fetch_assoc($credito)) ?>
							<tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
								<td colspan="5" align="center"><strong>TOTAL VENTA CREDITO</strong></td>
                        <td align="right"><strong><?PHP echo $row_suma_credito	['SUMA'] ?></strong></td>
                    </tr>
                </tr>
                
                <tr>
                		<td>CONSUMO APL</td>
                        <?PHP
							do{
						?>
							<tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                            	<td></td>
								<td><?PHP echo $row_vales['CANTIDAD_TOTAL']; ?></td>
								<td><?PHP echo $row_vales['ARTICULO']; ?></td>
								<td align="right"><?PHP echo $row_vales['PRECIO_COMPRA']; ?></td>
								<td align="right"><?PHP echo $row_vales['TOTAL_BS']; ?></td>
							</tr>
						<?PHP } while($row_vales = mysqli_fetch_assoc($vales)) ?>
							<tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
								<td colspan="5" align="center"><strong>TOTAL CONSUMO APL</strong></td>
								<td align="right"><strong><?PHP echo $row_suma_vales	['SUMA'] ?></strong></td>
							</tr>
                </tr>
                
                <tr>
                		<td>BAJA DE PRODUCTO</td>
                         <?PHP
							do{
						?>
							<tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                            	<td></td>
								<td><?PHP echo $row_baja['CANTIDAD_TOTAL']; ?></td>
								<td><?PHP echo $row_baja['ARTICULO']; ?></td>
								<td align="right"><?PHP echo $row_baja['PRECIO_COMPRA']; ?></td>
								<td align="right"><?PHP echo $row_baja['TOTAL_BS']; ?></td>
							</tr>
						<?PHP } while($row_baja = mysqli_fetch_assoc($baja)) ?>
							<tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
								<td colspan="5" align="center"><strong>TOTAL BAJA DE PRODUCTO</strong></td>
								<td align="right"><strong><?PHP echo $row_suma_baja['SUMA'] ?></strong></td>
							</tr>
                </tr>
                
                <tr>
                		<td>DEVOLUCION DE PRODUCTOS</td>
                        <?PHP
							do{
						?>
							<tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                            	<td></td>
								<td><?PHP echo $row_dev['CANTIDAD_TOTAL']; ?></td>
								<td><?PHP echo $row_dev['ARTICULO']; ?></td>
								<td align="right"><?PHP echo $row_dev['PRECIO_COMPRA']; ?></td>
								<td align="right"><?PHP echo $row_dev['TOTAL_BS']; ?></td>
							</tr>
						<?PHP } while($row_dev = mysqli_fetch_assoc($dev)) ?>
							<tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
								<td colspan="5" align="center"><strong>TOTAL DEVOLUCION DE PRODUCTOS</strong></td>
								<td align="right"><strong><?PHP echo $row_suma_dev['SUMA'] ?></strong></td>
							</tr>
                </tr>
                
            </tbody>
        </table>
    </section>
    
    
<!--    <section>
    	<h2>VENTA DIRECTA</h2>
        <table class="ui-tinytbl ui-corner-all">
            <thead class="ui-widget-header ui-corner-all">
                <tr>
                    <th>CANTIDAD</th>
                    <th>DETALLE</th>
                    <th>P.U.</th>
                    <th>TOTAL Bs.</th>
                </tr>  
            </thead>
            <tbody>
                <?PHP
                    do{
                ?>
                    <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td><?PHP echo $row_pedido['CANTIDAD_TOTAL']; ?></td>
                        <td><?PHP echo $row_pedido['ARTICULO']; ?></td>
                        <td align="right"><?PHP echo $row_pedido['PRECIO_VENTA']; ?></td>
                        <td align="right"><?PHP echo $row_pedido['TOTAL_BS']; ?></td>
                    </tr>
                <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
                    <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                        <td align="right"><strong><?PHP echo $row_suma['SUMA'] ?></strong></td>
                    </tr>
            </tbody>
        </table>
	</section>-->
    
    <!-- VENTAS CREDITO -->
       <!-- <section>
        <h2>VENTA CREDITO</h2>
        <table class="ui-tinytbl ui-corner-all">
            <thead class="ui-widget-header ui-corner-all">
                <tr>
                    <th>CANTIDAD</th>
                    <th>DETALLE</th>
                    <th>P.U.</th>
                    <th>TOTAL Bs.</th>
                </tr>  
            </thead>
            <tbody>
                <?PHP
                    do{
                ?>
                    <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td><?PHP echo $row_credito['CANTIDAD_TOTAL']; ?></td>
                        <td><?PHP echo $row_credito['ARTICULO']; ?></td>
                        <td align="right"><?PHP echo $row_credito['PRECIO_VENTA']; ?></td>
                        <td align="right"><?PHP echo $row_credito['TOTAL_BS']; ?></td>
                    </tr>
                <?PHP } while($row_credito = mysqli_fetch_assoc($credito)) ?>
                    <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                        <td align="right"><strong><?PHP echo $row_suma_credito	['SUMA'] ?></strong></td>
                    </tr>
            </tbody>
        </table>
	</section>-->
    
    <!-- VALES -->
        <!--<section>
        <h2>CONSUMO APL</h2>
        <table class="ui-tinytbl ui-corner-all">
            <thead class="ui-widget-header ui-corner-all">
                <tr>
                    <th>CANTIDAD</th>
                    <th>DETALLE</th>
                    <th>P.U.</th>
                    <th>TOTAL Bs.</th>
                </tr>  
            </thead>
            <tbody>
                <?PHP
                    do{
                ?>
                    <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td><?PHP echo $row_vales['CANTIDAD_TOTAL']; ?></td>
                        <td><?PHP echo $row_vales['ARTICULO']; ?></td>
                        <td align="right"><?PHP echo $row_vales['PRECIO_VENTA']; ?></td>
                        <td align="right"><?PHP echo $row_vales['TOTAL_BS']; ?></td>
                    </tr>
                <?PHP } while($row_vales = mysqli_fetch_assoc($vales)) ?>
                    <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                        <td align="right"><strong><?PHP echo $row_suma_vales	['SUMA'] ?></strong></td>
                    </tr>
            </tbody>
        </table>
	</section>-->
    
    <!-- BAJAS -->
       <!-- <section>
        <h2>BAJA DE PRODUCTO</h2>
        <table class="ui-tinytbl ui-corner-all">
            <thead class="ui-widget-header ui-corner-all">
                <tr>
                    <th>CANTIDAD</th>
                    <th>DETALLE</th>
                    <th>P.U.</th>
                    <th>TOTAL Bs.</th>
                </tr>  
            </thead>
            <tbody>
                <?PHP
                    do{
                ?>
                    <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td><?PHP echo $row_baja['CANTIDAD_TOTAL']; ?></td>
                        <td><?PHP echo $row_baja['ARTICULO']; ?></td>
                        <td align="right"><?PHP echo $row_baja['PRECIO_VENTA']; ?></td>
                        <td align="right"><?PHP echo $row_baja['TOTAL_BS']; ?></td>
                    </tr>
                <?PHP } while($row_baja = mysqli_fetch_assoc($baja)) ?>
                    <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                        <td align="right"><strong><?PHP echo $row_suma_baja['SUMA'] ?></strong></td>
                    </tr>
            </tbody>
        </table>
	</section>-->
    
     <!-- BAJAS -->
        <!--<section>
        <h2>DEVOLUCION DE PRODUCTOS</h2>
        <table class="ui-tinytbl ui-corner-all">
            <thead class="ui-widget-header ui-corner-all">
                <tr>
                    <th>CANTIDAD</th>
                    <th>DETALLE</th>
                    <th>P.U.</th>
                    <th>TOTAL Bs.</th>
                </tr>  
            </thead>
            <tbody>
                <?PHP
                    do{
                ?>
                    <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td><?PHP echo $row_dev['CANTIDAD_TOTAL']; ?></td>
                        <td><?PHP echo $row_dev['ARTICULO']; ?></td>
                        <td align="right"><?PHP echo $row_dev['PRECIO_VENTA']; ?></td>
                        <td align="right"><?PHP echo $row_dev['TOTAL_BS']; ?></td>
                    </tr>
                <?PHP } while($row_dev = mysqli_fetch_assoc($dev)) ?>
                    <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                        <td align="right"><strong><?PHP echo $row_suma_dev['SUMA'] ?></strong></td>
                    </tr>
            </tbody>
        </table>
	</section>-->
    
</body>
</html>