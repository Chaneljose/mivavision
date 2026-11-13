<?PHP 
require_once('../cnx/cnx_compras.php');
$marca = $_REQUEST['MARCA'];
$sql = "INSERT INTO marca (MARCA) VALUES (TRIM('$marca'))";
try{
  $query = $connect -> prepare($sql); 
  $query -> execute(); 
  header("Location:MarcaTabla.php");
}catch(PDOException $e){
  echo '<script language=javascript>
        alert("EL PRODUCTO INGRESADO YA EXISTE, NO SE REALIZARON MODIFICACIONES !!")
        location.href = "MarcaTabla.php";
    </script>';
}
?>