<?PHP 
require_once('../cnx/cnx_compras.php');
$codigo = $_REQUEST['CODIGO'];
$sql = "DELETE FROM unidad
		WHERE ID_UNIDAD = '$codigo'";
$query = $connect -> prepare($sql); 
$query -> execute(); 
header("Location:UnidadTabla.php")
?>