<?PHP require_once('../cnx/cnx_compras.php');
	  include_once('../Funciones/funciones.php');
	  include_once('../menu1.php'); ?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['ID_SOLICITUD'];

$sql2 = "SELECT ID_SOLICITUD_COMPRA,
				ID_AREA, 
				FECHA_SOLICITUD
		 FROM solicitud_compra
		 WHERE ID_ESTADO_SOLICITUD='ACT' and ID_SOLICITUD_COMPRA = '$codigo'";
$solicitud = mysqli_query($cnx_compras, $sql2) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_solicitud = mysqli_fetch_assoc($solicitud);
$num_solicitud = mysqli_num_rows($solicitud); 

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="../css/start/jquery-ui-1.8.21.custom.css">
<link rel="stylesheet" href="../css/estilo_form.css"> <!--REVISAR ESTE CSS CREA PROBLEMAS CON COMBOBOX-->
<link rel="stylesheet" href="../css/principal.css">

<!-- LLAMADA DE SCRIPTS JS -->
<script src="../js/jquery-1.7.2.min.js"></script>
<script src="../js/jquery-ui-1.8.21.custom.min.js"></script>

<!-- JQUERY BOTON -->
<script src="../js/js_boton.js"></script>

<!-- JQUERY AUTOCOMPLETAR -->
<script src="../js/js_autocompletar.js"></script>


<!-- JQUERY CALENDARIO -->
<script src="../js/js_calendario.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<title>Compras</title>
</head>

<body>
<div class="ui-widget form">
	<header class="ui-widget-header ui-corner-all">
    	<h2>Formulario Solicitud de Compra</h2>
    </header>
    
    <section  class="ui-widget-content ui-corner-all">
    	<form action="SolComprasDMLInsertItem.php" method="post">
        	<input type="hidden" name="ID_SOLICITUD" value="<?PHP echo $row_solicitud['ID_SOLICITUD_COMPRA']; ?>" />
        	<input type="hidden" name="FECHA" value="<?PHP echo $row_solicitud['FECHA_SOLICITUD']; ?>" />
        	<input type="hidden" name="AREA" value="<?PHP echo $row_solicitud['ID_AREA']; ?>" />
            
        	<div  class="formulario ui-corner-all">
            	<label>SOL. COMPRA</label><?PHP echo zerofill($row_solicitud['ID_SOLICITUD_COMPRA']); ?>
            </div>
            <div class="salto"></div>
            
            <div  class="formulario ui-corner-all">
            	<label>FECHA</label><?PHP echo fecha_dma($row_solicitud['FECHA_SOLICITUD']); ?>
            </div>
            <div class="salto"></div>
            
            <div  class="formulario ui-corner-all">
            	<label>AREA</label><?PHP echo $row_solicitud['ID_AREA']; ?>
            </div>
            <div class="salto"></div>
            
            <div  class="formulario ui-corner-all"></div>
            <div class="salto"></div>
       		
            <div class="formulario ui-corner-all">     
        		<label>ARTICULO</label><input type="text" name="ARTICULO" onkeyup="tachos(Carga)" onchange="this.value = this.value.toUpperCase();"/>
            </div>
            <div class="salto"></div>
           	
            <div class="formulario ui-corner-all">
            	<label>UNIDAD</label><input type="text" name="UNIDAD" onkeyup="tachos(Carga)" onchange="this.value = this.value.toUpperCase();"/>
            </div>
            <div class="salto"></div>
           	
            <div class="formulario ui-corner-all">  
            	<label>CANTIDAD</label><input type="text" name="CANTIDAD" onkeyup="sumar(Carga)" />        	
            </div>
        	<div class="salto"></div>
        
            <div class="formulario ui-corner-all">        	
            	<label>DESCRIPCION</label>
                <textarea name="DESCRIPCION" onchange="this.value = this.value.toUpperCase();" rows="5" cols="45"></textarea>
            </div>
            <div class="salto"></div>
           	
        <div class="formulario ui-corner-all"><input type="submit" name="BOTON" value="REGISTRAR" /></div>
            <div class="salto"></div>
    	  

        </form>
    </section>
</div>

</body>
</html>