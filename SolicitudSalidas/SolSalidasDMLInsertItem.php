<?PHP require_once('../cnx/cnx_compras.php');
	  include_once('../Funciones/funciones.php');?>
<?PHP

mysqli_select_db($cnx_compras, $database_cnx_compras);

$id_solicitud = $_REQUEST['ID_SOLICITUD'];
$id_area = $_REQUEST['AREA'];
$articulo = $_REQUEST['ARTICULO'];
$unidad = $_REQUEST['UNIDAD'];
$descripcion = $_REQUEST['DESCRIPCION'];
$cantidad = $_REQUEST['CANTIDAD'];

$sql1 = "INSERT INTO pedido (ID_SOLICITUD_COMPRA,
							 ID_AREA,
							 ARTICULO,
							 UNIDAD,
							 DESCRIPCION,
							 CANTIDAD)
					 VALUES ('$id_solicitud',
					 		 '$id_area',
							 '$articulo',
							 '$unidad',
							 '$descripcion',
							 '$cantidad')";
$consulta1 = mysqli_query($cnx_compras, $sql1) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));

header("Location:SolComprasTabla.php?BUSCAR=".$id_solicitud);
?>