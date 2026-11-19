<?PHP
require_once('../Funciones/Cabecera.php');
require_once('../Definiciones/Titulo.php');
?>
<!doctype html>
<html lang="es">
<?PHP
head1(unidad);
?>
<body class="ui-widget">

    <div class="modal-header">
        <a class="close" data-dismiss="modal">x</a>
        <h3>REGISTRO DE UNIDADES</h3>
    </div>
    <form class="form-horizontal" role="form" action="UnidadDMLInsert.php">
        <div class="form-group">
            <label for="UNIDAD" class="col-sm-3 control-label">NOMBRE UNIDAD</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="UNIDAD" name="UNIDAD" placeholder="NOMBRE UNIDAD"
                    onchange="this.value = this.value.toUpperCase();" required />
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success" id="submit">REGISTRAR</button>
            <a href="UnidadTabla.php" class="btn btn-default" data-dismiss="modal">CERRAR</a>
        </div>
    </form>
</body>
</html>