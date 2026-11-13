<?PHP require_once('../cnx/cnx_compras.php'); ?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);
?>
<html lang="es">
<head>
	<title>VALE</title>
    <link rel="stylesheet" href="../css/start/jquery-ui-1.9.2.custom.css">
    <link rel="stylesheet" href="../css/principal.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/estilo_form.css">
    <link rel="stylesheet" href="../css/estilo_tabla.css">
    
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
<body  class="ui-widget">
	<header class="ui-widget-header">
    	<h1>DEVOLUCION</h1>
    </header>
    	<?PHP include('../menu.php'); ?>
    <section>
    	<form action="DevDMLInsert.php">      
          	<div><label>FECHA REGISTRO</label><?PHP date_default_timezone_set('America/La_Paz'); echo date('d/m/Y ') ?></div> 
    </section>
            
            <div>
                 <table>
                     <thead  class="ui-widget-header ui-corner-all">
                        <tr>
                            <th>NRO</th>
                            <th>ARTICULO</th>
                            <th>CANTIDAD</th>
                            <th>OBSERVACIONES</th>
                        </tr>
                     </thead>	
                     <tbody>
                          <?PHP for($i=1;$i<=10;$i++){ ?>
                                <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
                                    <td><?PHP echo $i; ?></td>
                                    <td><select class="combobox" name="ARTICULO<?PHP echo $i; ?>">
                                        <option></option>
                                        <?PHP
                                            $sql="SELECT ID_ARTICULO, 
                                                         ARTICULO, 
                                                         ID_UNIDAD, 
                                                         DESCRIPCION,
                                                         PRECIO_COMPRA,
                                                         PRECIO_VENTA,
                                                         ID_GRUPO
                                                  FROM articulo";
                                            $articulo = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
                                            $row_articulo = mysqli_fetch_assoc($articulo);
                                            $num_articulo = mysqli_num_rows($articulo);
                                        
                                        
                                         do{ ?>
                                            <option value="<?PHP echo $row_articulo['ID_ARTICULO'];?>"><?PHP echo $row_articulo['ARTICULO']; ?></option>
                                        <?PHP }while($row_articulo =  mysqli_fetch_assoc($articulo)) ?>
                                </select>
                                    </td>
                                    <td><input type="text" name="CANTIDAD<?PHP echo $i; ?>" onKeyUp="sumar(Carga)"/></td>
                                    <td><input type="text" name="OBS<?PHP echo $i; ?>" /></td>
                                    <!--<td><input type="text" name="DEV<?PHP echo $i; ?>" class="calendario" /></td>-->
                                </tr>
                             <?PHP } ?>
                     </tbody>
                </table>
            </div>
            <div><input type="submit" name="BOTON" value="REGISTRAR" /></div>
        </form>

</body>
</html>