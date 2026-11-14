<?PHP
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Funciones/Funciones.php');
require_once('../Definiciones/Titulo.php');
session_start();
$var_tipo = '';
$var_active = '';
if (isset($_SESSION['SES_TIPO'])) {
  $var_tipo = $_SESSION['SES_TIPO'];
}
$nombre_empresa = '';
$sql = "SELECT e.NOMBRE_EMPRESA, e.TEMA FROM empresa e WHERE e.ID_EMPRESA = 1";
$query = $connect->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
  foreach ($results as $result) {
    $nombre_empresa = $result->NOMBRE_EMPRESA;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<?PHP head1(menu_venta); ?>

<body>
  <?PHP include('../menu.php');
  navbar(menu_venta, $var_tipo, $var_active); ?>
  <div class="container">

    <div class="starter-template">
      <h1>MODULO DE VENTAS</h1>
      <p class="lead">
        <?php
        echo $nombre_empresa;
        ?>
      </p>
    </div>
  </div><!-- /.container -->
  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <!--<script src="../../dist/js/bootstrap.min.js"></script>-->
</body>

</html>