<?PHP 
require_once('Definiciones/Titulo.php');

function navside(String $variable){ 
	if($variable == libro_comp)
	{	
?>
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li class="active"><a href="../ReportesCont/libro.php">LIBRO DE COMPRAS</a></li>
                    <!--<li><a href="../ReportesCont/ReporteKardexImporte.php">KARDEX</a></li>-->
                    <li><a href="../ReportesCont/ReporteKardexProducto.php">KARDEX PRODUCTO</a></li>
                </ul>
            </div>
        </div>	
<?PHP }
	  else if($variable == kardex_imp){ ?>
		<div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li><a href="../ReportesCont/libro.php">LIBRO DE COMPRAS</a></li>
                    <!--<li class="active"><a href="../ReportesCont/ReporteKardexImporte.php">KARDEX</a></li>-->
                    <li><a href="../ReportesCont/ReporteKardexProducto.php">KARDEX PRODUCTO</a></li>
                </ul>
            </div>
        </div>	  
<?PHP }
      else if($variable == kardex_prod){ ?>
		<div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li><a href="../ReportesCont/libro.php">LIBRO DE COMPRAS</a></li>
                    <!--<li><a href="../ReportesCont/ReporteKardexImporte.php">KARDEX</a></li>-->
                    <li class="active"><a href="../ReportesCont/ReporteKardexProducto.php">KARDEX PRODUCTO</a></li>
                </ul>
            </div>
        </div>	  
<?PHP }
}
?>