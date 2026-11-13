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
        <form  method="POST" action="javascript:buscar();">      
          <div class="form-group">
            <label for="TIPOSALIDA" class="col-sm-4 control-label">TIPO DE SALIDA: </label>
            <div class="col-sm-3">
                <select class="combobox" name="tipoVenta" id="tipoVenta">
                  <?PHP
                      $sql="SELECT ID_TIPO_VENTA, 
                                   TIPO
                            FROM tipo_venta
                            WHERE ID_TIPO_VENTA = 'CNT' OR ID_TIPO_VENTA = 'CRD'
                            ORDER BY 2";
                      $personal = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
                      $row_personal = mysqli_fetch_assoc($personal);
                      $num_personal = mysqli_num_rows($personal); 
                   ?>
                   <?PHP do{ ?>
                      <option value="<?PHP echo $row_personal['ID_TIPO_VENTA']; ?>"><?PHP echo $row_personal['TIPO'] ?></option>
                   <?PHP }while($row_personal = mysqli_fetch_assoc($personal))?>
                </select>
              </div>
              <br>
              <br>
              <label for="BARCODE" class="col-sm-4 control-label">INGRESO EL NUMERO DE TACHO: </label>
              <div class="col-sm-3">
                <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="INGRESE UN NUMERO DE TACHO" autofocus onchange="this.value = this.value.toUpperCase();" required />
                </br>
                </br>
                <!--<a class="btn btn-success" href="">BUSCAR</a>-->
                <button type="button" class="btn btn-success" onclick="buscar()">BUSCAR</button>
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