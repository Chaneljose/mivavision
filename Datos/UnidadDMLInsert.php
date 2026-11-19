<?PHP 
require_once('../cnx/cnx_compras.php');
$unidad = $_REQUEST['UNIDAD'];
$sql = "INSERT INTO unidad (NOMBRE) VALUES (TRIM('$unidad'))";
try{
  $query = $connect -> prepare($sql); 
  $query -> execute(); 
  header("Location:UnidadTabla.php");
}catch(PDOException $e){
  echo '<script language=javascript>
        alert("EL PRODUCTO INGRESADO YA EXISTE, NO SE REALIZARON MODIFICACIONES !!")
        location.href = "UnidadTabla.php";
    </script>';
}
?>