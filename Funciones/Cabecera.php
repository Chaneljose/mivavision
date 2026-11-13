<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Definiciones/Titulo.php');
$sql = "SELECT e.TEMA FROM empresa e";
$query = $connect -> prepare($sql); 
$query -> execute(); 
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$color_tema = '';
if($query -> rowCount() > 0){
    foreach($results as $result) {
        $color_tema = $result->TEMA;
    }
  }
function head1(String $titulo)
{ 
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../Iconos/favicon.ico">
    <title>
        <?PHP echo $titulo ?>
    </title>
    <?php // Bootstrap core CSS ?>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <?php // Custom styles for this template ?>
    <link href="../css/dashboard.css" rel="stylesheet">
    <link href="../css/custom-theme/jquery-ui-1.10.0.custom.css" rel="stylesheet">
    <!--<link href="../css/inicio_verde.css" rel="stylesheet">-->
    <?php 
        $color = $GLOBALS['color_tema'];
        echo '<link href="../css/inicio_'.$color.'.css" rel="stylesheet">';
    ?>
    <script src="../js/jquery-1.8.3.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="../js/busqueda.js"></script>
    <script src="../js/js_autocompletar.js"></script>
    <script src="../js/js_calendario.js"></script>
    
</head>
<?PHP
 }
 ?>