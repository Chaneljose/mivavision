<?PHP
require_once('../cnx/cnx_compras.php');
include_once('../Funciones/funciones.php');

//session_start();
//mysqli_select_db($cnx_compras, $database_cnx_compras);

$var_usuario = $_SESSION['SES_ID'];
if (!empty($_REQUEST['ARTICULO'])) {
	$id_articulo = (int)$_REQUEST['ARTICULO'];
	$sql1 = "SELECT c.PRECIO_FACTURA PRECIO_COMPRA
	,		c.NRO_FACTURA
	,		 a.PRECIO_VENTA
	,		 a.ID_ARTICULO
	,		 a.ARTICULO
	FROM articulo a JOIN compra c ON c.ID_ARTICULO = a.ID_ARTICULO
	WHERE a.ID_ARTICULO = '$id_articulo' ORDER BY c.NRO_FACTURA DESC LIMIT 1";
	/*$nota = mysqli_query($cnx_compras, $sql1) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
	$row_nota = mysqli_fetch_assoc($nota);
	$num_nota = mysqli_num_rows($nota);*/
	$queryNota = $connect->prepare($sql);
	$queryNota->execute();
	$notas = $queryNota->fetchAll(PDO::FETCH_OBJ);

	$sql2 = "SELECT * FROM stock s WHERE s.ID_ARTICULO = '$id_articulo'";
	/*$cant_stock = mysqli_query($cnx_compras, $sql2) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
	$row_cant_stock = mysqli_fetch_assoc($cant_stock);
	$num_cant_stock = mysqli_num_rows($cant_stock);*/
	$queryCantStock = $connect->prepare($sql);
	$queryCantStock->execute();
	$cantStocks = $queryCantStock->fetchAll(PDO::FETCH_OBJ);

	$precio_compra = 0;
	$precio_venta = 0;
	$cantidad = 0;
	$id_cliente = 1;

	/*$cantidad_stock = (int)$row_cant_stock['SALDO'];*/

	if ($queryCantStock->rowCount() > 0) {
		foreach ($cantStocks as $cantStock) {
			$cantidad_stock = $cantStock->SALDO;
		}
	}

	if (isset($row_nota['PRECIO_COMPRA'])) {
		$precio_compra = $row_nota['PRECIO_COMPRA'];
	}
	if (isset($row_nota['PRECIO_VENTA'])) {
		$precio_venta = $row_nota['PRECIO_VENTA'];
	}

	if (!empty($_REQUEST['CANTIDAD'])) {
		$cantidad = (int)$_REQUEST['CANTIDAD'];
	} else {
		$cantidad = 1;
	}

	$sql = "SELECT a.ID_ALMACEN,
					a.ID_COMPRA,
					a.ID_ARTICULO,
					c.PRECIO_COMPRA,
					c.PRECIO_VENTA
			FROM almacen a JOIN articulo c ON a.ID_ARTICULO = c.ID_ARTICULO
			WHERE a.ID_ARTICULO ='$id_articulo'
			ORDER BY 1 DESC LIMIT 1";
	$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras) . " : " . mysqli_error($cnx_compras));
	$row_pedido = mysqli_fetch_assoc($pedido);

	$almacen = 0;
	$compra = 0;
	if (isset($row_pedido['ID_ALMACEN'])) {
		$almacen = $row_pedido['ID_ALMACEN'];
	}
	if (isset($row_pedido['ID_COMPRA'])) {
		$compra = $row_pedido['ID_COMPRA'];
	}

	$sql4 = "INSERT INTO venta_aux( PRECIO_COMPRA
								, PRECIO_VENTA
								, CANTIDAD
								, TOTAL
								, ID_CLIENTE
								, ID_ALMACEN
								, ID_COMPRA
								, ID_ARTICULO
								, ID_USR
								, ID_TIPO_VENTA)
							VALUES ('$precio_compra'
								,'$precio_venta'
								,'$cantidad'
								,'$cantidad' * '$precio_venta'
								,'$id_cliente'
								,'$almacen'
								,'$compra'
								,'$id_articulo'
								,'$var_usuario'
								,'')";
	try {

		if ($cantidad_stock != 0) {
			$insertar = mysqli_query($cnx_compras, $sql4) or die(mysqli_errno($cnx_compras) . " : " . mysqli_error($cnx_compras));
			header("Location:SolSalidasForm.php");
		} else {
			echo '<script language=javascript>
						alert("PRODUCTO SIN STOCK, REALICE UNA COMPRA PRIMERO !!")
						location.href = "SolSalidasForm.php";
				</script>';
		}
		//header("Location:SolSalidasForm.php"); 
	} catch (Exception $e) {
		echo '<script language=javascript>
				alert("EL PRODUCTO INGRESADO YA EXISTE, NO SE REALIZARON MODIFICACIONES !!")
				location.href = "SolSalidasForm.php";
		</script>';
	}
} else {
	echo '<script language=javascript>
						alert("DEBE SELECCIONAR UN PRODUCTO, INTENTE DE NUEVO !!")
						location.href = "SolSalidasForm.php";
				</script>';
}
