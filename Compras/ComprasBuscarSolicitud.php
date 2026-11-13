<html lang="es">
<head>
	<title>TRABAJADOR</title>
    <link rel="stylesheet" href="../css/start/jquery-ui-1.9.2.custom.css">
    <link rel="stylesheet" href="../css/principal.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/estilo_form.css" >
    <link rel="stylesheet" href="../css/estilo_tabla.css" >
    
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
    		<h1>COMPRA</h1>
        </header>
    			<?PHP include('../menu.php'); ?>
        
        <section>
            <form action="ComprasForm.php" method="post">
              	<fieldset>
            	<legend>Buscar Solicitud Compra</legend> 
                <div><label>NRO. SOLICITUD</label><input type="text" name="BUSCAR"/></div>
                <div><input type="submit" name="BOTON" value="BUSCAR" /></div>
            	</fieldset>
            </form>
        </section>            
</body>
</html>