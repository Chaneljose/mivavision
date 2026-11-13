<?PHP
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Funciones/Funciones.php');
require_once('../Definiciones/Titulo.php');
//session_start();
$var_tipo = '';
$var_active = "compras";
if (isset($_SESSION['SES_TIPO'])) {
  $var_tipo = $_SESSION['SES_TIPO'];
}
$sql = "SELECT      c.ID_COMPRA_AUX
		,     c.ID_ARTICULO
		,		  a.ARTICULO
		,		  c.CANTIDAD CANTIDAD
    ,     c.PRECIO_FACTURA PRECIO_COMPRA
    ,     c.PRECIO_VENTA
		,		  c.FECHA_CADUCIDAD FECHA_CADUCIDAD
		,		  c.TOTAL TOTAL
		FROM compra_aux c JOIN articulo a ON c.ID_ARTICULO = a.ID_ARTICULO
		WHERE c.ID_ARTICULO>0
		ORDER BY 1 DESC";
$queryArticulo = $connect->prepare($sql);
$queryArticulo->execute();
$articulos = $queryArticulo->fetchAll(PDO::FETCH_OBJ);

$sql2 = "SELECT SUM(c.TOTAL) SUM_TOTAL
	   FROM compra_aux c JOIN articulo a ON c.ID_ARTICULO = a.ID_ARTICULO";
