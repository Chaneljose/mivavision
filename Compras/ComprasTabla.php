<?PHP 
require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Funciones/Funciones.php');
require_once('../Definiciones/Titulo.php'); 
//session_start(); 
$var_tipo = $_SESSION['SES_TIPO'];
$var_active = "compras";
$nro_factura = $_REQUEST['BUSCAR'];
$sql2 = "SELECT  c.ID_COMPRA
		 ,		  c.NRO_FACTURA
		 ,		  c.FECHA_FACTURA
		 ,		  c.CANTIDAD
		 ,		  c.PRECIO_FACTURA
		 ,		  c.UM_IMPUESTO
		 ,		  c.VALOR
		 ,		  c.ICE
		 ,        c.DESCUENTO
		 ,		  c.TOTAL
		 ,		  c.FECHA_CADUCIDAD
		 ,		  c.FECHA_REGISTRO
		 ,		  c.ID_ARTICULO
		 ,		  a.ARTICULO
		 FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
		 WHERE c.NRO_FACTURA =  '$nro_factura'
		 ORDER BY a.ARTICULO";
$querySolicitud = $connect->prepare($sql2);
$querySolicitud->execute();
$solicitudes = $querySolicitud->fetchAll(PDO::FETCH_OBJ);
$sql1 = "SELECT c.NRO_FACTURA, c.FECHA_FACTURA
      ,    SUM(c.ICE) SUM_ICE
		  ,  	 SUM(c.TOTAL) SUM_TOTAL
		  ,		 SUM(c.TOTAL) - SUM(c.ICE) DIFERENCIA
		  FROM compra c join articulo a on c.ID_ARTICULO = a.ID_ARTICULO
		  WHERE c.NRO_FACTURA =  '$nro_factura'
      GROUP BY 1,2";
$queryTotal = $connect->prepare($sql1);
$queryTotal->execute();
$totales = $queryTotal->fetchAll(PDO::FETCH_OBJ);
$ice = 0;
$var_total = 0;
$diferecnia = 0;
//$nro_factura = 0;
$fecha_factura = '';
if($queryTotal->rowCount()>0){
    foreach($totales as $total){
      $ice = $total->SUM_ICE;
      $var_total = $total->SUM_TOTAL;
      $diferecnia = $total->DIFERENCIA;
      //$nro_factura = $total->NRO_FACTURA;
      $fecha_factura = $total->FECHA_FACTURA;
    }
}
?>
<!doctype html>
<html lang="es">
<?PHP head1(compras); ?>
<body>
  <?PHP include('../menu.php');
			  require_once('../NavsideCompras.php');
		  	  navbar(reportes, $var_tipo, $var_active);
		  	  navside(reportes);?>
  <div class="container-fluid">
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h2 class="sub-header">
        <?PHP echo compras; ?>
      </h2>
      <form class="form-horizontal" role="form" action="">
        <div class="form-group form-horizontal">
          <label for="SOLICITUD" class="col-sm-4 control-label">IMPRIMIR FORMULARIO</label>
          <a id="impresion" class="btn btn-primary" href="ComprasImpreso.php?BUSCAR=<?PHP echo $nro_factura; ?>">IMPRIMIR</a>
        </div>
      </form>
      <hr />
      <div class="form-group form-horizontal">
        <label>FACTURA: </label>
        <?PHP echo $nro_factura; ?>
      </div>
      <div class="form-group form-horizontal">
        <label>FECHA FACTURA: </label>
        <?PHP echo fecha_dma($fecha_factura); ?>
      </div>
      <div class="form-group form-horizontal">
        <label>TOTAL FACTURA: </label>
        <?PHP echo round($var_total,2) ?>
      </div>
      <div class="form-group form-horizontal">
        <label>ICE: </label>
        <?PHP echo round($ice,2) ?>
      </div>
      <div class="form-group form-horizontal">
        <label>IMPORTE PARA CREDITO FISCAL: </label>
        <?PHP echo round($diferecnia,2) ?>
      </div>
      <hr />
      <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered table-condensed">
          <thead>
            <tr>
              <th>CANTIDAD</th>
              <th>ARTICULO</th>
              <th>PRECIO<br>FACTURA</th>
              <th>UM<br>IMPUESTO</th>
              <th>IMPORTE</th>
              <th>ICE</th>
              <th>DESCUENTO</th>
              <th>TOTAL</th>
              <th>ACCION</th>
            </tr>
          </thead>
          <tbody>
            <?PHP
            $cont =1;
            if($querySolicitud->rowCount()>0){
                foreach($solicitudes as $solicitud){
            ?>
            <tr class="<?=($c++%2==1) ? 'impar' : 'par' ?>">
              <td>
                <?PHP echo $solicitud->CANTIDAD; ?>
              </td>
              <td>
                <?PHP echo $solicitud->ARTICULO; ?>
              </td>
              <td align="right">
                <?PHP echo round($solicitud->PRECIO_FACTURA,4); ?>
              </td>
              <td align="right">
                <?PHP echo round($solicitud->UM_IMPUESTO,2); ?>
              </td>
              <td align="right">
                <?PHP echo round($solicitud->VALOR,2); ?>
              </td>
              <td align="right">
                <?PHP echo round($solicitud->ICE,2); ?>
              </td>
              <td align="right">
                <?PHP echo round($solicitud->DESCUENTO,2); ?>
              </td>
              <td align="right">
                <?PHP echo round($solicitud->TOTAL,2); ?>
              </td>
              <td><a data-toggle="modal" data-target="#UPDATE" class="btn btn-success btn-sm"
                  href="ComprasActualizar.php?BUSCAR=<?PHP echo $nro_factura; ?>&CODIGO=<?PHP echo $solicitud->ID_ARTICULO; ?>">EDITAR</a>
                <a data-toggle="modal" data-target="#DELETE" class="btn btn-danger btn-sm"
                  href="ComprasEliminar.php?BUSCAR=<?PHP echo $nro_factura; ?>&CODIGO=<?PHP echo $solicitud->ID_ARTICULO; ?>">BORRAR</a>
              </td>
            </tr>
            <?PHP 
              $cont++;
              }
            } 
            ?>
          </tbody>
        </table>
        <?php // MODAL DELETE ?>
        <div class="modal fade" id="DELETE" tabindex="-1" role="dialog" aria-labelledby="BORRAR" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <?PHP /*require_once('SolSalidasBorrar.php');*/?>
            </div>
          </div>
        </div>
        <?php // MODAL UPDATE ?>
        <div class="modal fade" id="UPDATE" tabindex="-1" role="dialog" aria-labelledby="EDITAR" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <?PHP require_once('ComprasActualizar.php');?>
            </div>
          </div>
        </div>
      </div>
</body>
</html>