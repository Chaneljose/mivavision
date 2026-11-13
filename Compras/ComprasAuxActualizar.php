<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Funciones/Funciones.php');
require_once('../Definiciones/Titulo.php');
$codigo = $_REQUEST['CODIGO'];
$sql="SELECT  c.CANTIDAD
		 ,		  c.PRECIO_FACTURA
     ,      c.PRECIO_VENTA
		 ,		  c.FECHA_CADUCIDAD
		 ,		  c.ID_ARTICULO
		 ,		  a.ARTICULO
		 FROM compra_aux c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
	  WHERE c.ID_ARTICULO = '$codigo'";
$query = $connect->prepare($sql);
$query->execute();
$pedidos = $query->fetchAll(PDO::FETCH_OBJ);
$id_articulo = 0;
$articulo = '';
$cantidad = 0;
$precio_factura = 0;
$precio_venta = 0;
if($query->rowCount()>0){
	foreach($pedidos as $pedido){
		$id_articulo = $pedido->ID_ARTICULO;
		$articulo = $pedido->ARTICULO;
		$cantidad = $pedido->CANTIDAD;
		$precio_factura = $pedido->PRECIO_FACTURA;
    $precio_venta = $pedido->PRECIO_VENTA;
	}
}
?>
<div class="modal-header">
  <a class="close" data-dismiss="modal">x</a>
  <h2>COMPRAS</h2>
</div>
<div class="container-fluid">
  <div class="col-sm-4 col-sm-offset-0 col-md-7 col-md-offset-0 main">
    <h5 class="sub-header">
      <?PHP echo '<strong>MODIFICAR DATOS DEL PRODUCTO</strong>'; ?>
    </h5>
    <form class="form-horizontal" action="ComprasAuxDMLUpdate.php" method="post">
      <fieldset>
        <div class="form-group">
          <label class="col-sm-4 control-label">ARTICULO</label>
          <div class="col-sm-7">
            <input type="hidden" name="ID_ARTICULO" value="<?PHP echo $id_articulo; ?>" />
            <input type="text" size="55" name="ARTICULO" value="<?PHP echo $articulo; ?>" disabled />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label">CANTIDAD</label>
          <div class="col-sm-7">
            <input type="text" name="CANTIDAD" value="<?PHP echo $cantidad; ?>" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label">PRECIO FACTURA</label>
          <div class="col-sm-7">
            <input type="text" name="PRECIO_FACTURA" value="<?PHP echo $precio_factura; ?>" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label">PRECIO VENTA</label>
          <div class="col-sm-7">
            <input type="text" name="PRECIO_VENTA" value="<?PHP echo $precio_venta; ?>" />
          </div>
        </div>
        <div class="form-group">
          <button class="btn btn-success" id="submit">REGISTRAR</button>
          <a href="ComprasForm.php" class="btn btn-default">CANCELAR</a>
        </div>
      </fieldset>
    </form>
  </div>
<div>