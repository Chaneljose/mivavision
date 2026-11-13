<?PHP require_once('../cnx/cnx_compras.php');
	  include_once('../Funciones/funciones.php');?>
<?PHP

mysqli_select_db($cnx_compras, $database_cnx_compras);

$id_solicitud = $_REQUEST['ID_SOLICITUD'];
$id_area = $_REQUEST['ID_AREA'];
$fecha = fecha_amd($_REQUEST['FECHA']);

$sql = "UPDATE solicitud_compra
		SET ID_AREA = '$id_area',
			FECHA_SOLICITUD = '$fecha'
		WHERE ID_SOLICITUD_COMPRA = '$id_solicitud'";
$row_consulta = mysqli_query($cnx_compras, $sql) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));

header("Location:SolComprasTabla.php?BUSCAR=".$id_solicitud);
?>