<?PHP require_once('../cnx/cnx_compras.php');
    require_once('../Funciones/Cabecera.php');
    require_once('../Funciones/Funciones.php');
    require_once('../Definiciones/Titulo.php');
      
//session_start();
$var_tipo = $_SESSION['SES_TIPO'];
$var_active = "operaciones";
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['BUSCAR'];

$sql2 = "SELECT v.ID_DEVOLUCION,
				 v.ID_SOLICITUD_DEV,
				 s.NRO_NOTA,
		 		 DATE_FORMAT(s.FECHA_SOLICITUD, '%d-%m-%Y %H:%i:%s') FECHA_SOLICITUD,
				 v.ID_ALMACEN,
				 v.ID_COMPRA,
				 v.ID_ARTICULO,
				 a.ARTICULO,
				 a.PRECIO_COMPRA,
				 v.CANTIDAD,
				 v.TOTAL,
				 s.ID_TIPO_VENTA,
		 		 t.TIPO,
				 v.OBS
		FROM DEVOLUCION v JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
				     JOIN solicitud_dev s ON v.ID_SOLICITUD_DEV = s.ID_SOLICITUD_DEV
				     JOIN tipo_venta t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
		WHERE s.ID_SOLICITUD_DEV = '$codigo'
		ORDER BY 1 DESC LIMIT 1";
$solicitud = mysqli_query($cnx_compras, $sql2) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_solicitud = mysqli_fetch_assoc($solicitud);
$num_solicitud = mysqli_num_rows($solicitud);

$id_solicitud_salida = 0;
if(isset($row_solicitud['ID_SOLICITUD_DEV'])){
    $id_solicitud_salida = $row_solicitud['ID_SOLICITUD_DEV'];
}

$sql="SELECT v.ID_SOLICITUD_DEV,
			 v.ID_ARTICULO,
			 r.ARTICULO,
			 r.ID_UNIDAD,
			 r.DESCRIPCION,
			 v.PRECIO_COMPRA,
			 v.CANTIDAD,
			 v.TOTAL,
			 v.OBS
	FROM devolucion v  join articulo r on v.ID_ARTICULO = r.ID_ARTICULO 
	WHERE v.ID_SOLICITUD_DEV = '$id_solicitud_salida'";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

$sql3="SELECT SUM(v.TOTAL) SUMA
	   FROM devolucion v  join articulo r on v.ID_ARTICULO = r.ID_ARTICULO 
	   WHERE v.ID_SOLICITUD_DEV = '$id_solicitud_salida'";
$total = mysqli_query($cnx_compras, $sql3) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_total = mysqli_fetch_assoc($total);
$num_total = mysqli_num_rows($total); 


?>
<!doctype html>
<html lang="es">
<?PHP head1(operaciones); ?>
<body  class="ui-widget">
    <?PHP 
    //include('../menu.php'); 
    require_once('../menu.php');
    navbar(operaciones, $var_tipo, $var_active);
    require_once('../NavsideOperacion.php');
    navside(devolucion);
    ?>
    <div class="container-fluid">
	    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h2 class="sub-header">DEVOLUCIONES</h2>
            <section>
                <form action="" >
                <div><label>SOLICITUD</label><input type="text" name="BUSCAR"/><input type="submit" name="BOTON" value="BUSCAR" /><a id="impresion" href="DevImpreso.php?BUSCAR=<?PHP echo $codigo; ?>">Impresion</a></div>
                </form>
            </section>    
            <hr />
            <section>
                <div><label>NRO NOTA: </label><?PHP if(isset($row_solicitud['NRO_NOTA'])){echo $row_solicitud['NRO_NOTA'];} ?></div>
                <div><label>FECHA: </label><?PHP if(isset($row_solicitud['FECHA_SOLICITUD'])){echo $row_solicitud['FECHA_SOLICITUD'];} ?></div>
                <div><label>FECHA: </label><?PHP if(isset($row_total['SUMA'])){echo $row_total['SUMA'];}  ?></div>
            </section>
        </div>
    <!--</div>-->
     <hr />
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <table class="ui-widget-header ui-corner-all">
            <thead>
                <tr>

                <th>CANT</th>
                <th>DETALLE</th>
                <th>PRECIO COMPRA</th>
                <th>TOTAL Bs.</th>
                <th>OBSERVACION</th>
                <th>EDITAR</th>
                <th>BORRAR</th>
                </tr>      
            </thead>
            <tbody>
                <?PHP
                    $cont =1;
                    do{
                ?>
                    <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                        <td><?PHP if(isset($row_pedido['CANTIDAD'])){echo $row_pedido['CANTIDAD'];} ?></td>
                        <td><?PHP if(isset($row_pedido['ARTICULO'])){echo $row_pedido['ARTICULO'];} ?></td>
                        <td align="right"><?PHP if(isset($row_pedido['PRECIO_COMPRA'])){echo $row_pedido['PRECIO_COMPRA'];} ?></td>
                        <td align="right"><?PHP if(isset($row_pedido['TOTAL'])){echo $row_pedido['TOTAL'];} ?></td>
                        <td align="right"><?PHP if(isset($row_pedido['OBS'])){echo $row_pedido['OBS'];} ?></td>

                        <td align="center">
                            <a href="ComprasActualizar.php?CODIGO=<?PHP if(isset($row_pedido['ID_SOLICITUD_DEV'])){echo $row_pedido['ID_SOLICITUD_DEV'];} ?>" >
                                <img title="EDITAR" src="../Iconos/EDITAR.ico" width="20" height="20" alt="EDITAR" />
                            </a>
                        </td>
                        <td align="center">
                            <a id="Borrar" href="ComprasDMLDelete.php?CODIGO=<?PHP if(isset($row_pedido['ID_SOLICITUD_DEV'])){echo $row_pedido['ID_SOLICITUD_DEV'];} ?>" onclick="return ConfirmarBorrar()">
                                <img title="BORRAR" src="../Iconos/BORRAR.ico" width="20" height="20" alt="BORRAR" />
                            </a>
                        </td>
                    </tr>
                <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>