<?PHP
require_once('../cnx/cnx_compras.php');
$codigo = $_REQUEST['CODIGO'];
$sql = "DELETE FROM articulo
		WHERE ID_ARTICULO = '$codigo'";
$query = $connect->prepare($sql);
$query->execute();
header("Location:ArticuloTabla.php")
?>