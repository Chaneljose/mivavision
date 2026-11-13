<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP

mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['CODIGO'];

$sql = "DELETE FROM pedido
		WHERE ID_PEDIDO = '$codigo'";
$row_consulta = mysqli_query($cnx_compras, $sql) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
header("Location:SolComprasTabla.php")
?>