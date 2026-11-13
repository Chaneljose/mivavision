<?PHP
require_once('Definiciones/Titulo.php');
function navside(String $variable, String $var_tipo)
{
    //echo "EL TIPO ES: ".$var_tipo;
    /*if ($var_tipo == 1) {*/
        if ($variable == articulo) {
?>
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li><a href="../Datos/EmpresaTabla.php"><?PHP echo empresa ?></a></li>
                        <li class="active"><a href="../Datos/ArticuloTabla.php"><?PHP echo articulo ?></a></li>
                        <li><a href="../Datos/MarcaTabla.php"><?PHP echo marca ?></a></li>
                        <li><a href="../Datos/UsuariosTabla.php"><?PHP echo usuarios ?></a></li>
                        <!--<li><a href="../Datos/CuentaTabla.php"><?PHP //echo cuenta ?></a></li>-->
                    </ul>
                </div>
            </div>
        <?PHP } else if ($variable == marca) {
        ?>
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li><a href="../Datos/EmpresaTabla.php"><?PHP echo empresa ?></a></li>
                        <li><a href="../Datos/ArticuloTabla.php"><?PHP echo articulo ?></a></li>
                        <li class="active"><a href="../Datos/MarcaTabla.php"><?PHP echo marca ?></a></li>
                        <li><a href="../Datos/UsuariosTabla.php"><?PHP echo usuarios ?></a></li>
                        <!--<li><a href="../Datos/CuentaTabla.php"><?PHP //echo cuenta ?></a></li>-->
                    </ul>
                </div>
            </div>
        <?PHP } else if ($variable == usuarios) {
        ?>
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li><a href="../Datos/EmpresaTabla.php"><?PHP echo empresa ?></a></li>
                        <li><a href="../Datos/ArticuloTabla.php"><?PHP echo articulo ?></a></li>
                        <li><a href="../Datos/MarcaTabla.php"><?PHP echo marca ?></a></li>
                        <li class="active"><a href="../Datos/UsuariosTabla.php"><?PHP echo usuarios ?></a></li>
                        <!--<li><a href="../Datos/CuentaTabla.php"><?PHP //echo cuenta ?></a></li>-->
                    </ul>
                </div>
            </div>
        <?PHP } else if ($variable == empresa) {
        ?>
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li class="active"><a href="../Datos/EmpresaTabla.php"><?PHP echo empresa ?></a></li>
                        <li><a href="../Datos/ArticuloTabla.php"><?PHP echo articulo ?></a></li>
                        <li><a href="../Datos/MarcaTabla.php"><?PHP echo marca ?></a></li>
                        <li><a href="../Datos/UsuariosTabla.php"><?PHP echo usuarios ?></a></li>
                        <!--<li><a href="../Datos/CuentaTabla.php"><?PHP //echo cuenta ?></a></li>-->
                    </ul>
                </div>
            </div>
        <?PHP 
        }
    }
?>