<?PHP require_once('../cnx/cnx_compras.php');
      require_once('../Funciones/Cabecera.php');
      require_once('../Funciones/Funciones.php');
      require_once('../Definiciones/Titulo.php'); 
      //session_start(); 
      $var_tipo = $_SESSION['SES_TIPO'];
      $var_active = "reportes";
?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = 1;
$marcas = 0;
if(isset($_REQUEST['MARCA'])){
    $marcas = $_REQUEST['MARCA'];
}

$sql = "SELECT m.ID_MARCA, m.MARCA FROM marca m ORDER BY 2";
$marca = mysqli_query($cnx_compras, $sql) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_marca = mysqli_fetch_assoc($marca);
$num_marca = mysqli_num_rows($marca);

$sql2 = "SELECT  c.ID_COMPRA
		 ,		  c.NRO_FACTURA
		 ,		  c.FECHA_FACTURA
		 ,		  c.CANTIDAD
		 ,		  c.PRECIO_FACTURA
		 ,		  c.UM_IMPUESTO
		 ,		  c.VALOR
		 ,		  c.ICE
		 ,        c.DESCUENTO
		 ,		  c.TOTAL
		 ,		  c.FECHA_CADUCIDAD
		 ,		  c.FECHA_REGISTRO
		 ,		  c.ID_ARTICULO
		 ,		  a.ARTICULO
         ,        a.NOMBRE_BUSQUEDA
         ,        a.ID_MARCA
		 FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
		 WHERE c.NRO_FACTURA =  '$codigo'
		 ORDER BY a.ARTICULO";
$sql3 = "SELECT  c.ID_COMPRA
		 ,		  c.NRO_FACTURA
		 ,		  c.FECHA_FACTURA
		 ,		  c.CANTIDAD
		 ,		  c.PRECIO_FACTURA
		 ,		  c.UM_IMPUESTO
		 ,		  c.VALOR
		 ,		  c.ICE
		 ,        c.DESCUENTO
		 ,		  c.TOTAL
		 ,		  c.FECHA_CADUCIDAD
		 ,		  c.FECHA_REGISTRO
		 ,		  c.ID_ARTICULO
		 ,		  a.ARTICULO
         ,        a.NOMBRE_BUSQUEDA
         ,        a.ID_MARCA
		 FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
		 WHERE c.NRO_FACTURA =  '$codigo' AND a.ID_MARCA = '$marcas'
		 ORDER BY a.ARTICULO";
$sql4 = '';
//echo $marcas;
if($marcas == 0){
    $sql4 = $sql2;
}else{
    $sql4 = $sql3;
}
//echo $sql4;
$solicitud = mysqli_query($cnx_compras, $sql4) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_solicitud = mysqli_fetch_assoc($solicitud);
$num_solicitud = mysqli_num_rows($solicitud);

$sql1 = "SELECT SUM(c.ICE) SUM_ICE
		 ,  	 SUM(c.TOTAL) SUM_TOTAL
		 ,		 SUM(c.TOTAL) - SUM(c.ICE) DIFERENCIA
		 FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
		 WHERE c.NRO_FACTURA =  '$codigo'";
$total = mysqli_query($cnx_compras, $sql1) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_total = mysqli_fetch_assoc($total);
$num_total = mysqli_num_rows($total);

$ice = $row_total['SUM_ICE'];
$var_total = $row_total['SUM_TOTAL'];
$diferecnia = $row_total['DIFERENCIA'];


?>
<!doctype html>
<html lang="es">

<?PHP head1(reportes); ?>

