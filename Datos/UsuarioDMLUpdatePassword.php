<?PHP 
require_once('../cnx/cnx_compras.php');
$idUsuario = $_REQUEST['CODIGO'];
$password = $_REQUEST['PASSWORD'];
$password2 = $_REQUEST['PASSWORD2'];
if($password == $password2){
	$passwd = password_hash($password, PASSWORD_DEFAULT);
	$sql = "UPDATE usr SET PSWR ='$passwd' WHERE ID_USR = '$idUsuario'";
	$query = $connect->prepare($sql);
	$query->execute();
	echo '<script language = javascript>
					alert("Operacion realizada con exito !!")
					self.location = "UsuariosTabla.php"
				</script>';
}else{
	echo '<script language = javascript>
					alert("Los contraseñas no son iguales, intente nuevamente !!")
					self.location = "UsuariosTabla.php"
				</script>';
}
?>