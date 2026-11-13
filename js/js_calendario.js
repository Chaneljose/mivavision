// JavaScript Document
$(function() {
		$( ".calendario" ).datepicker({
        	dateFormat: 'dd/mm/yy',
			changeMonth: true,
			changeYear: true,
    		//minDate: '+0d', fucnion que bloque los dias anteriores , se cambia el valor de cero y el calendario muestra como minimo dia , tambien existe
			//maxdate dael rando dia maximo revisar esta funcion 
			showButtonPanel: true
		});
	});