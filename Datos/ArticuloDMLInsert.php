<?PHP
require_once('../cnx/cnx_compras.php');
$articulo = $_REQUEST['ARTICULO'];
$id_marca = $_REQUEST['ID_MARCA'];
$grupo = $_REQUEST['ID_GRUPO'];
$pcompra = 0;
$pventa = $_REQUEST['VENTA'];
$unidad = $_REQUEST['ID_UNIDAD'];
$categoria = $_REQUEST['ID_CATEGORIA'];
$descripcion = $_REQUEST['DESCRIPCION'];
$artcode = $_REQUEST['ARTCODE'];
$marca = '';
$nombre_busqueda = '';
$sql_linea = "SELECT m.MARCA FROM marca m WHERE m.ID_MARCA = '$id_marca'";
$queryLinea = $connect->prepare($sql_linea);
$queryLinea->execute();
$lineas = $queryLinea->fetchAll(PDO::FETCH_OBJ);
if ($queryLinea->rowCount() > 0) {
	foreach ($lineas as $linea) {
		$marca = $linea->MARCA;
	}
}
$nombre_busqueda = $articulo . ' (' . $marca . ')';
if (isset($_FILES['IMAGEN']) && $_FILES['IMAGEN']['error'] === UPLOAD_ERR_OK) {
	$nombreArchivo = $_FILES['IMAGEN']['name'];
	$rutaTemporal = $_FILES['IMAGEN']['tmp_name'];
	$explode        = explode('.', $nombreArchivo);
	$extension_foto = array_pop($explode);
	$ima = str_replace('/', '-', $artcode);
	$nuevoNameFoto  = 'imagen_' . $ima . '.' . $extension_foto;
	// Crear la carpeta 'imagenes' si no existe
	$carpetaDestino = "../imagenes";
	if (!file_exists($carpetaDestino)) {
		mkdir($carpetaDestino, 0777, true);
	}
	// Renombrar el archivo para evitar duplicados o espacios
	$miDir         = opendir($carpetaDestino); //Habro el directorio
	$imagenCliente = $carpetaDestino . '/' . $nuevoNameFoto;
	// Mover el archivo a la carpeta del servidor
	if (move_uploaded_file($rutaTemporal, $imagenCliente)) {
		// Guardar la ruta en MySQL
		$sql = "INSERT INTO articulo (ARTICULO,
								NOMBRE_BUSQUEDA,
								BARCODE,
								IMAGEN,
							  ARTCODE,
							  DESCRIPCION,
							  PRECIO_COMPRA,
							  PRECIO_VENTA,
							  ID_MARCA,
							  ID_GRUPO,
							  ID_UNIDAD,
							  ID_CATEGORIA)
				VALUES (
						TRIM('$articulo'),
						TRIM('$nombre_busqueda'),
						TRIM(''),
						TRIM('$imagenCliente'),
						TRIM('$artcode'),
						TRIM('$descripcion'),
						'$pcompra',
						'$pventa',
						'$id_marca',
						'$grupo',
						'$unidad',
						'$categoria')";
		$query = $connect->prepare($sql);
		$query->execute();
		header("Location:ArticuloTabla.php");
	} else {
		echo "Error al mover el archivo al directorio.";
	}
} else {
	echo "No se seleccionó ninguna imagen o ocurrió un error en la subida.";
}
?>