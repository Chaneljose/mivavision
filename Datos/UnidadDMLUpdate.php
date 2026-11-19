<?PHP 
require_once('../cnx/cnx_compras.php');
$codigo = $_REQUEST['CODIGO'];
$unidad = $_REQUEST['UNIDAD'];
$sql = "UPDATE unidad
		SET NOMBRE ='$unidad'
		WHERE ID_UNIDAD = '$codigo'";
$query = $connect -> prepare($sql); 
$query -> execute(); 
header("Location:UnidadTabla.php");
?>