<?PHP 
function fecha_dma(String $amd)
{
    return substr($amd, 8, 2)."-".substr($amd, 5, 2)."-".substr($amd, 0, 4);
}

function fecha_amd(String $dma)
{
    return substr($dma, 6, 4)."-".substr($dma, 3, 2)."-".substr($dma, 0, 2);
}

function zerofill(String $num)
{
	$zerofill = 4;
	return str_pad($num, $zerofill, '0', STR_PAD_LEFT);
}
function redondeo(float $num)
{
	return round($num,2);
	//return round($num, precision: 2, mode: PHP_ROUND_HALF_UP);
}
function fecha_literal(String $fecha)
{
	 if(date('l',strtotime($fecha)) == "Monday")
	 {
		 echo "LUNES"." , ";
	 }
	 else
	 if(date('l',strtotime($fecha)) == "Tuesday")
	 {
		 echo "MARTES"." , ";
	 }
	 else
	 if(date('l',strtotime($fecha)) == "Wednesday")
	 {
		 echo "MIERCOLES"." , ";
	 }
	 else
	 if(date('l',strtotime($fecha)) == "Thursday")
	 {
		 echo "JUEVES"." , ";
	 }
	 else
	 if(date('l',strtotime($fecha)) == "Friday")
	 {
		 echo "VIERNES"." , ";
	 }
	 else
	 if(date('l',strtotime($fecha)) == "Saturday")
	 {
		 echo "SABADO"." , ";
	 }
	 else
	 if(date('l',strtotime($fecha)) == "Sunday")
	 {
		 echo "DOMINGO"." , ";
	 }
}
?>