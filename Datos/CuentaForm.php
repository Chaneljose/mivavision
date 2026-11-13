<?PHP require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Definiciones/Titulo.php'); ?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);
$codigo = $_SESSION['SES_ID'];
$sql = "SELECT u.ID_USR, u.USR, u.NOMBRE, u.APELLIDOP, u.APELLIDOM, 
u.CI, u.FECHA_NAC, t.TIPO_USR, t.ID_TIPO_USR 
FROM usr u JOIN tipo_usr t ON u.ID_TIPO_USR = t.ID_TIPO_USR
WHERE u.ID_USR = '$codigo'";
$usuario = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras) . ' : ' . mysqli_error($cnx_compras));
$row_usuario = mysqli_fetch_assoc($usuario);
$num_usuario = mysqli_num_rows($usuario);
$sql2="SELECT t.ID_TIPO_USR, t.TIPO_USR
	   FROM tipo_usr t
	   WHERE t.ID_TIPO_USR != '$codigo'";
$tipo = mysqli_query($cnx_compras, $sql2) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_tipo = mysqli_fetch_assoc($tipo);
$num_tipo = mysqli_num_rows($tipo);
?>
<div class="modal-header" style="text-align: center;">
    <a class="close" data-dismiss="modal">x</a>
    <h3>ACTUALIZACION DE USUARIO</h3>
</div>

<div style="text-align: center;">
    <form class="form-horizontal" role="form" method="post" action="MarcaDMLUpdate.php">
        <input type="hidden" name="CODIGO" value="<?PHP echo $row_marca['ID_USR']; ?>" />
        <div class="form-group">
            <label for="LOGIN" class="col-sm-3 control-label">LOGIN</label>
            <div class="col-sm-4">
                <input type="text" style="width: 400px;" class="form-control" id="LOGIN" name="LOGIN" placeholder="LOGIN DE USUARIO" value="<?PHP echo $row_usuario['USR']; ?>" onchange="this.value = this.value.toUpperCase();"  disabled
                />
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
                <input type="date" style="width: 400px;" class="form-control" id="FECHA" name="FECHA" placeholder="FECHA DE NACIMIENTO"
                    value="<?PHP echo $row_usuario['FECHA_NAC']; ?>"
                    onchange="this.value = this.value.toUpperCase();" disabled/>
            </div>
        </div><div class="form-group">
            <label for="TIPO" class="col-sm-3 control-label">TIPO DE USUARIO</label>
            <div class="col-sm-4">
                <select class="form-control combobox" name="ID_TIPO_USR" disabled>
                    <option value="<?PHP echo $row_usuario['ID_TIPO_USR'];?>">
                        <?PHP echo $row_usuario['TIPO_USR']; ?>
                    </option>
                    <?PHP do{ ?>
                    <option value="<?PHP echo $row_tipo['ID_TIPO_USR'];?>">
                        <?PHP echo $row_tipo['TIPO_USR']; ?>
                    </option>
                    <?PHP }while($row_tipo =  mysqli_fetch_assoc($tipo)) ?>
                </select>
            </div>
        </div>
    </form>
</div>