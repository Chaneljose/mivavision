<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
//require_once('../Funciones/Funciones.php');
require_once('../Definiciones/Titulo.php'); 
//session_start(); 
$var_tipo = '';
$var_active = "ventas";
$var_usuario = $_SESSION['SES_ID'];
if(isset($_SESSION['SES_TIPO'])){
    $var_tipo = $_SESSION['SES_TIPO'];
}      
$sql="SELECT      v.ID_VENTA_AUX
		,         v.ID_ARTICULO
		,		  a.ARTICULO
		,		  v.CANTIDAD CANTIDAD
        ,         v.PRECIO_COMPRA PRECIO_COMPRA
		,		  v.PRECIO_VENTA PRECIO_VENTA
		,		  v.TOTAL TOTAL
		FROM venta_aux v JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE v.ID_USR = '$var_usuario' AND v.ID_ARTICULO>0
		ORDER BY 1 DESC";
$queryArticulo = $connect->prepare($sql);
$queryArticulo->execute();
$articulos = $queryArticulo->fetchAll(PDO::FETCH_OBJ);
$sql2="SELECT SUM(v.TOTAL) SUM_TOTAL
	   FROM venta_aux v JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
       WHERE v.ID_USR = '$var_usuario'";
$queryTotal = $connect->prepare($sql2);
$queryTotal->execute();
$totales = $queryTotal->fetchAll(PDO::FETCH_OBJ);
$sql3 = "SELECT COUNT(ID_VENTA_AUX) TOTAL
		 FROM venta_aux
		 ORDER BY 1 DESC LIMIT 1";
$queryCont = $connect->prepare($sql3);
$queryCont->execute();
$conts = $queryCont->fetchAll(PDO::FETCH_OBJ);
$sql4 = "SELECT ID_CLIENTE
		 ,		ID_TIPO_VENTA
		 FROM venta_aux
		 ORDER BY 1 DESC LIMIT 1";
$queryVenAux = $connect->prepare($sql4);
$queryVenAux->execute();
$ventasAuxs = $queryVenAux->fetchAll(PDO::FETCH_OBJ);
$var_cliente = '';
$var_tipo_venta = '';
if ($queryVenAux->rowCount() > 0) {
    foreach ($ventasAuxs as $ventasAux) {
        $var_cliente = $ventasAux->ID_CLIENTE;
        $var_tipo_venta = $ventasAux->ID_TIPO_VENTA;
    }
}
/*if(isset($row_variable['ID_CLIENTE'])){
    $var_cliente = $row_variable['ID_CLIENTE'];
}
if(isset($row_variable['ID_TIPO_VENTA'])){
    $var_tipo_venta = $row_variable['ID_TIPO_VENTA'];
}*/
?>
<!doctype html>
<html lang="es">

<?PHP head1(salidas); ?>

