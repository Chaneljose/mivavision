<?PHP 
require_once('../cnx/cnx_compras.php');
//session_start();
$var_tipo = $_SESSION['SES_TIPO'];
$idUsuario = $_REQUEST['CODIGO'];
$sql = "SELECT u.ID_USR, u.USR, u.NOMBRE, u.APELLIDOP, u.APELLIDOM, 
u.CI, u.FECHA_NAC, t.TIPO_USR, t.ID_TIPO_USR 
FROM usr u JOIN tipo_usr t ON u.ID_TIPO_USR = t.ID_TIPO_USR
WHERE u.ID_USR = '$idUsuario'";
$query = $connect->prepare($sql);
$query->execute();
$usuarios = $query->fetchAll(PDO::FETCH_OBJ);
$login = '';
$nombre = '';
$apellidoP = '';
$apellidoM = '';
$ci = '';
$fechaNac = '';
$idTipoUsr = '';
$tipoUsr = '';
if ($query->rowCount() > 0) {
  foreach ($usuarios as $usuario) {
    $login = $usuario->USR;
    $nombre = $usuario->NOMBRE;
    $apellidoP = $usuario->APELLIDOP;
    $apellidoM = $usuario->APELLIDOM;
    $ci = $usuario->CI;
    $fechaNac = $usuario->FECHA_NAC;
    $idTipoUsr = $usuario->ID_TIPO_USR;
    $tipoUsr = $usuario->TIPO_USR;
  }
}
$sql2 = "SELECT t.ID_TIPO_USR, t.TIPO_USR
	   FROM tipo_usr t";
$queryT = $connect->prepare($sql2);
$queryT->execute();
$tipoUsuarios = $queryT->fetchAll(PDO::FETCH_OBJ);
?>
<div class="modal-header" style="text-align: center;">
  <a class="close" data-dismiss="modal">x</a>
  <h3>ACTUALIZACION DE USUARIO</h3>
</div>
<div style="text-align: center;">
  <form class="form-horizontal" role="form" method="post" action="UsuarioDMLUpdate.php">
    <input type="hidden" name="CODIGO" value="<?PHP echo $idUsuario; ?>" />
    <div class="form-group">
      <label for="LOGIN" class="col-sm-3 control-label">LOGIN</label>
      <div class="col-sm-4">
        <input type="text" style="width: 400px;" class="form-control" id="LOGIN" name="LOGIN" placeholder="LOGIN DE USUARIO" value="<?PHP echo $login; ?>" onchange="this.value = this.value.toUpperCase();"
          <?php if ($idUsuario == 1) { ?>disabled<?php } ?> />
      </div>
    </div>
    <div class="form-group">
      <label for="NOMBRE" class="col-sm-3 control-label">USUARIO</label>
      <div class="col-sm-4">
        <input type="text" style="width: 400px;" class="form-control" id="NOMBRE" name="NOMBRE" placeholder="NOMBRE DE USUARIO"
          value="<?PHP echo $nombre; ?>"
          onchange="this.value = this.value.toUpperCase();" />
      </div>
    </div>
    <div class="form-group">
      <label for="APATERNO" class="col-sm-3 control-label">APELLIDO PATERNO</label>
      <div class="col-sm-4">
        <input type="text" style="width: 400px;" class="form-control" id="APATERNO" name="APATERNO" placeholder="APELLIDO PATERNO"
          value="<?PHP echo $apellidoP; ?>"
          onchange="this.value = this.value.toUpperCase();" />
      </div>
    </div>
    <div class="form-group">
      <label for="AMATERNO" class="col-sm-3 control-label">APELLIDO MATERNO</label>
      <div class="col-sm-4">
        <input type="text" style="width: 400px;" class="form-control" id="AMATERNO" name="AMATERNO" placeholder="APELLIDO MATERNO"
          value="<?PHP echo $apellidoM; ?>"
          onchange="this.value = this.value.toUpperCase();" />
      </div>
    </div>
    <div class="form-group">
      <label for="CI" class="col-sm-3 control-label">CEDULA DE IDENTIDAD</label>
      <div class="col-sm-4">
        <input type="text" style="width: 400px;" class="form-control" id="CI" name="CI" placeholder="CEDULA DE IDENTIDAD"
          value="<?PHP echo $ci; ?>"
          onchange="this.value = this.value.toUpperCase();" />
      </div>
    </div>
    <div class="form-group">
      <label for="FECHA" class="col-sm-3 control-label">FECHA DE NACIMIENTO</label>
      <div class="col-sm-4">
        <input type="date" style="width: 400px;" class="form-control" id="FECHA" name="FECHA" placeholder="FECHA DE NACIMIENTO"
          value="<?PHP echo $fechaNac; ?>"
          onchange="this.value = this.value.toUpperCase();" />
      </div>
    </div>
    <div class="form-group">
      <label for="TIPO" class="col-sm-3 control-label">TIPO DE USUARIO</label>
      <div class="col-sm-4">
        <select class="form-control combobox" name="ID_TIPO_USR" <?php if ($idUsuario == 1) { ?>disabled<?php } ?>>
          <option value="<?PHP echo $idTipoUsr; ?>">
            <?PHP echo $tipoUsr; ?>
          </option>
          <?PHP
          if ($queryT->rowCount() > 0) {
            foreach ($tipoUsuarios as $tipoUsuario) {
          ?>
              <option value="<?PHP echo $tipoUsuario->ID_TIPO_USR; ?>">
                <?PHP echo $tipoUsuario->TIPO_USR; ?>
              </option>
          <?PHP
            }
          }
          ?>
        </select>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-success" id="submit">ACTUALIZAR</button>
      <a class="btn btn-danger" href="UsuariosTabla.php"> CERRAR </a>
    </div>
  </form>
</div>