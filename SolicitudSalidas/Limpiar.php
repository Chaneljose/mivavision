<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Funciones/Funciones.php');
	  require_once('../Definiciones/Titulo.php'); ?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">x</a>
    <h3>LIMPIAR LISTA</h3>
</div>
<div>
    <form class="form-horizontal" role="form" action="LimpiarDMLDelete.php">
        <p class="alert alert-danger">ESTA SEGURO QUE QUIERE LIMPIAR LA LISTA DE COMPRAS ? </p>
        <div class="modal-footer">
            <button class="btn  btn-danger" id="submit">LIMPIAR</button>
            <a href="SolSalidasForm.php" class="btn btn-default">CANCELAR</a>
        </div>
    </form>
</div>