<body>

    <?PHP 
    require('../menu.php');
	require('../NavsideSalidas.php');
    navbar(salidas, $var_tipo, $var_active);
    navside(salidas);
    ?>

    <div class="container-fluid">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="sub-header">VENTAS</h2>
            <form class="form-horizontal" role="form" action="SolSalidasDMLInsertAux.php">
                <!--<input type="hidden" id="FECHA" name="FECHA"
                    value="<?PHP //date_default_timezone_set('America/La_Paz'); echo date('d/m/Y ') ?>" />-->
                <div class="form-group">
                    <!--<input type="hidden" tipo="ID_CLIENTE" name="ID_CLIENTE" value=1>-->
                </div>
                <div class="table-responsive">
                    <table border="0">
                        <tr>
                            <th>ARTICULO: </th>
                            <th></th>
                            <th>CANTIDAD: </th>
                            <th></th>
                            <th> </th>
                        </tr>
                        <tr>
                            <th style="vertical-align: top;"><select class="combobox form-control" id="ARTICULO" name="ARTICULO">
                                    <option></option>
                                    <?PHP
                                        $sql = "SELECT * FROM stock";        
                                        $queryStock = $connect->prepare($sql);
                                        $queryStock->execute();
                                        $stocks = $queryStock->fetchAll(PDO::FETCH_OBJ);
                                        if ($queryStock->rowCount() > 0) {
                                            foreach ($stocks as $stock) {
                                    ?>
                                    <option value="<?PHP echo $stock->ID_ARTICULO;?>">
                                        <?PHP 
                                        echo $stock->NOMBRE_VENTA;
                                        ?>
                                    </option>
                                    <?PHP 
                                            }
                                        } 
                                    ?>
                                </select>
                            </th>
                            <th style="padding:4px;">
                            </th>
                            <th style="vertical-align: top;">
                                <input type="text" name="CANTIDAD" id="CANTIDAD" style="width: 100px; height: 26px;" >
                            </th>
                            <th style="padding:4px;"></th>
                            <th style="vertical-align: top;">
                                <button class="btn btn-success" id="SUBMIT" style="width: 100px; align-items: center; height: 26px; padding: 0px 12px; " >AGREGAR</button>
                            </th>
                        </tr>
                    </table>
                </div>
            </form>
            <hr>
            <div>
                <h3>TOTAL
                    <?PHP
                    if($queryTotal -> rowCount() > 0){
                        foreach($totales as $total) {
                            $sum_total = $total->SUM_TOTAL;
                            if($sum_total>0){
                                echo 'Bs.: '.redondeo($sum_total);
                            }else{
                                echo 'Bs.: 0';
                            }
                            
                        }
                    }
                    ?>
                </h3>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>
                                <h4>CANTIDAD</h4>
                            </th>
                            <th>
                                <h4>ARTICULO</h4>
                            </th>
                            <th>
                                <h4>P. COMPRA</h4>
                            </th>
                            <th>
                                <h4>P. VENTA</h4>
                            </th>
                            <th>
                                <h4>TOTAL</h4>
                            </th>
                            <th>
                                <h4>ACCION</h4>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?PHP 
                            $c = 0;
                            if ($queryArticulo->rowCount() > 0) {
                                foreach ($articulos as $articulo) {
                        ?>
                        <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                            <td>
                                <h4>
                                    <?PHP 
                                    echo $articulo->CANTIDAD;
                                    ?>
                                </h4>
                            </td>
                            <td>
                                <h4>
                                    <?PHP 
                                    echo $articulo->ARTICULO;
                                    ?>
                                </h4>
                            </td>
                            <td align="right">
                                <h4>
                                    <?PHP 
                                    echo $articulo->PRECIO_COMPRA;
                                    ?>
                                </h4>
                            </td>
                            <td align="right">
                                <h4>
                                    <?PHP 
                                    echo $articulo->PRECIO_VENTA;
                                    ?>
                                </h4>
                            </td>
                            <td align="right">
                                <h4>
                                    <?PHP 
                                    echo redondeo($articulo->TOTAL);
                                    ?>
                                </h4>
                            </td>
                            <td>
                                <?php 
                                if(isset($articulo->ID_ARTICULO)){
                                ?>
                                <h4><a data-toggle="modal" data-target="#UPDATE" class="btn btn-success btn-sm"
                                        href="SolSalidasActualizar.php?CODIGO=<?php echo $articulo->ID_ARTICULO;?>">EDITAR</a>
                                    <a data-toggle="modal" data-target="#DELETE" class="btn btn-danger btn-sm"
                                        href="SolSalidasBorrar.php?CODIGO=<?php echo $articulo->ID_ARTICULO;?>">BORRAR</a>
                                </h4>
                                <?php 
                                }
                                ?>
                            </td>
                        </tr>
                        <?PHP 
                            } 
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
            <?php 
            if(isset($total->SUM_TOTAL)){
            ?>
            <table width="34%" border="0">
                <form class="form-horizontal" role="form" method="post" action="SolSalidasDMLInsert.php">
                <tr style="height: 50px;">
                    <th colspan="3">
                        CLIENTE: <input type="text" maxlength="100" style="width: 400px;" onchange="this.value = this.value.toUpperCase();" name="CLIENTE" id="CLIENTE">
                    </th>
                </tr>
                <tr>
                    <!--<form class="form-horizontal" role="form" method="post" action="SolSalidasDMLInsert.php">-->
                        <th>
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                name="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                PAGO POR QR
                            </label>
                        </th>
                        <th>
                            <button class="btn btn-success" id="submit">REGISTRAR</button>
                        </th>
                    <!--</form>-->
                    <th>
                        <a data-toggle="modal" data-target="#LIMPIAR" class="btn btn-danger"
                            href="Limpiar.php">LIMPIAR</a>

                        <?php //MODAL LIMPIAR ?>
                        <div class="modal fade" id="LIMPIAR" tabindex="-1" role="dialog" aria-labelledby="BORRAR"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <?PHP require_once('Limpiar.php');?>
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
                </form>
            </table>
            <?php
            }
            ?>
            <?php // MODAL DELETE ?>
            <div class="modal fade" id="DELETE" tabindex="-1" role="dialog" aria-labelledby="BORRAR" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <?PHP require_once('SolSalidasBorrar.php');?>
                    </div>
                </div>
            </div>
            <?php // MODAL UPDATE ?>
            <div class="modal fade" id="UPDATE" tabindex="-1" role="dialog" aria-labelledby="EDITAR" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <?PHP require_once('SolSalidasActualizar.php');?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>