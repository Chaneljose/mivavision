<?PHP
require_once('Definiciones/Titulo.php');
$hostname_cnx_compras = DB_SERVIDOR;
$database_cnx_compras = DB_NOMBRE;
$username_cnx_compras = DB_USUARIO;
$password_cnx_compras = DB_PASSWORD;
$charset_cnx_compras = DB_CHARSET;
try {
  // Ejecutamos las variables y aplicamos UTF8
  $connect = new PDO("mysql:host=" . DB_SERVIDOR . ";dbname=" . DB_NOMBRE, DB_USUARIO, DB_PASSWORD);
} catch (PDOException $e) {
  exit("Error: " . $e->getMessage());
}
