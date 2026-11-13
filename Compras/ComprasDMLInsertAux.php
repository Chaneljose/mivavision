<?PHP 
require_once('../cnx/cnx_compras.php');
include_once('../Funciones/funciones.php');
//session_start();
$id_cliente = $_REQUEST['ID_CLIENTE'];
$id_articulo = (int)$_REQUEST['ARTICULO'];
$var_usuario = $_SESSION['SES_ID'];
$cantidad = $_REQUEST['CANTIDAD'];
$precio_compra = $_REQUEST['PRECIO_FACTURA'];
$precio_venta = $_REQUEST['PRECIO_VENTA'];
$fecha_caducidad = fecha_amd($_REQUEST['CADUCO']);
$sql = "INSERT INTO compra_aux( CANTIDAD
			, PRECIO_FACTURA
			, PRECIO_VENTA
			, UM_IMPUESTO
			, VALOR
			, ICE
			, DESCUENTO
			, TOTAL
			, FECHA_CADUCIDAD
			, ID_ARTICULO
			, ID_USR)
		VALUES ('$cantidad'
			,'$precio_compra'
			,'$precio_venta'
			,0
			,'$cantidad' * '$precio_compra'
			,0
			,0
			,'$cantidad' * '$precio_compra'
			,'$fecha_caducidad'
			,'$id_articulo'
			,'$var_usuario')";
	try{
		$query = $connect->prepare($sql);
		$query->execute();
		header("Location:ComprasForm.php"); 
	}catch(PDOException $e){
		echo '<script language=javascript>
        alert("EL PRODUCTO INGRESADO YA EXISTE, NO SE REALIZARON MODIFICACIONES !!")
        location.href = "ComprasForm.php";
    </script>';
	}
?>