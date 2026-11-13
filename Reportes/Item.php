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
					
//$inicio = fecha_amd($_REQUEST['INICIO']);
//$fin = fecha_amd($_REQUEST['FIN']);
$buscar =$_REQUEST['BUSCAR'];

$var_baja='BJA';
$var_dev='DEV';
$var_consumo = 'CSM';
$var_credito = 'CRD';

$sql="SELECT FECHA_REGISTRO
,		  NOTA
,		 FISICO_INGRESO ENTRADA
,		 FISICO_SALIDA SALIDA
,		 0 FISICO_SALDO
,         PU
,        VALOR_INGRESO
,		 0 VALOR_SALIDA
,		 0 VALOR_SALDO
,		 ID_ALMACEN
,        ID_COMPRA
,		 ID_ARTICULO
,		 ARTICULO
,		 ID_TIPO_VENTA
FROM (
		SELECT   c.FECHA_REGISTRO
		,		 CONCAT('F-',LPAD(c.NRO_FACTURA,'7','0')) NOTA
		,		 c.CANTIDAD FISICO_INGRESO
		,		 0 FISICO_SALIDA
		,		 0 FISICO_SALDO
		,		 c.TOTAL / c.CANTIDAD PU
		,		 c.TOTAL VALOR_INGRESO
		,		 0 VALOR_SALIDA
		,		 0 VALOR_SALDO
		,		 0 ID_ALMACEN
		,        c.ID_COMPRA
		,		 c.ID_ARTICULO
		,		 a.ARTICULO
		,		 'F' ID_TIPO_VENTA
		FROM COMPRA c JOIN ARTICULO a ON c.ID_ARTICULO = a.ID_ARTICULO
		WHERE c.ID_ARTICULO ='$buscar'
		UNION ALL
		SELECT   s.FECHA_SOLICITUD
		,		 CONCAT(s.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) NOTA
		,		 0 FISICO_INGRESO
		,		 v.CANTIDAD FISICO_SALIDA
		,		 0 FISICO_SALDO
		,		c.TOTAL / c.CANTIDAD PU
		,		 0 VALOR_INGRESO
		,		 0 VALOR_SALIDA
		,		 0 VALOR_SALDO
		,		 v.ID_ALMACEN
		,        v.ID_COMPRA
		,		 v.ID_ARTICULO
		,		 a.ARTICULO
		,		 s.ID_TIPO_VENTA
		FROM VENTA v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
						 JOIN ARTICULO a ON v.ID_ARTICULO = a.ID_ARTICULO 
						 JOIN COMPRA c ON v.ID_COMPRA = c.ID_COMPRA
		WHERE v.ID_ARTICULO = '$buscar'
		UNION ALL
		SELECT   s.FECHA_SOLICITUD
		,		 CONCAT(s.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) NOTA
		,		 0 FISICO_INGRESO
		,		 v.CANTIDAD FISICO_SALIDA
		,		 0 FISICO_SALDO
		,		 0 PU
		,		 0 VALOR_INGRESO
		,		 0 VALOR_SALIDA
		,		 0 VALOR_SALDO
		,		 v.ID_ALMACEN
		,        v.ID_COMPRA
		,		 v.ID_ARTICULO
		,		 a.ARTICULO
		,		 s.ID_TIPO_VENTA
		FROM VALE v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
						 JOIN ARTICULO a ON v.ID_ARTICULO = a.ID_ARTICULO 
		WHERE v.ID_ARTICULO = '$buscar'
		UNION ALL
		SELECT   s.FECHA_SOLICITUD
		,		 CONCAT(s.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) NOTA
		,		 0 FISICO_INGRESO
		,		 v.CANTIDAD FISICO_SALIDA
		,		 0 FISICO_SALDO
		,		 0 PU
		,		 0 VALOR_INGRESO
		,		 0 VALOR_SALIDA
		,		 0 VALOR_SALDO
		,		 v.ID_ALMACEN
		,        v.ID_COMPRA
		,		 v.ID_ARTICULO
		,		 a.ARTICULO
		,		 s.ID_TIPO_VENTA
		FROM VENTA_CREDITO v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
						 JOIN ARTICULO a ON v.ID_ARTICULO = a.ID_ARTICULO 
		WHERE v.ID_ARTICULO = '$buscar'
		UNION ALL
		SELECT   s.FECHA_SOLICITUD
		,		 CONCAT(s.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) NOTA
		,		 0 FISICO_INGRESO
		,		 v.CANTIDAD FISICO_SALIDA
		,		 0 FISICO_SALDO
		,		 0 PU
		,		 0 VALOR_INGRESO
		,		 0 VALOR_SALIDA
		,		 0 VALOR_SALDO
		,		 v.ID_ALMACEN
		,        v.ID_COMPRA
		,		 v.ID_ARTICULO
		,		 a.ARTICULO
		,		 s.ID_TIPO_VENTA
		FROM BAJA v JOIN SOLICITUD_BAJA s ON v.ID_SOLICITUD_BAJA = s.ID_SOLICITUD_BAJA
						 JOIN ARTICULO a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE v.ID_ARTICULO = '$buscar'
		UNION ALL
		SELECT   s.FECHA_SOLICITUD
		,		 CONCAT(s.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) NOTA
		,		 0 FISICO_INGRESO
		,		 v.CANTIDAD FISICO_SALIDA
		,		 0 FISICO_SALDO
		,		 0 PU
		,		 0 VALOR_INGRESO
		,		 0 VALOR_SALIDA
		,		 0 VALOR_SALDO
		,		 v.ID_ALMACEN
		,        v.ID_COMPRA
		,		 v.ID_ARTICULO
		,		 a.ARTICULO
		,		 s.ID_TIPO_VENTA
		FROM DEVOLUCION v JOIN SOLICITUD_DEV s ON v.ID_SOLICITUD_DEV = s.ID_SOLICITUD_DEV
						 JOIN ARTICULO a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE v.ID_ARTICULO = '$buscar'
		ORDER BY 1) k";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 



