<?PHP require_once('../cnx/cnx_compras.php');  ?>
<?PHP
$tacho = $_REQUEST["TACHO"];
mysqli_select_db( $cnx_compras, $database_cnx_compras);
$sql = "SELECT * 
		FROM censo2.socio s JOIN censo2.foto f ON s.ID_SOCIO = f.ID_SOCIO
	    WHERE TACHO='$tacho'";
$consulta = mysqli_query($cnx_compras, $sql) or die($mysqli_errno($cnx_compras)." : ".$mysqli_error($cnx_compras));
$row_consulta = mysqli_fetch_assoc($consulta);
$num_consulta = mysqli_num_rows($consulta);
$datos = $row_consulta["FOTOGRAFIA"];
echo $datos; 
?>