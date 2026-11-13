<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Definiciones/Titulo.php');
//session_start(); 
$var_tipo = $_SESSION['SES_TIPO']; 
$var_active = "compras";
$var_mes = $_REQUEST['MES'];
$var_gestion =$_REQUEST['GESTION'];
$sql="SELECT NRO_FACTURA
	  ,		 ROUND(SUM(TOTAL),2) TOTAL
	  , 	 DATE_FORMAT(FECHA_FACTURA , '%d-%m-%Y') FECHA_FACTURA
	  , 	 DATE_FORMAT(FECHA_FACTURA , '%Y%m%d') FECHA_REGISTRO
	  FROM  compra
	  WHERE MONTH(FECHA_FACTURA) = '$var_mes' and YEAR(FECHA_FACTURA) = '$var_gestion'
	  GROUP BY 1,3,4
	  ORDER BY 3";
/*$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido);*/
$queryCompra = $connect->prepare($sql);
$queryCompra->execute();
$compras = $queryCompra->fetchAll(PDO::FETCH_OBJ);

$sql2 =" SELECT	ID_MES
		 , 		MES 
		 FROM mes";
/*$mes = mysqli_query($cnx_compras, $sql2) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_mes = mysqli_fetch_assoc($mes);
$num_mes = mysqli_num_rows($mes);*/
$queryMes = $connect->prepare($sql2);
$queryMes->execute();
$meses = $queryMes->fetchAll(PDO::FETCH_OBJ); 

$sql3 =" SELECT	ID_MES
		 , 		MES 
		 FROM mes
		 WHERE ID_MES = MONTH(NOW())";
/*$mes_actual = mysqli_query($cnx_compras, $sql3) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_mes_actual = mysqli_fetch_assoc($mes_actual);
$num_mes_actual = mysqli_num_rows($mes_actual);*/
$queryMesAct = $connect->prepare($sql3);
$queryMesAct->execute();
$mesesAct = $queryMesAct->fetchAll(PDO::FETCH_OBJ);

$sql4 =" SELECT	ID_GESTION
		 FROM gestion
		 ORDER BY 1 ASC";
/*$gestion = mysqli_query($cnx_compras, $sql4) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_gestion = mysqli_fetch_assoc($gestion);
$num_gestion = mysqli_num_rows($gestion);*/
$queryGestion = $connect->prepare($sql4);
$queryGestion->execute();
$gestiones = $queryGestion->fetchAll(PDO::FETCH_OBJ);

$sql5 =" SELECT	ID_MES
		 , 		MES 
		 FROM mes
		 WHERE ID_MES = '$var_mes'";
/*$mes_nombre = mysqli_query($cnx_compras, $sql5) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_mes_nombre = mysqli_fetch_assoc($mes_nombre);
$num_mes_nombre = mysqli_num_rows($mes_nombre);*/
$queryMesNombre = $connect->prepare($sql5);
$queryMesNombre->execute();
$mesNombres = $queryMesNombre->fetchAll(PDO::FETCH_OBJ);

$nombre_mes = '';
if($queryMesNombre->rowCount()>0){
  foreach($mesNombres as $mesNombre){
    if(isset($mesNombre->MES)){
    $nombre_mes = $mesNombre->MES;
    }
  }
}


?>
<!doctype html>
<html lang="es">
<?PHP head1(compras); ?>
<body>
  <?PHP 
  include('../menu.php');
	require_once('../NavsideCompras.php');
  navbar(reportes, $var_tipo, $var_active);
  navside(reportes);
  ?>
  <div class="container-fluid">
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h2 class="sub-header">COMPRAS</h2>
      <form name="FormBuscar" action="">
        <div class="form-group">
          <label class="col-sm-2 control-label">
            <h4>BUSCAR</h4>
          </label>
          <div class="col-sm-10">
            <select name="MES" class="form-control combobox">
              <!--<option value="<?PHP //echo $row_mes_actual['ID_MES'] ?>">
                                <?PHP 
                                /*if(isset($row_mes_actual['MES'])){
                                    echo $row_mes_actual['MES']; 
                                }*/
                                ?>
                            </option>-->
              <?PHP 
              if($queryMes->rowCount()>0){
                foreach($meses as $mes){
              ?>
              <option value="<?PHP 
                              if(isset($mes->ID_MES)){
                                  echo $mes->ID_MES;
                              }
                                            ?>">
                <?PHP 
                                if(isset($mes->MES)){
                                    echo $mes->MES; 
                                }
                                ?>
              </option>
              <?PHP 
                }
              } 
              ?>
            </select>

            <select name="GESTION" class="form-control combobox">
              <?PHP 
              if($queryGestion->rowCount()>0){
                foreach($gestiones as $gestion){
              ?>
              <option value="<?PHP 
                                if(isset($gestion->ID_GESTION)){
                                    echo $gestion->ID_GESTION;
                                }
                            ?>">
                            <?PHP 
                                if(isset($gestion->ID_GESTION)){
                                    echo $gestion->ID_GESTION; 
                                }
                                ?>
              </option>
              <?PHP 
                }
              } 
              ?>
            </select>

            <button class="btn btn-success" id="submit">BUSCAR</button>
          </div>
        </div>
      </form>

      <hr />
      <h3 class="sub-header">FACTURAS DEL MES
        <?PHP echo $nombre_mes ?> DE
        <?PHP echo $var_gestion ?>
      </h3>
      <hr />

      <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered table-condensed">
          <thead>
            <tr>
              <th>FACTURA</th>
              <th>FECHA FACTURA</th>
              <th>TOTAL</th>
              <th>VER</th>
            </tr>
          </thead>
          <tbody>
            <?PHP 
            $c=0;
            if($queryCompra->rowCount()>0){
              foreach($compras as $compra){
            ?>
            <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
              <td>
                <?PHP 
                                if(isset($compra->NRO_FACTURA)){
                                    echo $compra->NRO_FACTURA;
                                } 
                                ?>
              </td>
              <td>
                <?PHP 
                                if(isset($compra->FECHA_FACTURA)){
                                    echo $compra->FECHA_FACTURA; 
                                }
                                ?>
              </td>
              <td align="right">
                <?PHP 
                                if(isset($compra->TOTAL)){
                                    echo $compra->TOTAL; 
                                }
                                ?>
              </td>
              <td align="center">
                <a href="ComprasTabla.php?BUSCAR=<?PHP echo $compra->NRO_FACTURA; ?>&MES=<?php echo $var_mes;?>&GESTION=<?php echo $var_gestion;?>">
                  <img title="EDITAR" src="../Iconos/COMPUTADORA.ico" width="20" height="20" alt="EDITAR" />
                </a>
              </td>
            </tr>
            <?PHP 
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>