$queryTotal = $connect->prepare($sql2);
$queryTotal->execute();
$totales = $queryTotal->fetchAll(PDO::FETCH_OBJ);
$sum_total = 0;
if ($queryTotal->rowCount() > 0) {
  foreach ($totales as $total) {
    if(!is_null($total->SUM_TOTAL)){
      $sum_total = $total->SUM_TOTAL;
    }
  }
}
$sql1 = "SELECT 	 ID_COMPRA
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
$queryPedido = $connect->prepare($sql);
$queryPedido->execute();
$pedidos = $queryPedido->fetchAll(PDO::FETCH_OBJ);
$sql3 = "SELECT MAX(NRO_FACTURA) AS NRO_FACTURA FROM compra";
$queryFactura = $connect->prepare($sql3);
$queryFactura->execute();
$facturas = $queryFactura->fetchAll(PDO::FETCH_OBJ);
$nueva_factura = 0;
foreach ($facturas as $factura) {
  $nueva_factura = $factura->NRO_FACTURA + 1;
}
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
      <h2 class="sub-header">COMPRAS</h2>
      <form class="form-horizontal" role="form" action="ComprasDMLInsertAux.php">
        <div class="form-group">
          <label for="FACTURA" class="col-sm-4 control-label">NRO FACTURA</label>
          <div class="col-sm-3">
            <input type="text" class="form-control" id="FACTURA" name="FACTURA" value="<?PHP echo $nueva_factura; ?>"
              disabled />
          </div>
        </div>
        <div class="form-group">
          <input type="hidden" tipo="ID_CLIENTE" name="ID_CLIENTE" value=1>
        </div>
        <div class="table-responsive">
          <table width="70%" border="0">
            <tr>
              <th>ARTICULO</th>
              <th>CANTIDAD</th>
              <th>PRECIO<br>FACTURA</th>
              <th>PRECIO<br>VENTA</th>
              <th>FECHA<br>CADUCIDAD</th>
            </tr>
            <tr>
              <th><select class="combobox form-control" id="ARTICULO" name="ARTICULO" required>
                  <option></option>
                  <?PHP
                  $sqlStock = "SELECT * FROM stock";
                  $queryArticuloC = $connect->prepare($sqlStock);
                  $queryArticuloC->execute();
                  $articulosC = $queryArticuloC->fetchAll(PDO::FETCH_OBJ);
                  if ($queryArticuloC->rowCount() > 0) {
                    foreach ($articulosC as $articuloC) {
                  ?>
                  <option value="<?PHP echo $articuloC->ID_ARTICULO; ?>">
                    <?PHP
                      echo ($articuloC->NOMBRE_BUSQUEDA);
                    ?>
                  </option>
                  <?PHP
                    }
                  }
                  ?>
                </select>
              </th>
              <th style="vertical-align: top;">
                <input type="number" name="CANTIDAD" style="width: 100px; height: 26px; border: 1px solid #ccc;" />
              </th>
              <th style="vertical-align: top;">
                <input type="number" step="any" name="PRECIO_FACTURA"
                  style="width: 100px; height: 26px; border: 1px solid #ccc;" required />
              </th>
              <th style="vertical-align: top;">
                <input type="number" step="any" name="PRECIO_VENTA"
                  style="width: 100px; height: 26px; border: 1px solid #ccc;" required />
              </th>
              <th style="vertical-align: top;">
                <input type="text" name="CADUCO" class="calendario" style="width: 100px; height: 26px;" required />
              </th>
              <th style="vertical-align: top;">
                <button class="btn btn-success" id="SUBMIT"
                  style="width: 100px; align-items: center; height: 26px; padding: 0px 12px; ">AGREGAR</button>
              </th>
            </tr>
          </table>
        </div>
      </form>
      <hr>
      <div>
        <h3><strong>TOTAL
            <?PHP
          echo 'Bs.: ' . redondeo($sum_total);
          ?>
          </strong>
        </h3>
      </div>
      <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered table-condensed">
          <thead style="font-size: 16px;">
            <tr>
              <th>
                ARTICULO
              </th>
              <th>
                CANTIDAD
              </th>
              <th>
                P. COMPRA
              </th>
              <th>
                P. VENTA
              </th>
              <th>
                TOTAL
              </th>
              <th>
                FECHA CADUCIDAD
              </th>
              <th>
                ACCION
              </th>
            </tr>
          </thead>
          <tbody>
            <?PHP
            $c = 0;
            if ($queryArticulo->rowCount() > 0) {
              foreach ($articulos as $articulo) {
            ?>
            <tr class="<?= ($c++ % 2 == 1) ? 'impar' : 'par' ?>">
              <td>
                <h5>
                  <?PHP
                      echo $articulo->ARTICULO;
                      ?>
                </h5>
              </td>
              <td>
                <h5>
                  <?PHP
                      echo $articulo->CANTIDAD;
                      ?>
                </h5>
              </td>
              <td align="right">
                <h5>
                  <?PHP
                      echo $articulo->PRECIO_COMPRA;
                      ?>
                </h5>
              </td>
              <td align="right">
                <h5>
                  <?PHP
                      echo $articulo->PRECIO_VENTA;
                      ?>
                </h5>
              </td>
              <td align="right">
                <h5>
                  <?PHP
                      echo redondeo($articulo->TOTAL);
                      ?>
                </h5>
              </td>
              <td align="right">
                <h5>
                  <?PHP
                      echo $articulo->FECHA_CADUCIDAD;
                      ?>
                </h5>
              </td>
              <td>
                <?php
                    if (isset($articulo->ID_ARTICULO)) {
                    ?>
                <h5><a data-toggle="modal" data-target="#UPDATE" class="btn btn-success btn-sm"
                    href="ComprasAuxActualizar.php?CODIGO=<?php echo $articulo->ID_ARTICULO; ?>">EDITAR</a>
                  <a data-toggle="modal" data-target="#DELETE" class="btn btn-danger btn-sm"
                    href="ComprasAuxBorrar.php?CODIGO=<?php echo $articulo->ID_ARTICULO; ?>">BORRAR</a>
                </h5>
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
      <hr>
      <div class="table-responsive">
        <form class="form-horizontal" role="form" method="post" action="ComprasDMLInsert.php">
          <div class="form-group">
            <table width="64%" border="0">
              <tr>
                <?php
                if (!empty($articulos)) {
                ?>
                <td style="width: 4%;" align="right">
                  <h4>FECHA FACTURA</h4>
                </td>
                <td style="width: 36%;">
                  <div class="col-sm-12">
                    <input type="text" class="form-control calendario" id="FECHA_FACTURA" name="FECHA_FACTURA"
                      placeholder="INGRESE LA FECHA DE LA FACTURA" />
                    <center>
                      <h6 style="color: red;">Si no ingresa una fecha el registro sera con la fecha actual</h6>
                    </center>
                  </div>
                </td>
                <td style="width: 8%;">
                  <button class="btn btn-success" id="submit" style="width: 120px; height: 34px;">REGISTRAR</button>
                </td>
                <td style="width: 8%;">
                  <a data-toggle="modal" data-target="#LIMPIAR" style="width: 120px; height: 34px; align-items: center;"
                    class="btn btn-danger" href="ComprasAuxLimpiar.php">LIMPIAR</a>
                </td>
                <?php
                }
                ?>
              </tr>
            </table>
          </div>
          <div>
            <input type="hidden" id="FACTURA" name="FACTURA" value="<?PHP echo $nueva_factura; ?>"/>
          </div>
        </form>
      </div>
      <!--MODAL DELETE--> 
      <div class="modal fade" id="DELETE" tabindex="-1" role="dialog" aria-labelledby="BORRAR" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <?PHP require_once('ComprasAuxBorrar.php'); ?>
          </div>
        </div>
      </div>
      <!--MODAL UPDATE--> 
      <div class="modal fade" id="UPDATE" tabindex="-1" role="dialog" aria-labelledby="EDITAR" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <?PHP require_once('ComprasAuxActualizar.php'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--MODAL LIMPIAR--> 
  <div class="modal fade" id="LIMPIAR" tabindex="-1" role="dialog" aria-labelledby="LIMPIAR" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <?PHP require_once('ComprasAuxLimpiar.php'); ?>
      </div>
    </div>
  </div>
</body>
</html>