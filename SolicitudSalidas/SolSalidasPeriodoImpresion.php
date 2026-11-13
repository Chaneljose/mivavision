<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Funciones/Funciones.php');
	  require_once('../Definiciones/Titulo.php'); ?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

/*$inicio = fecha_amd($_REQUEST['INICIO']);
$fin = fecha_amd($_REQUEST['FIN']);


$codigo = $_REQUEST['BUSCAR'];*/
$var_mes = $_REQUEST['MES'];
$var_gestion =$_REQUEST['GESTION'];

$sql_empresa = "SELECT * FROM empresa";
$empresa = mysqli_query($cnx_compras, $sql_empresa) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_empresa = mysqli_fetch_assoc($empresa);
$num_empresa = mysqli_num_rows($empresa);

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

$sql2="SELECT  SUM(v.TOTAL) SUM_TOTAL
	  FROM SOLICITUD_VENTA s JOIN VENTA v ON s.ID_SOLICITUD_VENTA = v.ID_SOLICITUD_VENTA
	  						 JOIN TIPO_VENTA t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
				WHERE MONTH(FECHA_SOLICITUD) = '$var_mes' and YEAR(FECHA_SOLICITUD)  = '$var_gestion'";
$total = mysqli_query($cnx_compras, $sql2) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_total = mysqli_fetch_assoc($total);
$num_total = mysqli_num_rows($total); 

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

$sql2 =" SELECT	ID_MES
		 , 		MES 
		 FROM mes";
$mes = mysqli_query($cnx_compras, $sql2) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_mes = mysqli_fetch_assoc($mes);
$num_mes = mysqli_num_rows($mes); 

$sql3 =" SELECT	ID_MES
		 , 		MES 
		 FROM mes
		 WHERE ID_MES = MONTH(NOW())";
$mes_actual = mysqli_query($cnx_compras, $sql3) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_mes_actual = mysqli_fetch_assoc($mes_actual);
$num_mes_actual = mysqli_num_rows($mes_actual);

$sql4 =" SELECT	ID_GESTION
		 FROM gestion
		 ORDER BY 1 DESC";
$gestion = mysqli_query($cnx_compras, $sql4) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_gestion = mysqli_fetch_assoc($gestion);
$num_gestion = mysqli_num_rows($gestion);

$sql5 =" SELECT	ID_MES
		 , 		MES 
		 FROM mes
		 WHERE ID_MES = '$var_mes'";
$mes_nombre = mysqli_query($cnx_compras, $sql5) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_mes_nombre = mysqli_fetch_assoc($mes_nombre);
$num_mes_nombre = mysqli_num_rows($mes_nombre);

$nombre_mes = '';
if(isset($row_mes_nombre['MES'])){
    $nombre_mes = $row_mes_nombre['MES'];
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <!--<link rel="stylesheet" href="../css/start/jquery-ui-1.8.21.custom.css">-->
    <link rel="stylesheet" href="../css/jquery.ui.tinytbl.css">

    <!-- LLAMADA DE SCRIPTS JS -->
    <script src="../js/jquery-1.7.2.min.js"></script>
    <script src="../js/jquery-ui-1.8.21.custom.min.js"></script>

    <!-- EJECUCION DE DIALOGO DE COFIRMACION-->
    <script src="../js/js_dialogo.js"></script>

    <!-- JQUERY BOTON -->
    <script src="../js/js_boton.js"></script>

    <!-- JQUERY GRID -->
    <link rel="stylesheet" href="../jqgrid/css/ui.jqgrid.css">
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
    <script src="../jqgrid/js/i18n/grid.locale-es.js"></script>
    <script src="../jqgrid/js/jquery.jqGrid.min.js"></script>

    <!-- JQUERY TABLA -->
    <script src="../js/jquery.ui.tinytbl.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('.ui-tinytable').tinytbl({
            direction: 'ltr', // text-direction (default: 'ltr')
            thead: true, // fixed table thead
            tfoot: true, // fixed table tfoot
            cols: 1, // fixed number of columns
            width: 'auto', // table width (default: 'auto')
            height: 'auto' // table height (default: 'auto')
        });
    });
    </script>

    <script>
    function ConfirmarBorrar() {
        var agree = confirm("Está seguro de eliminar este registro? Este proceso es irreversible.");
        if (agree)
            return true;
        else
            return false;
    }
    </script>

    <title>IMPRESION</title>
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
            <td align="center" class="fuente"><strong>SALIDAS DEL MES DE
                    <?PHP echo $nombre_mes ?> DE
                    <?PHP echo $var_gestion ?>
                </strong></td>
        </tr>

        <tr>
            <td>
                <table border="0">

                </table>
            </td>
        </tr>
        <tr>
            <td>
                <hr />
            </td>
        </tr>
        <tr>
            <td>
                <h4>
                    TOTAL QR Bs.:
                    <?PHP 
                    if(isset($row_total_qr['QR'])){
                    echo round($row_total_qr['QR'],2);
                    }else{
                        echo '0';
                    }
                    ?>
                </h4>
                <h4>
                    TOTAL CONTADO Bs.:
                    <?PHP 
                    if(isset($row_total_cnt['CNT'])){
                        echo round($row_total_cnt['CNT'],2);
                    }else{
                        echo '0';
                    }
                    ?>
                </h4>
                <h2>
                    <strong>
                        TOTAL Bs.:
                        <?PHP echo round($row_total['SUM_TOTAL'] + $row_vale['SUM_TOTAL'] + $row_credito['SUM_TOTAL'],2);?>
                    </strong>
                </h2>
            </td>
        </tr>
        <tr>
            <td>
                <hr />
            </td>
        </tr>
        <tr>
            <td>
                <table border="1" cellpadding="1" cellspacing="0" class="ui-tinytbl ui-corner-all">
                    <thead class="ui-widget-header ui-corner-all">
                        <tr>
                            <th>FECHA</th>
                            <th>PAGO QR</th>
                            <th>PAGO CONTADO</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?PHP
                                $cont =1;
                                do{
                            ?>
                        <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                            <td>
                                <?PHP if(isset($row_pedido['FECHA_SOLICITUD'])){echo $row_pedido['FECHA_SOLICITUD'];} ?>
                            </td>
                            <td align="right">
                                <?PHP if(isset($row_pedido['QR'])){echo $row_pedido['QR'];} ?>
                            </td>
                            <td align="right">
                                <?PHP if(isset($row_pedido['CNT'])){echo $row_pedido['CNT'];} ?>
                            </td>
                            <td align="right">
                                <?PHP if(isset($row_pedido['TOTAL'])){echo $row_pedido['TOTAL'];} ?>
                            </td>
                        </tr>
                        <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
                    </tbody>
                </table>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <div>
                    <hr />
                </div>
            </td>
        </tr>
        <tr>
            <td align="center" class="fuente">
                <p><?php echo $row_empresa['NOMBRE_EMPRESA']; ?>, Cochabamba
                    <?PHP date_default_timezone_set('America/La_Paz'); 
                        echo date('Y');?>. Todos los Derechos Resevervados
                </p>
            </td>
        </tr>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</body>

</html>