<?PHP require_once('../cnx/cnx_compras.php');
	  include_once('../Funciones/funciones.php');
	  include_once('../menu1.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['CODIGO'];

$sql="SELECT ID_PEDIDO,
			 ID_SOLICITUD_COMPRA, 
			 ID_AREA, 
			 ARTICULO,
			 UNIDAD,
			 DESCRIPCION,
			 CANTIDAD
	  FROM pedido
	  WHERE ID_PEDIDO = '$codigo'";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

$sql1="SELECT ID_AREA, ID_DEPT, NOMBRE_AREA
	  FROM area";
$area = mysqli_query($cnx_compras, $sql1) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_area = mysqli_fetch_assoc($area);
$num_area = mysqli_num_rows($area); 



?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="../css/start/jquery-ui-1.8.21.custom.css">
<link rel="stylesheet" href="../css/estilo_form.css">
<link rel="stylesheet" href="../css/principal.css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

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
<title>FORMULARIO CIUDAD</title>
</head>

<body>
<div class="ui-widget form">
	<header class="ui-widget-header ui-corner-all">
    	<h2>ACTUALIZACION DE ARTICULO</h2>
    </header>
    
    <section class="ui-widget-content ui-corner-all" >
    	<form action="SolComprasDMLUpdate.php" method="post">
        
        	<div class="formulario ui-corner-all"><label>SOLICITUD</label><?PHP echo zerofill($row_pedido['ID_SOLICITUD_COMPRA']); ?></div>
            <div class="salto"></div>
            
          <div class="formulario ui-corner-all"><label>ARTICULO</label>
            <span id="sprytextfield2">
            <input type="text" name="ARTICULO" value="<?PHP echo $row_pedido['ARTICULO']; ?>" onchange="this.value = this.value.toUpperCase();" /> 
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div>
            <div class="salto"></div>
            
            <div class="formulario ui-corner-all"><label>UNIDAD</label><input type="text" name="UNIDAD" value="<?PHP echo $row_pedido['UNIDAD']; ?>" onchange="this.value = this.value.toUpperCase();" /></div>
            <div class="salto"></div>
            
            <div class="formulario ui-corner-all"><label>CANTIDAD</label><input type="text" name = "CANTIDAD" value="<?PHP echo $row_pedido['CANTIDAD']; ?>" onchange="this.value = this.value.toUpperCase();" /></div>
            <div class="salto"></div>
            
            <div class="formulario ui-corner-all"><label>DESCRIPCION</label><textarea name="DESCRIPCION" cols="45" rows="5" onchange="this.value = this.value.toUpperCase();" ><?PHP echo $row_pedido['DESCRIPCION'] ?></textarea></div>
            <div class="salto"></div>
            
            <div class="formulario ui-corner-all"><input type="submit" name="BOTON" value="REGISTRAR"/></div>
            <div class="salto"></div>
            <div class="formulario ui-corner-all"><input type="hidden" name="CODIGO" value="<?PHP echo $row_pedido['ID_PEDIDO'] ?>"/></div>
            <div class="salto"></div> <div class="formulario ui-corner-all"><input type="hidden" name="SOLICITUD" value="<?PHP echo $row_pedido['ID_SOLICITUD_COMPRA'] ?>"/></div>
            <div class="salto"></div>
        </form>
    </section>
</div>
<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>