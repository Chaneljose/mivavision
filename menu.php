<script language=javascript>
    expira();
</script>
<?php
// Fixed navbar  
if (!isset($_SESSION['SES_TIPO'])) {
    //echo $_SESSION['SES_TIPO'];
?>
    <script language=javascript>
        //alert("su sesion ha terminado correctamente")
        location.href = "../Sesion/Destroy.php";
    </script>
<?php
}
function navbar(String $variable, String $var_tipo, String $var_active)
{
    include('../cnx/cnx_compras.php');
    //mysqli_select_db($cnx_compras, $database_cnx_compras);
    $nombre_empresa = '';
    $sql = "SELECT e.NOMBRE_EMPRESA FROM empresa e WHERE e.ID_EMPRESA = 1";
    /*$empresa = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras) . ' : ' . mysqli_error($cnx_compras));
    $row_empresa = mysqli_fetch_assoc($empresa);
    $num_empresa = mysqli_num_rows($empresa);
    //echo $nombre_empresa;*/
    
    $query = $connect -> prepare($sql); 
    $query -> execute(); 
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
    
    if($query -> rowCount() > 0){
        foreach($results as $result) {
            $nombre_empresa = $result->NOMBRE_EMPRESA;
        }
    }
?>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" id="BTNINICIO" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php
                if ($var_tipo == 1) {
                ?>
                    <a class="navbar-brand" href="../Sesion/MenuAdm.php">
                        <?php
                        /*if (isset($row_empresa['NOMBRE_EMPRESA'])) {
                            $nombre_empresa = $row_empresa['NOMBRE_EMPRESA'];
                        }*/
                        echo $nombre_empresa;
                        ?>
                    </a>
                <?php
                }
                if ($var_tipo == 2) {
                ?>
                    <a class="navbar-brand" href="../Sesion/MenuVenta.php">
                        <?php
                        /*if (isset($row_empresa['NOMBRE_EMPRESA'])) {
                            $nombre_empresa = $row_empresa['NOMBRE_EMPRESA'];
                        }*/
                        echo $nombre_empresa;
                        ?>
                    </a>
                <?php
                }
                ?>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <?php
                    if ($var_tipo == 1) {
                        if ($var_active == "datos") {
                    ?>
                            <li class="active"><a href="../Datos/EmpresaTabla.php">DATOS</a></li>
                            <li><a href="../Compras/ComprasForm.php">COMPRAS</a></li>
                            <li><a href="../SolicitudSalidas/SolSalidasForm.php">VENTAS</a></li>
                            <li><a href="../Operaciones/BajaReporte.php">OPERACIONES</a></li>
                            <li><a href="../ReportesCont/libro.php">CONTABILIDAD</a></li>
                            <li><a href="../Reportes/ReporteDiario.php">REPORTES</a></li>
                            <li><a href="../Sesion/Destroy.php">SALIR</a></li>
                        <?php
                        }
                        if ($var_active == "compras") {
                        ?>
                            <li><a href="../Datos/EmpresaTabla.php">DATOS</a></li>
                            <li class="active"><a href="../Compras/ComprasForm.php">COMPRAS</a></li>
                            <li><a href="../SolicitudSalidas/SolSalidasForm.php">VENTAS</a></li>
                            <li><a href="../Operaciones/BajaReporte.php">OPERACIONES</a></li>
                            <li><a href="../ReportesCont/libro.php">CONTABILIDAD</a></li>
                            <li><a href="../Reportes/ReporteDiario.php">REPORTES</a></li>
                            <li><a href="../Sesion/Destroy.php">SALIR</a></li>
                        <?php
                        }
                        if ($var_active == "ventas") {
                        ?>
                            <li><a href="../Datos/EmpresaTabla.php">DATOS</a></li>
                            <li><a href="../Compras/ComprasForm.php">COMPRAS</a></li>
                            <li class="active"><a href="../SolicitudSalidas/SolSalidasForm.php">VENTAS</a></li>
                            <li><a href="../Operaciones/BajaReporte.php">OPERACIONES</a></li>
                            <li><a href="../ReportesCont/libro.php">CONTABILIDAD</a></li>
                            <li><a href="../Reportes/ReporteDiario.php">REPORTES</a></li>
                            <li><a href="../Sesion/Destroy.php">SALIR</a></li>
                        <?php
                        }
                        if ($var_active == "operaciones") {
                        ?>
                            <li><a href="../Datos/ArticuloEmpresaTablaTabla.php">DATOS</a></li>
                            <li><a href="../Compras/ComprasForm.php">COMPRAS</a></li>
                            <li><a href="../SolicitudSalidas/SolSalidasForm.php">VENTAS</a></li>
                            <li class="active"><a href="../Operaciones/BajaReporte.php">OPERACIONES</a></li>
                            <li><a href="../ReportesCont/libro.php">CONTABILIDAD</a></li>
                            <li><a href="../Reportes/ReporteDiario.php">REPORTES</a></li>
                            <li><a href="../Sesion/Destroy.php">SALIR</a></li>
                        <?php
                        }
                        if ($var_active == "contabilidad") {
                        ?>
                            <li><a href="../Datos/EmpresaTabla.php">DATOS</a></li>
                            <li><a href="../Compras/ComprasForm.php">COMPRAS</a></li>
                            <li><a href="../SolicitudSalidas/SolSalidasForm.php">VENTAS</a></li>
                            <li><a href="../Operaciones/BajaReporte.php">OPERACIONES</a></li>
                            <li class="active"><a href="../ReportesCont/libro.php">CONTABILIDAD</a></li>
                            <li><a href="../Reportes/ReporteDiario.php">REPORTES</a></li>
                            <li><a href="../Sesion/Destroy.php">SALIR</a></li>
                        <?php
                        }
                        if ($var_active == "reportes") {
                        ?>
                            <li><a href="../Datos/EmpresaTabla.php">DATOS</a></li>
                            <li><a href="../Compras/ComprasForm.php">COMPRAS</a></li>
                            <li><a href="../SolicitudSalidas/SolSalidasForm.php">VENTAS</a></li>
                            <li><a href="../Operaciones/BajaReporte.php">OPERACIONES</a></li>
                            <li><a href="../ReportesCont/libro.php">CONTABILIDAD</a></li>
                            <li class="active"><a href="../Reportes/ReporteDiario.php">REPORTES</a></li>
                            <li><a href="../Sesion/Destroy.php">SALIR</a></li>
                        <?php
                        }
                        if ($var_active == "") {
                        ?>
                            <li><a href="../Datos/EmpresaTabla.php">DATOS</a></li>
                            <li><a href="../Compras/ComprasForm.php">COMPRAS</a></li>
                            <li><a href="../SolicitudSalidas/SolSalidasForm.php">VENTAS</a></li>
                            <li><a href="../Operaciones/BajaReporte.php">OPERACIONES</a></li>
                            <li><a href="../ReportesCont/libro.php">CONTABILIDAD</a></li>
                            <li><a href="../Reportes/ReporteDiario.php">REPORTES</a></li>
                            <li><a href="../Sesion/Destroy.php">SALIR</a></li>
                        <?php
                        }
                    } else {
                        if ($var_active == "datos") {
                        ?>
                            <li class="active"><a href="../Datos/EmpresaTabla.php">DATOS</a></li>
                            <li><a href="../Compras/ComprasForm.php">COMPRAS</a></li>
                            <li><a href="../SolicitudSalidas/SolSalidasForm.php">VENTAS</a></li>
                            <li><a href="../Reportes/ReporteDiario.php?INICIO=01/01/2024">REPORTES</a></li>
                            <li><a href="../Sesion/Destroy.php">SALIR</a></li>
                        <?php
                        }
                        if ($var_active == "compras") {
                        ?>
                            <li><a href="../Datos/EmpresaTabla.php">DATOS</a></li>
                            <li class="active"><a href="../Compras/ComprasForm.php">COMPRAS</a></li>
                            <li><a href="../SolicitudSalidas/SolSalidasForm.php">VENTAS</a></li>
                            <li><a href="../Reportes/ReporteDiario.php?INICIO=01/01/2024">REPORTES</a></li>
                            <li><a href="../Sesion/Destroy.php">SALIR</a></li>
                        <?php
                        }
                        if ($var_active == "ventas") {
                        ?>
                            <li><a href="../Datos/EmpresaTabla.php">DATOS</a></li>
                            <li><a href="../Compras/ComprasForm.php">COMPRAS</a></li>
                            <li class="active"><a href="../SolicitudSalidas/SolSalidasForm.php">VENTAS</a></li>
                            <li><a href="../Reportes/ReporteDiario.php?INICIO=01/01/2024">REPORTES</a></li>
                            <li><a href="../Sesion/Destroy.php">SALIR</a></li>
                        <?php
                        }
                        if ($var_active == "reportes") {
                        ?>
                            <li><a href="../Datos/EmpresaTabla.php">DATOS</a></li>
                            <li><a href="../Compras/ComprasForm.php">COMPRAS</a></li>
                            <li><a href="../SolicitudSalidas/SolSalidasForm.php">VENTAS</a></li>
                            <li class="active"><a href="../Reportes/ReporteDiario.php?INICIO=01/01/2024">REPORTES</a></li>
                            <li><a href="../Sesion/Destroy.php">SALIR</a></li>
                        <?php
                        }
                        if ($var_active == "") {
                        ?>
                            <li><a href="../Datos/EmpresaTabla.php">DATOS</a></li>
                            <li><a href="../Compras/ComprasForm.php">COMPRAS</a></li>
                            <li><a href="../SolicitudSalidas/SolSalidasForm.php">VENTAS</a></li>
                            <li><a href="../Reportes/ReporteDiario.php?INICIO=01/01/2024">REPORTES</a></li>
                            <li><a href="../Sesion/Destroy.php">SALIR</a></li>
                    <?php
                        }
                    }
                    ?>
                </ul>
                <ul class="nav navbar-nav pull-right">
                        <a href="../Datos/CuentaTabla.php" class="navbar-brand" style="font-size: smaller;"><?php echo 'Usuario: '.$_SESSION['SES_USR']; ?></a>
                </ul>
            </div>
        </div>
    </div>
<?PHP } ?>