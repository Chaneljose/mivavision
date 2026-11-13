<?PHP 
require_once('../cnx/cnx_compras.php');
$codigo = $_REQUEST['CODIGO'];
$sql = "DELETE FROM marca
		WHERE ID_MARCA = '$codigo'";
$query = $connect -> prepare($sql); 
$query -> execute(); 
header("Location:MarcaTabla.php")
?>