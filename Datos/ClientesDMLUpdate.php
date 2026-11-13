<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Definiciones/Titulo.php');?>
<?PHP

mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['CODIGO'];
$tacho = $_REQUEST['TACHO'];
$ci = $_REQUEST['CI'];
$nombre = $_REQUEST['NOMBRE'];
$apaterno = $_REQUEST['APATERNO'];
$amaterno = $_REQUEST['AMATERNO'];
$tipo = $_REQUEST['TIPO'];

$sql = "UPDATE cliente
		SET TACHO ='$tacho',
			CI = '$ci',
			NOMBRE = '$nombre',
			APATERNO = '$apaterno',
			AMATERNO = '$amaterno',
			ID_TIPO_CLIENTE = '$tipo'
		WHERE ID_CLIENTE = '$codigo'";
$row_consulta = mysqli_query($cnx_compras, $sql) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
header("Location:ClientesTabla.php");
?>