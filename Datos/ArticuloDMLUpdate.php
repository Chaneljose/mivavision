<?PHP
require_once('../cnx/cnx_compras.php');
$codigo = $_REQUEST['CODIGO'];
$artcode = $_REQUEST['ARTCODE'];
$articulo = $_REQUEST['ARTICULO'];
$id_marca = $_REQUEST['ID_MARCA'];
$grupo = $_REQUEST['ID_GRUPO'];
$pcompra = 0;
$pventa = $_REQUEST['VENTA'];
$unidad = $_REQUEST['ID_UNIDAD'];
$descripcion = $_REQUEST['DESCRIPCION'];
$sql = "SELECT ID_MARCA, MARCA
	  FROM marca
		WHERE id_marca = '$id_marca'";
$nombreMarca = '';
$query = $connect->prepare($sql);
$query->execute();
$marcas = $query->fetchAll(PDO::FETCH_OBJ);
foreach ($marcas as $marca) {
	$nombreMarca = $marca->MARCA;
}
$nombre_busqueda = $articulo . " (" . $nombreMarca . ")";
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
		$sql = "UPDATE articulo
				SET ARTICULO ='$articulo',
					IMAGEN = '$imagenCliente',
					NOMBRE_BUSQUEDA = '$nombre_busqueda',
					ID_UNIDAD = '$unidad',
					DESCRIPCION = '$descripcion',
					PRECIO_COMPRA = '$pcompra',
					PRECIO_VENTA = '$pventa',
					ID_MARCA = '$id_marca',
					ID_GRUPO = '$grupo'
				WHERE ID_ARTICULO = '$codigo'";
		$query = $connect->prepare($sql);
		$query->execute();
		header("Location:ArticuloTabla.php");
	} else {
		echo "Error al mover el archivo al directorio.";
	}
} else {
	$sql = "UPDATE articulo
				SET ARTICULO ='$articulo',
					NOMBRE_BUSQUEDA = '$nombre_busqueda',
					ID_UNIDAD = '$unidad',
					DESCRIPCION = '$descripcion',
					PRECIO_COMPRA = '$pcompra',
					PRECIO_VENTA = '$pventa',
					ID_MARCA = '$id_marca',
					ID_GRUPO = '$grupo'
				WHERE ID_ARTICULO = '$codigo'";
	$query = $connect->prepare($sql);
	$query->execute();
	header("Location:ArticuloTabla.php");
}
?>