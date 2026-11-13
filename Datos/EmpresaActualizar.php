<?PHP 
require_once('../cnx/cnx_compras.php');
/*require_once('../Funciones/Cabecera.php');
require_once('../Definiciones/Titulo.php'); */
$codigo = $_REQUEST['CODIGO'];
$sql = "SELECT e.ID_EMPRESA, 
			 e.NOMBRE_EMPRESA, 
			 e.NIT, 
			 e.INICIO_GESTION,
			 e.INICIO_MES,
			 e.DIRECCION,
			 e.CIUDAD,
			 e.TELEFONO,
             e.NOTA,
             e.TEMA,
			 m.ID_MES,
			 m.MES
	  FROM empresa e JOIN mes m ON e.INICIO_MES = m.ID_MES
	  WHERE ID_EMPRESA = '$codigo'";
$query = $connect -> prepare($sql); 
$query -> execute(); 
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$nombre_empresa = '';
$nit = '';
$ciudad = '';
$direccion = '';
$telefono = '';
$inicio_gestion = '';
$inicio_mes = '';
$nota = '';
$id_mes = '';
$mes = '';
$tema = '';
if($query -> rowCount() > 0){
    foreach($results as $result) {
     $id_empresa = $result->ID_EMPRESA;
        $nombre_empresa = $result->NOMBRE_EMPRESA;
        $nit = $result->NIT;
        $ciudad = $result->CIUDAD;
        $direccion = $result->DIRECCION;
        $telefono = $result->TELEFONO;
        $inicio_gestion = $result->INICIO_GESTION;
        $inicio_mes = $result->INICIO_MES;
        $nota = $result->NOTA;
        $id_mes = $result->ID_MES;
        $mes = $result->MES;
        $tema = $result->TEMA;
    }
}
?>
<div class="modal-header" style="text-align: center;">
    <a class="close" data-dismiss="modal">x</a>
    <h3>ACTUALIZACION DE EMPRESA</h3>
</div>

<div style="text-align: center;">
    <form class="form-horizontal" role="form" method="POST" action="EmpresaDMLUpdate.php" enctype="multipart/form-data">
        <input type="hidden" name="CODIGO" value="<?PHP echo $id_empresa; ?>" />
        <div class="form-group">
            <label for="NOMBRE" class="col-sm-3 control-label">MONBRE</label>
            <div class="col-sm-4">
                <input type="text" style="width: 400px;" class="form-control" id="NOMBRE" name="NOMBRE" placeholder="NOMBRE DE LA EMPRESA"
                    value="<?PHP echo $nombre_empresa; ?>" />
            </div>
        </div>

        <div class="form-group">
            <label for="NIT" class="col-sm-3 control-label">NIT</label>
            <div class="col-sm-4">
                <input type="text" style="width: 400px;" class="form-control" id="NIT" name="NIT" placeholder="NRO NIT DE LA EMPRESA"
                    value="<?PHP echo $nit; ?>" onchange="this.value = this.value.toUpperCase();" />
            </div>
        </div>

        <div class="form-group">
            <label for="CIUDAD" class="col-sm-3 control-label">CIUDAD</label>
            <div class="col-sm-4">
                <input type="text" style="width: 400px;" class="form-control" id="CIUDAD" name="CIUDAD" placeholder="CIUDAD DE RESIDENCIA DE LA EMPRESA"
                    value="<?PHP echo $ciudad; ?>"
                    onchange="this.value = this.value.toUpperCase();" />
            </div>
        </div>
        <div class="form-group">
            <label for="DIRECCION" class="col-sm-3 control-label">DIRECCION</label>
            <div class="col-sm-4">
                <input type="text" style="width: 400px;" class="form-control" id="DIRECCION" name="DIRECCION" placeholder="DIRECCION DE LA EMPRESA"
                    value="<?PHP echo $direccion; ?>"
                    onchange="this.value = this.value.toUpperCase();" />
            </div>
        </div>
        <div class="form-group">
            <label for="TELEFONO" class="col-sm-3 control-label">TELEFONO</label>
            <div class="col-sm-4">
                <input type="text" style="width: 400px;" class="form-control" id="TELEFONO" name="TELEFONO" placeholder="TELEFONO DE LA EMPRESA"
                    value="<?PHP echo $telefono; ?>"
                    onchange="this.value = this.value.toUpperCase();" />
            </div>
        </div>
        <div class="form-group">
            <label for="GESTION" class="col-sm-3 control-label">GESTION DE INICIO</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="GESTION" name="GESTION" 
                    value="<?PHP echo $inicio_gestion; ?>"
                    onchange="this.value = this.value.toUpperCase();" required />
            </div>
        </div>
        <div class="form-group">
            <label for="MES" class="col-sm-3 control-label">MES DE INICIO</label>
            <div class="col-sm-6">
                <select name="MES">
                    <option value="<?php echo $id_mes; ?>"><?php echo $mes; ?></option>
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
                    <option value="<?php echo $tema; ?>"><?php echo strtoupper($tema); ?></option>
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
                <input type="text" class="form-control" id="NOTA" name="NOTA" 
                    value="<?PHP echo $nota; ?>"
                    onchange="this.value = this.value.toUpperCase();" />
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success" id="submit">ACTUALIZAR</button>
            <a class="btn btn-danger" href="EmpresaTabla.php"> CERRAR </a>
        </div>
    </form>
</div>