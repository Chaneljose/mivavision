<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Funciones/Funciones.php');
require_once('../Definiciones/Titulo.php'); 
      
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['CODIGO'];
$buscar = $_REQUEST['BUSCAR'];
$inicio = "";
$fin = "";
if(isset($_REQUEST['INICIO'])){
    $inicio = $_REQUEST['INICIO'];
}
if(isset($_REQUEST['FIN'])){
    $fin = $_REQUEST['FIN'];
}

$sql="SELECT  v.ID_ARTICULO
		,		  a.ARTICULO
		,		  SUM(v.CANTIDAD) CANTIDAD
		,		  SUM(v.PRECIO_VENTA) PRECIO_VENTA
		FROM venta v JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE v.ID_ARTICULO = '$codigo' AND v.ID_SOLICITUD_VENTA = '$buscar'
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
    <form class="form-horizontal" role="form" method="post" action="SolSalidasDMLUpdateVenta.php?CODIGO=<?php echo $codigo;?>&BUSCAR=<?php echo $buscar;?>">

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

        <div class="modal-footer">
            <button class="btn btn-success" id="submit">REGISTRAR</button>
            <a href="SolSalidasTabla.php?BUSCAR=<?php echo $buscar; ?>&INICIO=<?php echo fecha_amd($inicio); ?>&FIN=<?php echo fecha_amd($fin); ?>" class="btn btn-default">CANCELAR</a>
        </div>
        <div><input type="hidden" name="CODIGO" value="<?PHP echo $row_articulo['ID_ARTICULO'] ?>" /></div>
    </form>
</div>