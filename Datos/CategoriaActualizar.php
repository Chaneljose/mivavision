<?PHP
require_once('../cnx/cnx_compras.php');
$codigo = $_REQUEST['CODIGO'];
$sql = "SELECT m.ID_CATEGORIA, 
        m.NOMBRE AS CATEGORIA 
        FROM categoria m 
        WHERE m.ID_CATEGORIA = '$codigo'";
$query = $connect->prepare($sql);
$query->execute();
$unidades = $query->fetchAll(PDO::FETCH_OBJ);
$idCategoria = '';
$nombreCategoria = '';
if ($query->rowCount() > 0) {
  foreach ($unidades as $unidad) {
    $idCategoria = $unidad->ID_CATEGORIA;
    $nombreCategoria = $unidad->CATEGORIA;
  }
}
?>
<div class="modal-header" style="text-align: center;">
  <a class="close" data-dismiss="modal">x</a>
  <h3>ACTUALIZACION DE CATEGORIA</h3>
</div>
<div style="text-align: center;">
  <form class="form-horizontal" role="form" method="post" action="CategoriaDMLUpdate.php">
    <input type="hidden" name="CODIGO" value="<?PHP echo $idCategoria; ?>" />
    <div class="form-group">
      <label for="CATEGORIA" class="col-sm-3 control-label">CATEGORIA</label>
      <div class="col-sm-4">
        <input type="text" style="width: 400px;" class="form-control" id="CATEGORIA" name="CATEGORIA" placeholder="CATEGORIA DEL PRODUCTO"
          value="<?PHP echo $nombreCategoria; ?>"
          onchange="this.value = this.value.toUpperCase();" />
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-success" id="submit">ACTUALIZAR</button>
      <a class="btn btn-danger" href="CategoriaTabla.php"> CERRAR </a>
    </div>
  </form>
</div>