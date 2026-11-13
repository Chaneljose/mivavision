<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Funciones/Funciones.php');
require_once('../Definiciones/Titulo.php'); 
/*mysqli_select_db($cnx_compras, $database_cnx_compras);*/
$codigo = $_REQUEST['CODIGO'];
$buscar = $_REQUEST['BUSCAR'];
?>
<div class="modal-header">
  <a class="close" data-dismiss="modal">x</a>
  <h3>ELIMINAR PRODUCTO</h3>
</div>
<div>
  <form class="form-horizontal" role="form" action="ComprasDMLDelete.php">
    <p class="alert alert-danger">ESTA SEGURO QUE QUIERE ELIMINAR ESTE PRODUCTO </p>
    <input type="hidden" name="CODIGO" value="<?PHP echo $codigo; ?>" />
    <input type="hidden" name="BUSCAR" value="<?PHP echo $buscar; ?>" />
    <div class="modal-footer">
      <button class="btn  btn-danger" id="submit">ELIMINAR</button>
      <a href="ComprasTabla.php?BUSCAR=<?php echo $buscar?>" class="btn btn-default">CANCELAR</a>
    </div>
  </form>
</div>