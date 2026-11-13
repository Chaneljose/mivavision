<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Definiciones/Titulo.php');?>
<?PHP

mysqli_select_db($cnx_compras, $database_cnx_compras);

$tipo_venta = 'BJA';

/**** AUTOMATIZAR DE MEJOR FORMA EL NRO DE SOLICTUD *******/
$sql4 = "SELECT ID_SOLICITUD_BAJA, 
				NRO_NOTA
		 FROM solicitud_baja
		 ORDER BY 1 DESC LIMIT 1";
$nota = mysqli_query($cnx_compras, $sql4) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_nota = mysqli_fetch_assoc($nota);
$num_nota = mysqli_num_rows($nota);

$nro_nota = 0;
if(isset($row_nota['NRO_NOTA'])){
$nro_nota = $row_nota['NRO_NOTA'] + 1;
$sql2 = "INSERT INTO solicitud_baja (NRO_NOTA,
									   FECHA_SOLICITUD,
									   ID_TIPO_VENTA)
							   VALUES ('$nro_nota',
							           now(),
									   '$tipo_venta')";
$consulta1 = mysqli_query($cnx_compras, $sql2) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
}

$sql3 = "SELECT s.ID_SOLICITUD_BAJA
		 FROM solicitud_baja s
		 ORDER BY 1 DESC LIMIT 1";
$pedido = mysqli_query($cnx_compras, $sql3) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_pedidos = mysqli_fetch_assoc($pedido);
$num_pedidos = mysqli_num_rows($pedido);

$id_solicitud_salida = 0;
if(isset($row_pedidos['ID_SOLICITUD_BAJA'])){
	$id_solicitud_salida = $row_pedidos['ID_SOLICITUD_BAJA'];



$articulo = array($_REQUEST['ARTICULO1'],
				  $_REQUEST['ARTICULO2'],
				  $_REQUEST['ARTICULO3'],
				  $_REQUEST['ARTICULO4'],
				  $_REQUEST['ARTICULO5'],
				  $_REQUEST['ARTICULO6'],
				  $_REQUEST['ARTICULO7'],
				  $_REQUEST['ARTICULO8'],
				  $_REQUEST['ARTICULO9'],
				  $_REQUEST['ARTICULO10']
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
				  $_REQUEST['CANTIDAD10']
				  );
				  
$obs = array($_REQUEST['OBS1'],
			 $_REQUEST['OBS2'],
			 $_REQUEST['OBS3'],
			 $_REQUEST['OBS4'],
			 $_REQUEST['OBS5'],
			 $_REQUEST['OBS6'],
			 $_REQUEST['OBS7'],
		     $_REQUEST['OBS8'],
			 $_REQUEST['OBS9'],
			 $_REQUEST['OBS10']
			);

	  
/*$baja = array(fecha_amd($_REQUEST['BAJA1']),
			  fecha_amd($_REQUEST['BAJA2']),
			  fecha_amd($_REQUEST['BAJA3']),
			  fecha_amd($_REQUEST['BAJA4']),
			  fecha_amd($_REQUEST['BAJA5']),
			  fecha_amd($_REQUEST['BAJA6']),
			  fecha_amd($_REQUEST['BAJA7']),
			  fecha_amd($_REQUEST['BAJA8']),
			  fecha_amd($_REQUEST['BAJA9']),
			  fecha_amd($_REQUEST['BAJA10']));*/

for($i=0;$i<count($cantidad);$i++)
{
	/*
	echo $articulo[$i];
	echo $cantidad[$i];
	echo $obs[$i];
	echo $baja[$i];*/
	
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
		$precio_venta = '0';
		
		$sql1 = "INSERT INTO baja( PRECIO_COMPRA,
								   PRECIO_VENTA,
								   CANTIDAD,
								   TOTAL,
								   FECHA_BAJA,
								   FECHA_REGISTRO,
								   OBS,
								   ID_ALMACEN,
								   ID_COMPRA,
								   ID_ARTICULO,
								   ID_SOLICITUD_BAJA)
						   VALUES ('$precio_compra',
						   		   '$precio_venta',
						   		   '$cantidad[$i]',
						   		   '$cantidad[$i]' * '$precio_compra',
								   now(),
								   now(),
								   '$obs[$i]',
								   '$almacen',
								   '$compra',
								   '$articulo[$i]',
								   '$id_solicitud_salida')";
		$insertar = mysqli_query($cnx_compras, $sql1) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
		/**/
	}
}
header("Location:BajaImpreso.php?BUSCAR=".$id_solicitud_salida); 
}else{
	header("Location:BajaForm.php");
}

?>