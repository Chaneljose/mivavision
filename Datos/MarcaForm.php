<?PHP
require_once('../Funciones/Cabecera.php');
require_once('../Definiciones/Titulo.php');
?>
<!doctype html>
<html lang="es">
<?PHP
head1(marca);
?>
<body class="ui-widget">

    <div class="modal-header">
        <a class="close" data-dismiss="modal">x</a>
        <h3>REGISTRO DE MARCAS</h3>
    </div>
    <form class="form-horizontal" role="form" action="MarcaDMLInsert.php">
        <div class="form-group">
            <label for="MARCA" class="col-sm-3 control-label">NOMBRE MARCA</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="MARCA" name="MARCA" placeholder="NOMBRE MARCA"
                    onchange="this.value = this.value.toUpperCase();" required />
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success" id="submit">REGISTRAR</button>
            <a href="MarcaTabla.php" class="btn btn-default" data-dismiss="modal">CERRAR</a>
        </div>
    </form>
</body>
</html>