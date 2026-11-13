<?PHP require_once('../cnx/cnx_compras.php');
    require_once('../Funciones/Cabecera.php');
    require_once('../Funciones/Funciones.php');
    require_once('../Definiciones/Titulo.php');
//session_start();
$var_tipo = $_SESSION['SES_TIPO'];
$var_active = "operaciones";
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = "";

if(isset($_REQUEST['BUSCAR'])){
    $codigo = $_REQUEST['BUSCAR'];
}


$sql="SELECT ID_SOLICITUD_DEV
	  ,		 NRO_NOTA
	  ,		 FECHA_SOLICITUD
	  FROM SOLICITUD_DEV
	  ORDER BY 1";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

?>
<!doctype html>
<html lang="es">
<?PHP head1(articulo); ?>
<body class="ui-widget">
    	<?PHP 
            require_once('../menu.php');
            navbar(operaciones, $var_tipo, $var_active);
            require_once('../NavsideOperacion.php');
            navside(devolucion);?>
    <div class="container-fluid">
	    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h2 class="sub-header">DEVOLUCIONES</h2>
            <section>
                <form action="" >
                    <div><a id="impresion" href="../Reportes/KardexImpresion.php?CODIGO=<?PHP echo $codigo; ?>">Impresion</a></div>
                </form>
            </section>
            <hr />
                <h2>FECHA <?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y') ?></h2>
            <div class="formulario ui-corner-all">
            <table class="ui-tinytbl ui-corner-all">
                <thead class="ui-widget-header ui-corner-all">
                    <tr>
                        <th>CODIGO</th>
                        <th>PRODUCTO</th>
                        <th>VER</th>
                    </tr>      
                </thead>
                <tbody>
                    <?PHP
                        $cont =1;
                        do{
                    ?>
                        <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                            <td align="center"><?PHP if(isset($row_pedido['NRO_NOTA'])){echo $row_pedido['NRO_NOTA'];} ?></td>
                            <td><?PHP if(isset($row_pedido['FECHA_SOLICITUD'])){echo $row_pedido['FECHA_SOLICITUD'];} ?></td>
                            <td align="center">
                                <a href="DevTabla.php?BUSCAR=<?PHP if(isset($row_pedido['ID_SOLICITUD_DEV'])){echo $row_pedido['ID_SOLICITUD_DEV'];} ?>" >
                                    <img title="EDITAR" src="../Iconos/COMPUTADORA.ico" width="20" height="20" alt="VER" />
                                </a>
                            </td>
                        </tr>
                    <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="salto"></div>

</body>
</html>