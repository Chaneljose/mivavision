function buscar() 
{
    var textoBusqueda = $("input#busqueda").val();
    var textoTipoVenta = $("select#tipoVenta").val();
	
    if (textoBusqueda !== "") 
    {
        $.post("buscar_tacho.php", {valorBusqueda: textoBusqueda, valorTipoVenta: textoTipoVenta}, function(mensaje) {
            $("#resultadoBusqueda").html(mensaje);
        }); 
    }
    else 
    { 
        $("#resultadoBusqueda").html("Debe ingresar un numero de tacho");
    };
};
function expira() 
{
    var n = 3600;
    //var n = 60;
    var move = window.setInterval(function(){
        document.onmousemove = function(){
            n = 3600;
            //n = 60;
        }
        n--;
        if(n <= -1){
            alert('Tu sesion ha expirado...');
            location.href = "../Sesion/Destroy.php";
        }
    }, 1000);
};
function imprimirReporteVenta(inicio, fin, buscar)
{
    location.href="../SolicitudSalidas/SolSalidasReporte.php?INICIO="+inicio+"&FIN="+fin;
    window.open('../SolicitudSalidas/SolSalidasImpreso_hoja_carta.php?BUSCAR='+buscar, '_blank');
}