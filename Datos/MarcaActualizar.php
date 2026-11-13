<?PHP
require_once('../cnx/cnx_compras.php');
$codigo = $_REQUEST['CODIGO'];
$sql = "SELECT m.ID_MARCA, 
        m.MARCA 
        FROM marca m 
        WHERE m.ID_MARCA = '$codigo'";
$query = $connect->prepare($sql);
$query->execute();
$marcas = $query->fetchAll(PDO::FETCH_OBJ);
$idMarca = '';
$nombreMarca = '';
if ($query->rowCount() > 0) {
  foreach ($marcas as $marca) {
    $idMarca = $marca->ID_MARCA;
    $nombreMarca = $marca->MARCA;
  }
}
?>
<div class="modal-header" style="text-align: center;">
  <a class="close" data-dismiss="modal">x</a>
  <h3>ACTUALIZACION DE MARCA</h3>
</div>
<div style="text-align: center;">
  <form class="form-horizontal" role="form" method="post" action="MarcaDMLUpdate.php">
    <input type="hidden" name="CODIGO" value="<?PHP echo $idMarca; ?>" />
    <div class="form-group">
      <label for="MARCA" class="col-sm-3 control-label">MARCA</label>
      <div class="col-sm-4">
        <input type="text" style="width: 400px;" class="form-control" id="MARCA" name="MARCA" placeholder="MARCA DEL PRODUCTO"
          value="<?PHP echo $nombreMarca; ?>"
          onchange="this.value = this.value.toUpperCase();" />
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-success" id="submit">ACTUALIZAR</button>
      <a class="btn btn-danger" href="MarcaTabla.php"> CERRAR </a>
    </div>
  </form>
</div>