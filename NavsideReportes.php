<?PHP 
require_once('Definiciones/Titulo.php');
$hoy = getdate();

function navside(String $variable){ 
	if($variable == diario)
	{	
?>
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li class="active"><a href="../Reportes/ReporteDiario.php?INICIO=01/01/2024"><?PHP echo diario ?></a></li>
                    <li><a href="../Reportes/Item.php?BUSCAR=''"><?PHP echo item ?></a></li>
                    <li><a href="../Reportes/Kardex.php?BUSCAR=''"><?PHP echo kardex ?></a></li>
					<li><a href="../Reportes/Utilidad.php"><?PHP echo utilidad ?></a></li>
                    <li><a href="../Reportes/InventarioInicial.php"><?PHP echo inventarioinicial ?></a></li>
                </ul>
            </div>
        </div>
<?PHP }
	  else if($variable == item){ ?>
		<div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li><a href="../Reportes/ReporteDiario.php?INICIO=01/01/2024"><?PHP echo diario ?></a></li>
                    <li class="active"><a href="../Reportes/Item.php?BUSCAR=''"><?PHP echo item ?></a></li>
                    <li><a href="../Reportes/Kardex.php?BUSCAR=''"><?PHP echo kardex ?></a></li>
					<li><a href="../Reportes/Utilidad.php"><?PHP echo utilidad ?></a></li>
                    <li><a href="../Reportes/InventarioInicial.php"><?PHP echo inventarioinicial ?></a></li>
                </ul>
            </div>
        </div>	  

<?PHP }
	  else if($variable == kardex){ ?>
		<div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li><a href="../Reportes/ReporteDiario.php?INICIO=01/01/2024"><?PHP echo diario ?></a></li>
                    <li><a href="../Reportes/Item.php?BUSCAR=''"><?PHP echo item ?></a></li>
                    <li class="active"><a href="../Reportes/Kardex.php?BUSCAR=''"><?PHP echo kardex ?></a></li>
					<li><a href="../Reportes/Utilidad.php"><?PHP echo utilidad ?></a></li>
                    <li><a href="../Reportes/InventarioInicial.php"><?PHP echo inventarioinicial ?></a></li>
                </ul>
            </div>
        </div>	
<?PHP }  //utilidad
else if($variable == utilidad){ ?>
		<div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li><a href="../Reportes/ReporteDiario.php?INICIO=01/01/2024"><?PHP echo diario ?></a></li>
                    <li><a href="../Reportes/Item.php?BUSCAR=''"><?PHP echo item ?></a></li>
					<li><a href="../Reportes/Kardex.php?BUSCAR=''"><?PHP echo kardex ?></a></li>
                    <li class="active"><a href="../Reportes/Utilidad.php"><?PHP echo utilidad ?></a></li>
                    <li><a href="../Reportes/InventarioInicial.php"><?PHP echo inventarioinicial ?></a></li>
                </ul>
            </div>
        </div>	
<?PHP }
else if($variable == inventarioinicial){ ?>
		<div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li><a href="../Reportes/ReporteDiario.php?INICIO=01/01/2024"><?PHP echo diario ?></a></li>
                    <li><a href="../Reportes/Item.php?BUSCAR=''"><?PHP echo item ?></a></li>
					<li><a href="../Reportes/Kardex.php?BUSCAR=''"><?PHP echo kardex ?></a></li>
                    <li><a href="../Reportes/Utilidad.php"><?PHP echo utilidad ?></a></li>
                    <li class="active"><a href="../Reportes/InventarioInicial.php"><?PHP echo inventarioinicial ?></a></li>
                </ul>
            </div>
        </div>	
<?PHP }
}
?>