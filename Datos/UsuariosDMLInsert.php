<?PHP
require_once('../cnx/cnx_compras.php');
$login = $_REQUEST['LOGIN'];
$password = password_hash($_REQUEST['PASSWORD'], PASSWORD_DEFAULT);
$nombre = $_REQUEST['NOMBRE'];
$apaterno = $_REQUEST['APATERNO'];
$amaterno = $_REQUEST['AMATERNO'];
$fecha_nac = $_REQUEST['FECHANAC'];
$ci = $_REQUEST['CI'];
$tipo = $_REQUEST['TIPO'];
$sql = "INSERT INTO usr (USR,
							 PSWR,
							 NOMBRE,
							 APELLIDOP,
							 APELLIDOM,
							 FECHA_NAC,
							 CI,
							 ID_TIPO_USR)
				VALUES (
						TRIM('$login'),
						TRIM('$password'),
						TRIM('$nombre'),
						TRIM('$apaterno'),
						TRIM('$amaterno'),
						TRIM('$fecha_nac'),
						TRIM('$ci'),
						TRIM('$tipo'))";
$sql2 = "SELECT u.USR FROM usr u WHERE u.USR = '$login'";
$query = $connect->prepare($sql2);
$query->execute();
$usuarios = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
	echo '<script language = javascript>
					alert("El nombre de usuario ' . $login . ' ya existe, debe cambiar por uno nuevo !!")
					self.location = "UsuariosTabla.php"
				</script>';
} else {
	$queryU = $connect->prepare($sql);
	$queryU->execute();
	echo '<script language = javascript>                  
					self.location = "UsuariosTabla.php"
				</script>';
}
?>