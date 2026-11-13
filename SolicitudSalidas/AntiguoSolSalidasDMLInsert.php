<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP include_once('../Funciones/funciones.php');?>
<?PHP

mysqli_select_db($cnx_compras, $database_cnx_compras);

$id_cliente = $_REQUEST['ID_CLIENTE'];
$tipo_venta = $_REQUEST['TIPO_VENTA'];
$var_credito = 'CRD';
$var_contado = 'CNT';
$var_consumo = 'CSM';
//$fecha = fecha_amd($_REQUEST['FECHA']);
//$estado = 'ACT';

/**** AUTOMATIZAR DE MEJOR FORMA EL NRO DE SOLICTUD *******/
$sql4 = "SELECT ID_SOLICITUD_VENTA, 
				NRO_NOTA
		 FROM solicitud_venta
		 ORDER BY 1 DESC LIMIT 1";
$nota = mysqli_query($cnx_compras, $sql4) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_nota = mysqli_fetch_assoc($nota);
$num_nota = mysqli_num_rows($nota);

$nro_nota = $row_nota['NRO_NOTA'] + 1;

if($id_cliente == '3')
{
	$sql2 = "INSERT INTO solicitud_venta (NRO_NOTA,
										   FECHA_SOLICITUD,
										   ID_CLIENTE,
										   ID_TIPO_VENTA)
								   VALUES ('$nro_nota',
										   now(),
										   '$id_cliente',
										   '$var_credito')";
	$consulta1 = mysqli_query($cnx_compras, $sql2) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
}
else
{
	$sql2 = "INSERT INTO solicitud_venta (NRO_NOTA,
										   FECHA_SOLICITUD,
										   ID_CLIENTE,
										   ID_TIPO_VENTA)
								   VALUES ('$nro_nota',
										   now(),
										   '$id_cliente',
										   '$tipo_venta')";
	$consulta1 = mysqli_query($cnx_compras, $sql2) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
}

$sql3 = "SELECT s.ID_SOLICITUD_VENTA
		 FROM solicitud_venta s
		 ORDER BY 1 DESC LIMIT 1";
$pedido = mysqli_query($cnx_compras, $sql3) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_pedidos = mysqli_fetch_assoc($pedido);
$num_pedidos = mysqli_num_rows($pedido);

$id_solicitud_salida = $row_pedidos['ID_SOLICITUD_VENTA'];

$articulo = array($_REQUEST['ARTICULO1'],
				  $_REQUEST['ARTICULO2'],
				  $_REQUEST['ARTICULO3'],
				  $_REQUEST['ARTICULO4'],
				  $_REQUEST['ARTICULO5'],
				  $_REQUEST['ARTICULO6'],
				  $_REQUEST['ARTICULO7'],
				  $_REQUEST['ARTICULO8'],
				  $_REQUEST['ARTICULO9'],
				  $_REQUEST['ARTICULO10'],
				  $_REQUEST['ARTICULO11'],
				  $_REQUEST['ARTICULO12'],
				  $_REQUEST['ARTICULO13'],
				  $_REQUEST['ARTICULO14'],
				  $_REQUEST['ARTICULO15']
				  );

$cantidad = array($_REQUEST['CANTIDAD1'],
				  $_REQUEST['CANTIDAD2'],
				  $_REQUEST['CANTIDAD3'],
				  $_REQUEST['CANTIDAD4'],
				  $_REQUEST['CANTIDAD5'],
				  $_REQUEST['CANTIDAD6'],
				  $_REQUEST['CANTIDAD7'],
				  $_REQUEST['CANTIDAD8'],
				  $_REQUEST['CANTIDAD9'],
				  $_REQUEST['CANTIDAD10'],
				  $_REQUEST['CANTIDAD11'],
				  $_REQUEST['CANTIDAD12'],
				  $_REQUEST['CANTIDAD13'],
				  $_REQUEST['CANTIDAD14'],
				  $_REQUEST['CANTIDAD15']
				  );
				  
