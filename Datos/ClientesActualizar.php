<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Definiciones/Titulo.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['CODIGO'];

$sql="SELECT c.ID_CLIENTE, 
			 c.TACHO, 
			 c.CI, 
			 c.NOMBRE,
			 c.APATERNO,
			 c.AMATERNO,
			 c.ID_TIPO_CLIENTE,
			 t.TIPO
	  FROM cliente c JOIN tipo_cliente t ON c.ID_TIPO_CLIENTE = t.ID_TIPO_CLIENTE
	  WHERE ID_CLIENTE = '$codigo'";
$articulo = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_articulo = mysqli_fetch_assoc($articulo);
$num_articulo = mysqli_num_rows($articulo); 

$sql="SELECT ID_TIPO_CLIENTE, 
			 TIPO
	  FROM tipo_cliente";
$marca = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_marca = mysqli_fetch_assoc($marca);
$num_marca = mysqli_num_rows($marca); 

?>
<!--<!doctype html>
<html lang="es">-->

<?PHP //head1(clientes); ?>

<!--<body class="ui-widget">-->

    <div class="modal-header">
        <a class="close" data-dismiss="modal">x</a>
        <h3>ACTUALIZACION DE CLIENTES</h3>
    </div>

    <div>
        <form class="form-horizontal" role="form" method="post" action="ClientesDMLUpdate.php">
            <input type="hidden" name="CODIGO" value="<?PHP echo $row_articulo['ID_CLIENTE']; ?>" />

            <div class="form-group">
                <label class="col-sm-3 control-label">CODIGO</label>
                <div class="col-sm-4">
                    <?PHP echo $row_articulo['ID_CLIENTE']; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="TACHO" class="col-sm-3 control-label">TACHO</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="TACHO" name="TACHO" placeholder="NRO TACHO"
                        value="<?PHP echo $row_articulo['TACHO']; ?>"
                        onchange="this.value = this.value.toUpperCase();" />
                </div>
            </div>

            <div class="form-group">
                <label for="CI" class="col-sm-3 control-label">CI</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="CI" name="CI" placeholder="NRO CI"
                        value="<?PHP echo $row_articulo['CI']; ?>" onchange="this.value = this.value.toUpperCase();" />
                </div>
            </div>

            <div class="form-group">
                <label for="NOMBRE" class="col-sm-3 control-label">NOMBRE</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" placeholder="NOMBRE"
                        value="<?PHP echo $row_articulo['NOMBRE']; ?>"
                        onchange="this.value = this.value.toUpperCase();" />
                </div>
            </div>

            <div class="form-group">
                <label for="APATERNO" class="col-sm-3 control-label">A. PATERNO</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="APATERNO" name="APATERNO" placeholder="APELLIDO PATERNO"
                        value="<?PHP echo $row_articulo['APATERNO']; ?>"
                        onchange="this.value = this.value.toUpperCase();" />
                </div>
            </div>

            <div class="form-group">
                <label for="AMATERNO" class="col-sm-3 control-label">A. MATERNO</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="AMATERNO" name="AMATERNO" placeholder="APELLIDO MATERNO"
                        value="<?PHP echo $row_articulo['AMATERNO']; ?>"
                        onchange="this.value = this.value.toUpperCase();" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">TIPO</label>
                <div class="col-sm-4">
                    <select class=" form-control combobox" name="TIPO">
                        <option>
                            <?PHP echo $row_articulo['ID_TIPO_CLIENTE']; ?>
                        </option>
                        <?PHP do{ ?>
                        <option value="<?PHP echo $row_marca['ID_TIPO_CLIENTE'];?>">
                            <?PHP echo $row_marca['TIPO']; ?>
                        </option>
                        <?PHP }while($row_marca =  mysqli_fetch_assoc($marca)) ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="submit">ACTUALIZAR</button>
                <a class="btn btn-danger" href="ClientesTabla.php"> CERRAR </a>
            </div>
        </form>
<!--</body>

</html>-->