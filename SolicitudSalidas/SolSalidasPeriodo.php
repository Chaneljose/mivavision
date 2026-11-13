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

/*$inicio = fecha_amd($_REQUEST['INICIO']);
$fin = fecha_amd($_REQUEST['FIN']);*/


//$codigo = $_REQUEST['BUSCAR'];
$var_mes = $_REQUEST['MES'];
$var_gestion =$_REQUEST['GESTION'];

$sql_antes="	SELECT FECHA_SOLICITUD
		,		 ROUND(SUM(TOTAL),2) TOTAL
		FROM(SELECT s.ID_SOLICITUD_VENTA
				,		 s.NRO_NOTA
				,		 DATE_FORMAT(s.FECHA_SOLICITUD , '%d-%m-%Y') FECHA_SOLICITUD
				, 	 SUM(v.TOTAL) TOTAL
				,      t.TIPO
				FROM SOLICITUD_VENTA s JOIN VENTA v ON s.ID_SOLICITUD_VENTA = v.ID_SOLICITUD_VENTA
									   JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
				WHERE MONTH(FECHA_SOLICITUD) = '$var_mes' and YEAR(FECHA_SOLICITUD)  = '$var_gestion'
				GROUP BY 1,2,3,5
				UNION
				SELECT s.ID_SOLICITUD_VENTA
				,		 s.NRO_NOTA
				,		 DATE_FORMAT(s.FECHA_SOLICITUD , '%d-%m-%Y') FECHA_SOLICITUD
				, 	 SUM(v.TOTAL) TOTAL
				,      t.TIPO
				FROM SOLICITUD_VENTA s JOIN VENTA_CREDITO v ON s.ID_SOLICITUD_VENTA = v.ID_SOLICITUD_VENTA
									   JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
				WHERE MONTH(FECHA_SOLICITUD) = '$var_mes' and YEAR(FECHA_SOLICITUD)  = '$var_gestion'
				GROUP BY 1,2,3,5
				UNION
				SELECT s.ID_SOLICITUD_VENTA
				,		 s.NRO_NOTA
				,		 DATE_FORMAT(s.FECHA_SOLICITUD , '%d-%m-%Y') FECHA_SOLICITUD
				, 	    SUM(l.TOTAL) TOTAL
				,      t.TIPO
				FROM SOLICITUD_VENTA s JOIN VALE l ON s.ID_SOLICITUD_VENTA = l.ID_SOLICITUD_VENTA
									   JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
				WHERE MONTH(FECHA_SOLICITUD) = '$var_mes' and YEAR(FECHA_SOLICITUD)  = '$var_gestion'
				GROUP BY 1,2,3,5
				ORDER BY 1) PERIODO
		GROUP BY 1";
		
$sql = "SELECT FECHA_SOLICITUD, ROUND(SUM(QR),2) QR, ROUND(SUM(CNT),2) CNT, ROUND(SUM(TOTAL),2) TOTAL
FROM
(SELECT s.ID_SOLICITUD_VENTA
				,		 s.NRO_NOTA
				,		 DATE_FORMAT(s.FECHA_SOLICITUD , '%d-%m-%Y') FECHA_SOLICITUD
				, 	 SUM(v.TOTAL) QR
				, 0 CNT
				, 0 TOTAL
				,      t.TIPO
				FROM SOLICITUD_VENTA s JOIN VENTA v ON s.ID_SOLICITUD_VENTA = v.ID_SOLICITUD_VENTA
									   JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
				WHERE MONTH(FECHA_SOLICITUD) = '$var_mes' and YEAR(FECHA_SOLICITUD)  = '$var_gestion' AND s.ID_TIPO_VENTA = 'QR'
				GROUP BY 1,2,3,7
UNION 
SELECT s.ID_SOLICITUD_VENTA
				,		 s.NRO_NOTA
				,		 DATE_FORMAT(s.FECHA_SOLICITUD , '%d-%m-%Y') FECHA_SOLICITUD
				, 0 QR
				, 	 SUM(v.TOTAL) CNT
				, 0 TOTAL
				,      t.TIPO
				FROM SOLICITUD_VENTA s JOIN VENTA v ON s.ID_SOLICITUD_VENTA = v.ID_SOLICITUD_VENTA
									   JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
				WHERE MONTH(FECHA_SOLICITUD) = '$var_mes' and YEAR(FECHA_SOLICITUD)  = '$var_gestion' AND s.ID_TIPO_VENTA = 'CNT'
				GROUP BY 1,2,3,7
UNION 
SELECT s.ID_SOLICITUD_VENTA
				,		 s.NRO_NOTA
				,		 DATE_FORMAT(s.FECHA_SOLICITUD , '%d-%m-%Y') FECHA_SOLICITUD
				, 0 QR
				, 0 CNT
				, 	 SUM(v.TOTAL) TOTAL
				,      t.TIPO
				FROM SOLICITUD_VENTA s JOIN VENTA v ON s.ID_SOLICITUD_VENTA = v.ID_SOLICITUD_VENTA
									   JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
				WHERE MONTH(FECHA_SOLICITUD) = '$var_mes' and YEAR(FECHA_SOLICITUD)  = '$var_gestion'
				GROUP BY 1,2,3,7
) PERIODO GROUP BY 1";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 
//echo $sql;

