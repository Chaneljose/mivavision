<?PHP 
require_once('Definiciones/Titulo.php');

function navside(String $variable){ 
	if($variable == salidas)
	{	
?>
<div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
            <li class="active"><a href="../SolicitudSalidas/SolSalidasForm.php">
                    <?PHP echo salidas ?>
                </a></li>
            <li><a href="../SolicitudSalidas/SolSalidasReporte.php?INICIO=01/01/2024&FIN=01/01/2024">
                    <?PHP echo reportes_sal ?>
                </a></li>
            <li><a href="../SolicitudSalidas/SolSalidasPeriodo.php?MES=1&GESTION=2024">
                    <?PHP echo reportes_periodo ?>
                </a></li>
        </ul>
    </div>
</div>
<?PHP }
	  else if($variable == reportes_sal){ ?>
<div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
            <li><a href="../SolicitudSalidas/SolSalidasForm.php">
                    <?PHP echo salidas ?>
                </a></li>
            <li class="active"><a href="../SolicitudSalidas/SolSalidasReporte.php?INICIO=01/01/2024&FIN=01/01/2024">
                    <?PHP echo reportes_sal ?>
                </a></li>
            <li><a href="../SolicitudSalidas/SolSalidasPeriodo.php?MES=1&GESTION=2024">
                    <?PHP echo reportes_periodo ?>
                </a></li>
        </ul>
    </div>
</div>
<?PHP }
	  else if($variable == reportes_periodo){ ?>
<div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
            <li><a href="../SolicitudSalidas/SolSalidasForm.php">
                    <?PHP echo salidas ?>
                </a></li>
            <li><a href="../SolicitudSalidas/SolSalidasReporte.php?INICIO=01/01/2024&FIN=01/01/2024">
                    <?PHP echo reportes_sal ?>
                </a></li>
            <li class="active"><a href="../SolicitudSalidas/SolSalidasPeriodo.php?MES=1&GESTION=2024">
                    <?PHP echo reportes_periodo ?>
                </a></li>
        </ul>
    </div>
</div>
<?PHP }
}
?>