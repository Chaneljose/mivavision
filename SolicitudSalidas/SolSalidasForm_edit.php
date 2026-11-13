<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Funciones/Funciones.php');
	  require_once('../Definiciones/Titulo.php'); ?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);
$var_tipo = '';
$var_active = "ventas";

$tacho_socio = $_REQUEST['TACHO'];
$sql_nombre = "SELECT s.TACHO
                ,    s.ORIGINAL
                FROM censo2.socio s
                WHERE s.TACHO='".$tacho_socio."'";
            
            $acceso = mysqli_query($cnx_compras, $sql_nombre) or die (mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
            $row_acceso = mysqli_fetch_assoc($acceso);

$sql="SELECT  v.ID_ARTICULO
		,		  a.ARTICULO
		,		  v.CANTIDAD CANTIDAD
		,		  v.PRECIO_VENTA PRECIO_VENTA
		,		  v.TOTAL TOTAL
		FROM venta_aux v JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE v.ID_ARTICULO>0
		GROUP BY 1,2";
$articulo = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_articulo = mysqli_fetch_assoc($articulo);
$num_articulo = mysqli_num_rows($articulo);

$sql2="SELECT SUM(v.TOTAL) SUM_TOTAL
	   FROM venta_aux v JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO";
$total = mysqli_query($cnx_compras, $sql2) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_total = mysqli_fetch_assoc($total);
$num_total = mysqli_num_rows($total);

$sql3 = "SELECT COUNT(ID_VENTA_AUX) TOTAL
		 FROM venta_aux
		 ORDER BY 1 DESC LIMIT 1";
$cont = mysqli_query($cnx_compras, $sql3) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_cont = mysqli_fetch_assoc($cont);
$num_cont = mysqli_num_rows($cont);

$sql5 = "SELECT ID_CLIENTE
		 ,		ID_TIPO_VENTA
		 FROM venta_aux
		 ORDER BY 1 DESC LIMIT 1";
$variable = mysqli_query($cnx_compras, $sql5) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_variable = mysqli_fetch_assoc($variable);
$num_variable = mysqli_num_rows($variable);

$var_cliente = $row_variable['ID_CLIENTE'];
$var_tipo_venta = $row_variable['ID_TIPO_VENTA'];

?>
<!doctype html>
<html lang="es">

<?PHP head1(salidas); ?>
<body>

    	<?PHP include('../menu.php');
			  require_once('../NavsideSalidas.php');
		  	  navbar(salidas, $var_tipo, $var_active);
		  	  navside(salidas);?>
    
    <div class="container-fluid">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        	   <h2 class="sub-header">SALIDAS</h2>
    	<form class="form-horizontal" role="form" action="SolSalidasDMLInsertAux.php" >
            <input type="hidden" name="FECHA" value="<?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y ') ?>" />
                <div class="form-group">
                	<label for="ID_CLIENTETACH" class="col-sm-4 control-label">TACHO</label>
                  <?php
                  echo '<input type="text" id="TACHO" name="TACHO" value="'.$tacho_socio.'" size="40" readonly/>';
                  ?>
                  <br>
                  <br>
                  <label for="ID_CLIENTENOMB" class="col-sm-4 control-label">NOMBRE</label>
                  <?php
                  echo '<input type="text" id="NOMBRE" name="NOMBRE" value="'.$row_acceso['ORIGINAL'].'" size="40" readonly/>';
                  ?>
                  </div>
                  
                  <div class="form-group">
                  	<label for="TIPO_VENTA" class="col-sm-4 control-label">SALIDA AL</label>
                    	<select class="combobox" name="TIPO_VENTA">
                        	<?PHP if($row_cont['TOTAL']==0){ ?>
                            	<option>CNT</option>
                            <?PHP }else{?>
                            	<option><?PHP echo $var_tipo_venta ?></option>
                            <?PHP }?>
									<?PHP
                                        $sql="SELECT ID_TIPO_VENTA, 
                                                     TIPO
                                              FROM tipo_venta
                                              WHERE ID_TIPO_VENTA = 'CNT' OR ID_TIPO_VENTA = 'CRD'
                                              ORDER BY 2";
                                        $personal = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
                                        $row_personal = mysqli_fetch_assoc($personal);
                                        $num_personal = mysqli_num_rows($personal); 
                                     ?>
                                     <?PHP do{ ?>
                                        <option value="<?PHP echo $row_personal['ID_TIPO_VENTA']; ?>"><?PHP echo $row_personal['TIPO'] ?></option>
                                     <?PHP }while($row_personal = mysqli_fetch_assoc($personal))?>
                        </select>
                  </div>
                  
                  <div class="form-group">
                      <label for="BARCODE" class="col-sm-4 control-label">ARTICULO</label>
                            <input type="text" id="BARCODE" name="BARCODE" placeholder="CODIGO DE BARRAS" 
                                   autofocus onchange="this.value = this.value.toUpperCase();" size = "40" required />
                 </div>
            </form>
            
            <div>
            	<h3>TOTAL <?PHP echo 'Bs.: '.redondeo($row_total['SUM_TOTAL']); ?></h3>
                <a class="btn btn-success" href="SolSalidasDMLInsert.php?TACHO=<?php echo $tacho_socio; ?>">REGISTRAR</a>
                <a data-toggle="modal" data-target="#LIMPIAR" class="btn btn-danger" href="Limpiar.php?TACHO=<?php echo $tacho_socio; ?>">LIMPIAR</a>
                
                <!-- MODAL DELETE -->
                    <div class="modal fade" id="LIMPIAR" tabindex="-1" role="dialog" aria-labelledby="BORRAR" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                                <?PHP require_once('Limpiar.php');?>
                        </div>
                      </div>
                    </div>
            </div>

        
        
        
			<div class="table-responsive">
                <table class="table table-striped table-hover table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th><h4>CANTIDAD</h4></th>
                            <th><h4>ARTICULO</h4></th>
                            <th><h4>PRECIO VENTA</h4></th>
                            <th><h4>TOTAL</h4></th>
                  		 	<th><h4>ACCION</h4></th>
                        </tr>      
                    </thead>
                    <tbody>
                        <?PHP do{?>
                            <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                <td><h4><?PHP echo $row_articulo['CANTIDAD'] ; ?></h4></td>
                                <td><h4><?PHP echo $row_articulo['ARTICULO']; ?></h4></td>
                                <td align="right"><h4><?PHP echo $row_articulo['PRECIO_VENTA']; ?></h4></td>
                                <td align="right"><h4><?PHP echo redondeo($row_articulo['TOTAL']); ?></h4></td>
                                <td><h4><a data-toggle="modal" data-target="#UPDATE" class="btn btn-success btn-sm" href="SolSalidasActualizar.php?CODIGO=<?php echo $row_articulo['ID_ARTICULO']?>&TACHO=<?php echo $tacho_socio;?>">EDITAR</a>
                                    <a data-toggle="modal" data-target="#DELETE" class="btn btn-danger btn-sm" href="SolSalidasBorrar.php?CODIGO=<?php echo $row_articulo['ID_ARTICULO']?>&TACHO=<?php echo $tacho_socio;?>">BORRAR</a></h4></td>
                            </tr>
                        <?PHP } while($row_articulo= mysqli_fetch_assoc($articulo)) ?>
                         <!-- MODAL DELETE -->
                        <div class="modal fade" id="DELETE" tabindex="-1" role="dialog" aria-labelledby="BORRAR" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                                    <?PHP require_once('SolSalidasBorrar.php');?>
                            </div>
                          </div>
                        </div>
                         
                    </tbody>
                </table>
     		</div>
          
           <!-- MODAL UPDATE -->
              <div class="modal fade" id="UPDATE" tabindex="-1" role="dialog" aria-labelledby="EDITAR" aria-hidden="true">
              	<div class="modal-dialog">
                  <div class="modal-content">
                          <?PHP require_once('SolSalidasActualizar.php');?>
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