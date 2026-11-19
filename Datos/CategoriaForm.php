<?PHP
require_once('../Funciones/Cabecera.php');
require_once('../Definiciones/Titulo.php');
?>
<!doctype html>
<html lang="es">
<?PHP
head1(categoria);
?>
<body class="ui-widget">

    <div class="modal-header">
        <a class="close" data-dismiss="modal">x</a>
        <h3>REGISTRO DE CATEGORIAS</h3>
    </div>
    <form class="form-horizontal" role="form" action="CategoriaDMLInsert.php">
        <div class="form-group">
            <label for="CATEGORIA" class="col-sm-3 control-label">NOMBRE CATEGORIA</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="CATEGORIA" name="CATEGORIA" placeholder="NOMBRE CATEGORIA"
                    onchange="this.value = this.value.toUpperCase();" required />
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success" id="submit">REGISTRAR</button>
            <a href="CategoriaTabla.php" class="btn btn-default" data-dismiss="modal">CERRAR</a>
        </div>
    </form>
</body>
</html>