$sql1="SELECT FECHA_REGISTRO
,		  NOTA
,		 FISICO_INGRESO ENTRADA
,		 FISICO_SALIDA SALIDA
,		 0 FISICO_SALDO
,        VALOR_INGRESO/FISICO_INGRESO PU
,        VALOR_INGRESO
,		 0 VALOR_SALIDA
,		 0 VALOR_SALDO
,		 ID_ALMACEN
,        ID_COMPRA
,		 ID_ARTICULO
,		 ARTICULO
,		 ID_TIPO_VENTA
FROM (
		SELECT   c.FECHA_REGISTRO
		,		 CONCAT('F-',LPAD(c.NRO_FACTURA,'7','0')) NOTA
		,		 c.CANTIDAD FISICO_INGRESO
		,		 0 FISICO_SALIDA
		,		 0 FISICO_SALDO
		,		 0 PU
		,		 c.TOTAL VALOR_INGRESO
		,		 0 VALOR_SALIDA
		,		 0 VALOR_SALDO
		,		 0 ID_ALMACEN
		,        c.ID_COMPRA
		,		 c.ID_ARTICULO
		,		 a.ARTICULO
		,		 'F' ID_TIPO_VENTA
		FROM COMPRA c JOIN ARTICULO a ON c.ID_ARTICULO = a.ID_ARTICULO
		WHERE c.ID_ARTICULO ='$buscar'
		UNION ALL
		SELECT   s.FECHA_SOLICITUD
		,		 CONCAT(s.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) NOTA
		,		 0 FISICO_INGRESO
		,		 v.CANTIDAD FISICO_SALIDA
		,		 0 FISICO_SALDO
		,		 0 PU
		,		 0 VALOR_INGRESO
		,		 0 VALOR_SALIDA
		,		 0 VALOR_SALDO
		,		 v.ID_ALMACEN
		,        v.ID_COMPRA
		,		 v.ID_ARTICULO
		,		 a.ARTICULO
		,		 s.ID_TIPO_VENTA
		FROM VENTA v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
						 JOIN ARTICULO a ON v.ID_ARTICULO = a.ID_ARTICULO 
		WHERE v.ID_ARTICULO = '$buscar'
		UNION ALL
		SELECT   s.FECHA_SOLICITUD
		,		 CONCAT(s.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) NOTA
		,		 0 FISICO_INGRESO
		,		 v.CANTIDAD FISICO_SALIDA
		,		 0 FISICO_SALDO
		,		 0 PU
		,		 0 VALOR_INGRESO
		,		 0 VALOR_SALIDA
		,		 0 VALOR_SALDO
		,		 v.ID_ALMACEN
		,        v.ID_COMPRA
		,		 v.ID_ARTICULO
		,		 a.ARTICULO
		,		 s.ID_TIPO_VENTA
		FROM VALE v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
						 JOIN ARTICULO a ON v.ID_ARTICULO = a.ID_ARTICULO 
		WHERE v.ID_ARTICULO = '$buscar'
		UNION ALL
		SELECT   s.FECHA_SOLICITUD
		,		 CONCAT(s.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) NOTA
		,		 0 FISICO_INGRESO
		,		 v.CANTIDAD FISICO_SALIDA
		,		 0 FISICO_SALDO
		,		 0 PU
		,		 0 VALOR_INGRESO
		,		 0 VALOR_SALIDA
		,		 0 VALOR_SALDO
		,		 v.ID_ALMACEN
		,        v.ID_COMPRA
		,		 v.ID_ARTICULO
		,		 a.ARTICULO
		,		 s.ID_TIPO_VENTA
		FROM VENTA_CREDITO v JOIN SOLICITUD_VENTA s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
						 JOIN ARTICULO a ON v.ID_ARTICULO = a.ID_ARTICULO 
		WHERE v.ID_ARTICULO = '$buscar'
		UNION ALL
		SELECT   s.FECHA_SOLICITUD
		,		 CONCAT(s.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) NOTA
		,		 0 FISICO_INGRESO
		,		 v.CANTIDAD FISICO_SALIDA
		,		 0 FISICO_SALDO
		,		 0 PU
		,		 0 VALOR_INGRESO
		,		 0 VALOR_SALIDA
		,		 0 VALOR_SALDO
		,		 v.ID_ALMACEN
		,        v.ID_COMPRA
		,		 v.ID_ARTICULO
		,		 a.ARTICULO
		,		 s.ID_TIPO_VENTA
		FROM BAJA v JOIN SOLICITUD_BAJA s ON v.ID_SOLICITUD_BAJA = s.ID_SOLICITUD_BAJA
						 JOIN ARTICULO a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE v.ID_ARTICULO = '$buscar'
		UNION ALL
		SELECT   s.FECHA_SOLICITUD
		,		 CONCAT(s.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) NOTA
		,		 0 FISICO_INGRESO
		,		 v.CANTIDAD FISICO_SALIDA
		,		 0 FISICO_SALDO
		,		 0 PU
		,		 0 VALOR_INGRESO
		,		 0 VALOR_SALIDA
		,		 0 VALOR_SALDO
		,		 v.ID_ALMACEN
		,        v.ID_COMPRA
		,		 v.ID_ARTICULO
		,		 a.ARTICULO
		,		 s.ID_TIPO_VENTA
		FROM DEVOLUCION v JOIN SOLICITUD_DEV s ON v.ID_SOLICITUD_DEV = s.ID_SOLICITUD_DEV
						 JOIN ARTICULO a ON v.ID_ARTICULO = a.ID_ARTICULO
		WHERE v.ID_ARTICULO = '$buscar'
		ORDER BY 1) k
		ORDER BY 1 DESC LIMIT 1,1";
