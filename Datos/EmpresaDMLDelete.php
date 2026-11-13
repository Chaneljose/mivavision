<?PHP require_once('../cnx/cnx_compras.php');
$codigo = $_REQUEST['CODIGO'];
$sql = "TRUNCATE TABLE empresa";
$sql2 = "TRUNCATE TABLE gestion";
$query = $connect -> prepare($sql); 
$query -> execute(); 
$query2 = $connect -> prepare($sql2); 
$query2 -> execute();
header("Location:../Sesion/MenuAdm.php");
?>