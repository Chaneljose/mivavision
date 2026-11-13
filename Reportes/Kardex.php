<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Funciones/Funciones.php');
	  require_once('../Definiciones/Titulo.php'); 
      //session_start(); 
  $var_tipo = $_SESSION['SES_TIPO']; 
  $var_active = "reportes";
      ?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);
//$menu = $_REQUEST['MENU'];

$codigo = $_REQUEST['BUSCAR'];
$sql="SELECT ARTICULO,
             CODIGO,
			 SUM(DEBE) ENTRADA,
			 SUM(HABER) SALIDA,
			 SUM(DEBE) - SUM(HABER) SALDO
	  FROM (	SELECT	a.ID_ARTICULO CODIGO, 
					 	a.NOMBRE_BUSQUEDA ARTICULO, 
					 	SUM(c.CANTIDAD) DEBE, 
					 	0 HABER
			  	FROM articulo a JOIN compra c ON a.ID_ARTICULO = c.ID_ARTICULO
			  	GROUP BY 1
			 	UNION ALL
			  	SELECT	v.ID_ARTICULO CODIGO, 
					 	a.NOMBRE_BUSQUEDA ARTICULO, 
					 	0 DEBE, 
					 	SUM(v.CANTIDAD) HABER
			  	FROM venta v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
			  	GROUP BY 1
			  	UNION ALL
			  	SELECT	v.ID_ARTICULO CODIGO, 
					 	a.NOMBRE_BUSQUEDA ARTICULO, 
					 	0 DEBE, 
					 	SUM(v.CANTIDAD) HABER
			  	FROM venta_credito v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
			  	GROUP BY 1
			  	UNION ALL
				SELECT	v.ID_ARTICULO CODIGO, 
					 	a.NOMBRE_BUSQUEDA ARTICULO, 
					 	0 DEBE, 
					 	SUM(v.CANTIDAD) HABER
			  	FROM vale v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
			  	GROUP BY 1
			  	UNION ALL
			  	SELECT	b.ID_ARTICULO CODIGO, 
					 	a.NOMBRE_BUSQUEDA ARTICULO, 
					 	0 DEBE, 
					 	SUM(b.CANTIDAD) HABER
			  	FROM baja b JOIN articulo a On b.ID_ARTICULO = a.ID_ARTICULO
			  	GROUP BY 1
			  	UNION ALL
			  	SELECT	b.ID_ARTICULO CODIGO, 
					 	a.NOMBRE_BUSQUEDA ARTICULO, 
					 	0 DEBE, 
					 	SUM(b.CANTIDAD) HABER
			  	FROM devolucion b JOIN articulo a On b.ID_ARTICULO = a.ID_ARTICULO
			  	GROUP BY 1
			  	ORDER BY 2
			) KARDEX
		GROUP BY 1,2";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

?>
<!doctype html>
<html lang="es">

<?PHP head1(reportes); ?>
<body>
    	<?PHP include('../menu.php');
			  /*if($menu == 2)
		  	  navbar(reportes_caja, $var_tipo);
			  else*/
		  	  navbar(reportes, $var_tipo, $var_active);
			  
			  require_once('../NavsideReportes.php');
		  	  navside(kardex);?>
        
        <div class="container-fluid">
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">               
            	<!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li><a href="#kardex" class="btn btn-link" data-toggle="tab">KARDEX</a></li>
                    <!--<li><a href="#credito" class="btn btn-link" data-toggle="tab">VENTA CREDITO</a></li>
                    <li><a href="#vales" class="btn btn-link" data-toggle="tab">VALES</a></li>-->
                    <li><a href="#devolucion" class="btn btn-link" data-toggle="tab">DEVOLUCIONES</a></li>
                    <li><a href="#bajas" class="btn btn-link" data-toggle="tab">BAJAS</a></li>
                </ul>
                
                <!-- Tab panes -->
                <div class="tab-content">
                  <div class="tab-pane active" id="kardex">
                  	<h2 class="sub-header">KARDEX</h2>
                        <section>
                            <form action="" >
                                <div><a class="btn btn-primary" href="KardexImpresion.php?CODIGO=<?PHP echo $codigo; ?>">IMPRESION</a>
                                     <a class="btn btn-info" href="KardexExcel.php?CODIGO=<?PHP echo $codigo; ?>">EXCEL</a></div>
                            </form>
                        </section>
                        <h2 class="sub-header">FECHA <?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y H:i:s') ?></h2>
                        <h3 class="sub-header">
                          <table>
                              <tbody>
                                  <tr>
                                      <td align="right" style="background-color: #0F0"><= 10 U</td>
                                      <td align="right" style="background-color: #FF0">= 0 U</td>
                                      <td align="right" style="background-color: #F00">< 0 U</td>
                                  </tr>
                              </tbody>
                          </table>
                		</h3>
                        <section class="table-responsive" >
                          <table  class="table table-striped table-hover table-bordered table-condensed">
                              <thead>
                                  <tr>
                                      <th>CODIGO</th>
                                      <th>PRODUCTO</th>
                                      <th>ENTRADA</th>
                                      <th>SALIDA</th>
                                      <th>SALDO</th>
                                  </tr>      
                              </thead>
                              <tbody>
                                  <?PHP
                                      $cont =1;
                                      do{
                                        if(isset($row_pedido['SALDO'])){
                                  ?>
                                      <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                          <td align="center"><?PHP echo $row_pedido['CODIGO']; ?></td>
                                          <td><?PHP echo $row_pedido['ARTICULO']; ?></td>
                                          <td align="right"><?PHP echo $row_pedido['ENTRADA']; ?></td>
                                          <td align="right"><?PHP echo $row_pedido['SALIDA']; ?></td>
                                          <?PHP if($row_pedido['SALDO'] == 0){ ?>
                                              <td align="right" style="background-color: #FF0"><?PHP echo $row_pedido['SALDO']; ?></td>
                                          <?PHP }else if($row_pedido['SALDO'] < 0) { ?>
                                              <td align="right" style="background-color:#F00"><?PHP echo $row_pedido['SALDO']; ?></td>
                                          <?PHP }else if($row_pedido['SALDO'] <= 10) { ?>
                                              <td align="right" style="background-color: #0F0"><?PHP echo $row_pedido['SALDO']; ?></td>
                                          <?PHP }else { ?>
                                              <td align="right"><?PHP echo $row_pedido['SALDO']; ?></td>
                                          <?PHP } } ?>
                                      </tr>
                                  <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
                              </tbody>
                          </table>
                  </div>
                  <div class="tab-pane fade" id="credito"><?PHP require_once('VentaCredito.php');?></div>
                  <div class="tab-pane fade" id="vales"><?PHP require_once('Vale.php');?>.</div>
                  <div class="tab-pane fade" id="devolucion"><?PHP require_once('Devolucion.php');?></div>
                  <div class="tab-pane fade" id="bajas"><?PHP require_once('Baja.php'); ?></div>
                </div>
                
            </div> <!-- COL -->
        </div> <!-- DIV CONTAINER FLUID -->
        
     <script src="../assets/js/docs.js"></script>
	 <script src="../js/jquery-1.8.3.min.js"></script>
	 <script src="../js/bootstrap.min.js"></script> 
    
</body>
</html>