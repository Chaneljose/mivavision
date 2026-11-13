<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP

mysqli_select_db($cnx_compras, $database_cnx_compras);

$id_solicitud = $_REQUEST['ID_SOLICITUD'];

$sql = "UPDATE solicitud_compra
		SET ID_ESTADO_SOLICITUD = 'ANU'
		WHERE ID_SOLICITUD_COMPRA = '$id_solicitud'";
$row_consulta = mysqli_query($cnx_compras, $sql) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
header("Location:SolComprasTabla.php?BUSCAR=".$id_solicitud);
?>