<body>
    <?PHP include('../menu.php');
              navbar(reportes, $var_tipo, $var_active);
			  require_once('../NavsideReportes.php');
		  	  navside(inventarioinicial);?>
    <div class="container-fluid">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="sub-header">
                <?PHP echo inventarioinicial; ?>
            </h2>
            <form class="form-horizontal" role="form" action="">
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        <h4>BUSCAR</h4>
                    </label>
                    <div class="col-sm-10">
                        <select name="MARCA" class="form-control combobox">
                            <option value="0">TODOS</option>
                            <?PHP do{ ?>
                            <option value="<?PHP 
                                                if(isset($row_marca['ID_MARCA'])){
                                                    echo $row_marca['ID_MARCA'];
                                                }
                                            ?>">
                                <?PHP 
                                if(isset($row_marca['MARCA'])){
                                    echo $row_marca['MARCA']; 
                                }
                                ?>
                            </option>
                            <?PHP } while($row_marca = mysqli_fetch_assoc($marca)) ?>
                        </select>

                        <button class="btn btn-success" id="submit">BUSCAR</button>
                    </div>
                </div>
            </form>
            <hr />
            <div class="form-group form-horizontal">
                <label>FACTURA: </label>
                <?PHP
                    if(isset($row_solicitud['NRO_FACTURA'])) {
                        echo $row_solicitud['NRO_FACTURA'] ;
                    }
                 
                ?>
            </div>

            <div class="form-group form-horizontal">
                <label>FECHA FACTURA: </label>
                <?PHP if(isset($row_solicitud['FECHA_FACTURA'])){
                    echo fecha_dma($row_solicitud['FECHA_FACTURA']);
                }
                 
                ?>
            </div>
            <div class="form-group form-horizontal">
                <label>TOTAL FACTURA: </label>
                <?PHP echo round($var_total,2) ?>
            </div>
            <div class="form-group form-horizontal">
                <label>ICE: </label>
                <?PHP echo round($ice,2) ?>
            </div>
            <div class="form-group form-horizontal">
                <label>IMPORTE PARA CREDITO FISCAL: </label>
                <?PHP echo round($diferecnia,2) ?>
            </div>
            
            <hr />
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>CANTIDAD</th>
                            <th>ARTICULO</th>
                            <th>PRECIO<br>FACTURA</th>
                            <th>UM<br>IMPUESTO</th>
                            <th>IMPORTE</th>
                            <th>ICE</th>
                            <th>DESCUENTO</th>
                            <th>TOTAL</th>
                            <th>ACCION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?PHP
                    $cont =1;
                    do{
                ?>
                        <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                            <td>
                                <?PHP 
                                if(isset($row_solicitud['CANTIDAD'])){
                                    echo $row_solicitud['CANTIDAD'];
                                }
                                 
                                ?>
                            </td>
                            <td>
                                <?PHP 
                                if(isset($row_solicitud['NOMBRE_BUSQUEDA'])){
                                    echo ($row_solicitud['NOMBRE_BUSQUEDA']); 
                                }
                                
                                ?>
                            </td>
                            <td align="right">
                                <?PHP 
                                if(isset($row_solicitud['PRECIO_FACTURA'])){
                                    echo round($row_solicitud['PRECIO_FACTURA'],4);
                                }
                                 ?>
                            </td>
                            <td align="right">
                                <?PHP 
                                if(isset($row_solicitud['UM_IMPUESTO'])){
                                    echo round($row_solicitud['UM_IMPUESTO'],2);
                                }
                                 ?>
                            </td>
                            <td align="right">
                                <?PHP if(isset($row_solicitud['VALOR'])){
                                    echo round($row_solicitud['VALOR'],2);
                                } 
                                ?>
                            </td>
                            <td align="right">
                                <?PHP 
                                if(isset($row_solicitud['ICE'])){
                                    echo round($row_solicitud['ICE'],2);
                                }
                                 ?>
                            </td>
                            <td align="right">
                                <?PHP 
                                if(isset($row_solicitud['DESCUENTO'])){
                                    echo round($row_solicitud['DESCUENTO'],2);
                                }
                                 ?>
                            </td>
                            <td align="right">
                                <?PHP 
                                if(isset($row_solicitud['TOTAL'])){
                                    echo round($row_solicitud['TOTAL'],2);
                                }
                                 ?>
                            </td>
                            <td><a data-toggle="modal" data-target="#UPDATE" class="btn btn-success btn-sm"
                                    href="InventarioInicialActualizar.php?CODIGO=<?PHP echo $row_solicitud['ID_COMPRA']; ?>&BUSCAR=<?PHP echo $codigo; ?>&MARCA=<?PHP echo $marcas; ?>">EDITAR</a>
                                <a data-toggle="modal" data-target="#DELETE" class="btn btn-danger btn-sm"
                                    href="ComprasDMLDelete.php?CODIGO=<?PHP echo $row_solicitud['ID_COMPRA'];?>">BORRAR</a>
                            </td>
                        </tr>
                        <?PHP $cont++;
                         } while($row_solicitud = mysqli_fetch_assoc($solicitud)) ?>
                    </tbody>
                </table>
                <?php // MODAL DELETE ?>
                <div class="modal fade" id="DELETE" tabindex="-1" role="dialog" aria-labelledby="BORRAR" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <?PHP /*require_once('SolSalidasBorrar.php');*/?>
                        </div>
                    </div>
                </div>
                <?php // MODAL UPDATE ?>
                <div class="modal fade" id="UPDATE" tabindex="-1" role="dialog" aria-labelledby="EDITAR" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <?PHP require_once('InventarioInicialActualizar.php');?>
                        </div>
                    </div>
                </div>
            </div>

</body>

</html>