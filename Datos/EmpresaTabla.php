<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Definiciones/Titulo.php'); 
//session_start();
$var_tipo = $_SESSION['SES_TIPO'];	
$var_active = "datos";
$sql="SELECT e.ID_EMPRESA
    , e.NOMBRE_EMPRESA
    , e.NIT
    , e.INICIO_GESTION
    , e.INICIO_MES
    , e.DIRECCION
    , e.CIUDAD
    , e.TELEFONO
    , e.TEMA
    FROM empresa e 
    WHERE e.ID_EMPRESA > 0";
$query = $connect -> prepare($sql); 
$query -> execute(); 
$results = $query -> fetchAll(PDO::FETCH_OBJ);

$nombre_empresa = '';
$nit = '';
$ciudad = '';
$direccion = '';
$telefono = '';
$inicio_gestion = '';
$inicio_mes = '';
$tema = '';

if($query -> rowCount() > 0){
    foreach($results as $result) {
        $id_empresa = $result->ID_EMPRESA;
        $nombre_empresa = $result->NOMBRE_EMPRESA;
        $nit = $result->NIT;
        $ciudad = $result->CIUDAD;
        $direccion = $result->DIRECCION;
        $telefono = $result->TELEFONO;
        $inicio_gestion = $result->INICIO_GESTION;
        $inicio_mes = $result->INICIO_MES;
        $tema = $result->TEMA;
    }
}

?>
<!doctype html>
<html lang="es">
<?PHP head1(empresa); ?>

<body>

    <?PHP require_once('../menu.php'); ?>
    <?PHP require_once('../NavsideDatos.php');
		  navbar(datos, $var_tipo, $var_active);
		  navside(empresa,$var_tipo);?>


    <div class="container-fluid">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

            <h2 class="sub-header">
                <?PHP echo empresa; ?>
            </h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>NOMBRE EMPRESA</th>
                            <th>NIT</th>
							<th>CIUDAD</th>
                            <th>DIRECCION</th>
                            <th>TELEFONO</th>
                            <th>INICIO GESTION</th>
                            <th>INICIO MES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                            <td>
                                <?PHP
                                echo $nombre_empresa;
                                ?>
                            </td>
							<td>
                                <?PHP 
                                echo $nit;
                                ?>
                            </td>
                            <td>
                                <?PHP 
                                echo $ciudad;
                                ?>
                            </td>
                            <td>
                                <?PHP 
                                echo $direccion;
                                ?>
                            </td>
                            <td>
                                <?PHP 
                                echo $telefono;
                                ?>
                            </td>
                            <td>
                                <?PHP 
                                echo $inicio_gestion;
                                ?>
                            </td>
                            <td>
                                <?PHP 
                                echo $inicio_mes;
                                ?>
                            </td>
                            <?php 
                                if($var_tipo == 1){
                            ?>
                            <td><a data-toggle="modal" data-target="#UPDATE" class="btn btn-success btn-sm"
                                    href="EmpresaActualizar.php?CODIGO=<?php echo $id_empresa;?>">EDITAR</a>
                                <a data-toggle="modal" data-target="#DELETE" class="btn btn-danger btn-sm"
                                    href="EmpresaBorrar.php?CODIGO=<?php echo $id_empresa;?>">BORRAR</a>
                            </td>
                            <?php 
                                }
                            ?>
                        </tr>
                        <!-- MODAL UPDATE -->
                        <div class="modal fade" id="UPDATE" tabindex="-1" role="dialog" aria-labelledby="EDITAR" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <?PHP require_once('EmpresaActualizar.php');?>
                                </div>
                            </div>
                        </div>
                        <!-- MODAL DELETE -->
                        <div class="modal fade" id="DELETE" tabindex="-1" role="dialog" aria-labelledby="BORRAR"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <?PHP require_once('EmpresaBorrar.php');?>
                                </div>
                            </div>
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../assets/js/docs.js"></script>
    <script src="../js/jquery-1.8.3.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>