<?PHP
//session_start();

if(isset($_SESSION['SES_TIPO'])){
	session_unset();
	session_destroy();
	?>
		<script language = javascript>
			//alert("su sesion ha terminado correctamente")
			self.location = "../"
		</script>
	<?PHP
}else{
	?>
		<script language = javascript>
			//alert("No ha iniciado ninguna sesión, por favor regístrese")
			self.location = "../"
		</script>
	<?PHP
}
?>