$sql2="SELECT  SUM(v.TOTAL) SUM_TOTAL
	  FROM SOLICITUD_VENTA s JOIN VENTA v ON s.ID_SOLICITUD_VENTA = v.ID_SOLICITUD_VENTA
	  						 JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
				WHERE MONTH(FECHA_SOLICITUD) = '$var_mes' and YEAR(FECHA_SOLICITUD)  = '$var_gestion'";
//echo $sql2;
$total = mysqli_query($cnx_compras, $sql2) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_total = mysqli_fetch_assoc($total);
$num_total = mysqli_num_rows($total); 

$sql3="SELECT  SUM(v.TOTAL) SUM_TOTAL
	  FROM SOLICITUD_VENTA s JOIN VALE v ON s.ID_SOLICITUD_VENTA = v.ID_SOLICITUD_VENTA
	  						 JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
				WHERE MONTH(FECHA_SOLICITUD) = '$var_mes' and YEAR(FECHA_SOLICITUD)  = '$var_gestion'";
$total_vale = mysqli_query($cnx_compras, $sql3) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_vale = mysqli_fetch_assoc($total_vale);
$num_vale = mysqli_num_rows($total_vale); 

$sql4="SELECT  SUM(v.TOTAL) SUM_TOTAL
	  FROM SOLICITUD_VENTA s JOIN VENTA_CREDITO v ON s.ID_SOLICITUD_VENTA = v.ID_SOLICITUD_VENTA
	  						 JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
				WHERE MONTH(FECHA_SOLICITUD) = '$var_mes' and YEAR(FECHA_SOLICITUD)  = '$var_gestion'";
$total_credito = mysqli_query($cnx_compras, $sql4) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_credito = mysqli_fetch_assoc($total_credito);
$num_credito = mysqli_num_rows($total_credito); 

$sql5 =" SELECT	ID_MES
		 , 		MES 
		 FROM mes";
$mes = mysqli_query($cnx_compras, $sql5) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_mes = mysqli_fetch_assoc($mes);
$num_mes = mysqli_num_rows($mes); 

$sql6 =" SELECT	ID_MES
		 , 		MES 
		 FROM mes
		 WHERE ID_MES = MONTH(NOW())";
$mes_actual = mysqli_query($cnx_compras, $sql6) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_mes_actual = mysqli_fetch_assoc($mes_actual);
$num_mes_actual = mysqli_num_rows($mes_actual);

$sql7 =" SELECT	ID_GESTION
		 FROM gestion
		 ORDER BY 1 ASC";
$gestion = mysqli_query($cnx_compras, $sql7) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_gestion = mysqli_fetch_assoc($gestion);
$num_gestion = mysqli_num_rows($gestion);

$sql8 =" SELECT	ID_GESTION
		 FROM gestion
		 WHERE ID_GESTION = YEAR(NOW())";
$gestion_actual = mysqli_query($cnx_compras, $sql8) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_gestion_actual = mysqli_fetch_assoc($gestion_actual);
$num_gestion_actual = mysqli_num_rows($gestion_actual);

$sql9 =" SELECT	ID_MES
		 , 		MES 
		 FROM mes
		 WHERE ID_MES = '$var_mes'";
$mes_nombre = mysqli_query($cnx_compras, $sql9) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_mes_nombre = mysqli_fetch_assoc($mes_nombre);
$num_mes_nombre = mysqli_num_rows($mes_nombre);
$nombre_mes = '';
if(isset($row_mes_nombre['MES'])){
	$nombre_mes = $row_mes_nombre['MES'];
}

$sql_qr = "SELECT SUM(v.TOTAL) QR
FROM SOLICITUD_VENTA s JOIN VENTA v ON s.ID_SOLICITUD_VENTA = v.ID_SOLICITUD_VENTA
JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
WHERE MONTH(FECHA_SOLICITUD) = '$var_mes' and YEAR(FECHA_SOLICITUD)  = '$var_gestion' AND s.ID_TIPO_VENTA = 'QR'";
$total_qr = mysqli_query($cnx_compras, $sql_qr) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_total_qr = mysqli_fetch_assoc($total_qr);
$num_total_qr = mysqli_num_rows($total_qr); 

$sql_cnt = "SELECT SUM(v.TOTAL) CNT
FROM SOLICITUD_VENTA s JOIN VENTA v ON s.ID_SOLICITUD_VENTA = v.ID_SOLICITUD_VENTA
JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
WHERE MONTH(FECHA_SOLICITUD) = '$var_mes' and YEAR(FECHA_SOLICITUD)  = '$var_gestion' AND s.ID_TIPO_VENTA = 'CNT'";
$total_cnt = mysqli_query($cnx_compras, $sql_cnt) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_total_cnt = mysqli_fetch_assoc($total_cnt);
$num_total_cnt = mysqli_num_rows($total_cnt);
?>
<!doctype html>
<html lang="es">

