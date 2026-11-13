<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Funciones/Funciones.php');
	  require_once('../Definiciones/Titulo.php'); ?>
<?PHP

mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['CODIGO'];
$buscar = $_REQUEST['BUSCAR'];


$id_solicitud = $_REQUEST['SOLICITUD'];
$articulo = $_REQUEST['ARTICULO'];
$unidad = $_REQUEST['UNIDAD'];
$cantidad = $_REQUEST['CANTIDAD'];

$descripcion = $_REQUEST['DESCRIPCION'];
$sql3 = "UPDATE venta
			 SET CANTIDAD = '$cantidad'
			 ,   TOTAL = CANTIDAD * PRECIO_VENTA
			 WHERE ID_ARTICULO = '$codigo' AND ID_SOLICITUD_VENTA = '$buscar'";
	$insertar = mysqli_query($cnx_compras, $sql3) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
header("Location:SolSalidasTabla.php?BUSCAR=".$buscar); 
?>