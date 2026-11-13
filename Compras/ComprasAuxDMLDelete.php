<?PHP require_once('../cnx/cnx_compras.php');
$id_articulo = $_REQUEST['CODIGO'];
$sql = "DELETE FROM compra_aux
        WHERE ID_ARTICULO = '$id_articulo'";
$query = $connect->prepare($sql);
$query->execute();
header("Location:ComprasForm.php");
?>