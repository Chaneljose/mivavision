<?PHP 

require_once('../cnx/cnx_compras.php');
include_once('../Funciones/funciones.php');
include('../fpdf/fpdf.php');

mysqli_select_db($cnx_compras, $database_cnx_compras);

$codigo = $_REQUEST['BUSCAR'];
    $sql2 = "SELECT v.ID_VENTA,
         v.ID_SOLICITUD_VENTA,
         s.NRO_NOTA,
         DATE_FORMAT(s.FECHA_SOLICITUD, '%d-%m-%Y') FECHA_SOLICITUD,
         v.ID_CLIENTE,
         c.NOMBRE,
         c.TACHO,
         v.ID_ALMACEN,
         v.ID_COMPRA,
         v.ID_ARTICULO,
         a.ARTICULO,
         a.PRECIO_VENTA,
         v.CANTIDAD,
         v.TOTAL,
         v.CI_TACHO_CLIENTE,
         v.NOMBRE_CLIENTE,
         s.ID_TIPO_VENTA,
         t.TIPO
    FROM venta v JOIN cliente c ON v.ID_CLIENTE = c.TACHO
             JOIN articulo a ON v.ID_ARTICULO = a.ID_ARTICULO
             JOIN solicitud_venta s ON v.ID_SOLICITUD_VENTA = s.ID_SOLICITUD_VENTA
             JOIN tipo_venta t ON s.ID_TIPO_VENTA = t.ID_TIPO_VENTA
    WHERE s.ID_SOLICITUD_VENTA = '$codigo'
        ORDER BY 1 DESC LIMIT 1";
        
$solicitud = mysqli_query($cnx_compras, $sql2) or die (mysqli_errno($cnx_compras)." : ".mysqli_error($cnx_compras));
$row_solicitud = mysqli_fetch_assoc($solicitud);
$num_solicitud = mysqli_num_rows($solicitud);

$id_solicitud_salida = $row_solicitud['ID_SOLICITUD_VENTA'];

$sql="SELECT v.ID_SOLICITUD_VENTA,
			 v.ID_ARTICULO,
			 r.ARTICULO,
			 r.ID_UNIDAD,
			 r.DESCRIPCION,
			 r.PRECIO_VENTA,
			 v.CANTIDAD,
			 v.TOTAL
	FROM venta v  join articulo r on v.ID_ARTICULO = r.ID_ARTICULO 
	WHERE v.ID_SOLICITUD_VENTA = '$id_solicitud_salida'";
$pedido = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_pedido = mysqli_fetch_assoc($pedido);
$num_pedido = mysqli_num_rows($pedido); 

$sql3="SELECT SUM(v.TOTAL) SUMA
	   FROM venta v  join articulo r on v.ID_ARTICULO = r.ID_ARTICULO 
	   WHERE v.ID_SOLICITUD_VENTA = '$id_solicitud_salida'";
$total = mysqli_query($cnx_compras, $sql3) or die(mysqli_errno($cnx_compras).' : '.mysqli_error($cnx_compras));
$row_total = mysqli_fetch_assoc($total);
$num_total = mysqli_num_rows($total);

/* comvertir numero a literal*/
function unidad($numuero){
switch ($numuero)
{
case 9:
{
$numu = "NUEVE";
break;
}
case 8:
{
$numu = "OCHO";
break;
}
case 7:
{
$numu = "SIETE";
break;
}
case 6:
{
$numu = "SEIS";
break;
}
case 5:
{
$numu = "CINCO";
break;
}
case 4:
{
$numu = "CUATRO";
break;
}
case 3:
{
$numu = "TRES";
break;
}
case 2:
{
$numu = "DOS";
break;
}
case 1:
{
$numu = "UNO";
break;
}
case 0:
{
$numu = "";
break;
}
}
return $numu;
}

