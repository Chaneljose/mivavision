<?PHP require_once('../cnx/cnx_compras.php');
	  require_once('../Funciones/Cabecera.php');
	  require_once('../Funciones/Funciones.php');
	  require_once('../Definiciones/Titulo.php'); ?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['BUSCAR'];



$sql="SELECT b.ID_VENTA_CREDITO
,		 CONCAT(s.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) NOTA
,		 s.FECHA_SOLICITUD
,		 a.ARTICULO
,		 b.CANTIDAD
,		 b.PRECIO_VENTA
,		 b.TOTAL
,		 CONCAT(t.NOMBRE,' ',t.APATERNO,' ',t.AMATERNO) OBS
FROM venta_credito b JOIN solicitud_venta s ON b.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA 
			   			JOIN articulo a ON b.ID_ARTICULO = a.ID_ARTICULO
			   			JOIN cliente t ON t.ID_CLIENTE = b.ID_CLIENTE";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

?>
<h2 class="sub-header"><?PHP echo kardex; ?></h2>
<section>
    <form action="" >
        <div><a class="btn btn-primary" href="VentaCreditoImpresion.php?CODIGO=<?PHP echo $codigo; ?>">IMPRESION</a></div>
    </form>
</section>
<hr />
<h2>FECHA <?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y') ?></h2>

<div class="table-responsive" >
    <table class="table table-striped table-hover table-bordered table-condensed">
        <thead>
            <tr>
                <!--<th>ID</th>-->
                <th>NOTA</th>
                <th>FECHA DEVOLUCION</th>
                <th>PRODUCTO</th>
                <th>CANTIDAD</th>
                <th>PRECIO VENTA</th>
                <th>TOTAL</th>
                <th>OBSERVACION</th>
            </tr>      
        </thead>
        <tbody>
            <?PHP
                $cont =1;
                do{
            ?>
                <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                    <!--<td align="center"><?PHP echo $row_pedido['ID_VENTA_CREDITO']; ?></td>-->
                    <td align="center"><?PHP echo $row_pedido['NOTA']; ?></td>
                    <td align="center"><?PHP echo $row_pedido['FECHA_SOLICITUD']; ?></td>
                    <td><?PHP echo $row_pedido['ARTICULO']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['CANTIDAD']; ?></td>
                    <td align="right"><?PHP echo round($row_pedido['PRECIO_VENTA'],2); ?></td>
                    <td align="right"><?PHP echo round($row_pedido['TOTAL'],2); ?></td>
                    <td align="right"><?PHP echo $row_pedido['OBS']; ?></td>
                </tr>
            <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
        </tbody>
    </table>
</div>

