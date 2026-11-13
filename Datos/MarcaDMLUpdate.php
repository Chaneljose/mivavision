<?PHP 
require_once('../cnx/cnx_compras.php');
$codigo = $_REQUEST['CODIGO'];
$marca = $_REQUEST['MARCA'];
$sql = "UPDATE marca
		SET MARCA ='$marca'
		WHERE ID_MARCA = '$codigo'";
$query = $connect -> prepare($sql); 
$query -> execute(); 
header("Location:MarcaTabla.php");
?>