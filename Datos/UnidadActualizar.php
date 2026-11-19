<?PHP
require_once('../cnx/cnx_compras.php');
$codigo = $_REQUEST['CODIGO'];
$sql = "SELECT m.ID_UNIDAD, 
        m.NOMBRE AS UNIDAD 
        FROM unidad m 
        WHERE m.ID_UNIDAD = '$codigo'";
$query = $connect->prepare($sql);
$query->execute();
$unidades = $query->fetchAll(PDO::FETCH_OBJ);
$idUnidad = '';
$nombreUnidad = '';
if ($query->rowCount() > 0) {
  foreach ($unidades as $unidad) {
    $idUnidad = $unidad->ID_UNIDAD;
    $nombreUnidad = $unidad->UNIDAD;
  }
}
?>
<div class="modal-header" style="text-align: center;">
  <a class="close" data-dismiss="modal">x</a>
  <h3>ACTUALIZACION DE UNIDAD</h3>
</div>
<div style="text-align: center;">
  <form class="form-horizontal" role="form" method="post" action="UnidadDMLUpdate.php">
    <input type="hidden" name="CODIGO" value="<?PHP echo $idUnidad; ?>" />
    <div class="form-group">
      <label for="UNIDAD" class="col-sm-3 control-label">UNIDAD</label>
      <div class="col-sm-4">
        <input type="text" style="width: 400px;" class="form-control" id="UNIDAD" name="UNIDAD" placeholder="UNIDAD DEL PRODUCTO"
          value="<?PHP echo $nombreUnidad; ?>"
          onchange="this.value = this.value.toUpperCase();" />
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-success" id="submit">ACTUALIZAR</button>
      <a class="btn btn-danger" href="UnidadTabla.php"> CERRAR </a>
    </div>
  </form>
</div>