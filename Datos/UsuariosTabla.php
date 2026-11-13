<?PHP require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Definiciones/Titulo.php');
//Iniciar Sesión
//session_start();
$var_tipo = $_SESSION['SES_TIPO'];
$var_id = $_SESSION['SES_ID'];
$var_active = "datos";
$sql = '';
//Validar si se está ingresando con sesión correctamente
if (!$_SESSION) {
?>
  <script language=javascript>
    alert("usuario no autenticado")
    self.location = "../index.html"
  </script>';
<?PHP
}
if($var_tipo == 1){
  $sql = "SELECT u.ID_USR, u.USR, u.NOMBRE, u.APELLIDOP, 
               u.APELLIDOM, u.CI, u.FECHA_NAC, t.TIPO_USR, t.ID_TIPO_USR 
        FROM usr u JOIN tipo_usr t ON u.ID_TIPO_USR = t.ID_TIPO_USR";
}else{
  $sql = "SELECT u.ID_USR, u.USR, u.NOMBRE, u.APELLIDOP, 
               u.APELLIDOM, u.CI, u.FECHA_NAC, t.TIPO_USR, t.ID_TIPO_USR 
        FROM usr u JOIN tipo_usr t ON u.ID_TIPO_USR = t.ID_TIPO_USR
        WHERE u.ID_USR <> 1";
}
$query = $connect->prepare($sql);
$query->execute();
$usuarios = $query->fetchAll(PDO::FETCH_OBJ);
?>
<!doctype html>
<html lang="es">
<?PHP
head1(usuarios);
?>

<body>

  <?PHP
  require_once('../menu.php');
  require_once('../NavsideDatos.php');
  navbar(datos, $var_tipo, $var_active);
  navside(usuarios, $var_tipo);
  ?>
  <div class="container-fluid">
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

      <h2 class="sub-header"><?PHP echo usuarios; ?></h2>
      <div>
        <?php
        if($var_tipo == 1){
        ?>
        <p><a class="btn btn-primary" data-toggle="modal" data-target="#INSERT">CREAR</a></p>
        <?php 
        }
        ?>
      </div>
      <!-- MODAL INSERT -->
      <div class="modal fade" id="INSERT" tabindex="-1" role="dialog" aria-labelledby="INSERTAR" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <?PHP require_once('UsuariosForm.php'); ?>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered table-condensed">
          <thead>
            <tr>
              <th>LOGIN</th>
              <th>NOMBRE</th>
              <th>A. PATERNO</th>
              <th>A. MATERNO</th>
              <th>CI</th>
              <th>FECHA NAC.</th>
              <th>TIPO DE USUARIO</th>
              <th>ACCION</th>
            </tr>
          </thead>
          <tbody>
            <?PHP
            if ($query->rowCount() > 0) {
              foreach ($usuarios as $usuario) {
            ?>
                <tr>
                  <td>
                    <?PHP
                    echo $usuario->USR;
                    ?>
                  </td>
                  <td>
                    <?PHP
                    echo $usuario->NOMBRE;
                    ?>
                  </td>
                  <td>
                    <?PHP
                    echo $usuario->APELLIDOP;
                    ?>
                  </td>
                  <td>
                    <?PHP
                    echo $usuario->APELLIDOM;
                    ?>
                  </td>
                  <td>
                    <?PHP
                    echo $usuario->CI;
                    ?>
                  </td>
                  <td>
                    <?PHP
                    echo $usuario->FECHA_NAC;
                    ?>
                  </td>
                  <td>
                    <?PHP
                    echo $usuario->TIPO_USR;
                    $idUsuario = $usuario->ID_USR;
                    ?>
                  </td>
                  <td>
                    <?php
                    if($var_tipo == 1){
                    ?>
                      <a data-toggle="modal" data-target="#UPDATE" class="btn btn-success btn-sm" href="UsuariosActualizar.php?CODIGO=<?php echo $idUsuario; ?>">EDITAR</a>
                      <a data-toggle="modal" data-target="#PASWD" class="btn btn-success btn-sm" href="UsuarioPassword.php?CODIGO=<?php echo $idUsuario; ?>">PASSWORD</a>
                      <?php
                      if ($idUsuario != 1) {
                      ?>
                        <a data-toggle="modal" data-target="#DELETE" class="btn btn-danger btn-sm" href="UsuariosBorrar.php?CODIGO=<?php echo $idUsuario; ?>">BORRAR</a>
                      <?php
                      }
                    }else{
                      if($idUsuario == $var_id){
                      ?>
                      <a data-toggle="modal" data-target="#PASWD" class="btn btn-success btn-sm" href="UsuarioPassword.php?CODIGO=<?php echo $idUsuario; ?>">PASSWORD</a>
                      <?php
                      }
                    }
                    ?>
                  </td>
                </tr>
            <?PHP
              }
            }
            ?>
          </tbody>
        </table>
      </div>
      <!-- MODAL UPDATE -->
      <div class="modal fade" id="UPDATE" tabindex="-1" role="dialog" aria-labelledby="EDITAR" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <?PHP require_once('UsuariosActualizar.php'); ?>
          </div>
        </div>
      </div>
      <!-- MODAL DELETE -->
      <div class="modal fade" id="DELETE" tabindex="-1" role="dialog" aria-labelledby="BORRAR" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <?PHP require_once('UsuariosBorrar.php'); ?>
          </div>
        </div>
      </div>
      <!-- MODAL PASWD -->
      <div class="modal fade" id="PASWD" tabindex="-1" role="dialog" aria-labelledby="PASSWORD" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <?PHP require_once('UsuarioPassword.php'); ?>
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