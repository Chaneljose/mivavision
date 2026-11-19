<?PHP require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Definiciones/Titulo.php'); 
$var_tipo = $_SESSION['SES_TIPO'];
$var_active = "datos";
if (!$_SESSION) { 
?>
  <script language=javascript>
    alert("usuario no autenticado")
    self.location = "../index.html"
  </script>';
<?PHP 
}
$sql = "SELECT ID_UNIDAD, 
			 NOMBRE
	    FROM unidad ORDER BY 2";
$query = $connect -> prepare($sql); 
$query -> execute(); 
$unidades = $query -> fetchAll(PDO::FETCH_OBJ);
?>
<!doctype html>
<html lang="es">
<?PHP 
head1(unidad); 
?>
<body>

  <?PHP 
  require_once('../menu.php'); 
  require_once('../NavsideDatos.php');
  navbar(datos, $var_tipo, $var_active);
  navside(unidad, $var_tipo); 
  ?>
  <div class="container-fluid">
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h2 class="sub-header"><?PHP echo unidad; ?></h2>
      <div>
        <p><a class="btn btn-primary" data-toggle="modal" data-target="#INSERT">CREAR</a></p>
      </div>
      <!-- MODAL INSERT -->
      <div class="modal fade" id="INSERT" tabindex="-1" role="dialog" aria-labelledby="INSERTAR" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <?PHP require_once('UnidadForm.php'); ?>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered table-condensed">
          <thead>
            <tr>
              <th>UNIDAD</th>
              <th>ACCION</th>
            </tr>
          </thead>
          <tbody>
            <?PHP
            if($query->rowCount()>=0){
              foreach($unidades as $unidad){
            ?>
              <tr>
                <td>
                  <?PHP
                  $nombreUnidad = $unidad->NOMBRE;
                  $idUnidad = $unidad->ID_UNIDAD;
                  echo $nombreUnidad;
                  ?>
                </td>
                <td>
                    <a data-toggle="modal" data-target="#UPDATE" class="btn btn-success btn-sm" href="UnidadActualizar.php?CODIGO=<?php echo $idUnidad; ?>">EDITAR</a>
                    <a data-toggle="modal" data-target="#DELETE" class="btn btn-danger btn-sm" href="UnidadBorrar.php?CODIGO=<?php echo $idUnidad; ?>">BORRAR</a>
                </td>
              </tr>
            <?PHP 
              }
            } 
            ?>
          </tbody>
        </table>
      </div>
      <!-- MODAL DELETE -->
      <div class="modal fade" id="DELETE" tabindex="-1" role="dialog" aria-labelledby="BORRAR" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <?PHP require_once('UnidadBorrar.php'); ?>
          </div>
        </div>
      </div>
      <!-- MODAL UPDATE -->
      <div class="modal fade" id="UPDATE" tabindex="-1" role="dialog" aria-labelledby="EDITAR" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <?PHP require_once('UnidadActualizar.php'); ?>
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