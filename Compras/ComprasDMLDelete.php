<?PHP
require_once('../cnx/cnx_compras.php');
$nro_factura = $_REQUEST['BUSCAR'];
$codigo = $_REQUEST['CODIGO'];
$sql = "DELETE FROM compra c
		WHERE c.NRO_FACTURA = '$nro_factura' AND c.ID_ARTICULO = '$codigo'";
$query = $connect->prepare($sql);
$query->execute();
header("Location:ComprasTabla.php?BUSCAR=".$nro_factura);
?>