$aux = mysqli_query($cnx_compras, $sql1) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_aux = mysqli_fetch_assoc($aux);
$num_aux = mysqli_num_rows($aux); 
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
		  	  navside(item);?>
        
        <div class="container-fluid">
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
               <h2 class="sub-header"><?PHP echo item; ?></h2>
               <form class="form-horizontal" role="form"  action="" >
                  <fieldset>
                      <div class="form-group">
                      	<label  class="col-sm-4 control-label">ARTICULO</label>
            				<div class="col-sm-7">
                              <select class="form-control combobox" name="BUSCAR">
                                  <option></option>
                                      <?PHP
                                          /*$sql="SELECT DISTINCT a.ID_ARTICULO, a.ARTICULO
                                                FROM articulo a JOIN almacen c ON a.ID_ARTICULO = c.ID_ARTICULO
                                                ORDER BY 1";*/
																					$sql = "SELECT * FROM stock";
                                          $articulo = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
                                          $row_articulo = mysqli_fetch_assoc($articulo);
                                          $num_articulo = mysqli_num_rows($articulo);
                                       do{ ?>
                                          <option value="<?PHP echo $row_articulo['ID_ARTICULO']; ?>"><?PHP echo $row_articulo['NOMBRE_BUSQUEDA']; ?></option>
                                      <?PHP }while($row_articulo = mysqli_fetch_assoc($articulo))?>
                              </select>
                              <button class="btn btn-success" id="submit">BUSCAR</button>
                           <a id="impresion" class="btn btn-primary" href="ItemImpresion.php?ARTICULO=<?PHP echo $buscar; ?>">IMPRESION</a>
                           </div>
                           
                      </div>
                      <!--<div><label>FECHA</label><input type="text" name="INICIO" class="calendario" value="<?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y') ?>"/> AL <input type="text" name="FIN" class="calendario" value="<?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y') ?>"/></div>-->
                  
                  </fieldset>
              </form>
              
              <section class="table-responsive">
                <table class="table table-condensed">
                    <tr>
                        <td><strong>ARTICULO: </strong><?PHP if(isset($row_pedido['ARTICULO'])){echo $row_pedido['ARTICULO'];} ?></td>
                    </tr>
                    <!--<tr>
                        <td><strong>UNIDAD: </strong></td>
                    </tr>-->
                    <tr>
                        <td><strong>CODIGO: </strong><?PHP if(isset($row_pedido['ID_ARTICULO'])){echo $row_pedido['ID_ARTICULO'];} ?></td>
                    </tr>
                    <!--<tr>
                        <td><strong>TOTAL EXISTENCIAS: </strong></td></tr>
                    <tr>
                        <td>SALDO: </td>
                    </tr>-->
                </table>
            </section>
              
              <div class="table-responsive" >
              	<table  class="table table-striped table-hover table-bordered table-condensed">
            		<thead class="ui-widget-header ui-corner-all">
                        <tr>
                            <th rowspan="2">FECHA</th>
                            <th rowspan="2">NRO. COMPROBANTE</th>
                            <th colspan="3">FISICO</th>
                            <th rowspan="2">P/UNIT.</th>
                            <th colspan="3">VALORADO</th>
                        </tr>
                        <tr>
                            <th>INGRESO</th>
                            <th>SALIDA</th>
                            <th>SALDO</th>
                            <th>INGRESO</th>
                            <th>SALIDA</th>
                            <th>SALDO</th>
                        </tr>      
                    </thead>
                    <tbody>
                        <?PHP
                            $total_fisico = 0;
                            $total_valorado = 0;
                            $pu = 0;
                            $cont =1;
                            do{
                        ?>
                            <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                <td><?PHP if(isset($row_pedido['FECHA_REGISTRO'])){echo date('d-m-Y H:i:s',strtotime($row_pedido['FECHA_REGISTRO']));} ?></td>
                                <?php if(isset($row_pedido['NOTA'])){?>
                                <?PHP if(strpos($row_pedido['NOTA'],$var_baja) == $var_baja){  ?>
                                     <td align="right" style="background-color: #0FF "><?PHP echo $row_pedido['NOTA']; ?></td>
                                <?PHP }else if(strpos($row_pedido['NOTA'],$var_dev) == $var_dev){ ?>
                                                <td align="right" style="background-color: #FF0"><?PHP echo $row_pedido['NOTA']; ?></td>
                                <?PHP }else if(strpos($row_pedido['NOTA'],$var_consumo) == $var_consumo){ ?>
                                        <td align="right" style="background-color: #0F0"><?PHP echo $row_pedido['NOTA']; ?></td>
                                <?PHP }else if(strpos($row_pedido['NOTA'],$var_credito) == $var_credito){ ?>
                                        <td align="right" style="background-color: #F90"><?PHP echo $row_pedido['NOTA']; ?></td>
                                <?PHP } else {?>
                                    <td align="right"><?PHP echo $row_pedido['NOTA']; ?></td>
                                <?PHP } } ?>
                                
                                <td align="right"><?PHP if(isset($row_pedido['ENTRADA'])){echo $row_pedido['ENTRADA'];} ?></td>
                                <td align="right"><?PHP if(isset($row_pedido['SALIDA'])){echo $row_pedido['SALIDA'];} ?></td>
                                <td align="right"><?PHP if(isset($row_pedido['ENTRADA'])){echo $total_fisico = $total_fisico + $row_pedido['ENTRADA'] - $row_pedido['SALIDA'];} ?></td>
                                <td align="right"><strong><?PHP if(isset($row_pedido['PU'])){echo round($row_pedido['PU'],4);} ?></strong></td>
                                <td align="right"><?PHP if(isset($row_pedido['VALOR_INGRESO'])){echo round($row_pedido['VALOR_INGRESO'],2);} ?></td>
                                <td align="right"><?PHP if(isset($row_pedido['PU'])){echo round($row_pedido['PU']*$row_pedido['SALIDA'],2);} ?></td>
                                <?php if(isset($row_pedido['ID_TIPO_VENTA'])){?>
																<td align="right"><?PHP if($row_pedido['ID_TIPO_VENTA']=='CSM')
                                                            echo round($total_valorado = $total_valorado + $row_pedido['VALOR_INGRESO'] - 0*$pu*$row_pedido['SALIDA'],2);
                                                        else
                                                            echo round($total_valorado = $total_valorado + $row_pedido['VALOR_INGRESO'] - $row_pedido['PU']*$row_pedido['SALIDA'],2);} ?></td>
                            </tr>
                        <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
                    </tbody>
                </table>
            </div>
               
        	</div>
        </div>
              
   
</body>
</html>