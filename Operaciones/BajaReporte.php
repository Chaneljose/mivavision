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


$sql="SELECT ID_SOLICITUD_BAJA
	  ,		 NRO_NOTA
	  ,		 FECHA_SOLICITUD
	  FROM SOLICITUD_BAJA
	  ORDER BY 1";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

?>
<!doctype html>
<html lang="es">
<?PHP head1(articulo); ?>
<body>

  	<?PHP require_once('../menu.php');
		  navbar(operaciones, $var_tipo, $var_active);
		  require_once('../NavsideOperacion.php');
		  navside(baja);?>

<div class="container-fluid">
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    	<h2 class="sub-header">BAJAS</h2>
            <div><a id="registro" class="btn btn-success" href="BajaForm.php">REGISTRAR</a>
            	 <a id="impresion" class="btn btn-primary" href="../Reportes/KardexImpresion.php?CODIGO=<?PHP echo $codigo; ?>">IMPRESION</a></div>
    	<h3 class="sub-header">FECHA <?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y H:i:s') ?></h3>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>CODIGO</th>
                        <th>FECHA</th>
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
                        <?php
                        if(isset($row_pedido['ID_SOLICITUD_BAJA'])){
                        ?>
                        <td align="center">
                            <a href="BajaTabla.php?BUSCAR=<?PHP echo $row_pedido['ID_SOLICITUD_BAJA']; ?>" >
                                <img title="EDITAR" src="../Iconos/COMPUTADORA.ico" width="20" height="20" alt="VER" />
                            </a>
                        </td>
                        <?php 
                        }
                        ?>
                    </tr>
                    <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
                </tbody>
            </table>
        </div>
        
	</div>
</div>

</body>
</html>