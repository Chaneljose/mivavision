<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Definiciones/Titulo.php');?>
<?PHP

mysqli_select_db($cnx_compras, $database_cnx_compras);

$tacho = $_REQUEST['TACHO'];
$ci = $_REQUEST['CI'];
$nombre = $_REQUEST['NOMBRE'];
$apaterno = $_REQUEST['APATERNO'];
$amaterno = $_REQUEST['AMATERNO'];
$tipo = $_REQUEST['TIPO'];

$sql = "INSERT INTO cliente (TACHO,
							 CI,
							 NOMBRE,
							 APATERNO,
							 AMATERNO,
							 ID_TIPO_CLIENTE)
				VALUES (
						TRIM('$tacho'),
						TRIM('$ci'),
						TRIM('$nombre'),
						TRIM('$apaterno'),
						TRIM('$amaterno'),
						TRIM('$tipo'))";
$row_consulta = mysqli_query($cnx_compras, $sql) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
header("Location:ClientesTabla.php");
?>