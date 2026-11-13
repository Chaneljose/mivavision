<?PHP 
require_once('Definiciones/Titulo.php');

function navside(String $variable){ 
	if($variable == reportes)
{ ?>
		<div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li class="active"><a href="../Deposito/DepositoTabla.php"><?PHP echo reportes ?></a></li>
                    <li><a href="../Deposito/DepositoPeriodo.php"><?PHP echo periodo ?></a></li>
                </ul>
            </div>
        </div>	  
<?PHP }
	  else if($variable == periodo){ ?>
		<div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li><a href="../Deposito/DepositoTabla.php"><?PHP echo reportes ?></a></li>
                    <li class="active"><a href="../Deposito/DepositoPeriodo.php"><?PHP echo periodo ?></a></li>
                </ul>
            </div>
        </div>	  
<?PHP }
}
?>