<?PHP
require_once('../cnx/cnx_compras.php');
require_once('../class-php-ico.php');
//mysqli_select_db($cnx_compras, $database_cnx_compras);

$nombre_empresa = ($_REQUEST['NOMBRE']);
$nit = $_REQUEST['NIT'];
$ciudad = $_REQUEST['CIUDAD'];
$direccion = $_REQUEST['DIRECCION'];
$telefono = $_REQUEST['TELEFONO'];
$gestion = $_REQUEST['GESTION'];
$mes = $_REQUEST['MES'];
$tema = $_REQUEST['TEMA'];
$nota = $_REQUEST['NOTA'];
$nombre_logo = "";
$nombre_tarjeta = "";

if (isset($_FILES['LOGO']) && $_FILES['LOGO']['error'] === UPLOAD_ERR_OK) {
	$nombreArchivo = $_FILES['LOGO']['name'];
	$nombreArchivoIco = $_FILES['LOGO']['name'];
	$rutaTemporal = $_FILES['LOGO']['tmp_name'];
	$rutaTemporalIco = $_FILES['LOGO']['tmp_name'];
	$explode        = explode('.', $nombreArchivo);
	$explodeIco        = explode('.', $nombreArchivoIco);
	$extension_foto = array_pop($explode);
	$extension_fotoIco = array_pop($explodeIco);
	$nuevoNameFoto  = 'logo_empresa.' . $extension_foto;
	$nuevoNameIcono = 'favicon.ico';
	// Crear la carpeta 'Iconos' si no existe
	$carpetaDestino = "../Iconos";
	if (!file_exists($carpetaDestino)) {
		mkdir($carpetaDestino, 0777, true);
	}
	// Renombrar el archivo para evitar duplicados o espacios
	$miDir         = opendir($carpetaDestino); //Habro el directorio
	$imagenCliente = $carpetaDestino . '/' . $nuevoNameFoto;
	$imagenIcono = $carpetaDestino . '/' . $nuevoNameIcono;
	// Tamaños estándar recomendados para incluir en el archivo .ico
	$tamanios = [[16, 16], [32, 32], [48, 48], [64, 64]];
	try {
		// Instanciar la clase pasándole la ruta temporal y los tamaños
		$icoObj = new PHP_ICO($rutaTemporalIco, $tamanios);
		// Guardar el archivo final .ico
		$icoObj->save_ico($imagenIcono);
		// Mover el archivo a la carpeta del servidor
	} catch (Exception $e) {
		echo "Error al procesar la imagen: " . $e->getMessage();
	}
	if (move_uploaded_file($rutaTemporal, $imagenCliente)) {
		$nombre_logo = $imagenCliente;
		echo "El archivo LOGO se movio correctamente al directorio";
	} else {
		echo "Error al mover el archivo al directorio.";
	}
} else {
	echo "No se seleccionó ninguna imagen o ocurrió un error en la subida 1.";
}
if (isset($_FILES['TARJETA']) && $_FILES['TARJETA']['error'] === UPLOAD_ERR_OK) {

	$nombreTarjeta = $_FILES['TARJETA']['name'];
	$rutaTarjeta = $_FILES['TARJETA']['tmp_name'];
	$explodeTarjeta = explode('.', $nombreTarjeta);
	$extension_Tarjeta = array_pop($explodeTarjeta);
	$nuevoNameTarjeta = 'logo_cabecera.' . $extension_Tarjeta;
	// Crear la carpeta 'Iconos' si no existe
	$carpetaDestino = "../Iconos";
	if (!file_exists($carpetaDestino)) {
		mkdir($carpetaDestino, 0777, true);
	}
	// Renombrar el archivo para evitar duplicados o espacios
	$miDir = opendir($carpetaDestino); //Habro el directorio
	$imagenTarjeta = $carpetaDestino . '/' . $nuevoNameTarjeta;
	if (move_uploaded_file($rutaTarjeta, $imagenTarjeta)) {
		$nombre_tarjeta = $imagenTarjeta;
		echo "El archivo TARJETA se movio correctamente al directorio";
	} else {
		echo "Error al mover el archivo al directorio.";
	}
} else {
	echo "No se seleccionó ninguna imagen o ocurrió un error en la subida 2.";
}
$sqlEmpresa = "INSERT INTO empresa (ID_EMPRESA, 
								NOMBRE_EMPRESA,
							  NIT,
							  CIUDAD,
							  DIRECCION,
							  TELEFONO,
							  INICIO_GESTION,
							  INICIO_MES,
								TEMA,
								NOTA,
								LOGO,
								LOGO_CABECERA)
					VALUES (
						'1',
						'$nombre_empresa',
						'$nit',
						'$ciudad',
						'$direccion',
						'$telefono',
						'$gestion',
						'$mes',
						'$tema',
						'$nota',
						'$nombre_logo',
						'$nombre_tarjeta')";
