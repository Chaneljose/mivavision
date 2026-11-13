<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Funciones/Funciones.php');
	  require_once('../Definiciones/Titulo.php'); ?>
<?PHP

mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['CODIGO'];


$id_solicitud = $_REQUEST['SOLICITUD'];
//$id_area = $_REQUEST['ID_AREA'];
$articulo = $_REQUEST['ARTICULO'];
//$unidad = $_REQUEST['UNIDAD'];
$cantidad = $_REQUEST['CANTIDAD'];
$precio = $_REQUEST['PRECIO'];

$descripcion = $_REQUEST['DESCRIPCION'];
//$fecha = $_REQUEST['FECHA'];

/*$sql1 = "UPDATE solicitud
		SET ID_AREA = '$id_area',
			FECHA = '$fecha'
		WHERE ID_SOLICITUD_COMPRA = '$id_solicitud'";
$row_consulta = mysqli_query($sql, $cnx_compras) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
*/
$sql3 = "UPDATE venta_aux
			 SET CANTIDAD = '$cantidad', PRECIO_VENTA = '$precio'
			 ,   TOTAL = CANTIDAD * PRECIO_VENTA
			 WHERE ID_ARTICULO = '$codigo'";
	$insertar = mysqli_query($cnx_compras, $sql3) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
header("Location:SolSalidasForm.php"); 
?>