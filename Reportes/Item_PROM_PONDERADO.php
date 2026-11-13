<?PHP require_once('../cnx/cnx_compras.php');
	  include_once('../Funciones/funciones.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);
					
$inicio = fecha_amd($_REQUEST['INICIO']);
$fin = fecha_amd($_REQUEST['FIN']);
$buscar =$_REQUEST['BUSCAR'];
/*
$sql="SELECT c.FECHA_REGISTRO, 
			 a.ID_ARTICULO, 
			 r.ARTICULO, 
			 CONCAT('F-',LPAD(c.NRO_FACTURA,'7','0')) TIPO,
			 a.ENTRADA, 
			 a.SALIDA,
			 (c.TOTAL * 0.87)/a.ENTRADA PU,
			 c.TOTAL *0.87 PC,
			 0 PV
	  FROM almacen a JOIN articulo r ON a.ID_ARTICULO = r.ID_ARTICULO
					 JOIN compra c ON a.ID_COMPRA = c.ID_COMPRA
	  WHERE a.ID_ARTICULO = '$buscar'
	  UNION
	  SELECT s.FECHA_SOLICITUD, 
	  		 v.ID_ARTICULO, 
			 a.ARTICULO, 
			 CONCAT(t.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) TIPO,
			 '0', 
			 v.CANTIDAD,
			 0 PU,
			 '0' PC,
			 v.PRECIO_VENTA PV
	  FROM venta v JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
				   JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
				   JOIN tipo_venta t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
	  WHERE v.ID_ARTICULO = '$buscar'
	  UNION
	  SELECT s.FECHA_SOLICITUD, 
	  		 v.ID_ARTICULO, 
			 a.ARTICULO, 
			 CONCAT(t.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) TIPO,
			 '0', 
			 v.CANTIDAD,
			 0 PU,
			 '0' PC,
			 v.PRECIO_VENTA PV
	  FROM venta_credito v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
				   JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
				   JOIN tipo_venta t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
	  WHERE v.ID_ARTICULO = '$buscar'
	  UNION
	  SELECT s.FECHA_SOLICITUD, 
	  		 v.ID_ARTICULO, 
			 a.ARTICULO, 
			 t.TIPO,
			 '0', 
			 v.CANTIDAD,
			 0 PU,
			 '0' PC,
			 v.PRECIO_VENTA PV
	  FROM vale v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
				   JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
				   JOIN tipo_venta t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
	  WHERE v.ID_ARTICULO = '$buscar'
	  UNION
	  SELECT b.FECHA_REGISTRO, 
	  		 b.ID_ARTICULO, 
			 a.ARTICULO, 
			 t.TIPO,
			 '0', 
			 b.CANTIDAD,
			 0 PU,
			 '0' PC,
			 b.PRECIO_VENTA PV
	  FROM baja b JOIN articulo a On b.ID_ARTICULO = a.ID_ARTICULO
				   JOIN solicitud_BAJA s ON b.ID_SOLICITUD_BAJA = s.ID_SOLICITUD_BAJA
				   JOIN tipo_venta t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
	  WHERE b.ID_ARTICULO = '$buscar'
	  UNION
	  SELECT b.FECHA_REGISTRO, 
	  		 b.ID_ARTICULO, 
			 a.ARTICULO, 
			 t.TIPO,
			 '0', 
			 b.CANTIDAD,
			 0 PU,
			 '0' PC,
			 b.PRECIO_VENTA PV
	  FROM devolucion b JOIN articulo a On b.ID_ARTICULO = a.ID_ARTICULO
				   JOIN solicitud_DEV s ON b.ID_SOLICITUD_DEV = s.ID_SOLICITUD_DEV
				   JOIN tipo_venta t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
	  WHERE b.ID_ARTICULO = '$buscar'
	  ORDER BY 1";
	  
	  
$sql = "SELECT 	 FECHA_REGISTRO
		,		 ID_ARTICULO
		,		 ARTICULO
		,		 TIPO
		,		 ENTRADA
		,	 	 SALIDA
		,		 PU
		,		 PC
		,		 IF(SALIDA>0,SALIDA*PU,0) PV
		,       @sum := @sum + PC + IF(SALIDA>0,SALIDA*PU,0) SUMA
		FROM(	SELECT 	 c.FECHA_REGISTRO
				, 		 a.ID_ARTICULO
				, 		 r.ARTICULO
				, 		 CONCAT('F-',LPAD(c.NRO_FACTURA,'7','0')) TIPO
				,		 a.ENTRADA
				, 		 a.SALIDA
				,		 (c.TOTAL * 0.87)/a.ENTRADA PU
				,		 c.TOTAL *0.87 PC
				,		 0 PV
				FROM almacen a JOIN articulo r ON a.ID_ARTICULO = r.ID_ARTICULO
								   JOIN compra c ON a.ID_COMPRA = c.ID_COMPRA
				WHERE a.ID_ARTICULO = '1'
				UNION
				SELECT   s.FECHA_SOLICITUD
				, 		 v.ID_ARTICULO
				, 		 a.ARTICULO
				, 		 CONCAT(t.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) TIPO
				,		 0
				, 		 v.CANTIDAD
				,		 0 PU
				,        0 PC
				,        v.PRECIO_VENTA PV
				FROM venta v JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
								JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
								JOIN tipo_venta t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
				WHERE v.ID_ARTICULO = '1') KARDEX , (SELECT @sum :=0) r
		ORDER BY 1";*/
		
$sql="SELECT FECHA_REGISTRO
,		  NOTA
,		 FISICO_INGRESO ENTRADA
,		 FISICO_SALIDA SALIDA
,		 0 FISICO_SALDO
,        0 PU
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
		,		 ((c.TOTAL - c.ICE) * 0.87)+c.ICE VALOR_INGRESO
		,		 0 VALOR_SALIDA
		,		 0 VALOR_SALDO
		,		 0 ID_ALMACEN
		,        c.ID_COMPRA
		,		 c.ID_ARTICULO
		,		 a.ARTICULO
		,		 'F' ID_TIPO_VENTA
		FROM COMPRA c JOIN ARTICULO a ON c.ID_ARTICULO = a.ID_ARTICULO
		WHERE c.ID_ARTICULO ='$buscar'
		UNION
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
		UNION
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
		UNION
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
		ORDER BY 1) k";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 


