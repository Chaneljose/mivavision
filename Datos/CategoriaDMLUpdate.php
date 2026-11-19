<?PHP 
require_once('../cnx/cnx_compras.php');
$codigo = $_REQUEST['CODIGO'];
$categoria = $_REQUEST['CATEGORIA'];
$sql = "UPDATE categoria
		SET NOMBRE ='$categoria'
		WHERE ID_CATEGORIA = '$codigo'";
$query = $connect -> prepare($sql); 
$query -> execute(); 
header("Location:CategoriaTabla.php");
?>