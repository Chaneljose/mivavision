<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Funciones/Funciones.php');
	  require_once('../Definiciones/Titulo.php'); ?>
<?PHP
$fecha_factura = fecha_amd($_REQUEST['FECHA_FACTURA']);
?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">x</a>
    <h3>INSERTAR LISTA</h3>
</div>
<div>
    <form class="form-horizontal" role="form" action="ComprasDMLInsert.php">
        <p class="alert alert-danger">LA FECHA DE FACTURA ES: <?php echo $fecha_factura; ?> </p>
        <div class="modal-footer">
            <button class="btn  btn-danger" id="submit">INSERTAR</button>
            <a href="ComprasForm.php" class="btn btn-default">CANCELAR</a>
        </div>
    </form>
</div>