function decena($numdero){

if ($numdero >= 90 && $numdero <= 99)
{
$numd = "NOVENTA ";
if ($numdero > 90)
$numd = $numd."Y ".(unidad($numdero - 90));
}
else if ($numdero >= 80 && $numdero <= 89)
{
$numd = "OCHENTA ";
if ($numdero > 80)
$numd = $numd."Y ".(unidad($numdero - 80));
}
else if ($numdero >= 70 && $numdero <= 79)
{
$numd = "SETENTA ";
if ($numdero > 70)
$numd = $numd."Y ".(unidad($numdero - 70));
}
else if ($numdero >= 60 && $numdero <= 69)
{
$numd = "SESENTA ";
if ($numdero > 60)
$numd = $numd."Y ".(unidad($numdero - 60));
}
else if ($numdero >= 50 && $numdero <= 59)
{
$numd = "CINCUENTA ";
if ($numdero > 50)
$numd = $numd."Y ".(unidad($numdero - 50));
}
else if ($numdero >= 40 && $numdero <= 49)
{
$numd = "CUARENTA ";
if ($numdero > 40)
$numd = $numd."Y ".(unidad($numdero - 40));
}
else if ($numdero >= 30 && $numdero <= 39)
{
$numd = "TREINTA ";
if ($numdero > 30)
$numd = $numd."Y ".(unidad($numdero - 30));
}
else if ($numdero >= 20 && $numdero <= 29)
{
if ($numdero == 20)
$numd = "VEINTE ";
else
$numd = "VEINTI".(unidad($numdero - 20));
}
else if ($numdero >= 10 && $numdero <= 19)
{
switch ($numdero){
case 10:
{
$numd = "DIEZ ";
break;
}
case 11:
{
$numd = "ONCE ";
break;
}
case 12:
{
$numd = "DOCE ";
break;
}
case 13:
{
$numd = "TRECE ";
break;
}
case 14:
{
$numd = "CATORCE ";
break;
}
case 15:
{
$numd = "QUINCE ";
break;
}
case 16:
{
$numd = "DIECISEIS ";
break;
}
case 17:
{
$numd = "DIECISIETE ";
break;
}
case 18:
{
$numd = "DIECIOCHO ";
break;
}
case 19:
{
$numd = "DIECINUEVE ";
break;
}
}
}
else
$numd = unidad($numdero);
return $numd;
}

function centena($numc){
if ($numc >= 100)
{
if ($numc >= 900 && $numc <= 999)
{
$numce = "NOVECIENTOS ";
if ($numc > 900)
$numce = $numce.(decena($numc - 900));
}
else if ($numc >= 800 && $numc <= 899)
{
$numce = "OCHOCIENTOS ";
if ($numc > 800)
$numce = $numce.(decena($numc - 800));
}
else if ($numc >= 700 && $numc <= 799)
{
$numce = "SETECIENTOS ";
if ($numc > 700)
$numce = $numce.(decena($numc - 700));
}
else if ($numc >= 600 && $numc <= 699)
{
$numce = "SEISCIENTOS ";
if ($numc > 600)
$numce = $numce.(decena($numc - 600));
}
else if ($numc >= 500 && $numc <= 599)
{
$numce = "QUINIENTOS ";
if ($numc > 500)
$numce = $numce.(decena($numc - 500));
}
else if ($numc >= 400 && $numc <= 499)
{
$numce = "CUATROCIENTOS ";
if ($numc > 400)
$numce = $numce.(decena($numc - 400));
}
else if ($numc >= 300 && $numc <= 399)
{
$numce = "TRESCIENTOS ";
if ($numc > 300)
$numce = $numce.(decena($numc - 300));
}
else if ($numc >= 200 && $numc <= 299)
{
$numce = "DOSCIENTOS ";
if ($numc > 200)
$numce = $numce.(decena($numc - 200));
}
else if ($numc >= 100 && $numc <= 199)
{
if ($numc == 100)
$numce = "CIEN ";
else
$numce = "CIENTO ".(decena($numc - 100));
}
}
else
$numce = decena($numc);

return $numce;
}

