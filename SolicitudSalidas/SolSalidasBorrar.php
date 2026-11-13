<?PHP require_once('../cnx/cnx_compras.php');
	    require_once('../Funciones/Cabecera.php');	
	    require_once('../Definiciones/Titulo.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['CODIGO'];

?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">x</a>
    <h3>BORRAR REGISTRO</h3>
</div>
<div>
    <form class="form-horizontal" role="form" action="SolSalidasDMLDelete.php">
        <input type="hidden" name="CODIGO" value="<?PHP echo $codigo; ?>" />
        <p class="alert alert-danger">ESTA SEGURO QUE QUIERE BORRAR ESTE REGISTRO?</p>
        <div class="modal-footer">
            <button class="btn  btn-danger" id="submit">BORRAR</button>
            <a href="SolSalidasForm.php" class="btn btn-default">CANCELAR</a>
				</div>
    </form>
</div>