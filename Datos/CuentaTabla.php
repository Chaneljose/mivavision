<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Definiciones/Titulo.php'); 
//mysqli_select_db($cnx_compras, $database_cnx_compras);
//Iniciar Sesión
//session_start();
$var_tipo = $_SESSION['SES_TIPO'];
$var_active = "datos";

//Validar si se está ingresando con sesión correctamente
if (!$_SESSION) { ?>
  <script language=javascript>
    alert("usuario no autenticado")
    self.location = "../index.html"
  </script>';
<?PHP }
$codigo = $_SESSION['SES_ID'];
$sql = "SELECT u.ID_USR, u.USR, u.NOMBRE, u.APELLIDOP, u.APELLIDOM, 
u.CI, u.FECHA_NAC, t.TIPO_USR, t.ID_TIPO_USR 
FROM usr u JOIN tipo_usr t ON u.ID_TIPO_USR = t.ID_TIPO_USR
WHERE u.ID_USR = '$codigo'";
/*$usuario = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras) . ' : ' . mysqli_error($cnx_compras));
$row_usuario = mysqli_fetch_assoc($usuario);
$num_usuario = mysqli_num_rows($usuario);*/
$query = $connect->prepare($sql);
$query->execute();
$usuarios = $query->fetchAll(PDO::FETCH_OBJ);
$sql2="SELECT t.ID_TIPO_USR, t.TIPO_USR
	   FROM tipo_usr t
	   WHERE t.ID_TIPO_USR = '$var_tipo'";
/*$tipo = mysqli_query($cnx_compras, $sql2) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_tipo = mysqli_fetch_assoc($tipo);
$num_tipo = mysqli_num_rows($tipo);*/
$queryT = $connect->prepare($sql);
$queryT->execute();
$tipoUsuarios = $queryT->fetchAll(PDO::FETCH_OBJ);
?>
<!doctype html>
<html lang="es">
<?PHP head1(cuenta); ?>

<body>

  <?PHP require_once('../menu.php'); ?>
  <?PHP require_once('../NavsideDatos.php');
  navbar(datos, $var_tipo, $var_active);
  navside(cuenta, $var_tipo); ?>


  <div class="container-fluid">
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

      <h2 class="sub-header"><?PHP echo cuenta;?></h2>
      <!-- MODAL INSERT -->
      <div class="modal fade" id="INSERT" tabindex="-1" role="dialog" aria-labelledby="INSERTAR" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <?PHP /*require_once('CuentaForm.php');*/ ?>
          </div>
        </div>
      </div>
      <div style="text-align: center;">
    <form class="form-horizontal" role="form" method="post">
        <input type="hidden" name="CODIGO" value="<?PHP echo $row_marca['ID_USR']; ?>" />
        <div class="form-group">
            <label for="LOGIN" class="col-sm-3 control-label">LOGIN</label>
            <div class="col-sm-4">
                <input type="text" style="width: 400px;" class="form-control" id="LOGIN" name="LOGIN" placeholder="LOGIN DE USUARIO" value="<?PHP echo $row_usuario['USR']; ?>" onchange="this.value = this.value.toUpperCase();" 
                disabled/>
            </div>
        </div>
        <div class="form-group">
            <label for="NOMBRE" class="col-sm-3 control-label">USUARIO</label>
            <div class="col-sm-4">
                <input type="text" style="width: 400px;" class="form-control" id="NOMBRE" name="NOMBRE" placeholder="NOMBRE DE USUARIO"
                    value="<?PHP echo $row_usuario['NOMBRE']; ?>"
                    onchange="this.value = this.value.toUpperCase();" disabled/>
            </div>
        </div>
        <div class="form-group">
            <label for="APATERNO" class="col-sm-3 control-label">APELLIDO PATERNO</label>
            <div class="col-sm-4">
                <input type="text" style="width: 400px;" class="form-control" id="APATERNO" name="APATERNO" placeholder="APELLIDO PATERNO"
                    value="<?PHP echo $row_usuario['APELLIDOP']; ?>"
                    onchange="this.value = this.value.toUpperCase();" disabled/>
            </div>
        </div>
        <div class="form-group">
            <label for="AMATERNO" class="col-sm-3 control-label">APELLIDO MATERNO</label>
            <div class="col-sm-4">
                <input type="text" style="width: 400px;" class="form-control" id="AMATERNO" name="AMATERNO" placeholder="APELLIDO MATERNO"
                    value="<?PHP echo $row_usuario['APELLIDOM']; ?>"
                    onchange="this.value = this.value.toUpperCase();" disabled/>
            </div>
        </div>
        <div class="form-group">
            <label for="CI" class="col-sm-3 control-label">CEDULA DE IDENTIDAD</label>
            <div class="col-sm-4">
                <input type="text" style="width: 400px;" class="form-control" id="CI" name="CI" placeholder="CEDULA DE IDENTIDAD"
                    value="<?PHP echo $row_usuario['CI']; ?>"
                    onchange="this.value = this.value.toUpperCase();" disabled/>
            </div>
        </div>
        <div class="form-group">
            <label for="FECHA" class="col-sm-3 control-label">FECHA DE NACIMIENTO</label>
            <div class="col-sm-4">
                <input type="text" style="width: 400px;" class="form-control" id="FECHA" name="FECHA" placeholder="FECHA DE NACIMIENTO"
                    value="<?PHP echo $row_usuario['FECHA_NAC']; ?>"
                    onchange="this.value = this.value.toUpperCase();" disabled/>
            </div>
        </div>
        <div class="form-group">
            <label for="TIPOUSR" class="col-sm-3 control-label">TIPO DE USUARIO</label>
            <div class="col-sm-4">
                <input type="text" style="width: 400px;" class="form-control" id="TIPOUSR" name="TIPOUSR" placeholder="TIPO DE USUARIO"
                    value="<?PHP echo $row_tipo['TIPO_USR']; ?>"
                    onchange="this.value = this.value.toUpperCase();" disabled/>
            </div>
        </div>
        <div>
          <a data-toggle="modal" data-target="#UPDATE" class="btn btn-success btn-sm" href="CuentaActualizar.php?CODIGO=<?php echo $row_usuario['ID_USR'] ?>">CAMBIAR PASSWORD</a>
        </div>
    </form>
</div>
      
      <!-- MODAL UPDATE -->
      <div class="modal fade" id="UPDATE" tabindex="-1" role="dialog" aria-labelledby="EDITAR" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <?PHP require_once('CuentaActualizar.php'); ?>
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