function miles($nummero){
if ($nummero >= 1000 && $nummero < 2000){
$numm = "MIL ".(centena($nummero%1000));
}
if ($nummero >= 2000 && $nummero <10000){
$numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
}
if ($nummero < 1000)
$numm = centena($nummero);

return $numm;
}

function decmiles($numdmero){
if ($numdmero == 10000)
$numde = "DIEZ MIL";
if ($numdmero > 10000 && $numdmero <20000){
$numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));
}
if ($numdmero >= 20000 && $numdmero <100000){
$numde = decena(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000));
}
if ($numdmero < 10000)
$numde = miles($numdmero);

return $numde;
}

function cienmiles($numcmero){
if ($numcmero == 100000)
$num_letracm = "CIEN MIL";
if ($numcmero >= 100000 && $numcmero <1000000){
$num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000));
}
if ($numcmero < 100000)
$num_letracm = decmiles($numcmero);
return $num_letracm;
}

function millon($nummiero){
if ($nummiero >= 1000000 && $nummiero <2000000){
$num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));
}
if ($nummiero >= 2000000 && $nummiero <10000000){
$num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));
}
if ($nummiero < 1000000)
$num_letramm = cienmiles($nummiero);

return $num_letramm;
}

function decmillon($numerodm){
if ($numerodm == 10000000)
$num_letradmm = "DIEZ MILLONES";
if ($numerodm > 10000000 && $numerodm <20000000){
$num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));
}
if ($numerodm >= 20000000 && $numerodm <100000000){
$num_letradmm = decena(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000));
}
if ($numerodm < 10000000)
$num_letradmm = millon($numerodm);

return $num_letradmm;
}

function cienmillon($numcmeros){
if ($numcmeros == 100000000)
$num_letracms = "CIEN MILLONES";
if ($numcmeros >= 100000000 && $numcmeros <1000000000){
$num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000));
}
if ($numcmeros < 100000000)
$num_letracms = decmillon($numcmeros);
return $num_letracms;
}

function milmillon($nummierod){
if ($nummierod >= 1000000000 && $nummierod <2000000000){
$num_letrammd = "MIL ".(cienmillon($nummierod%1000000000));
}
if ($nummierod >= 2000000000 && $nummierod <10000000000){
$num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000));
}
if ($nummierod < 1000000000)
$num_letrammd = cienmillon($nummierod);

return $num_letrammd;
}


function convertir($numero){
$num = str_replace(",","",$numero);
$num = number_format($num,2,'.','');
$cents = substr($num,strlen($num)-2,strlen($num)-1);
$num = (int)$num;

$numf = milmillon($num);

return $numf." CON  ".$cents."/100 ";
}
/* fin de convertir numero a literal*/

/* tenemos que generar una instancia de la clase */
        //$pdf = new FPDF();
