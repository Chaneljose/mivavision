<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Funciones/Funciones.php');
	  require_once('../Definiciones/Titulo.php'); 
      //session_start(); 
      $var_tipo = '';
      if(isset($_SESSION['SES_TIPO'])){
          $var_tipo = $_SESSION['SES_TIPO'];
      }   
      ?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$inicio = $_REQUEST['INICIO'];
$fin = $_REQUEST['FIN'];

$sql_empresa = "SELECT * FROM empresa";
$empresa = mysqli_query($cnx_compras, $sql_empresa) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_empresa = mysqli_fetch_assoc($empresa);
$num_empresa = mysqli_num_rows($empresa);

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
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/jquery.ui.tinytbl.css">
    <style type="text/css">
    .f {
        font-family: Verdana, Geneva, sans-serif;
        font-size: 14px;
    }

    .fuente {
        font-family: Verdana, Geneva, sans-serif;
    }

    .fuente {
        font-family: Verdana, Geneva, sans-serif;
    }

    .fuente {
        font-family: Verdana, Geneva, sans-serif;
        font-size: 12px;
    }
    </style>
    <title>REPORTE SALIDAS</title>
</head>

<body>
    <table border="0" class="fuente">
        <tr>
            <td>
                <table width="917" border="0">
                    <tr>
                        <td width="388"><img src="../Iconos/logo_cabecera.jpg" width="220" height="48"/></td>
                        <td width="177"> </td>
                        <td width="336"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" class="fuente">
                <strong>REPORTE DE VENTAS DEL:
                    <?PHP echo $inicio; ?> AL
                    <?PHP echo $fin; ?>
                </strong>
            </td>
        </tr>
        <tr>
            <td>
                <h2>
                    <hr />
                    <strong>
                        TOTAL Bs.:
                        <?PHP echo round($row_total['SUM_TOTAL'] + $row_vale['SUM_TOTAL'] + $row_credito['SUM_TOTAL'],2);?>
                    </strong>
                    <hr />
                </h2>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0">
                    <thead>
                        <tr>
                            <th>NRO NOTA</th>
                            <th>FECHA</th>
                            <th>TIPO VENTA</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?PHP
                                $cont =1;
                                $c=0;
                                do{
                            ?>
                        <tr>
                            <td align="center" width="25%">
                                <?PHP 
                                if(isset($row_pedido['NRO_NOTA'])){
                                    echo $row_pedido['NRO_NOTA'];
                                }
                                ?>
                            </td>
                            <td width="25%">
                                <?PHP 
                                if(isset($row_pedido['FECHA_SOLICITUD'])){
                                    echo $row_pedido['FECHA_SOLICITUD'];
                                } 
                                ?>
                            </td>
                            <td align="center" width="25%">
                                <?PHP 
                                if(isset($row_pedido['TIPO'])){
                                    echo $row_pedido['TIPO']; 
                                }
                                ?>
                            </td>
                            <td align="right" width="25%">
                                <?PHP 
                                if(isset($row_pedido['TOTAL'])){
                                    echo round($row_pedido['TOTAL'],2);
                                } 
                                ?>
                            </td>
                        </tr>
                        <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" class="fuente" colspan="4">
                <hr />
                <p><?php echo $row_empresa['NOMBRE_EMPRESA']; ?>, Cochabamba
                    <?PHP date_default_timezone_set('America/La_Paz'); 
                        echo date('Y');?>. Todos los Derechos Resevervados
                </p>
            </td>
        </tr>
    </table>
</body>

</html>