for($i=0;$i<count($cantidad);$i++)
{
	/*echo $articulo[$i];
	echo $cantidad[$i];*/
	
	if($cantidad[$i]>0)
	{
		$sql ="SELECT a.ID_ALMACEN,
					  a.ID_COMPRA,
					  a.ID_ARTICULO,
					  c.PRECIO_COMPRA,
					  c.PRECIO_VENTA
			   FROM almacen a JOIN articulo c ON a.ID_ARTICULO = c.ID_ARTICULO
			   WHERE a.ID_ARTICULO ='$articulo[$i]'
			   ORDER BY 1 DESC LIMIT 1";
		$pedido = mysqli_query($cnx_compras, $sql) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
		$row_pedido = mysqli_fetch_assoc($pedido);
		
		$almacen = $row_pedido['ID_ALMACEN'];
		$compra = $row_pedido['ID_COMPRA'];
		$precio_compra = $row_pedido['PRECIO_COMPRA'];
		$precio_venta = $row_pedido['PRECIO_VENTA'];
		
		if($tipo_venta == $var_contado && $id_cliente != '2')
		{
			$sql1 = "INSERT INTO venta(PRECIO_COMPRA,
									   PRECIO_VENTA,
									   CANTIDAD,
									   TOTAL,
									   ID_SOLICITUD_VENTA,
									   ID_CLIENTE,
									   ID_ALMACEN,
									   ID_COMPRA,
									   ID_ARTICULO)
							   VALUES ('$precio_compra',
									   '$precio_venta',
									   '$cantidad[$i]',
									   '$cantidad[$i]' * '$precio_venta',
									   '$id_solicitud_salida',
									   '$id_cliente',
									   '$almacen',
									   '$compra',
									   '$articulo[$i]')";
			$insertar = mysqli_query($cnx_compras, $sql1) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
			header("Location:SolSalidasImpreso.php?BUSCAR=".$id_solicitud_salida); 
		}
		else
		if($tipo_venta == $var_credito && $id_cliente != '2')
		{
			$sql1 = "INSERT INTO venta_credito(PRECIO_COMPRA,
											   PRECIO_VENTA,
											   CANTIDAD,
											   TOTAL,
											   ID_SOLICITUD_VENTA,
											   ID_CLIENTE,
											   ID_ALMACEN,
											   ID_COMPRA,
											   ID_ARTICULO)
									   VALUES ('$precio_compra',
											   '$precio_venta',
											   '$cantidad[$i]',
											   '$cantidad[$i]' * '$precio_venta',
											   '$id_solicitud_salida',
											   '$id_cliente',
											   '$almacen',
											   '$compra',
											   '$articulo[$i]')";
			$insertar = mysqli_query($cnx_compras, $sql1) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
			header("Location:SolSalidasImpresoCredito.php?BUSCAR=".$id_solicitud_salida); 
		}
		else
		if($id_cliente == '2')
		{
			$sql1 = "INSERT INTO vale(PRECIO_COMPRA,
								   PRECIO_VENTA,
								   CANTIDAD,
								   TOTAL,
								   ID_ALMACEN,
								   ID_COMPRA,
								   ID_ARTICULO,
								   ID_SOLICITUD_VENTA,
								   ID_CLIENTE,
								   OBS)
						   VALUES ('$precio_compra',
						   		   '$precio_venta',
						   		   '$cantidad[$i]',
						   		   '$cantidad[$i]' * '$precio_compra',
								   '$almacen',
								   '$compra',
								   '$articulo[$i]',
								   '$id_solicitud_salida',
								   '$id_cliente',
								   '$obs')";
			$insertar = mysqli_query($cnx_compras, $sql1) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
			header("Location:SolSalidasImpresoVale.php?BUSCAR=".$id_solicitud_salida); 
		}
		/*$sql = "UPDATE almacen a
				SET a.SALIDA = '$cantidad[$i]', 
    				a.saldo = a.saldo - '$cantidad[$i]'
				WHERE a.ID_ARTICULO='$articulo[$i]'
				ORDER BY id_almacen DESC LIMIT 1";
		$pedido = mysqli_query($cnx_compras, $sql) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
		*/
	}
}
?>