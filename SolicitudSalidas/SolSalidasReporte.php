<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Funciones/Funciones.php');
	  require_once('../Definiciones/Titulo.php'); 
      //session_start(); 
      $var_tipo = '';
      $var_active = "ventas";
      if(isset($_SESSION['SES_TIPO'])){
          $var_tipo = $_SESSION['SES_TIPO'];
      }   
      ?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$inicio = fecha_amd($_REQUEST['INICIO']);
$fin = fecha_amd($_REQUEST['FIN']);

$sql="	SELECT s.ID_SOLICITUD_VENTA
	  	,		 s.NRO_NOTA
	  	,		 s.FECHA_SOLICITUD
	  	, 	 SUM(v.TOTAL) TOTAL
	  	,      t.TIPO
	  	FROM SOLICITUD_VENTA s JOIN VENTA v ON s.ID_SOLICITUD_VENTA = v.ID_SOLICITUD_VENTA
	  						   JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
	  	WHERE FECHA_SOLICITUD BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'
	  	GROUP BY 1,2,3,5
		UNION
	    SELECT s.ID_SOLICITUD_VENTA
	  	,		 s.NRO_NOTA
	  	,		 s.FECHA_SOLICITUD
	  	, 	 SUM(v.TOTAL) TOTAL
	  	,      t.TIPO
	  	FROM SOLICITUD_VENTA s JOIN VENTA_CREDITO v ON s.ID_SOLICITUD_VENTA = v.ID_SOLICITUD_VENTA
	  						   JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
	  	WHERE FECHA_SOLICITUD BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'
	  	GROUP BY 1,2,3,5
	  	UNION
		SELECT s.ID_SOLICITUD_VENTA
		,		 s.NRO_NOTA
		,		 s.FECHA_SOLICITUD
		, 	    SUM(l.TOTAL) TOTAL
		,      t.TIPO
		FROM SOLICITUD_VENTA s JOIN VALE l ON s.ID_SOLICITUD_VENTA = l.ID_SOLICITUD_VENTA
							   JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
		WHERE FECHA_SOLICITUD BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'
		GROUP BY 1,2,3,5
		ORDER BY 1";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

$sql2="SELECT  SUM(v.TOTAL) SUM_TOTAL
	  FROM SOLICITUD_VENTA s JOIN VENTA v ON s.ID_SOLICITUD_VENTA = v.ID_SOLICITUD_VENTA
	  						 JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
	  WHERE FECHA_SOLICITUD BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'";
$total = mysqli_query($cnx_compras, $sql2) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_total = mysqli_fetch_assoc($total);
$num_total = mysqli_num_rows($total); 

$sql3="SELECT  SUM(v.TOTAL) SUM_TOTAL
	  FROM SOLICITUD_VENTA s JOIN VALE v ON s.ID_SOLICITUD_VENTA = v.ID_SOLICITUD_VENTA
	  						 JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
	  WHERE FECHA_SOLICITUD BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'";
$total_vale = mysqli_query($cnx_compras, $sql3) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_vale = mysqli_fetch_assoc($total_vale);
$num_vale = mysqli_num_rows($total_vale); 

$sql4="SELECT  SUM(v.TOTAL) SUM_TOTAL
	  FROM SOLICITUD_VENTA s JOIN VENTA_CREDITO v ON s.ID_SOLICITUD_VENTA = v.ID_SOLICITUD_VENTA
	  						 JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
	  WHERE FECHA_SOLICITUD BETWEEN '$inicio 00:00:00' and '$fin 23:59:59'";
$total_credito = mysqli_query($cnx_compras, $sql4) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_credito = mysqli_fetch_assoc($total_credito);
$num_credito = mysqli_num_rows($total_credito); 
?>
<!doctype html>
<html lang="es">
<?PHP head1(salidas); ?>
<body>
    <?PHP include('../menu.php');
			  require_once('../NavsideSalidas.php');
		  	  navbar(salidas, $var_tipo, $var_active);
		  	  navside(reportes_sal);?>
    <div class="container-fluid">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="sub-header">VENTAS</h2>
            <form class="form-inline" role="form" action="">
                <fieldset>
                    <div class="form-group">
                        <label for="INICIO" class="col-sm-3 control-label">FECHA</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control calendario" id="INICIO" name="INICIO"
                                placeholder="FECHA INICIO" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="INICIO" class="col-sm-3 control-label">AL</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control calendario" id="FIN" name="FIN"
                                placeholder="FECHA FIN" />
                        </div>
                    </div>
                    <button class="btn btn-success" id="submit">BUSCAR</button>
                    <a class="btn btn-info" id="impresion"
                        href="SolSalidasReporteImpresion.php?INICIO=<?PHP echo $inicio; ?>&FIN=<?PHP echo $fin; ?>">IMPRESION</a>
                </fieldset>
            </form>
            <h3 class="sub-header">FECHA:
                <?PHP echo fecha_dma($inicio);?> AL
                <?PHP echo fecha_dma($fin);?>
            </h3>
            <h3 class="sub-header">TOTAL Bs.:
                <?PHP echo round($row_total['SUM_TOTAL'] + $row_vale['SUM_TOTAL'] + $row_credito['SUM_TOTAL'],2);?>
            </h3>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>NRO NOTA</th>
                            <th>FECHA</th>
                            <th>TIPO VENTA</th>
                            <th>TOTAL</th>
                            <th>VER</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?PHP
                                $cont =1;
                                $c=0;
                                do{
                            ?>
                        <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                            <td align="center" class="resaltar">
                                <?PHP 
                                if(isset($row_pedido['NRO_NOTA'])){
                                echo $row_pedido['NRO_NOTA']; 
                                }
                                ?>
                            </td>
                            <td>
                                <?PHP 
                                if(isset($row_pedido['FECHA_SOLICITUD'])){
                                echo $row_pedido['FECHA_SOLICITUD']; 
                                }
                                ?>
                            </td>
                            <td class="resaltar">
                                <?PHP 
                                if(isset($row_pedido['TIPO'])){
                                echo $row_pedido['TIPO']; 
                                }
                                ?>
                            </td>
                            <td align="right">
                                <?PHP 
                                if(isset($row_pedido['TOTAL'])){
                                echo round($row_pedido['TOTAL'],2); 
                                }
                                ?>
                            </td>
                            <td align="center">
                                <a href="SolSalidasTabla.php?BUSCAR=<?PHP echo $row_pedido['ID_SOLICITUD_VENTA']; ?>&INICIO=<?php echo $inicio;?>&FIN=<?php echo $fin;?>">
                                    <img title="EDITAR" src="../Iconos/COMPUTADORA.ico" width="20" height="20"
                                        alt="VER" />
                                </a>
                            </td>
                        </tr>
                        <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>