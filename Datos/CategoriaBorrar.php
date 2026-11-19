<?PHP
$codigo = $_REQUEST['CODIGO'];
?>
<div class="modal-header">
  <a class="close" data-dismiss="modal">x</a>
  <h3>BORRAR REGISTRO</h3>
</div>
<div>
  <form class="form-horizontal" role="form" action="CategoriaDMLDelete.php">
    <input type="hidden" name="CODIGO" value="<?PHP echo $codigo; ?>" />
    <p class="alert alert-danger">ESTA SEGURO QUE QUIERE BORRAR ESTE REGISTRO?</p>
    <div class="modal-footer">
      <button class="btn  btn-danger" id="submit">BORRAR</button>
      <a href="#" class="btn btn-success" data-dismiss="modal">CERRAR</a>
    </div>
  </form>
</div>