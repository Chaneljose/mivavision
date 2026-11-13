<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Definiciones/Titulo.php');
      //session_start(); 
      $var_tipo = $_SESSION['SES_TIPO'];
      $var_active = "operaciones";
mysqli_select_db($cnx_compras, $database_cnx_compras);
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
        	<form class="form-horizontal" role="form"  action="BajaDMLInsert.php" method="post">      
        		<div class="form-group">
            		<label for="FECHA" class="col-sm-4 control-label">FECHA REGISTRO</label>
    					<div class="col-sm-3">
                			<input type="text" class="form-control" id="FECHA" name="FECHA" value="<?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y ') ?>" readonly />
							
                        </div>
                </div>

              
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>NRO</th>
                            <th>ARTICULO</th>
                            <th>CANTIDAD</th>
                            <th>OBSERVACIONES</th>
                        </tr>
                     </thead>	
                     <tbody>
                          <?PHP for($i=1;$i<=10;$i++){ ?>
                                <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                    <td><?PHP echo $i; ?></td>
                                    <td><select class="combobox" name="ARTICULO<?PHP echo $i; ?>">
                                        <option></option>
                                        <?PHP
                                            $sql="SELECT ID_ARTICULO, 
                                                         ARTICULO, 
                                                         ID_UNIDAD, 
                                                         DESCRIPCION,
                                                         PRECIO_COMPRA,
                                                         PRECIO_VENTA,
                                                         ID_GRUPO
                                                  FROM articulo";
                                            $articulo = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
                                            $row_articulo = mysqli_fetch_assoc($articulo);
                                            $num_articulo = mysqli_num_rows($articulo);
                                        
                                        
                                         do{ ?>
                                            <option value="<?PHP echo $row_articulo['ID_ARTICULO'];?>"><?PHP echo $row_articulo['ARTICULO']; ?></option>
                                        <?PHP }while($row_articulo =  mysqli_fetch_assoc($articulo)) ?>
                                        </select></td>
                                    <td><input type="text" name="CANTIDAD<?PHP echo $i; ?>" onKeyUp="sumar(Carga)"/></td>
                                    <td><input type="text" name="OBS<?PHP echo $i; ?>" onchange="this.value = this.value.toUpperCase();"/></td>
                                    <!--<td><input type="text" name="BAJA<?PHP echo $i; ?>" class="calendario" /></td>-->
                                </tr>
                             <?PHP } ?>
                     </tbody>
                </table>
            </div>
            <div> <button class="btn btn-success" id="submit">REGISTRAR</button></div>
        </form> 
    </div>
</div>
</body>
</html>