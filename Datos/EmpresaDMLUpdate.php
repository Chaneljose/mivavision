<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Definiciones/Titulo.php');
require_once('../class-php-ico.php');
$codigo = $_REQUEST['CODIGO'];
$nombre = $_REQUEST['NOMBRE'];
$nit = $_REQUEST['NIT'];
$ciudad = $_REQUEST['CIUDAD'];
$direccion = $_REQUEST['DIRECCION'];
$telefono = $_REQUEST['TELEFONO'];
$gestion = $_REQUEST['GESTION'];
$mes = $_REQUEST['MES'];
$nota = $_REQUEST['NOTA'];
$tema = $_REQUEST['TEMA'];
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
		echo "El archivo TARJETA se movio correctamente al directorio";
	} else {
		echo "Error al mover el archivo al directorio.";
	}
} else {
	echo "No se seleccionó ninguna imagen o ocurrió un error en la subida 2.";
}
$sql = "UPDATE empresa
		SET NOMBRE_EMPRESA ='$nombre',
			NIT = '$nit',
			CIUDAD = '$ciudad',
			DIRECCION = '$direccion',
			TELEFONO = '$telefono',
			INICIO_GESTION = '$gestion',
			INICIO_MES = '$mes',
			NOTA = '$nota',
			TEMA = '$tema'
		WHERE ID_EMPRESA = '$codigo'";
$query = $connect -> prepare($sql); 
$query -> execute(); 
header("Location:EmpresaTabla.php");
?>