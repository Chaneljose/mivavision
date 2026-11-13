<?php
require_once('../cnx/cnx_compras.php');  
mysqli_select_db($cnx_compras, $database_cnx_compras);

$texto = $_GET['search'];
$sql = " SELECT a.NOMBRE_BUSQUEDA AS value FROM articulo a WHERE a.NOMBRE_BUSQUEDA LIKE '%$texto%' "; 
$result = $mysqli->query($conexion, $sql);

while ($myrow = $result->fetch_array(MYSQLI_ASSOC)) {
    $resultado[]=$myrow;
}

echo json_encode($resultado);
?>