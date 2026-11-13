<?PHP require_once('../cnx/cnx_compras.php');
$id_compra = $_REQUEST['ID_COMPRA'];
$id_articulo = $_REQUEST['ID_ARTICULO'];
$nro_factura = $_REQUEST['NRO_FACTURA'];
$cantidad = $_REQUEST['CANTIDAD'];
$precio_factura = $_REQUEST['PRECIO_FACTURA'];
$sql = "UPDATE compra
			SET ID_ARTICULO = '$id_articulo'
			,	CANTIDAD = '$cantidad'
			,	PRECIO_FACTURA = '$precio_factura'
			,	VALOR = '$cantidad' * '$precio_factura'
			,	ICE = '0'
			,	DESCUENTO ='0' 
			, 	TOTAL=(('$cantidad' * '$precio_factura') + '0') - '0'
			WHERE ID_COMPRA = '$id_compra'";
$query = $connect->prepare($sql);
$query->execute();
header("Location:ComprasTabla.php?BUSCAR=".$nro_factura);
?>