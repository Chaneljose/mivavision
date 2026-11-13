<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Funciones/Funciones.php');
	  require_once('../Definiciones/Titulo.php'); 
    mysqli_select_db($cnx_compras, $database_cnx_compras);
    $var_tipo = '';
$var_active = "ventas";
?>

<!doctype html>
<html lang="es">

<?PHP head1(salidas); ?>
<body>

    	<?PHP include('../menu.php');
			  require_once('../NavsideSalidas.php');
		  	  navbar(salidas, $var_tipo, $var_active);
		  	  navside(salidas);?>
    
    <div class="container-fluid">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        	   <h2 class="sub-header">SALIDAS</h2>
        <center>
          <br>
          <br>
          <br>
          <br>
          <button type="button" class="btn btn-success" onclick="location.href='SolSalidasDMLInsertPrevSocio.php';" style="width: 300px;height:100px;">SOCIO</button>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <button type="button" class="btn btn-danger" onclick="location.href='SolSalidasDMLInsertPrevNoSocio.php';" style="width: 300px;height:100px;">NO SOCIO</button>
        </center>
      </div>
      </div>
     <script src="../assets/js/docs.js"></script>
	 <script src="../js/jquery-1.8.3.min.js"></script>
	 <script src="../js/bootstrap.min.js"></script>
</body>
</html>