<?PHP head1(salidas); ?>
<body>

    	<?PHP include('../menu.php');
			  require_once('../NavsideSalidas.php');
		  	  navbar(salidas, $var_tipo, $var_active);
		  	  navside(reportes_periodo);?>

    <div class="container-fluid">
    	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main"> 
        	   <h2 class="sub-header">VENTAS</h2>
                <form name="FormBuscar" action="">
                	<div class="form-group">
										<div class="col-sm-7">
											<label class="col-sm-2 control-label">BUSCAR</label>
										</div>
            				<div class="col-sm-7" >
											<select name="MES" class="form-control combobox">
												<option value="<?PHP if(isset($row_mes_actual['ID_MES'])){echo $row_mes_actual['ID_MES'];}?>">
													<?PHP if(isset($row_mes_actual['MES'])){echo $row_mes_actual['MES'];} ?>
												</option>
														<?PHP do{ ?>
												<option value="<?PHP if(isset($row_mes['ID_MES'])){echo $row_mes['ID_MES']; }?>">
													<?PHP if(isset($row_mes['MES'])){echo $row_mes['MES']; }?>
												</option>
												<?PHP } while($row_mes = mysqli_fetch_assoc($mes)) ?>
											</select>
                      <select name="GESTION" class="form-control combobox">
												<option value="<?PHP if(isset($row_gestion_actual['ID_GESTION'])){echo $row_gestion_actual['ID_GESTION'];} ?>">
													<?PHP if(isset($row_gestion_actual['ID_GESTION'])){echo $row_gestion_actual['ID_GESTION'];} ?>
												</option>
													<?PHP do{ ?>
												<option value="<?PHP if(isset($row_gestion['ID_GESTION'])){echo $row_gestion['ID_GESTION'];} ?>">
													<?PHP if(isset($row_gestion['ID_GESTION'])){echo $row_gestion['ID_GESTION'];} ?>
												</option>
													<?PHP } while($row_gestion = mysqli_fetch_assoc($gestion)) ?>
                      </select>
											<button class="btn btn-success" id="submit">BUSCAR</button>
										</div>
									</div>
                </form>
								<!--<div class="col-sm-8" style="border:1px solid brown;">-->
								<div class="col-sm-8">
									<h3 class="sub-header">VENTAS DEL MES DE <?PHP echo $nombre_mes ?> DE <?PHP echo $var_gestion ?> </h3>
									<h4>
									TOTAL QR Bs.: <?PHP 
																	if(isset($row_total_qr['QR'])){
																		echo round($row_total_qr['QR'],2);
																	}else{
																		echo '0';
																	}
																?>
									</h4>
									<h4>
									TOTAL CONTADO Bs.: <?PHP 
																			if(isset($row_total_cnt['CNT'])){
																				echo round($row_total_cnt['CNT'],2);
																			}else{
																				echo '0';
																			}
																		 ?>
									</h4>
                	<h3 class="sub-header">
										TOTAL Bs.: <?PHP 
																if(isset($row_total['SUM_TOTAL'])){
																	echo round($row_total['SUM_TOTAL'],2);
																}else{
																	echo '0';
																}
															 ?>
									</h3>
									<div class="col-sm-7">
											<div>
												<a class="btn btn-primary" href="SolSalidasPeriodoImpresion.php?MES=<?PHP echo $var_mes; ?>&amp;GESTION=<?PHP echo $var_gestion ?>">IMPRESION</a>
												<a class="btn btn-info" href="SolSalidasPeriodoExcel.php?MES=<?PHP echo $var_mes; ?>&amp;GESTION=<?PHP echo $var_gestion ?>">EXCEL</a>
											</div>
                    </div>
								</div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th style="text-align: center">FECHA</th>
																		<th style="text-align: center">PAGO QR</th>
																		<th style="text-align: center">PAGO CONTADO</th>
                                    <th style="text-align: center">TOTAL</th>
                                </tr>      
                            </thead>
                            <tbody>
                            <?PHP
                                $cont =1;
                                do{
                            ?>
                                <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                    <td><?PHP if(isset($row_pedido['FECHA_SOLICITUD'])){echo $row_pedido['FECHA_SOLICITUD'];} ?></td>
                                    <td align="right" ><?PHP if(isset($row_pedido['QR'])){echo $row_pedido['QR'];} ?></td>
																		<td align="right" ><?PHP if(isset($row_pedido['CNT'])){echo $row_pedido['CNT'];} ?></td>
																		<td align="right" ><?PHP if(isset($row_pedido['TOTAL'])){echo $row_pedido['TOTAL'];} ?></td>
                                </tr>
                            <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
                            </tbody>
                        </table>
                    </div>
                    
                    
    	</div>
    </div>
</body>
</html>