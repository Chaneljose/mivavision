<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Definiciones/Titulo.php');
//session_start(); 
$var_tipo = $_SESSION['SES_TIPO']; 
$var_active = "compras";
$sql="SELECT 	 ID_COMPRA
			,		 NRO_FACTURA
			,		 FECHA_FACTURA
			,		 CANTIDAD
			,		 PRECIO_FACTURA
			,		 UM_IMPUESTO
			,		 VALOR
			,		 ICE
			,        DESCUENTO
			,		 TOTAL
			,		 FECHA_CADUCIDAD
			,		 FECHA_REGISTRO
			,		 ID_ARTICULO
			FROM compra";
/*$compra = mysqli_query($cnx_compras, $sql, ) or die (mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_compra = mysqli_fetch_assoc($compra);
$num_compra = mysqli_num_rows($compra);*/
$query = $connect->prepare($sql);
$query->execute();
$compras = $query->fetchAll(PDO::FETCH_OBJ);
/*if($row_compra['ID_SOLICITUD_COMPRA'] == $buscar)
{
	echo "LA SOLICITUD ".$row_compra['ID_SOLICITUD_COMPRA']." YA EXISTE COMO REGISTRADA";
}
else
{	*/
	$sql1="SELECT 	 ID_COMPRA
			,		 NRO_FACTURA
			,		 FECHA_FACTURA
			,		 CANTIDAD
			,		 PRECIO_FACTURA
			,		 UM_IMPUESTO
			,		 VALOR
			,		 ICE
			,        DESCUENTO
			,		 TOTAL
			,		 FECHA_CADUCIDAD
			,		 FECHA_REGISTRO
			,		 ID_ARTICULO
			FROM compra";
	$pedido = mysqli_query($cnx_compras, $sql1) or die (mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
	$row_pedido = mysqli_fetch_assoc($pedido);
	$num_pedido = mysqli_num_rows($pedido);
    
    $sql2 = "SELECT MAX(NRO_FACTURA) AS NRO_FACTURA FROM compra";
    $nro_factura = mysqli_query($cnx_compras, $sql2) or die (mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
	$row_nro_factura = mysqli_fetch_assoc($nro_factura);
    $nueva_factura = $row_nro_factura['NRO_FACTURA'] + 1;
    //echo $nueva_factura;

?>
<!doctype html>
<html lang="es">

<?PHP head1(compras); ?>

<body>
    <?PHP 
    include('../menu.php');
    require_once('../NavsideCompras.php');
    navbar(compras, $var_tipo, $var_active);
    navside(compras);
    ?>

    <div class="container-fluid">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

            <h2 class="sub-header">
                <?PHP echo compras; ?>
            </h2>
            <form class="form-horizontal" role="form" action="ComprasDMLInsert.php" method="post">

                <!--<input type="hidden" name="ID_SOLICITUD" value="<?PHP /*echo $row_pedido['ID_SOLICITUD_COMPRA']; */?>" />-->
                <input type="hidden" name="ID_COMPRA" value="<?PHP echo $row_pedido['ID_COMPRA']; ?>" />
                <input type="hidden" name="NRO_FACTURA" value="<?PHP echo $nueva_factura; ?>" />
                
                <div class="form-group">
                    <label for="FACTURA" class="col-sm-4 control-label">NRO FACTURA</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="FACTURA" name="FACTURA" value="<?PHP echo $nueva_factura; ?>" disabled/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="FECHA_FACTURA" class="col-sm-4 control-label">FECHA FACTURA</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control calendario" id="FECHA_FACTURA" name="FECHA_FACTURA"
                            placeholder="FECHA FACTURA" required />
                    </div>
                </div>
                <hr />
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>NRO</th>
                                <th>ARTICULO</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO<br>FACTURA</th>
                                <!--<th>ICE</th>
                                <th>DESCUENTO</th>-->
                                <th>FECHA<br>CADUCIDAD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?PHP 
                                $c=0;
                                for($i=1;$i<=30;$i++){ ?>
                            <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                <td>
                                    <?PHP echo $i; ?>
                                </td>
                                <td><select class="combobox" name="ARTICULO<?PHP echo $i; ?>">
                                        <option></option>
                                        <?PHP
                                        $sql="SELECT ID_ARTICULO, 
                                                     ARTICULO, 
                                                     NOMBRE_BUSQUEDA,
                                                     ID_UNIDAD, 
                                                     DESCRIPCION,
                                                     PRECIO_COMPRA,
                                                     PRECIO_VENTA,
                                                     ID_GRUPO
                                              FROM articulo";
                                        $articulo = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
                                        $row_articulo = mysqli_fetch_assoc($articulo);
                                        $num_articulo = mysqli_num_rows($articulo);
                                    
                                    
                                     do{ ?>
                                        <option value="<?PHP echo $row_articulo['ID_ARTICULO'];?>">
                                            <?PHP 
                                            if(isset($row_articulo['NOMBRE_BUSQUEDA'])){
                                                //echo utf8_encode($row_articulo['NOMBRE_BUSQUEDA']);
                                                echo mb_convert_encoding($row_articulo['NOMBRE_BUSQUEDA'], 'UTF-8', 'ISO-8859-1');
                                            }
                                            ?>
                                        </option>
                                        <?PHP }while($row_articulo =  mysqli_fetch_assoc($articulo)) ?>
                                    </select>
                                </td>
                                <td><input type="text" name="CANTIDAD<?PHP echo $i; ?>" /></td>
                                <td><input type="text" name="PRECIO_FACTURA<?PHP echo $i; ?>" /></td>
                                <!--<td><input type="text" name="ICE<?PHP //echo $i; ?>" value="0" /></td>
                                <td><input type="text" name="DESCUENTO<?PHP //echo $i; ?>" value="0" /></td>-->
                                <td><input type="text" name="CADUCO<?PHP echo $i; ?>" class="calendario" /></td>
                            </tr>

                            <?PHP } ?>
                        </tbody>
                    </table>
                </div>
                <div> <button class="btn btn-success" id="submit">REGISTRAR</button></div>
            </form>
            <?PHP //} //FIN ELSE ?>


</body>

</html>