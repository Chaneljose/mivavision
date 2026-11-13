<?PHP 
require_once('Definiciones/Titulo.php');

function navside(String $variable){ 
	if($variable == vale)
	{	
?>

        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li class="active"><a href="../Vale/ValeForm.php"><?PHP echo vale ?></a></li>
                    <li><a href="../Vale/ValeReporte.php"><?PHP echo reportes ?></a></li>
                </ul>
            </div>
        </div>
<?PHP }
	  else if($variable == reportes){ ?>
		<div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li><a href="../Vale/ValeForm.php"><?PHP echo vale ?></a></li>
                    <li class="active"><a href="../Vale/ValeReporte.php"><?PHP echo reportes ?></a></li>
                </ul>
            </div>
        </div>	  
<?PHP }
}
?>