$pdf = new FPDF('P', 'mm', array(74,105));
$pdf->AddPage();
$pdf->Sety(0);
/* seleccionamos el tipo, estilo y tama�o de la letra a utilizar */
$pdf->Image('../Iconos/logo_marol_solo_cruz.jpg',6,3,10);
$pdf->Ln();
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0,4,'',0,1,'C');
$pdf->Cell(0,4,'FARMACIA MAROL',0,1,'C');
$pdf->SetFont('Times', 'B', 6);
$pdf->Cell(0,2,'CALLE URPILA #SN',0,1,'C');
$pdf->Cell(0,2,'TELF:(591-4) 4306976',0,1,'C');
$pdf->SetFont('Times', 'B', 8);
$cadenatiposalida = "NOTA DE VENTA";
$pdf->Cell(0,7,$cadenatiposalida,0,1,'C');
$pdf->Setx(1);
$pdf->Cell(20,3,'NRO NOTA:',0,0,'R');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(13,3,zerofill($row_solicitud['NRO_NOTA']),0,0,'L');
$pdf->Ln();
$pdf->SetFont('Times', 'B', 8);
$pdf->Setx(1);
$pdf->Cell(20,3,'TIPO VENTA:',0,0,'R');
$pdf->SetFont('Times', '', 8);
if(strcmp($row_solicitud['TACHO'],$row_solicitud['CI_TACHO_CLIENTE']) == 0){
    $pdf->Cell(30,3,$row_solicitud['TIPO'],0,0,'L');
}else{
    $pdf->Cell(30,3,$row_solicitud['TIPO'],0,0,'L');
} 
$pdf->SetFont('Times', 'B', 8);
$pdf->Ln();
$pdf->Setx(1);
$pdf->Cell(20,3,'FECHA:',0,0,'R');
$pdf->SetFont('Times', '', 8);
$pdf->Cell(30,3,$row_solicitud['FECHA_SOLICITUD'],0,0,'L');
$pdf->Ln();
$pdf->SetFont('Times', 'B', 6);
$pdf->line(1,29,73,29);
$pdf->Setx(1);
$pdf->Cell(7,5,'CANT',0,0,'C');
$pdf->Cell(48,5,'PRODUCTO',0,0,'C');
$pdf->Cell(7,5,'P.U.',0,0,'C');
$pdf->Cell(10,5,'TOTAL',0,0,'C');
$pdf->line(1,32,73,32);
$pdf->SetFont('Times', '', 6);
$total_salida = 0;
do{
    $tamarticulo = strlen($row_pedido['ARTICULO']);
    $total_salida = $total_salida + redondeo($row_pedido['TOTAL']);
    $pdf->Ln();
    $pdf->Setx(1);
    $pdf->SetFont('Times', '', 7);
    $pdf->Cell(7,3,(string)$row_pedido['CANTIDAD'],0,0,'C');
    $pdf->SetFont('Times', '', 6);
    $pdf->Cell(48,3,substr($row_pedido['ARTICULO'], 0, 36),0,0,'L');
    $pdf->SetFont('Times', '', 7);
    $pdf->Cell(7,3,(string)$row_pedido['PRECIO_VENTA'],0,0,'C');
    $pdf->Cell(10,3,(string)redondeo($row_pedido['TOTAL']),0,0,'C');
    if($tamarticulo > 39){
        $pdf->Ln();
        $pdf->SetFont('Times', '', 6);
        $pdf->Setx(1);
        $pdf->Cell(7,3,'',0,0,'C');
        $pdf->Cell(48,3,substr($row_pedido['ARTICULO'], 36, 73),0,0,'L');
    }
    $pdf->SetFont('Times', '', 6);
} while($row_pedido = mysqli_fetch_assoc($pedido));
$pdf->Ln();
$pdf->SetFont('Times', 'B', 6);
$pdf->Setx(1);
$pdf->Cell(72,1,'____________________________________________________________________',0,0,'C');
$pdf->Ln();
$pdf->SetFont('Times', '', 7);
$pdf->Setx(1);
$pdf->Cell(72,5,'IMPORTE TOTAL EN BS:  '.$total_salida,0,0,'L');
$pdf->Ln();
$pdf->Setx(1);
//$pdf->Cell(72,2,'SON: '.convertir($total_salida).'  BOLIVIANOS',0,0,'L');
$cadenaprueba = convertir($total_salida).' BOLIVIANOS ';
//$pdf->Cell(72,2,'SON: '.substr($row_pedido['ARTICULO'], 0, 46),0,0,'L');
$pdf->Cell(72,2,'SON: '.substr($cadenaprueba, 0, 46),0,0,'L');
if(strlen($cadenaprueba) > 46){
    $pdf->Ln();
    $pdf->Setx(1);
    $pdf->Cell(72,3,'          '.substr($cadenaprueba, 46, 92),0,0,'L');
}
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
/*$pdf->Ln();
$pdf->Setx(1);
$pdf->Cell(72,2,'____________________',0,0,'C');
$pdf->Ln();
$pdf->Setx(1);
$pdf->Cell(72,3,'FIRMA '.$firma,0,0,'C');*/

$pdf->Output();
exit;
?>