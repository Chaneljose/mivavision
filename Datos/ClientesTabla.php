<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Definiciones/Titulo.php'); 
//mysqli_select_db($cnx_compras, $database_cnx_compras);
//Iniciar Sesión
//session_start();
$var_tipo = $_SESSION['SES_TIPO'];	
$var_active = "datos"; 

//Validar si se está ingresando con sesión correctamente
if (!$_SESSION)
{ ?>
<script language = javascript>
	alert("usuario no autenticado")
	self.location = "../index.html"
</script>';
<?PHP }


$sql="SELECT c.ID_CLIENTE, 
			 c.TACHO, 
			 c.CI, 
			 c.NOMBRE,
			 c.APATERNO,
			 c.AMATERNO,
			 c.ID_TIPO_CLIENTE,
			 t.TIPO
	  FROM cliente c JOIN tipo_cliente t ON c.ID_TIPO_CLIENTE = t.ID_TIPO_CLIENTE
	  ORDER BY 4";
/*$articulo = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_articulo = mysqli_fetch_assoc($articulo);
$num_articulo = mysqli_num_rows($articulo); */
$query = $connect->prepare($sql);
$query->execute();
$clientes = $query->fetchAll(PDO::FETCH_OBJ);
/*$sql="SELECT ID_TIPO_CLIENTE, 
			 TIPO
	  FROM tipo_cliente";
$marca = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_marca = mysqli_fetch_assoc($marca);
$num_marca = mysqli_num_rows($marca); 
$query = $connect->prepare($sql);
$query->execute();
$tipoClientes = $query->fetchAll(PDO::FETCH_OBJ);*/
?>
<!doctype html>
<html lang="es">
<?PHP head1(clientes); ?>
<body>

  	<?PHP require_once('../menu.php'); ?>
    <?PHP require_once('../NavsideDatos.php');
		  navbar(datos, $var_tipo, $var_active);
		  navside(clientes, $var_tipo);?>
    
    
    <div class="container-fluid">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    
          <h2 class="sub-header"><?PHP echo clientes; ?></h2>
         
                 
                 
    <!-- ORIGINAL              
	<p><a data-toggle="modal" href="#form-content" class="btn btn-primary">CREAR</a></p>-->
              
              
              
              <!-- Button trigger modal 
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>-->

            <div>
                <p><a class="btn btn-primary" data-toggle="modal" data-target="#INSERT" >CREAR</a></p>
            </div>
            
            <!-- MODAL INSERT -->
            <div class="modal fade" id="INSERT" tabindex="-1" role="dialog" aria-labelledby="INSERTAR" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                        <?PHP require_once('ClientesForm.php');?>
                </div>
              </div>
            </div>
            
            
		<div class="table-responsive">
            <table class="table table-striped table-hover table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>TACHO</th>
                        <th>CI</th>
                        <th>NOMBRE</th>
                        <th>A. PATERNO</th>
                        <th>A. MATERNO</th>
                        <th>TIPO</th>
                        <th>ACCION</th>
                    </tr>      
                </thead>
                <tbody>
                    <?PHP 
                      if($query->rowCount()>0){
                        foreach($clientes as $cliente){
                    ?>
                        <tr>
                          <td>
                            <?PHP
                            echo $cliente->TACHO;
                            ?>
                          </td>
                          <td>
                            <?PHP 
                            echo $cliente->CI;
                            ?>
                          </td>
                          <td>
                            <?PHP 
                            echo $cliente->NOMBRE;
                            ?>
                          </td>
                          <td>
                            <?PHP 
                            echo $cliente->APATERNO;
                            ?>
                          </td>
                          <td>
                            <?PHP 
                            echo $cliente->AMATERNO;
                            ?>
                          </td>
                          <td>
                            <?PHP 
                            echo $cliente->TIPO;
                            ?>
                          </td>
                          <td>
                            <a data-toggle="modal" data-target="#UPDATE" class="btn btn-success btn-sm" href="ClientesActualizar.php?CODIGO=<?php echo $cliente->ID_CLIENTE;?>">EDITAR</a>
                            <a data-toggle="modal" data-target="#DELETE" class="btn btn-danger btn-sm" href="ClientesBorrar.php?CODIGO=<?php echo $cliente->ID_CLIENTE;?>">BORRAR</a>
                          </td>
                    	</tr>
                <?PHP 
                  }
                }  
                ?> 
                
                    <!-- MODAL DELETE -->
                    <div class="modal fade" id="DELETE" tabindex="-1" role="dialog" aria-labelledby="BORRAR" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                                <?PHP require_once('ClientesBorrar.php');?>
                        </div>
                      </div>
                    </div>
               
               </tbody>
			</table>
		</div>
              
              <!-- MODAL UPDATE -->
              <div class="modal fade" id="UPDATE" tabindex="-1" role="dialog" aria-labelledby="EDITAR" aria-hidden="true">
              	<div class="modal-dialog">
                  <div class="modal-content">
                          <?PHP require_once('ClientesActualizar.php');?>
                  </div>
                </div>
              </div>
              
        </div>
      </div>
     <script src="../assets/js/docs.js"></script>
	 <script src="../js/jquery-1.8.3.min.js"></script>
	 <script src="../js/bootstrap.min.js"></script>
	</body>
</html>