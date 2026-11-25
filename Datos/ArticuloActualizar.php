<?PHP
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Definiciones/Titulo.php');
$codigo = $_REQUEST['CODIGO'];
$sql = "SELECT ID_ARTICULO, 
			 ARTICULO,
             ARTCODE,
             IMAGEN,
			 DESCRIPCION,
			 PRECIO_COMPRA,
			 PRECIO_VENTA,
			 ID_GRUPO,
			 ID_MARCA, 
			 ID_UNIDAD
	  FROM articulo
	  WHERE ID_ARTICULO = '$codigo'";
$id_marca = '';
$id_grupo = '';
$id_unidad = '';
$id_articulo = '';
$artcode = '';
$articuloNombre = '';
$precioVenta = '';
$imagen = '';
$descripcion = '';
$queryArticulo = $connect->prepare($sql);
$queryArticulo->execute();
$articulos = $queryArticulo->fetchAll(PDO::FETCH_OBJ);
if ($queryArticulo->rowCount() > 0) {
    foreach ($articulos as $articulo) {
        $id_marca = $articulo->ID_MARCA;
        $id_grupo = $articulo->ID_GRUPO;
        $id_unidad = $articulo->ID_UNIDAD;
        $id_articulo = $articulo->ID_ARTICULO;
        $artcode = $articulo->ARTCODE;
        $articuloNombre = $articulo->ARTICULO;
        $precioVenta = $articulo->PRECIO_VENTA;
        $imagen = $articulo->IMAGEN;
        $descripcion = $articulo->DESCRIPCION;
    }
}
$sql = "SELECT ID_MARCA, MARCA
	  FROM marca
	  WHERE id_marca = '$id_marca'
	  UNION ALL
      SELECT ID_MARCA, MARCA
	  FROM marca";
$queryMarca = $connect->prepare($sql);
$queryMarca->execute();
$marcas = $queryMarca->fetchAll(PDO::FETCH_OBJ);
$sql1 = "SELECT ID_GRUPO, GRUPO
	   FROM grupo
	   WHERE ID_GRUPO = '$id_grupo'
	   UNION ALL
	   SELECT ID_GRUPO, GRUPO
	   FROM grupo";
$queryGrupo = $connect->prepare($sql1);
$queryGrupo->execute();
$grupos = $queryGrupo->fetchAll(PDO::FETCH_OBJ);
$sql2 = "SELECT ID_UNIDAD, NOMBRE AS UNIDAD
	   FROM unidad
	   WHERE ID_UNIDAD = '$id_unidad'
	   UNION ALL
	   SELECT ID_UNIDAD, NOMBRE AS UNIDAD
	   FROM unidad";
$queryUnidad = $connect->prepare($sql2);
$queryUnidad->execute();
$unidades = $queryUnidad->fetchAll(PDO::FETCH_OBJ);
?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">x</a>
    <h3>ACTUALIZACION DE ARTICULOS</h3>
</div>
<form class="form-horizontal" role="form" method="post" id="formModal" enctype="multipart/form-data" action="ArticuloDMLUpdate.php">
    <div class="form-group">
        <label for="ARTICULO" class="col-sm-4 control-label">ID</label>
        <div class="col-sm-7">
            <?PHP echo $id_articulo; ?>
        </div>
    </div>
    <div class="form-group">
        <label for="ARTCODE" class="col-sm-4 control-label">CODIGO ARTICULO</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="ARTCODE" name="ARTCODE" placeholder="ARTCODE"
                value="<?PHP echo $artcode; ?>" onchange="this.value = this.value.toUpperCase();" />
        </div>
    </div>
    <div class="form-group">
        <label for="ARTICULO" class="col-sm-4 control-label">ARTICULO</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="ARTICULO" name="ARTICULO" placeholder="ARTICULO"
                value="<?PHP echo $articuloNombre; ?>" onchange="this.value = this.value.toUpperCase();" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">MARCA</label>
        <div class="col-sm-7">
            <select class="form-control combobox" name="ID_MARCA">
                <?PHP
                foreach ($marcas as $marca) {
                ?>
                    <option value="<?PHP echo $marca->ID_MARCA; ?>">
                        <?PHP echo $marca->MARCA; ?>
                    </option>
                <?PHP
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">GRUPO</label>
        <div class="col-sm-7">
            <select class="form-control combobox" name="ID_GRUPO">
                <?PHP
                foreach ($grupos as $grupo) {
                ?>
                    <option value="<?PHP echo $grupo->ID_GRUPO; ?>">
                        <?PHP echo $grupo->GRUPO; ?>
                    </option>
                <?PHP
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="VENTA" class="col-sm-4 control-label">PRECIO VENTA</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="VENTA" name="VENTA" placeholder="0.00"
                value="<?PHP echo $precioVenta; ?>" required />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">UNIDAD</label>
        <div class="col-sm-7">
            <select class="form-control combobox" name="ID_UNIDAD">
                <?PHP
                foreach ($unidades as $unidad) {
                ?>
                    <option value="<?PHP echo $unidad->ID_UNIDAD; ?>">
                        <?PHP echo $unidad->UNIDAD; ?>
                    </option>
                <?PHP
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="IMAGEN" class="col-sm-4 control-label">IMAGEN</label>
        <div class="col-sm-7">
            <?PHP
            $ima = $imagen;
            echo '<img src="' . $ima . '" alt="Descripción de la imagen" width="200" height="200">';
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="IMAGEN" class="col-sm-4 control-label">MODIFICAR IMAGEN</label>
        <div class="col-sm-7">
            <input type="file" id="IMAGEN" name="IMAGEN" class="form-control-file" accept="image/*" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">DESCRIPCION</label>
        <div class="col-sm-7">
            <textarea class="form-control" name="DESCRIPCION" rows="4"
                onChange="this.value = this.value.toUpperCase();"><?PHP echo $descripcion; ?></textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success" id="submit">REGISTRAR</button>
        <a class="btn btn-danger" href="ArticuloTabla.php"> CERRAR </a>
    </div>
    <input type="hidden" name="CODIGO" value="<?PHP echo $id_articulo; ?>" />
</form>