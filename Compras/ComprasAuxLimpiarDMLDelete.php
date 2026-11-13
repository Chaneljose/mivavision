<?PHP 
require_once('../cnx/cnx_compras.php');
$sql = "TRUNCATE TABLE compra_aux";
$query = $connect->prepare($sql);
$query->execute();
header("Location:ComprasForm.php")
?>