<?PHP require_once('../cnx/cnx_compras.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['BUSCAR'];



$sql="SELECT b.ID_BAJA
,		 CONCAT(s.ID_TIPO_VENTA,'-',LPAD(s.NRO_NOTA,'7','0')) NOTA
,		 b.FECHA_BAJA
,		 a.ARTICULO
,		 b.CANTIDAD
,		 b.PRECIO_COMPRA
,		 b.TOTAL
,		 b.OBS
FROM baja b JOIN solicitud_baja s ON b.ID_SOLICITUD_BAJA = s.ID_SOLICITUD_BAJA 
			   JOIN articulo a ON b.ID_ARTICULO = a.ID_ARTICULO";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

?>
<h2 class="sub-header"><?PHP echo baja; ?></h2>
    <section>
        <form action="" >
            <div><a class="btn btn-primary" href="BajaImpresion.php?CODIGO=<?PHP echo $codigo; ?>">IMPRESION</a></div>
        </form>
    </section>
    <hr />
    	<h2>FECHA <?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y') ?></h2>
    <div class="table-responsive">
    <table  class="table table-striped table-hover table-bordered table-condensed">
        <thead>
            <tr>
                <!--<th>ID</th>-->
                <th>NOTA</th>
                <th>FECHA BAJA</th>
                <th>PRODUCTO</th>
                <th>CANTIDAD</th>
                <th>PRECIO COMPRA</th>
                <th>TOTAL</th>
                <th>OBSERVACION</th>
            </tr>      
        </thead>
        <tbody>
            <?PHP
                $cont =1;
                do{
                    if(isset($row_pedido['ID_BAJA'])){
            ?>
                <tr  class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                    <!--<td align="center"><?PHP echo $row_pedido['ID_BAJA']; ?></td>-->
                    <td align="center"><?PHP echo $row_pedido['NOTA']; ?></td>
                    <td align="center"><?PHP echo $row_pedido['FECHA_BAJA']; ?></td>
                    <td><?PHP echo $row_pedido['ARTICULO']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['CANTIDAD']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['PRECIO_COMPRA']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['TOTAL']; ?></td>
                    <td align="right"><?PHP echo $row_pedido['OBS'];} ?></td>
                </tr>
            <?PHP } while($row_pedido = mysqli_fetch_assoc($pedido)) ?>
        </tbody>
    </table>
    </div>

</body>
</html>