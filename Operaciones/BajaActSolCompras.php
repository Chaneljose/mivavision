<?PHP require_once('../cnx/cnx_compras.php');
	  include_once('../Funciones/funciones.php');
	  include_once('../menu1.php');?>
<?PHP
mysqli_select_db($cnx_compras, $database_cnx_compras);

$id_solicitud = $_REQUEST['ID_SOLICITUD'];

$sql="SELECT ID_AREA, 
			 FECHA_SOLICITUD
	  FROM solicitud_compra
	  WHERE ID_SOLICITUD_COMPRA = '$id_solicitud'";
$solicitud = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_solicitud = mysqli_fetch_assoc($solicitud);
$num_solicitud = mysqli_num_rows($solicitud); 

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
    	<form action="SolComprasDMLUpdateActSolicitud.php" method="post">
        
        	<div class="formulario ui-corner-all"><label>SOLICITUD</label><?PHP echo zerofill($id_solicitud); ?></div>
            <div class="salto"></div>
            
        	<div class="formulario ui-corner-all"><label>AREA</label>
        	  <select class="combobox" name="ID_AREA">
                    <option><?PHP echo $row_solicitud['ID_AREA']; ?></option>
                        <?PHP do{ ?>
                            <option value="<?PHP echo $row_area['ID_AREA'];?>"><?PHP echo $row_area['NOMBRE_AREA']; ?></option>
                        <?PHP }while($row_area =  mysqli_fetch_assoc($area)) ?>
        </select></div>
            <div class="salto"></div>
            
            <div class="formulario ui-corner-all"><label>FECHA</label><input type="text" name="FECHA" class="calendario" value="<?PHP echo $row_solicitud['FECHA_SOLICITUD'] ?>"/></div>
            <div class="salto"></div>           
            
            <div class="formulario ui-corner-all"><input type="submit" name="BOTON" value="REGISTRAR"/></div>
            <div class="salto"></div>
            <div class="formulario ui-corner-all"><input type="hidden" name="CODIGO" value="<?PHP echo $row_pedido['ID_PEDIDO'] ?>"/></div>
            <div class="salto"></div> <div class="formulario ui-corner-all"><input type="hidden" name="SOLICITUD" value="<?PHP echo $row_pedido['ID_SOLICITUD_COMPRA'] ?>"/></div>
            <div class="salto"></div>
            
            <input type="hidden" name="ID_SOLICITUD" value="<?PHP echo $id_solicitud; ?>" />
        </form>
    </section>
</div>

</body>
</html>