<?PHP 
require_once('../cnx/cnx_compras.php');
//require_once('../Funciones/Cabecera.php');
//require_once('../Definiciones/Titulo.php'); 
//session_start();
$idUsuario = $_REQUEST['CODIGO'];
?>
<div class="modal-header" style="text-align: center;">
    <a class="close" data-dismiss="modal">x</a>
    <h3>ACTUALIZACION DE PASSWORD</h3>
</div>

<div style="text-align: center;">
    <form class="form-horizontal" role="form" method="post" action="UsuarioDMLUpdatePassword.php">
        <input type="hidden" name="CODIGO" value="<?PHP echo $idUsuario; ?>" />
        <div class="form-group">
            <label for="PASSWORD" class="col-sm-3 control-label">PASSWORD</label>
            <div class="col-sm-4">
                <input type="password" style="width: 400px;" class="form-control" id="PASSWORD" name="PASSWORD" placeholder="PASSWORD" required />
            </div>
        </div>
        <div class="form-group">
            <label for="PASSWORD2" class="col-sm-3 control-label">REPETIR PASSWORD</label>
            <div class="col-sm-4">
                <input type="password" style="width: 400px;" class="form-control" id="PASSWORD2" name="PASSWORD2" placeholder="REPETIR PASSWORD" required/>
            </div>
        </div>      
        <div class="modal-footer">
            <button class="btn btn-success" id="submit">ACTUALIZAR</button>
            <a class="btn btn-danger" href="UsuariosTabla.php"> CERRAR </a>
        </div>
    </form>
</div>