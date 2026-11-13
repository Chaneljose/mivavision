<?php
require_once('../cnx/cnx_compras.php');  
mysqli_select_db($cnx_compras, $database_cnx_compras);
$tacho = 0;
$nombre = '';
    
      $buscar = $_POST['valorBusqueda'];
      $tipoVenta = $_POST['valorTipoVenta'];

      if(!empty($buscar)) {
            buscar($buscar,$cnx_compras, $tipoVenta);
      }
       
      function buscar($b,$conexion,$tipoVenta) 
      {
            $sql = "SELECT s.TACHO
            		,	   s.ORIGINAL
            		FROM censo2.socio s
            		WHERE s.TACHO='".$b."'";
            
            $acceso = mysqli_query($conexion, $sql) or die (mysqli_errno($conexion).' : '.mysqli_error($conexion));
            $row_acceso = mysqli_fetch_assoc($acceso);
			
            
            
            if(!isset($row_acceso['TACHO']))
            {
				echo "<b>INGRESE TACHO VALIDO</b>";
            }
            else
            {
				//do
				//{	
                    $tacho = $row_acceso['TACHO'];
                    $nombre = $row_acceso['ORIGINAL'];
                    //echo $nombre;
                    
                    echo '<br>
                        <form action="SolSalidasDMLInsert.php">
                            <table border = 0 width = 70%>
                            <tr>
                                <td align = center>
                                    FOTO
                                </td>
                                <td align = center>
                                    TACHO
                                </td>
                                <td align = center>
                                    NOMBRE
                                </td>
                                <td align = center>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td align = center>
                                    <img src="../foto/mostrar.php?TACHO='.$tacho.'" alt="SOCIO" class="img-thumbnail" width="240" height="240">
                                </td>
								<td align = center>
                                    '.$tacho.'
                                    <input type="hidden" id="TACHO" name="TACHO" value="'.$tacho.'" required />
                                    <input type="hidden" id="CI" name="CI" value="'.$tacho.'" required />
                                    <input type="hidden" id="TIPO_VENTA" name="TIPO_VENTA" value="'.$tipoVenta.'" required />
                                    <input type="hidden" id="NOMBRE" name="NOMBRE" value="'.$nombre.'" required />
                                    <input type="hidden" id="TIPO_SOCIO" name="TIPO_SOCIO" value="SOCIO" required />
                                </td>
                                <td align = center>
                                    '.$nombre.'
                                </td>
                                <td align = center>
                                    <input type="submit" class="btn btn-primary btn-ch active" value="SIGUIENTE">
                                </td>
                            </tr>';
					//}while($row_acceso = mysqli_fetch_assoc($acceso));
					echo '</table>
                    </form>'; 
                }			  
            }
?>