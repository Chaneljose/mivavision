<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Funciones/Funciones.php');
require_once('../Definiciones/Titulo.php'); 
//session_start(); 
$var_tipo = $_SESSION['SES_TIPO']; 
$var_active = "reportes";

mysqli_select_db($cnx_compras, $database_cnx_compras);

$inicio = "";

if(isset($_REQUEST['INICIO'])){
    $inicio = fecha_amd($_REQUEST['INICIO']);
}

$sql="SELECT v.ID_ARTICULO,
			 a.PRECIO_VENTA,
			 s.FECHA_SOLICITUD,
			 CASE WHEN a.NOMBRE_BUSQUEDA IS NULL THEN 'TOTAL' ELSE a.NOMBRE_BUSQUEDA END ARTICULO,
			 SUM(round(CANTIDAD,2)) CANTIDAD_TOTAL,
			 SUM(round(TOTAL,2)) TOTAL_BS
	FROM venta v JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
					 JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
	WHERE s.ID_TIPO_VENTA = 'CNT' AND s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$inicio 23:59:59'
	GROUP BY 1,3";
    //echo $sql;
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

$sql2="SELECT SUM(round(TOTAL,2)) SUMA
		FROM venta v JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
						 JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE s.ID_TIPO_VENTA = 'CNT' AND s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$inicio 23:59:59'";
$suma= mysqli_query($cnx_compras, $sql2) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_suma = mysqli_fetch_assoc($suma);
$num_suma = mysqli_num_rows($suma);

/* Ventas por QR*/ 
$sqlqr="SELECT v.ID_ARTICULO,
			 a.PRECIO_VENTA,
			 s.FECHA_SOLICITUD,
			 CASE WHEN a.NOMBRE_BUSQUEDA IS NULL THEN 'TOTAL' ELSE a.NOMBRE_BUSQUEDA END ARTICULO,
			 SUM(round(CANTIDAD,2)) CANTIDAD_TOTAL,
			 SUM(round(TOTAL,2)) TOTAL_BS
	FROM venta v JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
					 JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
	WHERE s.ID_TIPO_VENTA = 'QR' AND s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$inicio 23:59:59'
	GROUP BY 1,3";
    //echo $sqlqr;
$pedidoqr = mysqli_query($cnx_compras, $sqlqr) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedidoqr = mysqli_fetch_assoc($pedidoqr);
$num_pedidoqr = mysqli_num_rows($pedidoqr); 

$sql2qr="SELECT SUM(round(TOTAL,2)) SUMA
		FROM venta v JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
						 JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE s.ID_TIPO_VENTA = 'QR' AND s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$inicio 23:59:59'";
$sumaqr= mysqli_query($cnx_compras, $sql2qr) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_sumaqr = mysqli_fetch_assoc($sumaqr);
$num_sumaqr = mysqli_num_rows($sumaqr);
/* Fin ventas QR */

$sql3="SELECT v.ID_ARTICULO,
			 a.PRECIO_VENTA,
			 s.FECHA_SOLICITUD,
			 CASE WHEN a.ARTICULO IS NULL THEN 'TOTAL' ELSE a.ARTICULO END ARTICULO,
			 SUM(round(CANTIDAD,2)) CANTIDAD_TOTAL,
			 SUM(round(TOTAL,2)) TOTAL_BS
	FROM venta_credito v JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
					 JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
	WHERE s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$inicio 23:59:59'
	GROUP BY 1,3";
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
             v.PRECIO_VENTA,
			 s.FECHA_SOLICITUD,
			 CASE WHEN a.ARTICULO IS NULL THEN 'TOTAL' ELSE a.ARTICULO END ARTICULO,
			 SUM(round(CANTIDAD,2)) CANTIDAD_TOTAL,
			 SUM(round(TOTAL,2)) TOTAL_BS
	FROM vale v JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
				JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
	WHERE s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$inicio 23:59:59'
	GROUP BY 1,2,3,4";
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
		GROUP BY 1,2,3";
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
		GROUP BY 1,2,3";
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

<?PHP head1(reportes); ?>

