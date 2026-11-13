<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP include_once('../Funciones/funciones.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$inicio= $_REQUEST['INICIO'];
//$fin= $_REQUEST['FIN'];

$sql="SELECT v.ID_ARTICULO,
			 a.PRECIO_VENTA,
			 s.FECHA_SOLICITUD,
			 CASE WHEN a.ARTICULO IS NULL THEN 'TOTAL' ELSE a.ARTICULO END ARTICULO,
			 SUM(round(CANTIDAD,2)) CANTIDAD_TOTAL,
			 SUM(round(TOTAL,2)) TOTAL_BS
	FROM venta v JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
					 JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
	WHERE s.ID_TIPO_VENTA = 'CNT' AND s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$inicio 23:59:59'
	GROUP BY 1,3";
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
			 s.FECHA_SOLICITUD,
			 CASE WHEN a.ARTICULO IS NULL THEN 'TOTAL' ELSE a.ARTICULO END ARTICULO,
			 SUM(round(CANTIDAD,2)) CANTIDAD_TOTAL,
			 SUM(round(TOTAL,2)) TOTAL_BS
	FROM vale v JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
				JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
	WHERE s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$inicio 23:59:59'
	GROUP BY 1,2,3";
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
    .f {
        font-family: Verdana, Geneva, sans-serif;
        font-size: 14px;
    }

    .fuente {
        font-family: Verdana, Geneva, sans-serif;
    }

    .fuente {
        font-family: Verdana, Geneva, sans-serif;
    }

    .fuente {
        font-family: Verdana, Geneva, sans-serif;
        font-size: 6px;
    }
    </style>
    <script src="../jqgrid/js/i18n/grid.locale-es.js"></script>
    <script src="../jqgrid/js/jquery.jqGrid.min.js"></script>

    <!-- JQUERY TABLA -->
    <script src="../js/jquery.ui.tinytbl.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('.ui-tinytable').tinytbl({
            direction: 'ltr', // text-direction (default: 'ltr')
            thead: true, // fixed table thead
            tfoot: true, // fixed table tfoot
            cols: 1, // fixed number of columns
            width: 'auto', // table width (default: 'auto')
            height: 'auto' // table height (default: 'auto')
        });
    });
    </script>

    <script>
    function ConfirmarBorrar() {
        var agree = confirm("Está seguro de eliminar este registro? Este proceso es irreversible.");
        if (agree)
            return true;
        else
            return false;
    }
    </script>

    <title>IMPRESION</title>
</head>

<body>
    <!--<p>&nbsp;</p>-->
    <!--<center>-->
    <table border="0" class="fuente">
        <tr>
            <td>
                <table width="450" border="0">
                    <tr>
                        <td width="30%"><img src="../Iconos/logo_cabecera.jpg" width="160" height="48" alt="CJCompuNet" />
                        </td>
                        <td width="40%" align="center" class="fuente"><strong>REPORTE DIARIO DE VENTA</strong></td>
                        <td width="30%"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <strong>FECHA: </strong>
                <?PHP echo fecha_dma($inicio); ?>

                <table border="1" cellpadding="1" cellspacing="0" class="ui-tinytbl ui-corner-all">
                    <thead class="ui-widget-header ui-corner-all">
                        <tr>
                            <th></th>
                            <th><strong>CANTIDAD</strong></th>
                            <th><strong>DETALLE</strong></th>
                            <th><strong>P.U.</strong></th>
                            <th><strong>SUB-TOTAL Bs.</strong></th>
                            <th><strong>TOTAL Bs.</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>VENTA DIRECTA</strong></td>
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
            <td><strong>VENTA POR QR</strong></td>
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
            <td colspan="5" align="center"><strong>TOTAL VENTAS DEL DIA</strong></td>
            <td align="right">
                <strong>
                    <?PHP echo $row_suma['SUMA'] + $row_sumaqr['SUMA'] ?>
                </strong>
            </td>
        </tr>
        </tbody>
    </table>
    </td>
    </tr>
    <tr>
        <td align="center" class="fuente">
            <p>CJCompuNet, Cochabamba - Bolivia
                <?PHP date_default_timezone_set('America/La_Paz'); 
                                echo date('Y');?>. Todos los Derechos Resevervados
            </p>
        </td>
    </tr>
    </table>
    <!--</center>-->
</body>

</html>