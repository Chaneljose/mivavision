<?PHP 
date_default_timezone_set('America/La_Paz');
header('Content-type: application/vnd.ms-excel');  
header("Content-Disposition: attachment; filename=KardexExcel".date("YmdHis").".xls");  
header("Pragma: no-cache");  
header("Expires: 0");
?>
<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP include_once('../Funciones/funciones.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['CODIGO'];

$sql="SELECT CODIGO,
			 ARTICULO,
			 SUM(DEBE) ENTRADA,
			 SUM(HABER) SALIDA,
			 SUM(DEBE) - SUM(HABER) SALDO
	  FROM (	SELECT	a.ID_ARTICULO CODIGO, 
					 	r.NOMBRE_BUSQUEDA ARTICULO, 
					 	SUM(a.ENTRADA) DEBE, 
					 	SUM(a.SALIDA) HABER
			  	FROM almacen a JOIN articulo r ON a.ID_ARTICULO = r.ID_ARTICULO
							   JOIN compra c ON a.ID_COMPRA = c.ID_COMPRA
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
			  	ORDER BY 1
			) KARDEX
		GROUP BY 1,2";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">

 
<title>IMPRESION</title>
</head>

<body>

    <h2><strong>KARDEX DE PRODUCTOS <?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y H:i:s') ?></strong></h2>

	<table border="1" cellpadding="1" cellspacing="0" class="ui-tinytbl ui-corner-all">
        <thead class="ui-widget-header ui-corner-all">
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
									if(isset($row_pedido['CODIGO'])){
            ?>
                <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                    <td align="center"><?PHP echo $row_pedido['CODIGO']; ?></td>
                    <td><?PHP echo $row_pedido['ARTICULO']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['ENTRADA']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['SALIDA']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['SALDO']; }?></td>
                </tr>
            <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
        </tbody>
    </table>
</body>
</html>