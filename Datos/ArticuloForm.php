<?PHP require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Definiciones/Titulo.php'); ?>
<?PHP

$sql = "SELECT ID_MARCA, MARCA
	  FROM marca ORDER BY MARCA";
$sql1 = "SELECT ID_GRUPO, GRUPO
	  FROM grupo ORDER BY GRUPO";
$sql2 = "SELECT ID_UNIDAD, NOMBRE
	   FROM unidad ORDER BY NOMBRE";
$sql3 = "SELECT ID_CATEGORIA, NOMBRE
	   FROM categoria ORDER BY NOMBRE";
$queryMarca = $connect->prepare($sql);
$queryMarca->execute();
$marcas = $queryMarca->fetchAll(PDO::FETCH_OBJ);
$queryGrupo = $connect->prepare($sql1);
$queryGrupo->execute();
$grupos = $queryGrupo->fetchAll(PDO::FETCH_OBJ);
$queryUnidad = $connect->prepare($sql2);
$queryUnidad->execute();
$unidades = $queryUnidad->fetchAll(PDO::FETCH_OBJ);
$queryCategoria = $connect->prepare($sql3);
$queryCategoria->execute();
$categorias = $queryCategoria->fetchAll(PDO::FETCH_OBJ);

?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">x</a>
    <h3>REGISTRO DE ARTICULOS</h3>
</div>
<form class="form-horizontal" method="POST" role="form" action="ArticuloDMLInsert.php" enctype="multipart/form-data">
    <div class="form-group">
        <label for="ARTCODE" class="col-sm-4 control-label">CODIGO DE ARTICULO</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="ARTCODE" name="ARTCODE" placeholder="Ejemplo: ART001"
                onchange="this.value = this.value.toUpperCase();" required />
        </div>
    </div>
    <div class="form-group">
        <label for="ARTICULO" class="col-sm-4 control-label">NOMBRE DE ARTICULO</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="ARTICULO" name="ARTICULO" placeholder="ARTICULO"
                onchange="this.value = this.value.toUpperCase();" required />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">MARCA</label>
        <div class="col-sm-7">
            <select name="ID_MARCA" required>
                <option>---SELECCIONE UNA MARCA---</option>
                <?PHP
                if ($queryMarca->rowCount() > 0) {
                    foreach ($marcas as $marca) {
                ?>
                        <option value="<?PHP echo $marca->ID_MARCA; ?>">
                            <?PHP
                            echo $marca->MARCA;
                            ?>
                        </option>
                <?PHP
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">TIPO</label>
        <div class="col-sm-7">
            <select name="ID_GRUPO" required>
                <option>------SELECCIONE UN TIPO------</option>
                <?PHP
                if ($queryGrupo->rowCount() > 0) {
                    foreach ($grupos as $grupo) {
                ?>
                        <option value="<?PHP echo $grupo->ID_GRUPO; ?>">
                            <?PHP
                            echo $grupo->GRUPO;
                            ?>
                        </option>
                <?PHP
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="VENTA" class="col-sm-4 control-label">PRECIO VENTA</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="VENTA" name="VENTA" placeholder="0.00"
                onchange="this.value = this.value.toUpperCase();" required />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">UNIDAD DE MEDIDA</label>
        <div class="col-sm-7">
            <select name="ID_UNIDAD" required>
                <option>---SELECCIONE UNA UNIDAD---</option>
                <?PHP
                if ($queryGrupo->rowCount() > 0) {
                    foreach ($unidades as $unidad) {
                ?>
                        <option value="<?PHP echo $unidad->ID_UNIDAD; ?>">
                            <?PHP
                            echo $unidad->NOMBRE;
                            ?>
                        </option>
                <?PHP
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">CATEGORIA</label>
        <div class="col-sm-7">
            <select name="ID_CATEGORIA" required>
                <option>---SELECCIONE UNA CATEGORIA---</option>
                <?PHP
                if ($queryCategoria->rowCount() > 0) {
                    foreach ($categorias as $categoria) {
                ?>
                        <option value="<?PHP echo $categoria->ID_CATEGORIA; ?>">
                            <?PHP
                            echo $categoria->NOMBRE;
                            ?>
                        </option>
                <?PHP
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="IMAGEN" class="col-sm-4 control-label">IMAGEN</label>
        <div class="col-sm-7">
            <input type="file" id="IMAGEN" name="IMAGEN" class="form-control-file" accept="image/*" required />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">DESCRIPCION</label>
        <div class="col-sm-7">
            <textarea class="form-control" name="DESCRIPCION" rows="5"
                onChange="this.value = this.value.toUpperCase();"></textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success" id="submit" name="submit">REGISTRAR</button>
        <a href="ArticuloTabla.php" class="btn btn-default" data-dismiss="modal">CERRAR</a>
    </div>
</form>