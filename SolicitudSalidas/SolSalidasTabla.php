<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Funciones/Funciones.php');
	  require_once('../Definiciones/Titulo.php'); 
      //session_start(); 
      $var_tipo = $_SESSION['SES_TIPO'];
      $var_active = "ventas";
?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['BUSCAR'];
$inicio = "";
$fin = "";
if(isset($_REQUEST['INICIO'])){
    $inicio = $_REQUEST['INICIO'];
}
if(isset($_REQUEST['FIN'])){
    $fin = $_REQUEST['FIN'];
}

$sql2 = "SELECT v.ID_VENTA,
                 v.ID_SOLICITUD_VENTA,
                 s.NRO_NOTA,
                 DATE_FORMAT(s.FECHA_SOLICITUD, '%Y-%m-%d %H:%i:%s') FECHA_SOLICITUD,
                 v.ID_CLIENTE,
                 c.NOMBRE,
                 v.ID_ALMACEN,
                 v.ID_COMPRA,
                 v.ID_ARTICULO,
                 a.ARTICULO,
                 a.PRECIO_VENTA,
                 v.CANTIDAD,
                 v.TOTAL,
                 v.CI_TACHO_CLIENTE,
                 v.NOMBRE_CLIENTE,
                 s.ID_TIPO_VENTA,
                 t.TIPO
        FROM venta v JOIN cliente c ON v.ID_CLIENTE = c.TACHO
                     JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
                     JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
                     JOIN tipo_venta t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
        WHERE s.ID_SOLICITUD_VENTA = '$codigo'
		ORDER BY 1 DESC LIMIT 1";
        //echo 'CONSULTA: '.$sql2;
$solicitud = mysqli_query($cnx_compras, $sql2) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_solicitud = mysqli_fetch_assoc($solicitud);
$num_solicitud = mysqli_num_rows($solicitud);

$id_solicitud_salida = $row_solicitud['ID_SOLICITUD_VENTA'];

$sql="SELECT v.ID_SOLICITUD_VENTA,
			 v.ID_ARTICULO,
			 r.ARTICULO,
			 r.ID_UNIDAD,
			 r.DESCRIPCION,
			 v.PRECIO_VENTA,
			 v.CANTIDAD,
			 v.TOTAL
	FROM venta v  join articulo r on v.ID_ARTICULO = r.ID_ARTICULO 
	WHERE v.ID_SOLICITUD_VENTA = '$id_solicitud_salida'";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

$sql3="SELECT SUM(v.TOTAL) SUMA
	   FROM venta v  join articulo r on v.ID_ARTICULO = r.ID_ARTICULO 
	   WHERE v.ID_SOLICITUD_VENTA = '$id_solicitud_salida'";
$total = mysqli_query($cnx_compras, $sql3) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_total = mysqli_fetch_assoc($total);
$num_total = mysqli_num_rows($total); 
?>

<!doctype html>
<html lang="es">

<?PHP head1(salidas); ?>
<body>
<?PHP
    include('../menu.php');
			  require_once('../NavsideSalidas.php');
		  	  navbar(salidas, $var_tipo, $var_active);
		  	  navside(reportes_sal);?>
    <div class="container-fluid">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="sub-header">
                <?PHP echo salidas; ?>
            </h2>
            <div>
                <section>
                    <?php 
                        $inicio = fecha_dma($inicio);
                        $fin = fecha_dma($fin);
                    ?>
                    <a id="impresion" class="btn btn-success btn-sm"
                        onclick="imprimirReporteVenta('<?php echo $inicio;?>','<?php echo $fin;?>','<?php echo $row_solicitud['ID_SOLICITUD_VENTA'];?>')">IMPRESION</a>
                    <h4>NRO NOTA:
                        <?PHP echo $row_solicitud['NRO_NOTA'] ; ?>
                    </h4>
                    <h4>TIPO VENTA:
                        <?PHP echo $row_solicitud['TIPO']; ?>
                    </h4>
                    <h4>FECHA:
                        <?PHP echo $row_solicitud['FECHA_SOLICITUD'];?>
                    </h4>
                </section>

                <section>
                    <table WIDTH="100%" border="1">
                        <thead >
                            <tr>
                                <th style="text-align: center" WIDTH="10%">CANTIDAD</th>
                                <th style="text-align: center" WIDTH="60%">DETALLE</th>
                                <th style="text-align: center" WIDTH="10%">P.U.</th>
                                <th style="text-align: center" WIDTH="10%">TOTAL Bs.</th>
                                <?php
                                if($var_tipo == 1){
                                    echo "<th style='text-align: center' WIDTH='10%'>EDITAR</th>";
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?PHP
                                    do{
                                ?>
                            <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                <td style="text-align: center">
                                    <?PHP echo $row_pedido['CANTIDAD']; ?>
                                </td>
                                <td>
                                    <?PHP echo ($row_pedido['ARTICULO']); ?>
                                </td>
                                <td style="text-align: center">
                                    <?PHP echo $row_pedido['PRECIO_VENTA']; ?>
                                </td>
                                <td align="right">
                                    <?PHP echo round($row_pedido['TOTAL'],2); ?>
                                </td>
                                <?php
                                $codigo_envio = "";
                                if($var_tipo == 1){
                                    $codigo_envio = $row_pedido['ID_ARTICULO'];
                                    $id_venta = $row_pedido['ID_SOLICITUD_VENTA'];
                                    echo "
                                    <td align='center'>
                                        <a data-toggle='modal' data-target='#UPDATE' href='SolSalidasActualizarVenta.php?CODIGO=".$codigo_envio."&BUSCAR=".$codigo."&INICIO=".$inicio."&FIN=".$fin."'>
                                            <img title='EDITAR' src='../Iconos/EDITAR.ico' width='20' height='20' alt='EDITAR' />
                                        </a>
                                    </td>";
                                }
                                ?>
                            </tr>
                            <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
                            <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                <td colspan="3" align="center"><strong>TOTAL</strong></td>
                                <td align="right"><strong>
                                        <?PHP echo round($row_total['SUMA'],2) ?>
                                    </strong></td>
                            </tr>
                        </tbody>
                    </table>
                </section>
            </div>
            <?php // MODAL UPDATE ?>
            <div class="modal fade" id="UPDATE" tabindex="-1" role="dialog" aria-labelledby="EDITAR" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <?PHP require_once('SolSalidasActualizarVenta.php');?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>