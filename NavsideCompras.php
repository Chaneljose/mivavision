<?PHP 
require_once('Definiciones/Titulo.php');

function navside(String $variable){ 
	if($variable == compras)
	{	
?>
<div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
            <li class="active">
                <a href="../Compras/ComprasForm.php">
                    <?PHP echo compras ?>
                </a>
            </li>
            <li>
                <a href="../Compras/ComprasReporte.php?MES=12&GESTION=2040">
                    <?PHP echo reportes ?>
                </a>
            </li>
        </ul>
    </div>
</div>
<?PHP }
	  else if($variable == reportes){ ?>
<div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
            <li>
                <a href="../Compras/ComprasForm.php">
                    <?PHP echo compras ?>
                </a>
            </li>
            <li class="active">
                <a href="../Compras/ComprasReporte.php?MES=12&GESTION=2040">
                    <?PHP echo reportes ?>
                </a>
            </li>
        </ul>
    </div>
</div>
<?PHP }
}
?>