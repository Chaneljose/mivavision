<?PHP 
require_once('../cnx/cnx_compras.php');
$categoria = $_REQUEST['CATEGORIA'];
$sql = "INSERT INTO categoria (NOMBRE) VALUES (TRIM('$categoria'))";
try{
  $query = $connect -> prepare($sql); 
  $query -> execute(); 
  header("Location:CategoriaTabla.php");
}catch(PDOException $e){
  echo '<script language=javascript>
        alert("EL PRODUCTO INGRESADO YA EXISTE, NO SE REALIZARON MODIFICACIONES !!")
        location.href = "CategoriaTabla.php";
    </script>';
}
?>