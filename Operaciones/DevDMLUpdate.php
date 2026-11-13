<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP

mysqli_select_db($cnx_compras, $database_cnx_compras);

$id_solicitud = $_REQUEST['SOLICITUD'];
//$id_area = $_REQUEST['ID_AREA'];
$articulo = $_REQUEST['ARTICULO'];
$unidad = $_REQUEST['UNIDAD'];
$cantidad = $_REQUEST['CANTIDAD'];
$codigo = $_REQUEST['CODIGO'];
$descripcion = $_REQUEST['DESCRIPCION'];
//$fecha = $_REQUEST['FECHA'];

/*$sql1 = "UPDATE solicitud
		SET ID_AREA = '$id_area',
			FECHA = '$fecha'
		WHERE ID_SOLICITUD_COMPRA = '$id_solicitud'";
$row_consulta = mysqli_query($sql, $cnx_compras) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
*/
$sql = "UPDATE pedido
		SET ARTICULO = '$articulo',
			UNIDAD = '$unidad',
			DESCRIPCION = '$descripcion',
			CANTIDAD = '$cantidad'
		WHERE ID_PEDIDO = '$codigo'";
$row_consulta = mysqli_query($cnx_compras, $sql) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
header("Location:SolComprasTabla.php?BUSCAR=".$id_solicitud);
?>