$sqlGestion = "INSERT INTO gestion (ID_GESTION)
									VALUES (
											'$gestion')";
$sqlGrupo = "INSERT INTO grupo (ID_GRUPO, GRUPO) VALUES ('PROD', 'PRODUCTO'), ('SERV', 'SERVICIO');";
$sqlMes = "INSERT INTO mes (ID_MES, MES) VALUES (1, 'ENERO'), (2, 'FEBRERO'), (3, 'MARZO'), (4, 'ABRIL'), (5, 'MAYO'), (6, 'JUNIO'),
										(7, 'JULIO'), (8, 'AGOSTO'), (9, 'SEPTIEMBRE'), (10, 'OCTUBRE'), (11, 'NOVIEMBRE'), (12, 'DICIEMBRE');";
//$sqlTipoUsr = "INSERT INTO tipo_usr (ID_TIPO_USR, TIPO_USR) VALUES (1, 'ADMINISTRADOR'), (2, 'VENTAS');";
$sqlTipoVenta = "INSERT INTO tipo_venta (ID_TIPO_VENTA, TIPO) VALUES ('BJA', 'BAJA'), ('CNT', 'CONTADO'), ('CRD', 'CREDITO'), 
													('CSM', 'CONSUMO'), ('DEV', 'DEVOLUCION'), ('QR', 'PAGO QR');";
$sqlUnidad = "INSERT INTO unidad (ID_UNIDAD, UNIDAD) VALUES ('UNI', 'UNIDAD');";
$sqlCliente = "INSERT INTO cliente (ID_CLIENTE, TACHO, CI, NOMBRE, APATERNO, AMATERNO, ID_TIPO_CLIENTE) VALUES (1, 1, '1', 'VENTAS CONTADO', '', '', 'NS');";
$sqlTipoCliente = "INSERT INTO tipo_cliente (ID_TIPO_CLIENTE, TIPO) VALUES ('NS', 'NO SOCIO'), ('S', 'SOCIO');";
$queryEmpresa = $connect -> prepare($sqlEmpresa); 
$queryEmpresa -> execute(); 
$queryGestion = $connect -> prepare($sqlGestion); 
$queryGestion -> execute();
$sqlHayGrupo = "SELECT * FROM grupo";
$queryHayGrupo = $connect -> prepare($sqlHayGrupo); 
$queryHayGrupo -> execute();
if($queryHayGrupo -> rowCount() <= 0){
	$queryGrupo = $connect -> prepare($sqlGrupo); 
	$queryGrupo -> execute();
	$queryMes = $connect -> prepare($sqlMes); 
	$queryMes -> execute();
	//$queryTipoUsr = $connect -> prepare($sqlTipoUsr); 
	//$queryTipoUsr -> execute();
	$queryTipoVenta = $connect -> prepare($sqlTipoVenta); 
	$queryTipoVenta -> execute();
	$queryUnidad = $connect -> prepare($sqlUnidad); 
	$queryUnidad -> execute();
	$queryTipoCliente = $connect -> prepare($sqlTipoCliente); 
	$queryTipoCliente -> execute();
	$queryCliente = $connect -> prepare($sqlCliente); 
	$queryCliente -> execute();
}
header("Location:EmpresaTabla.php");
?>