<?PHP
require_once('../cnx/cnx_compras.php');
include_once('../Funciones/funciones.php');
require_once('../Funciones/Cabecera.php');
require_once('../Definiciones/Titulo.php');
//session_start();
$var_tipo = $_SESSION['SES_TIPO'];
$var_active = "datos";
$sql = "SELECT a.ID_ARTICULO
  		,	   a.BARCODE
        ,      a.IMAGEN
        ,      a.ARTCODE
		,	   a.ARTICULO
		, 	   a.DESCRIPCION
		,	   ROUND(a.PRECIO_COMPRA,2) PRECIO_COMPRA
		,      round(a.PRECIO_COMPRA *0.87,2) IVA
		,	   ROUND(a.PRECIO_VENTA,2) PRECIO_VENTA
		,	   a.ID_GRUPO
		,      a.ID_MARCA
		,	   m.MARCA
        ,	   s.SALDO
		FROM articulo a JOIN marca m ON a.ID_MARCA = m.ID_MARCA JOIN stock s ON a.ID_ARTICULO = s.ID_ARTICULO
		WHERE a.ID_ARTICULO > 0
		ORDER BY 4";
$query = $connect->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
?>
<!doctype html>
<html lang="es">
<?PHP
head1(articulo);
?>

<body>

    <?PHP
    require_once('../menu.php');
    require_once('../NavsideDatos.php');
    navbar(datos, $var_tipo, $var_active);
    navside(articulo, $var_tipo);
    ?>
    <div class="container-fluid">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="sub-header"><?PHP echo articulo; ?></h2>
            <div>
                <p><a class="btn btn-primary" data-toggle="modal" data-target="#INSERT">CREAR</a></p>
            </div>
            <!-- MODAL INSERT -->
            <div class="modal fade" id="INSERT" tabindex="-1" role="dialog" aria-labelledby="INSERTAR"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <?PHP require_once('ArticuloForm.php'); ?>
                    </div>
                </div>
            </div>
            <?php
            if ($query->rowCount() > 0) {
            ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>IMAGEN</th>
                                <th>CODIGO</th>
                                <th>CODIGOBARRA</th>
                                <th>ARTICULO</th>
                                <th>MARCA</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO VENTA</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?PHP
                            foreach ($results as $result) {
                            ?>
                                <tr class="<?= ($c++ % 2 == 1) ? 'impar' : 'par' ?>">
                                    <td>
                                        <?PHP
                                        echo $result->ID_ARTICULO;
                                        ?>
                                    </td>
                                    <td>
                                        <?PHP
                                        $ima = $result->IMAGEN;
                                        echo '<img src="' . $ima . '" alt="Descripción de la imagen" width="100" height="100">';
                                        ?>
                                    </td>
                                    <td>
                                        <?PHP
                                        echo $result->ARTCODE;
                                        ?>
                                    </td>
                                    <td>
                                        <?PHP
                                        echo $result->BARCODE;
                                        ?>
                                    </td>
                                    <td>
                                        <?PHP
                                        echo $result->ARTICULO;
                                        ?>
                                    </td>
                                    <td>
                                        <?PHP
                                        echo $result->MARCA;
                                        ?>
                                    </td>
                                    <td>
                                        <?PHP
                                        echo $result->SALDO;
                                        ?>
                                    </td>
                                    <td align="right">
                                        <?PHP
                                        echo $result->PRECIO_VENTA;
                                        ?>
                                    </td>
                                    <td>
                                        <a data-toggle="modal" data-target="#UPDATE" class="btn btn-success btn-sm"
                                            href="ArticuloActualizar.php?CODIGO=<?php echo $result->ID_ARTICULO; ?>">EDITAR</a>
                                        <a data-toggle="modal" data-target="#DELETE" class="btn btn-danger btn-sm"
                                            href="ArticuloBorrar.php?CODIGO=<?php echo $result->ID_ARTICULO; ?>">BORRAR</a>
                                    </td>
                                </tr>
                            <?PHP
                            }
                            ?>
                            <!-- MODAL DELETE -->
                            <div class="modal fade" id="DELETE" tabindex="-1" role="dialog" aria-labelledby="BORRAR"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <?PHP require_once('ArticuloBorrar.php'); ?>
                                    </div>
                                </div>
                            </div>
                        </tbody>
                    </table>
                </div>
            <?php
            }
            ?>
            <!-- MODAL UPDATE -->
            <div class="modal fade" id="UPDATE" tabindex="-1" role="dialog" aria-labelledby="EDITAR" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <?PHP require_once('ArticuloActualizar.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/docs.js"></script>
    <script src="../js/jquery-1.8.3.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function() {
            const $ventanaModal = $('#INSERT');
            $ventanaModal.on('hidden.bs.modal', function(event) {
                const $formaulario = $ventanaModal.find('form');
                $formaulario[0].reset();
            });
        });
    </script>
</body>

</html>