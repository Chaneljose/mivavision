<?PHP 
/*require_once('../../cnx/cnx_compras.php');*/
require_once('../../Funciones/Cabecera.php');
/*require_once('../../Definiciones/Titulo.php');*/
//mysqli_select_db($database_cnx_compras, $cnx_compras);
$codigo = $_REQUEST['CODIGO'];
?>
<!doctype html>
<html lang="es">

<?PHP head1(clientes); ?>
<body  class="ui-widget">

   	<div class="modal-header">
          <a class="close" data-dismiss="modal">x</a>
          <h3>BORRAR REGISTRO</h3>
    </div>
    <div>
   	<form class="form-horizontal" role="form"  action="ClientesDMLDelete.php">
    	<input type="hidden" name="CODIGO" value="<?PHP echo $codigo; ?>" />
       	<p class="alert alert-danger">ESTA SEGURO QUE QUIERE BORRAR ESTE REGISTRO?</p>
    <div class="modal-footer">
            <button class="btn  btn-danger" id="submit">BORRAR</button>
            <a href="#" class="btn btn-default" data-dismiss="modal">CERRAR</a>
    </div>
    </form>
</body>
</html>