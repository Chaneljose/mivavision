<?PHP 
require_once('Definiciones/Titulo.php');

function navside(String $variable){ 
	if($variable == baja)
	{	
?>
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li class="active"><a href="../Operaciones/BajaReporte.php"><?PHP echo baja ?></a></li>
                    <li><a href="../Operaciones/DevReporte.php"><?PHP echo devolucion ?></a></li>
                </ul>
            </div>
        </div>
<?PHP }
	  else if($variable == devolucion){ ?>
		<div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li><a href="../Operaciones/BajaReporte.php"><?PHP echo baja ?></a></li>
                    <li class="active"><a href="../Operaciones/DevReporte.php"><?PHP echo devolucion ?></a></li>
                </ul>
            </div>
        </div>	  
<?PHP }
}
?>