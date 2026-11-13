<?PHP
$codigo = $_REQUEST['CODIGO'];
?>
<div class="modal-header" style="text-align: center;">
  <a class="close" data-dismiss="modal">x</a>
  <h3>BORRAR REGISTRO</h3>
</div>
<div style="text-align: center;">
  <form class="form-horizontal" role="form" action="EmpresaDMLDelete.php">
    <input type="hidden" name="CODIGO" value="<?PHP echo $codigo; ?>" />
    <p class="alert alert-danger">
      ESTA SEGURO QUE QUIERE BORRAR ESTE REGISTRO?
      <BR>
      Se borraran tambien todos los registros de GESTION.
    </p>
    <div class="modal-footer">
      <button class="btn  btn-danger" id="submit">BORRAR</button>
      <a href="#" class="btn btn-success" data-dismiss="modal">CERRAR</a>
    </div>
  </form>
</div>