<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Definiciones/Titulo.php');?>
<?PHP
//mysqli_select_db($cnx_compras, $database_cnx_compras);

/*$sql="SELECT ID_TIPO_CLIENTE, 
			 TIPO
	  FROM tipo_cliente";*/
//$marca = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
//$row_marca = mysqli_fetch_assoc($marca);
//$num_marca = mysqli_num_rows($marca); 

?>
<!doctype html>
<html lang="es">
<?PHP 
//verificar si es necesario la cabecera al crear una nueva empresa.
head1(empresa); 
?>

<body class="ui-widget">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">x</a>
        <h3>REGISTRA TU EMPRESA</h3>
    </div>
    <form class="form-horizontal" method="POST" role="form" action="../Datos/EmpresaDMLInsert.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="NOMBRE" class="col-sm-3 control-label">NOMBRE EMPRESA</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" placeholder="Ejm: CJCompuNet"
                    onchange="this.value = this.value;" required />
            </div>
        </div>

        <div class="form-group">
            <label for="NIT" class="col-sm-3 control-label">CI/NIT</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="NIT" name="NIT" placeholder="Ejm: 5290570056"
                    onchange="this.value = this.value.toUpperCase();" required />
            </div>
        </div>

        <div class="form-group">
            <label for="CIUDAD" class="col-sm-3 control-label">CIUDAD</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="CIUDAD" name="CIUDAD" placeholder="Ejm: COCHABAMBA"
                    onchange="this.value = this.value.toUpperCase();" required />
            </div>
        </div>

        <div class="form-group">
            <label for="DIRECCION" class="col-sm-3 control-label">DIRECCION</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="DIRECCION" name="DIRECCION" placeholder="Ejm: CALLE ESTEBAN ARZE #1449"
                    onchange="this.value = this.value.toUpperCase();" required />
            </div>
        </div>

        <div class="form-group">
            <label for="TELEFONO" class="col-sm-3 control-label">TELEFONO</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="TELEFONO" name="TELEFONO" placeholder="Ejm: 4306978"
                    onchange="this.value = this.value.toUpperCase();" required />
            </div>
        </div>
        <div class="form-group">
            <label for="GESTION" class="col-sm-3 control-label">GESTION DE INICIO</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="GESTION" name="GESTION" placeholder="Ejm: 1984"
                    onchange="this.value = this.value.toUpperCase();" required />
            </div>
        </div>
        <div class="form-group">
            <label for="MES" class="col-sm-3 control-label">MES DE INICIO</label>
            <div class="col-sm-6">
                <select name="MES" required>
                    <option value="">--SELECCIONES UN MES--</option>
                    <option value="1">ENERO</option>
                    <option value="2">FEBRERO</option>
                    <option value="3">MARZO</option>
                    <option value="4">ABRIL</option>
                    <option value="5">MAYO</option>
                    <option value="6">JUNIO</option>
                    <option value="7">JULIO</option>
                    <option value="8">AGOSTO</option>
                    <option value="9">SEPTIEMBRE</option>
                    <option value="10">OCTUBRE</option>
                    <option value="11">NOVIEMBRE</option>
                    <option value="12">DICIEMBRE</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="LOGO" class="col-sm-3 control-label">MODELO LOGO DE LA EMPRESA</label>
            <div class="col-sm-6">
                <?php
                    $ima = '../Iconos/logo_medidas.png';
                    echo '<img src="'.$ima.'" alt="LOGO MODELO" width="160" height="160">';
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="LOGO" class="col-sm-3 control-label">CARGAR LOGO DE LA EMPRESA</label>
            <div class="col-sm-6">
                <input type="file" id="LOGO" name="LOGO" class="form-control-file" accept="image/*" />
            </div>
        </div>
        <div class="form-group">
            <label for="TARJETA" class="col-sm-3 control-label">MODELO TARJETA DE LA EMPRESA PARA IMPRIMIR NOTAS DE VENTA</label>
            <div class="col-sm-6">
                <?php
                    $ima = '../Iconos/logo_cabecera_medidas.png';
                    echo '<img src="'.$ima.'" alt="TARJETA MODELO" width="440" height="160">';
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="TARJETA" class="col-sm-3 control-label">CARGAR TARJETA DE LA EMPRESA</label>
            <div class="col-sm-6">
                <input type="file" id="TARJETA" name="TARJETA" class="form-control-file" accept="image/*" />
            </div>
        </div>
        <div class="form-group">
            <label for="TEMA" class="col-sm-3 control-label">COLOR DE TEMA</label>
            <div class="col-sm-6">
                <select name="TEMA" required>
                    <option value="">--SELECCIONE UN COLOR--</option>
                    <option value="amarillo">AMARILLO</option>
                    <option value="azul">AZUL</option>
                    <option value="cafe">CAFE</option>
                    <option value="fucsia">FUCSIA</option>
                    <option value="naranja">NARANJA</option>
                    <option value="oscuro">OSCURO</option>
                    <option value="verde">VERDE</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="NOTA_IMPRESION_BOLETA" class="col-sm-3 control-label">NOTA IMPRESION DE BOLETA (OPCIONAL)</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="NOTA" name="NOTA" placeholder="Ejm: Garantia de un año en equipos nuevos"
                    onchange="this.value = this.value.toUpperCase();" />
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success" id="submit">REGISTRAR</button>
            <a href="MenuAdm.php" class="btn btn-default" data-dismiss="modal">CERRAR</a>
        </div>
    </form>
</body>

</html>