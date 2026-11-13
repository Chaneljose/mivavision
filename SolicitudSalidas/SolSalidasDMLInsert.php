<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Funciones/Funciones.php');
require_once('../Definiciones/Titulo.php'); 
//session_start();  
$var_tipo = '';
$var_active = "ventas";
$var_usuario = $_SESSION['SES_ID'];
if(!isset($_SESSION['SES_TIPO'])){
  $var_tipo = $_SESSION['SES_TIPO'];
}  

mysqli_select_db($cnx_compras, $database_cnx_compras);
$fecha = date("Y-m-d H:i:s");
//$tipoSocio="";
$tacho="1";
$ci="5290570";
$nombre="VENTAS AL CONTADO";
$tipoVenta="CNT";
$cliente="";
$nro_nota = 0;
if(isset($_REQUEST['flexCheckDefault'])){
	$tipoVenta = "QR";
}
if(isset($_REQUEST['CLIENTE'])){
	$cliente = $_REQUEST['CLIENTE'];
}
//echo $pagoQR;

/**** AUTOMATIZAR DE MEJOR FORMA EL NRO DE SOLICTUD *******/
$sql3 = "SELECT ID_SOLICITUD_VENTA, 
				NRO_NOTA
		 FROM solicitud_venta
		 ORDER BY 1 DESC LIMIT 1";
$nota = mysqli_query($cnx_compras, $sql3) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_nota = mysqli_fetch_assoc($nota);
$num_nota = mysqli_num_rows($nota);

echo $num_nota.":";

if($num_nota != 0){
	$nro_nota = $row_nota['NRO_NOTA'] + 1;
}else{
	$nro_nota = $nro_nota + 1;
}

$sql1 = "INSERT INTO solicitud_venta( NRO_NOTA
								   , FECHA_SOLICITUD
									 , ID_USR
								   , ID_CLIENTE
								   , ID_TIPO_VENTA)
							 VALUES ('$nro_nota'
									,'$fecha'
									,'$var_usuario'
									,'$tacho'
									,'$tipoVenta')";

$consulta = mysqli_query($cnx_compras, $sql1) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$sql2 = "SELECT s.ID_SOLICITUD_VENTA
		 FROM solicitud_venta s
		 ORDER BY 1 DESC LIMIT 1";
$solicitud = mysqli_query($cnx_compras, $sql2) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_solicitud = mysqli_fetch_assoc($solicitud);
$num_solicitud = mysqli_num_rows($solicitud);

$id_solicitud_salida = $row_solicitud['ID_SOLICITUD_VENTA'];

$sql5 = "UPDATE venta_aux
SET NOMBRE_CLIENTE = '$cliente' 
WHERE ID_USR = '$var_usuario';";

$actualizar = mysqli_query($cnx_compras, $sql5) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
	
//SI NO EXISTE REGISTRO
/*$sql4 = "INSERT INTO venta( PRECIO_COMPRA
						   , PRECIO_VENTA
						   , CANTIDAD
						   , TOTAL
						   , ID_SOLICITUD_VENTA
						   , ID_CLIENTE
						   , ID_ALMACEN
						   , ID_COMPRA
						   , ID_ARTICULO
							 , ID_USR
						   , CI_TACHO_CLIENTE
						   , NOMBRE_CLIENTE)
					  SELECT PRECIO_COMPRA
					  ,		 PRECIO_VENTA
					  ,		 CANTIDAD
					  ,		 TOTAL
					  ,		 '$id_solicitud_salida'
					  ,		 '$tacho'
					  ,		 ID_ALMACEN
					  ,		 ID_COMPRA
					  ,		 ID_ARTICULO
						,    '$var_usuario'
					  ,		 '$ci'
					  ,		 NOMBRE_CLIENTE
					  FROM venta_aux
					  WHERE ID_USR = '$var_usuario' AND ID_ARTICULO > 0";*/

$sql_ventas_aux = "SELECT * FROM venta_aux WHERE ID_USR = '$var_usuario'";
$vx = mysqli_query($cnx_compras, $sql_ventas_aux) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
//$row_vx = mysqli_fetch_assoc($vx);
$num_vx = mysqli_num_rows($vx);

						
if($num_vx > 0){
	while($row_vx = $row_vx = mysqli_fetch_assoc($vx)){
		$precio_compra = $row_vx['PRECIO_COMPRA'];
		$precio_venta = $row_vx['PRECIO_VENTA'];
		$cantidad = $row_vx['CANTIDAD'];
		$total = $row_vx['TOTAL'];
		$id_almacen = $row_vx['ID_ALMACEN'];
		$id_compra = $row_vx['ID_COMPRA'];
		$id_articulo = $row_vx['ID_ARTICULO'];
		$nombre_cliente = $row_vx['NOMBRE_CLIENTE'];
		$sql4 = "INSERT INTO venta( PRECIO_COMPRA
						   , PRECIO_VENTA
						   , CANTIDAD
						   , TOTAL
						   , ID_SOLICITUD_VENTA
						   , ID_CLIENTE
						   , ID_ALMACEN
						   , ID_COMPRA
						   , ID_ARTICULO
							 , ID_USR
						   , CI_TACHO_CLIENTE
						   , NOMBRE_CLIENTE)
					  VALUES('$precio_compra'
					  ,		 '$precio_venta'
					  ,		 '$cantidad'
					  ,		 '$total'
					  ,		 '$id_solicitud_salida'
					  ,		 '$tacho'
					  ,		 '$id_almacen'
					  ,		 '$id_compra'
					  ,		 '$id_articulo'
						,    '$var_usuario'
					  ,		 '$ci'
					  ,		 '$nombre_cliente')";
		$insertar = mysqli_query($cnx_compras, $sql4) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
	}
}
//$insertar = mysqli_query($cnx_compras, $sql4) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));

//$sql = "TRUNCATE TABLE venta_aux";
$sql_delete = "DELETE FROM venta_aux WHERE ID_USR = '$var_usuario'";
$row_consulta = mysqli_query($cnx_compras, $sql_delete) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
			
?>

<?PHP head1(salidas); ?>
<body>

    	<?PHP include('../menu.php');
			  require_once('../NavsideSalidas.php');
		  	  navbar(salidas, $var_tipo, $var_active);
		  	  navside(salidas);?>

	<form class="form-horizontal" id="impre_form" name="impre_form" role="form" action="SolSalidasForm.php">
	  <div class="form-group">
	  	<br>
	  	<br>
	   	<label class="col-sm-4 control-label">IMPRIMIR COMPROBANTE: </label><input type="submit" class="btn btn-success" value="IMPRIMIR" onClick="<?PHP echo "window.open('SolSalidasImpreso_hoja_carta.php?BUSCAR=$id_solicitud_salida');";?>">
	  </div>
	</form>
</body>
</html>