<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP

mysqli_select_db($cnx_compras, $database_cnx_compras);

$id_compra = $_REQUEST['ID_COMPRA'];
$id_articulo = $_REQUEST['ID_ARTICULO'];
$nro_factura = $_REQUEST['NRO_FACTURA'];
$cantidad = $_REQUEST['CANTIDAD'];
$precio_factura = $_REQUEST['PRECIO_FACTURA'];
$precio_venta = $_REQUEST['PRECIO_VENTA'];
$marcas = $_REQUEST['MARCA'];
/*$ice = $_REQUEST['ICE'];
$descuento = $_REQUEST['DESCUENTO'];*/


$sql = "UPDATE compra
		SET ID_ARTICULO = '$id_articulo'
		,	CANTIDAD = '$cantidad'
		,	PRECIO_FACTURA = '$precio_factura'
		,	VALOR = '$cantidad' * '$precio_factura'
		,	ICE = '0'
		,	DESCUENTO ='0' 
		, 	TOTAL=(('$cantidad' * '$precio_factura') + '0') - '0'
		WHERE ID_COMPRA = '$id_compra'";
$row_consulta = mysqli_query($cnx_compras, $sql) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));

$sql2 = "UPDATE articulo SET PRECIO_VENTA = '$precio_venta' WHERE ID_ARTICULO = '$id_articulo'";
$row_consulta2 = mysqli_query($cnx_compras, $sql2) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
header("Location:InventarioInicial.php?MARCA=".$marcas);
?>