<body>
    <?PHP include('../menu.php');
		  	  navbar(reportes, $var_tipo, $var_active);
			  require_once('../NavsideReportes.php');
		  	  navside(diario);?>

    <div class="container-fluid">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="sub-header">
                <?PHP echo diario; ?>
            </h2>
            <form class="form-horizontal" role="form" action="">
                <fieldset>
                    <div class="form-group">
                        <label for="INICIO" class="col-sm-3 control-label">FECHA</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control calendario" id="INICIO" name="INICIO"
                                placeholder="FECHA INICIO" />
                        </div>
                        <button class="btn btn-success" id="submit">BUSCAR</button>
                        <a id="impresion" class="btn btn-primary"
                            href="ReporteDiarioImpresion.php?INICIO=<?PHP echo $inicio; ?>">IMPRESION</a>
                    </div>

                </fieldset>
            </form>
            <hr />
            <h3 class="sub-header">REPORTE DIARIO DEL
                <?PHP echo fecha_dma($inicio); ?>
            </h3>
            <hr />
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered table-condensed">
                    <thead>
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
                            <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                <td></td>
                                <td>
                                    <?PHP if(isset($row_pedido['CANTIDAD_TOTAL'])){echo $row_pedido['CANTIDAD_TOTAL'];} ?>
                                </td>
                                <td>
                                    <?PHP if(isset($row_pedido['ARTICULO'])){echo $row_pedido['ARTICULO'];} ?>
                                </td>
                                <td align="right">
                                    <?PHP if(isset($row_pedido['PRECIO_VENTA'])){echo $row_pedido['PRECIO_VENTA'];} ?>
                                </td>
                                <td align="right">
                                    <?PHP if(isset($row_pedido['TOTAL_BS'])){echo $row_pedido['TOTAL_BS'];} ?>
                                </td>
                            </tr>
                            <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)); 
                            if(isset($row_sumaqr['SUMA']))
                            {
                            ?>
                            <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                <td colspan="5" align="center"><strong>TOTAL VENTA DIRECTA</strong></td>
                                <td align="right"><strong>
                                        <?PHP echo $row_suma['SUMA'] ?>
                                    </strong></td>
                            </tr>
                            <?php 
                            }
                            ?>
                        </tr>
                        <?php 
                            if(isset($row_sumaqr['SUMA']))
                            {
                        ?>
                        <tr>
                            <td>VENTA QR</td>
                            <?PHP
							do{
                            ?>
                            <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                <td></td>
                                <td>
                                    <?PHP echo $row_pedidoqr['CANTIDAD_TOTAL']; ?>
                                </td>
                                <td>
                                    <?PHP echo $row_pedidoqr['ARTICULO']; ?>
                                </td>
                                <td align="right">
                                    <?PHP echo $row_pedidoqr['PRECIO_VENTA']; ?>
                                </td>
                                <td align="right">
                                    <?PHP echo $row_pedidoqr['TOTAL_BS']; ?>
                                </td>
                            </tr>
                            <?PHP } while($row_pedidoqr = mysqli_fetch_assoc($pedidoqr)) ?>
                            <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                <td colspan="5" align="center"><strong>TOTAL VENTA QR</strong></td>
                                <td align="right"><strong>
                                        <?PHP echo $row_sumaqr['SUMA'] ?>
                                    </strong></td>
                            </tr>
                        </tr>
                        <?php 
                        }
                        ?>
                        <tr>
                            <td colspan="5" align="center">
                                <h2><strong>TOTAL VENTAS DEL DIA</strong></h2>
                            </td>
                            <td align="right">
                                <h2><strong>
                                        <?PHP echo $row_suma['SUMA'] + $row_sumaqr['SUMA'] ?>
                                    </strong></h2>
                            </td>
                        </tr>
                        <!--<tr>
                            <td>VENTA CREDITO</td>
                            <?PHP
							//do{
                            ?>
                            <tr class="<?//=($c++%2==1) ? 'impar' : 'par' ?>">
                                <td></td>
                                <td>
                                    <?PHP //echo $row_credito['CANTIDAD_TOTAL']; ?>
                                </td>
                                <td>
                                    <?PHP //echo $row_credito['ARTICULO']; ?>
                                </td>
                                <td align="right">
                                    <?PHP //echo $row_credito['PRECIO_VENTA']; ?>
                                </td>
                                <td align="right">
                                    <?PHP //echo $row_credito['TOTAL_BS']; ?>
                                </td>
                            </tr>
                            <?PHP //} while($row_credito = mysqli_fetch_assoc($credito)) ?>
                            <tr class="<?//=($c++%2==1) ? 'impar' : 'par' ?>">
                                <td colspan="5" align="center"><strong>TOTAL VENTA CREDITO</strong></td>
                                <td align="right"><strong>
                                        <?PHP //echo $row_suma_credito	['SUMA'] ?>
                                    </strong></td>
                            </tr>
                        </tr>

                        <tr>
                            <td>BAJA DE PRODUCTO</td>
                            <?PHP
                                //do{
                            ?>
                            <tr class="<?//=($c++%2==1) ? 'impar' : 'par' ?>">
                                <td></td>
                                <td>
                                    <?PHP //echo $row_baja['CANTIDAD_TOTAL']; ?>
                                </td>
                                <td>
                                    <?PHP //echo $row_baja['ARTICULO']; ?>
                                </td>
                                <td align="right">
                                    <?PHP //echo $row_baja['PRECIO_COMPRA']; ?>
                                </td>
                                <td align="right">
                                    <?PHP //echo $row_baja['TOTAL_BS']; ?>
                                </td>
                            </tr>
                            <?PHP //} while($row_baja = mysqli_fetch_assoc($baja)) ?>
                            <tr class="<?//=($c++%2==1) ? 'impar' : 'par' ?>">
                                <td colspan="5" align="center"><strong>TOTAL BAJA DE PRODUCTO</strong></td>
                                <td align="right"><strong>
                                        <?PHP //echo $row_suma_baja['SUMA'] ?>
                                    </strong></td>
                            </tr>
                        </tr>

                        <tr>
                            <td>DEVOLUCION DE PRODUCTOS</td>
                            <?PHP
                                //do{
                            ?>
                            <tr class="<?//=($c++%2==1) ? 'impar' : 'par' ?>">
                                <td></td>
                                <td>
                                    <?PHP //echo $row_dev['CANTIDAD_TOTAL']; ?>
                                </td>
                                <td>
                                    <?PHP //echo $row_dev['ARTICULO']; ?>
                                </td>
                                <td align="right">
                                    <?PHP //echo $row_dev['PRECIO_COMPRA']; ?>
                                </td>
                                <td align="right">
                                    <?PHP //echo $row_dev['TOTAL_BS']; ?>
                                </td>
                            </tr>
                            <?PHP //} while($row_dev = mysqli_fetch_assoc($dev)) ?>
                            <tr class="<?//=($c++%2==1) ? 'impar' : 'par' ?>">
                                <td colspan="5" align="center"><strong>TOTAL DEVOLUCION DE PRODUCTOS</strong></td>
                                <td align="right"><strong>
                                        <?PHP //echo $row_suma_dev['SUMA'] ?>
                                    </strong></td>
                            </tr>
                        </tr>-->

                    </tbody>
                </table>
            </div>



        </div>
    </div>


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
                    //do{
                ?>
                    <tr  class="<?//=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td><?PHP //echo $row_pedido['CANTIDAD_TOTAL']; ?></td>
                        <td><?PHP //echo $row_pedido['ARTICULO']; ?></td>
                        <td align="right"><?PHP //echo $row_pedido['PRECIO_VENTA']; ?></td>
                        <td align="right"><?PHP //echo $row_pedido['TOTAL_BS']; ?></td>
                    </tr>
                <?PHP //} while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
                    <tr class="<?//=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                        <td align="right"><strong><?PHP //echo $row_suma['SUMA'] ?></strong></td>
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
                    //do{
                ?>
                    <tr  class="<?//=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td><?PHP //echo $row_credito['CANTIDAD_TOTAL']; ?></td>
                        <td><?PHP //echo $row_credito['ARTICULO']; ?></td>
                        <td align="right"><?PHP //echo $row_credito['PRECIO_VENTA']; ?></td>
                        <td align="right"><?PHP //echo $row_credito['TOTAL_BS']; ?></td>
                    </tr>
                <?PHP //} while($row_credito = mysqli_fetch_assoc($credito)) ?>
                    <tr class="<?//=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                        <td align="right"><strong><?PHP //echo $row_suma_credito	['SUMA'] ?></strong></td>
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
                    //do{
                ?>
                    <tr  class="<?//=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td><?PHP //echo $row_vales['CANTIDAD_TOTAL']; ?></td>
                        <td><?PHP //echo $row_vales['ARTICULO']; ?></td>
                        <td align="right"><?PHP //echo $row_vales['PRECIO_VENTA']; ?></td>
                        <td align="right"><?PHP //echo $row_vales['TOTAL_BS']; ?></td>
                    </tr>
                <?PHP //} while($row_vales = mysqli_fetch_assoc($vales)) ?>
                    <tr class="<?//=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                        <td align="right"><strong><?PHP //echo $row_suma_vales	['SUMA'] ?></strong></td>
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
                    //do{
                ?>
                    <tr  class="<?//=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td><?PHP //echo $row_baja['CANTIDAD_TOTAL']; ?></td>
                        <td><?PHP //echo $row_baja['ARTICULO']; ?></td>
                        <td align="right"><?PHP //echo $row_baja['PRECIO_VENTA']; ?></td>
                        <td align="right"><?PHP //echo $row_baja['TOTAL_BS']; ?></td>
                    </tr>
                <?PHP //} while($row_baja = mysqli_fetch_assoc($baja)) ?>
                    <tr class="<?//=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                        <td align="right"><strong><?PHP //echo $row_suma_baja['SUMA'] ?></strong></td>
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
                    //do{
                ?>
                    <tr  class="<?//=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td><?PHP //echo $row_dev['CANTIDAD_TOTAL']; ?></td>
                        <td><?PHP //echo $row_dev['ARTICULO']; ?></td>
                        <td align="right"><?PHP //echo $row_dev['PRECIO_VENTA']; ?></td>
                        <td align="right"><?PHP //echo $row_dev['TOTAL_BS']; ?></td>
                    </tr>
                <?PHP //} while($row_dev = mysqli_fetch_assoc($dev)) ?>
                    <tr class="<?//=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td colspan="3" align="center"><strong>TOTAL</strong></td>
                        <td align="right"><strong><?PHP //echo $row_suma_dev['SUMA'] ?></strong></td>
                    </tr>
            </tbody>
        </table>
	</section>-->

</body>

</html>