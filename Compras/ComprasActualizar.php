<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Funciones/Funciones.php');
require_once('../Definiciones/Titulo.php');
$id_articulo = $_REQUEST['CODIGO'];
$nro_factura = $_REQUEST['BUSCAR'];
$sql="SELECT  c.ID_COMPRA
		 ,		  c.NRO_FACTURA
		 ,		  c.FECHA_FACTURA
		 ,		  c.CANTIDAD
		 ,		  c.PRECIO_FACTURA
		 ,		  c.UM_IMPUESTO
		 ,		  c.VALOR
		 ,		  c.ICE
		 ,      c.DESCUENTO
		 ,		  c.TOTAL
		 ,		  c.FECHA_CADUCIDAD
		 ,		  c.FECHA_REGISTRO
		 ,		  c.ID_ARTICULO
		 ,		  a.ARTICULO
		 FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
	  WHERE c.NRO_FACTURA = '$nro_factura' AND c.ID_ARTICULO = '$id_articulo'";
$queryCompra = $connect->prepare($sql);
$queryCompra->execute();
$compras = $queryCompra->fetchAll(PDO::FETCH_OBJ);
$id_compra = 0;
$num_factura = 0;
$id_articulo = 0;
$articulo = '';
$cantidad = 0;
$precio_factura = 0;

if($queryCompra->rowCount()>0){
	foreach($compras as $compra){
		$id_compra = $compra->ID_COMPRA;
		$num_factura = $compra->NRO_FACTURA;
		$id_articulo = $compra->ID_ARTICULO;
		$articulo = $compra->ARTICULO;
		$cantidad = $compra->CANTIDAD;
		$precio_factura = $compra->PRECIO_FACTURA;
	}
}
?>
<div class="modal-header">
  <a class="close" data-dismiss="modal">x</a>
  <h3>ACTUALIZACION DE COMPRAS</h3>
</div>
<div class="container-fluid">
  <div class="col-sm-4 col-sm-offset-0 col-md-7 col-md-offset-0 main">
    <h2 class="sub-header">
      <?PHP echo compras; ?>
    </h2>
    <form class="form-horizontal" action="ComprasDMLUpdate.php" method="post">
      <fieldset>
        <input type="hidden" name="ID_COMPRA" value="<?PHP echo $id_compra; ?>" />
        <input type="hidden" name="NRO_FACTURA" value="<?PHP echo $num_factura; ?>" />
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
          <button class="btn btn-success" id="submit">REGISTRAR</button>
          <a href="ComprasTabla.php?BUSCAR=<?php echo $nro_factura;?>" class="btn btn-default">CANCELAR</a>
        </div>
      </fieldset>
    </form>
  </div>
<div>