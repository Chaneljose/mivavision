<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Funciones/Funciones.php');
	  require_once('../Definiciones/Titulo.php'); 
      
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['CODIGO'];

$sql="SELECT  v.ID_ARTICULO
		,		  a.ARTICULO
		,		  SUM(v.CANTIDAD) CANTIDAD
		,		  SUM(v.PRECIO_VENTA) PRECIO_VENTA
		FROM venta_aux v JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE v.ID_ARTICULO = '$codigo'
		GROUP BY 1,2";
$articulo = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_articulo = mysqli_fetch_assoc($articulo);
$num_articulo = mysqli_num_rows($articulo);

?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">x</a>
    <h3>ACTUALIZACION DE ARTICULOS</h3>
</div>

<div>
    <form class="form-horizontal" role="form" method="post" action="SolSalidasDMLUpdate.php">

        <div class="form-group">
            <label for="ARTICULO" class="col-sm-4 control-label">ARTICULO</label>
            <div class="col-sm-7">
                <input type="text" id="ARTICULO" name="ARTICULO" value="<?PHP echo $row_articulo['ARTICULO']; ?>"
                    disabled />
            </div>
        </div>

        <div class="form-group">
            <label for="CANTIDAD" class="col-sm-4 control-label">CANTIDAD</label>
            <div class="col-sm-7">
                <input type="text" id="CANTIDAD" name="CANTIDAD" value="<?PHP echo $row_articulo['CANTIDAD']; ?>" />
            </div>
        </div>
        
        <div class="form-group">
            <label for="PRECIO" class="col-sm-4 control-label">PRECIO</label>
            <div class="col-sm-7">
                <input type="text" id="PRECIO" name="PRECIO" value="<?PHP echo $row_articulo['PRECIO_VENTA']; ?>" />
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn btn-success" id="submit">REGISTRAR</button>
            <a href="SolSalidasForm.php" class="btn btn-default">CANCELAR</a>
        </div>
        <div><input type="hidden" name="CODIGO" value="<?PHP echo $row_articulo['ID_ARTICULO'] ?>" /></div>
    </form>
</div>