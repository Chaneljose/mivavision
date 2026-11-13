<?PHP require_once('../cnx/cnx_compras.php');
$id_articulo = $_REQUEST['ID_ARTICULO'];
$cantidad = $_REQUEST['CANTIDAD'];
$precio_factura = $_REQUEST['PRECIO_FACTURA'];
$precio_venta = $_REQUEST['PRECIO_VENTA'];
$sql = "UPDATE compra_aux
		SET CANTIDAD = '$cantidad'
		,	PRECIO_FACTURA = '$precio_factura'
		,	VALOR = '$cantidad' * '$precio_factura'
		, 	TOTAL=(('$cantidad' * '$precio_factura') + '0') - '0'
		WHERE ID_ARTICULO = '$id_articulo'";
$queryCompraAux = $connect->prepare($sql);
$queryCompraAux->execute();
header("Location:ComprasForm.php");
?>