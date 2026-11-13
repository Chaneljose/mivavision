<?PHP
require_once('../cnx/cnx_compras.php');
include_once('../Funciones/Funciones.php');
//session_start();
$var_tipo = '';
$var_active = "compras";
$nro_factura = $_REQUEST['FACTURA'];
$var_usuario = $_SESSION['SES_ID'];
$nro_nota = 1;
if(!isset($_SESSION['SES_TIPO'])){
  $var_tipo = $_SESSION['SES_TIPO'];
} 
$fecha = date("Y-m-d H:i:s");
$fecha_factura = date("Y-m-d");
if($_REQUEST['FECHA_FACTURA'] != ''){
	$fecha_factura = fecha_amd($_REQUEST['FECHA_FACTURA']);
}
/*$sql1 = "INSERT INTO solicitud_compra( NRO_NOTA
								   , FECHA_SOLICITUD
									 , FECHA_FACTURA
									 , ID_USR)
							 VALUES ('$nro_factura'
									,'$fecha'
									,'$fecha_factura'
									,'$var_usuario')";
$querySolComp = $connect->prepare($sql1);
$querySolComp->execute();*/
$sql_compras_aux = "SELECT * FROM compra_aux";
$queryCompAux = $connect->prepare($sql_compras_aux);
$queryCompAux->execute();
$compras_auxs = $queryCompAux->fetchAll(PDO::FETCH_OBJ);
if($queryCompAux->rowCount()>0){
	foreach($compras_auxs as $compras_aux){
		$cantidad = $compras_aux->CANTIDAD;
		$precio_factura = $compras_aux->PRECIO_FACTURA;
		$precio_venta = $compras_aux->PRECIO_VENTA;
		$um_impuesto = $compras_aux->UM_IMPUESTO;
		$valor = $compras_aux->VALOR;
		$ice = $compras_aux->ICE;
		$descuento = $compras_aux->DESCUENTO;
		$total = $compras_aux->TOTAL;
		$fecha_caducidad = $compras_aux->FECHA_CADUCIDAD;
		$id_articulo = $compras_aux->ID_ARTICULO;
		$sql4 = "INSERT INTO compra( NRO_FACTURA
							 , FECHA_FACTURA
							 , CANTIDAD
						   , PRECIO_FACTURA
						   , UM_IMPUESTO
						   , VALOR
						   , ICE
						   , DESCUENTO
						   , TOTAL
						   , FECHA_CADUCIDAD
							 , FECHA_REGISTRO
							 , ID_ARTICULO
							 , ID_USR)
					  VALUES('$nro_factura'
						,    '$fecha_factura'
						,    '$cantidad'
						,    '$precio_factura'
					  ,		 '$um_impuesto'
					  ,		 '$valor'
					  ,		 '$ice'
					  ,		 '$descuento'
					  ,		 '$total'
					  ,		 '$fecha_caducidad'
						,    '$fecha' 
					  ,		 '$id_articulo'
						,    '$var_usuario')";
		$queryComp = $connect->prepare($sql4);
		$queryComp->execute();
		$sql5 = "UPDATE articulo
				SET PRECIO_VENTA = '$precio_venta'
				WHERE ID_ARTICULO = '$id_articulo'";
		$queryArt = $connect->prepare($sql5);
		$queryArt->execute();
	}
}
$sql6 = "TRUNCATE TABLE compra_aux;";
$queryDele = $connect->prepare($sql6);
$queryDele->execute();
echo "<script language = javascript>self.location='ComprasTabla.php?BUSCAR=".$nro_factura."'</script>"
?>