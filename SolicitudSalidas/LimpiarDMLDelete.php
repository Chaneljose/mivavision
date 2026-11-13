<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP
//session_start();
$var_usuario = $_SESSION['SES_ID'];
mysqli_select_db($cnx_compras, $database_cnx_compras);

//$sql = "TRUNCATE TABLE venta_aux";
$sql_delete = "DELETE FROM venta_aux WHERE ID_USR = '$var_usuario'";
$row_consulta = mysqli_query($cnx_compras, $sql_delete) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
header("Location:SolSalidasForm.php")
?>