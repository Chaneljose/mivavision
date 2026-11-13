<?PHP 
		require_once('../cnx/cnx_compras.php');
		require_once('../Funciones/Cabecera.php');
		require_once('../Funciones/Funciones.php');
		require_once('../Definiciones/Titulo.php');
		/*session_start();
		$var_tipo = $_SESSION['SES_TIPO'];	
		$var_active = "compras";*/
		mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = '';
$buscar = '';
$marcas = '';
		
if(isset($_REQUEST['CODIGO'])){
	$codigo = $_REQUEST['CODIGO'];
}
if(isset($_REQUEST['BUSCAR'])){
	$buscar = $_REQUEST['BUSCAR'];
}
if(isset($_REQUEST['MARCA'])){
	$marcas = $_REQUEST['MARCA'];
}

//echo $codigo." ".$buscar." MARCA=".$marcas;

$sql="SELECT  c.ID_COMPRA
		 ,		  c.NRO_FACTURA
		 ,		  c.FECHA_FACTURA
		 ,		  c.CANTIDAD
		 ,		  c.PRECIO_FACTURA
		 ,		  c.UM_IMPUESTO
		 ,		  c.VALOR
		 ,		  c.ICE
		 ,      c.DESCUENTO
		 ,		  c.TOTAL
		 ,		  c.FECHA_CADUCIDAD
		 ,		  c.FECHA_REGISTRO
		 ,		  c.ID_ARTICULO
		 ,		  a.ARTICULO
		 ,      a.PRECIO_VENTA
		 FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
	  WHERE c.ID_COMPRA = '$codigo'";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">x</a>
    <h3>ACTUALIZAR INVENTARIO INICIAL</h3>
</div>
    

    
	<div class="container-fluid">
        <div class="col-sm-4 col-sm-offset-0 col-md-7 col-md-offset-0 main">
    
          <h3 class="sub-header"><?PHP echo inventarioinicial; ?></h3>
            <form class="form-horizontal" action="InventarioInicialDMLUpdate.php" method="post">
            <fieldset>
            	<input type="hidden" name="ID_COMPRA" value="<?PHP echo $row_pedido['ID_COMPRA']; ?>" />
            	<input type="hidden" name="NRO_FACTURA" value="<?PHP echo $row_pedido['NRO_FACTURA']; ?>" />
                
                <div class="form-group">
                	<label class="col-sm-4 control-label">ARTICULO</label>
    				<div class="col-sm-7">
											<input type="hidden" name = "ID_ARTICULO" value="<?PHP echo $row_pedido['ID_ARTICULO']; ?>"/>
											<input type="hidden" name = "MARCA" value="<?PHP echo $marcas; ?>"/>
											<input type="text" size="55" name = "ARTICULO" value="<?PHP echo $row_pedido['ARTICULO']; ?>" disabled/>
                	</div>
                </div>
                <div class="form-group">
                	<label  class="col-sm-4 control-label">CANTIDAD</label>
    				<div class="col-sm-7">
                    	<input type="text" name = "CANTIDAD" value="<?PHP echo $row_pedido['CANTIDAD']; ?>"/>
                	</div>
                </div>
                
                <div class="form-group">
                	<label class="col-sm-4 control-label">PRECIO FACTURA</label>
    				<div class="col-sm-7">
                    	<input type="text" name = "PRECIO_FACTURA" value="<?PHP echo $row_pedido['PRECIO_FACTURA']; ?>"/>
                	</div>
                </div>
                <div class="form-group">
                	<label class="col-sm-4 control-label">PRECIO VENTA</label>
    				<div class="col-sm-7">
                    	<input type="text" name = "PRECIO_VENTA" value="<?PHP echo $row_pedido['PRECIO_VENTA']; ?>"/>
                	</div>
                </div>
                
                
                <div class="form-group">
									<button class="btn btn-success" id="submit">REGISTRAR</button>
									<a href="InventarioInicial.php?MARCA=<?php echo $marcas?>" class="btn btn-default">CANCELAR</a>
							  </div>
            </fieldset>
            </form>
		</div>
    <div>
</body>
</html>