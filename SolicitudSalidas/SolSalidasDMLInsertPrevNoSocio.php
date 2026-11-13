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
        <form  method="POST" action="SolSalidasDMLInsert.php">      
          <div class="form-group">
            <label for="TIPOSALIDA" class="col-sm-4 control-label">CI: </label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="CI" name="CI" placeholder="INGRESE UN NUMERO DE CI" autofocus onchange="this.value = this.value.toUpperCase();" required />
              </div>
              <br>
              <br>
              <label for="BARCODE" class="col-sm-4 control-label">NOMBRE: </label>
              <div class="col-sm-3">
                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" placeholder="INGRESE UN NOMBRE" autofocus onchange="this.value = this.value.toUpperCase();" required />
                <input type="hidden" id="TIPO_SOCIO" name="TIPO_SOCIO" value="NO SOCIO" required />
                <input type="hidden" id="TIPO_VENTA" name="TIPO_VENTA" value="CNT" required />
                <input type="hidden" id="TACHO" name="TACHO" value="1" required />
                </br>
                </br>
                <!--<a class="btn btn-success" href="">BUSCAR</a>-->
                <button type="submit" class="btn btn-success">SIGUIENTE</button>
              </div>
           </div>
        </form>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div id="resultadoBusqueda">
          <br>
          <br>
        </div>
        </center>
      </div>
      </div>
     <script src="../assets/js/docs.js"></script>
	 <script src="../js/jquery-1.8.3.min.js"></script>
	 <script src="../js/bootstrap.min.js"></script>
</body>
</html>