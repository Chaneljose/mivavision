<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Funciones/Funciones.php');
require_once('../Definiciones/Titulo.php'); 
//session_start(); 
$var_tipo = '';
$var_active = "contabilidad";
if(isset($_SESSION['SES_TIPO'])){
    $var_tipo = $_SESSION['SES_TIPO'];
} 
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['BUSCAR'];
$inicio = fecha_amd($_REQUEST['INICIO']);
$fin = fecha_amd($_REQUEST['FIN']);

$sql="SELECT CODIGO,
			 ARTICULO,
			 MAX(DEBE) ENTRADA,
			 MAX(HABER) SALIDA,
			 MAX(DEBE) - MAX(HABER) SALDO,
			 ROUND(PC,2) PC,
			 ROUND(PV,2) PV,
			 ROUND(MAX(HABER) * PC,2) PC_SALDO,
			 ROUND(MAX(HABER) * PV,2) PV_SALDO,
			 ROUND((MAX(HABER) * PV)-(MAX(HABER) * PC),2) UTILIDAD
	  FROM (SELECT	a.ID_ARTICULO CODIGO, 
				 	r.ARTICULO ARTICULO, 
				 	SUM(a.ENTRADA) DEBE, 
				 	SUM(a.SALIDA) HABER,
				 	r.PRECIO_COMPRA PC,
				 	r.PRECIO_VENTA PV
		  	FROM almacen a JOIN articulo r ON a.ID_ARTICULO = r.ID_ARTICULO
						   JOIN compra c ON a.ID_COMPRA = c.ID_COMPRA
			
			WHERE c.FECHA_REGISTRO between '$inicio 00:00:00' and '$fin 23:59:59'
		  	GROUP BY 1
		 	UNION
		  	SELECT	v.ID_ARTICULO CODIGO, 
				 	a.ARTICULO ARTICULO, 
				 	0 DEBE, 
				 	SUM(v.CANTIDAD) HABER,
				 	a.PRECIO_COMPRA PC,
				 	a.PRECIO_VENTA PV
		  	FROM venta v JOIN articulo a On v.ID_ARTICULO = a.ID_ARTICULO
					     JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
			
			WHERE s.FECHA_SOLICITUD between '$inicio 00:00:00' and '$fin 23:59:59'
		  	GROUP BY 1
		  	ORDER BY 1) KARDEX
		GROUP BY 1,2";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

?>
<!doctype html>
<html lang="es">
<?PHP head1(menu_cont); ?>
<body class="ui-widget">
    <?PHP 
        include('../menu.php');
        require_once('../NavsideContador.php');
        navbar(menu_cont, $var_tipo, $var_active);
        navside(kardex_imp);
    ?>
    	<h1>KARDEX IMPORTE</h1>
    <section>
        <form action="" >
        	<fieldset>
            <legend>Buscar</legend>
        	<div><label>FECHA</label><input type="text" name="INICIO" class="calendario"/> AL <input type="text" name="FIN" class="calendario"/></div>
            <div><input type="submit" name="BOTON" value="BUSCAR" /><a id="impresion" href="ReporteKardexImporteImpresion.php">Impresion</a><a id="excel" href="ReporteKardexImporteImpresion.php">Excel</a></div>
            </fieldset>
        </form>
    </section>
    <hr />
    	<h2>FECHA <?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y') ?></h2>
        <h3>
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
    <div class="formulario ui-corner-all">
    <table class="ui-tinytbl ui-corner-all">
        <thead class="ui-widget-header ui-corner-all">
            <tr>
                <th>PRODUCTO</th>
                <th>ENTRADA</th>
                <th>SALIDA</th>
                <th>SALDO</th>
                <th>PRECIO COMPRA</th>
                <th>PC * SALDO</th>
                <th>PRECIO VENTA</th>
                <th>PV * SALDO</th>
                <th>UTILIDAD</th>
            </tr>      
        </thead>
        <tbody>
            <?PHP
                $cont =1;
                do{
            ?>
                <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
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
                    <?PHP } ?>
                    <td align="right"><?PHP echo $row_pedido['PC']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['PC_SALDO']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['PV']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['PV_SALDO']; ?></td>
                    <?PHP if($row_pedido['UTILIDAD']<0){ ?>
						<td align="right" style="background-color:#F00"><?PHP echo $row_pedido['UTILIDAD']; ?></td>
                    <?PHP } else { ?>
                    	<td align="right"><?PHP echo $row_pedido['UTILIDAD']; ?></td>
                    <?PHP }?>
                </tr>
            <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
        </tbody>
    </table>
    </div>
        <div class="salto"></div>

</body>
</html>