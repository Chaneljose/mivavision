<?PHP 
require_once('../cnx/cnx_compras.php');
$codigo = $_REQUEST['CODIGO'];
$sql = "DELETE FROM categoria
		WHERE ID_CATEGORIA = '$codigo'";
$query = $connect -> prepare($sql); 
$query -> execute(); 
header("Location:CategoriaTabla.php")
?>