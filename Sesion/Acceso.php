<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Funciones/Funciones.php');
require_once('../Definiciones/Titulo.php'); 
//Inicio de variables de sesión
//session_start();
if (isset($_SESSION)) {
	$_SESSION['TIEMPO'] = time();
}
//Recibir los datos ingresados en el formulario
$usr = $_POST['USR'];
$pswr = $_POST['PSWR'];

$var_usr= '';
$var_pswr = '';
$var_tipo = '';
$var_id = "";

$sql = "SELECT ID_USR, USR, PSWR, ID_TIPO_USR FROM usr WHERE USR='$usr'";
$query = $connect -> prepare($sql); 
$query -> execute(); 
$results = $query -> fetchAll(PDO::FETCH_OBJ);

if($query -> rowCount() > 0){
	foreach($results as $result) {
		$var_id = $result->ID_USR;
		$var_usr= $result->USR;
		$var_pswr= $result->PSWR;
		$var_tipo= $result->ID_TIPO_USR;
	}
}

if($var_usr == $usr && password_verify($pswr, $var_pswr))
{
	//echo password_verify($pswr, $var_pswr);
	//session_start();
	//session_set_cookie_params(0, "/", $_SERVER["HTTP_HOST"], 0);
	/*if (isset($_SESSION)) {
		$_SESSION['TIEMPO'] = time();
	}*/
	if($var_tipo==1) //ADMINISTRADOR
	{
		$_SESSION['SES_USR'] = $var_usr;
		$_SESSION['SES_PSWR'] = $var_pswr;
		$_SESSION['SES_TIPO'] = $var_tipo;
		$_SESSION['SES_ID'] = $var_id;
		
		
		header("Location: MenuAdm.php");
	}
	else
	if($var_tipo==2) //VENTAS 
	{
		$_SESSION['SES_USR'] = $var_usr;
		$_SESSION['SES_PSWR'] = $var_pswr;
		$_SESSION['SES_TIPO'] = $var_tipo;
		$_SESSION['SES_ID'] = $var_id;
		
		header("Location: MenuVenta.php");
	}
	else
	if($var_tipo==3) //CAJA
	{
		$_SESSION['SES_USR'] = $var_usr;
		$_SESSION['SES_PSWR'] = $var_pswr;
		$_SESSION['SES_TIPO'] = $var_tipo;
		$_SESSION['SES_ID'] = $var_id;
		
		header("Location: MenuCaja.php");
	}
	else
	if($var_tipo==4) //CONTABILIDAD
	{
		$_SESSION['SES_USR'] = $var_usr;
		$_SESSION['SES_PSWR'] = $var_pswr;
		$_SESSION['SES_TIPO'] = $var_tipo;
		$_SESSION['SES_ID'] = $var_id;
		
		header("Location: MenuCont.php");
	}
	else
	if($var_tipo==5) //VALES
	{
		$_SESSION['SES_USR'] = $var_usr;
		$_SESSION['SES_PSWR'] = $var_pswr;
		$_SESSION['SES_TIPO'] = $var_tipo;
		$_SESSION['SES_ID'] = $var_id;
		
		header("Location: MenuVale.php");
	}
}
else
{ 
	?>
	<script language = javascript>
		alert("EL USUARIO O LA CLAVE SON INCORRECTOS, POR FAVOR INTENTELO DE NUEVO")
		self.location = "../index.html"
	</script>';
<?PHP 
}
?>