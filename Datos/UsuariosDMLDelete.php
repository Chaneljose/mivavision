<?PHP 
require_once('../cnx/cnx_compras.php');
$codigo = $_REQUEST['CODIGO'];
$sql = "DELETE FROM usr
		WHERE ID_USR = '$codigo'";
$query = $connect->prepare($sql);
$query->execute();
header("Location:UsuariosTabla.php")
?>