?>
<!doctype html>
<html lang="es">
<head>
	<title>REPORTE DIARIO</title>
    <link rel="stylesheet" href="../css/start/jquery-ui-1.9.2.custom.css">
    <link rel="stylesheet" href="../css/principal.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/estilo_form.css" >
    <link rel="stylesheet" href="../css/estilo_tabla.css" >
    
    <!-- JQUERY -->
        <!-- SCRIPT DE CONFIRMACION PARA BORRAR -->
        <script src="../js/js_confirma_borrar.js"></script>   
        <!-- LLAMADA DE SCRIPTS JS -->
		<script src="../js/jquery-1.8.3.js"></script>
        <script src="../js/jquery-ui-1.9.2.custom.min.js"></script>
        <!-- JQUERY BOTON -->
		<script src="../js/js_boton.js"></script>
        <!-- JQUERY AUTOCOMPLETAR -->
		<script src="../js/js_autocompletar.js"></script>
        <!-- JQUERY CALENDARIO -->
		<script src="../js/js_calendario.js"></script>
        <!-- SCRIPT DE CONFIRMACION PARA ANULAR BOLETA -->
        <script src="../js/js_confirma_anular.js"></script>
        
</head>
<body class="ui-widget">
	
	<header class="ui-widget-header">
    	<h1>REPORTE DIARIO DE VENTA</h1>
    </header>
    	<?PHP include('../menu.php'); ?>
    <section>
    <form action="" >
    	<fieldset>
        <legend>Buscar</legend>
    			<div><label>ARTICULO</label>
                	<select name="BUSCAR" class="combobox">
                		<option></option>
							<?PHP
                                $sql="SELECT DISTINCT a.ID_ARTICULO, a.ARTICULO
                                      FROM articulo a JOIN almacen c ON a.ID_ARTICULO = c.ID_ARTICULO
                                      ORDER BY 1";
                                $articulo = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
                                $row_articulo = mysqli_fetch_assoc($articulo);
                                $num_articulo = mysqli_num_rows($articulo);
                             do{ ?>
                                <option value="<?PHP echo $row_articulo['ID_ARTICULO']; ?>"><?PHP echo $row_articulo['ARTICULO'] ?></option>
                            <?PHP }while($row_articulo = mysqli_fetch_assoc($articulo))?>
                    </select></div>
    			<div><label>FECHA</label><input type="text" name="INICIO" class="calendario" value="<?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y') ?>"/> AL <input type="text" name="FIN" class="calendario" value="<?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y') ?>"/></div>
                <div><input type="submit" name="BOTON" value="BUSCAR" /><a id="impresion" href="ItemImpresion.php?INICIO=<?PHP echo $inicio; ?>&amp;FIN=<?PHP echo $fin; ?>&amp;ARTICULO=<?PHP echo $buscar; ?>">Impresion</a></div>
		
    	</fieldset>
    </form>
	</section>
    <hr />
    <section>
    	<table>
        	<tr>
            	<td><strong>ARTICULO: </strong><?PHP echo $row_pedido['ARTICULO']; ?></td>
            </tr>
            <tr>
            	<td><strong>UNIDAD: </strong></td>
            </tr>
            <tr>
            	<td><strong>CODIGO: </strong><?PHP echo $row_pedido['ID_ARTICULO']; ?></td>
            </tr>
            <tr>
            	<td><strong>TOTAL EXISTENCIAS: </strong></td></tr>
            <tr>
            	<td>SALDO: </td>
            </tr>
            <tr></tr>
        </table>
    </section>
    <section>
        <table class="ui-tinytbl ui-corner-all">
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
                        <td><?PHP echo date('d-m-Y H:i:s',strtotime($row_pedido['FECHA_REGISTRO'])); ?></td>
                        <td align="right"><?PHP echo $row_pedido['NOTA']; ?></td>
                        <td align="right"><?PHP echo $row_pedido['ENTRADA']; ?></td>
                        <td align="right"><?PHP echo $row_pedido['SALIDA']; ?></td>
                        <td align="right"><?PHP echo $total_fisico = $total_fisico + $row_pedido['ENTRADA'] - $row_pedido['SALIDA']; ?></td>
                        <td align="right"><?PHP if($total_fisico == 0||$row_pedido['ID_TIPO_VENTA']=='CSM')
													echo 0;
												else
													echo round($pu=$total_valorado/$total_fisico,4);?></td>
                        <td align="right"><?PHP echo round($row_pedido['VALOR_INGRESO'],4); ?></td>
                        <td align="right"><?PHP if($row_pedido['ID_TIPO_VENTA']=='CSM')
													echo 0;
												else
													echo round($pu*$row_pedido['SALIDA'],4); ?></td>
                        <td align="right"><?PHP if($row_pedido['ID_TIPO_VENTA']=='CSM')
													echo round($total_valorado = $total_valorado + $row_pedido['VALOR_INGRESO'] - 0*$pu*$row_pedido['SALIDA'],4);
												else
													echo round($total_valorado = $total_valorado + $row_pedido['VALOR_INGRESO'] - $pu*$row_pedido['SALIDA'],4); ?></td>
                    </tr>
                <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
            </tbody>
        </table>
    </section>
</body>
</html>