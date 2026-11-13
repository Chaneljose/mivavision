<?PHP 
require_once('../cnx/cnx_compras.php');
$idUsuario = $_REQUEST['CODIGO'];
$login = $_REQUEST['LOGIN'];
$nombre = $_REQUEST['NOMBRE'];
$apaterno = $_REQUEST['APATERNO'];
$amaterno = $_REQUEST['AMATERNO'];
$ci =$_REQUEST['CI'];
$fechaNac = $_REQUEST['FECHA'];
$idTipoUsr = $_REQUEST['ID_TIPO_USR'];
$sql = "UPDATE usr
				SET USR = '$login',
						NOMBRE = '$nombre',
						APELLIDOP = '$apaterno',
						APELLIDOM = '$amaterno',
						FECHA_NAC = '$fechaNac',
						CI = '$ci',
						ID_TIPO_USR = '$idTipoUsr'
				WHERE ID_USR = '$idUsuario'";
	$query = $connect->prepare($sql);
	$query->execute();
header("Location:UsuariosTabla.php");
?>