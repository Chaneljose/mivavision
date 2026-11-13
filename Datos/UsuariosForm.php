<?PHP require_once('../cnx/cnx_compras.php');
require_once('../Funciones/Cabecera.php');
require_once('../Definiciones/Titulo.php'); 
//mysqli_select_db($cnx_compras, $database_cnx_compras);

$sql = "SELECT ID_TIPO_USR, 
			 TIPO_USR
	  FROM tipo_usr";
//$marca = mysqli_query($cnx_compras, $sql) or die(mysqli_errno($cnx_compras) . ' : ' . mysqli_error($cnx_compras));
//$row_marca = mysqli_fetch_assoc($marca);
//$num_marca = mysqli_num_rows($marca);
$query = $connect->prepare($sql);
$query->execute();
$tipoUsuarios = $query->fetchAll(PDO::FETCH_OBJ);
?>
<!doctype html>
<html lang="es">

<?PHP head1(clientes); ?>

<body class="ui-widget">

  <div class="modal-header">
    <a class="close" data-dismiss="modal">x</a>
    <h3>REGISTRO DE USUARIOS</h3>
  </div>
  <form class="form-horizontal" role="form" action="UsuariosDMLInsert.php">
    <div class="form-group">
      <label for="LOGIN" class="col-sm-3 control-label">LOGIN</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="LOGIN" name="LOGIN" placeholder="LOGIN"
          onchange="this.value = this.value.toUpperCase();" required />
      </div>
    </div>

    <div class="form-group">
      <label for="PASSWORD" class="col-sm-3 control-label">PASSWORD</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="PASSWORD" name="PASSWORD" placeholder="PASSWORD" required />
      </div>
    </div>

    <div class="form-group">
      <label for="NOMBRE" class="col-sm-3 control-label">NOMBRE</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" placeholder="NOMBRE"
          onchange="this.value = this.value.toUpperCase();" required />
      </div>
    </div>

    <div class="form-group">
      <label for="APATERNO" class="col-sm-3 control-label">APELLIDO PATERNO</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="APATERNO" name="APATERNO" placeholder="APELLIDO PATERNO"
          onchange="this.value = this.value.toUpperCase();" required />
      </div>
    </div>

    <div class="form-group">
      <label for="AMATERNO" class="col-sm-3 control-label">APELLIDO MATERNO</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="AMATERNO" name="AMATERNO" placeholder="APELLIDO MATERNO"
          onchange="this.value = this.value.toUpperCase();" required />
      </div>
    </div>

    <div class="form-group">
      <label for="CI" class="col-sm-3 control-label">CI</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="CI" name="CI" placeholder="NRO CI"
          onchange="this.value = this.value.toUpperCase();" required />
      </div>
    </div>

    <div class="form-group">
      <label for="FECHANAC" class="col-sm-3 control-label">FECHA DE NACIMIENTO</label>
      <div class="col-sm-4">
        <input type="date" class="form-control" id="FECHANAC" name="FECHANAC" placeholder="FECHA DE NACIMIENTO" required />
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">TIPO</label>
      <div class="col-sm-4">
        <select class="form-control combobox" name="TIPO" required>
          <option value="">-- seleccione un valor --</option>
          <?PHP 
          if($query->rowCount()>0){
            foreach($tipoUsuarios as $tipoUsuario){
          ?>
            <option value="<?PHP echo $tipoUsuario->ID_TIPO_USR; ?>">
              <?PHP
              echo $tipoUsuario->TIPO_USR;
              ?>
            </option>
          <?PHP 
            }
          }
          ?>
        </select>
      </div>
    </div>

    <div class="modal-footer">
      <button class="btn btn-success" id="submit">REGISTRAR</button>
      <a href="UsuariosTabla.php" class="btn btn-default" data-dismiss="modal">CERRAR</a>
    </div>
  </form>
  <script>
    // JavaScript Document
    (function($) {
      $.widget("ui.combobox", {
        _create: function() {
          var self = this,
            select = this.element.hide(),
            selected = select.children(":selected"),
            value = selected.val() ? selected.text() : "";
          var input = this.input = $("<input>")
            .insertAfter(select)
            .val(value)
            .autocomplete({
              delay: 0,
              minLength: 0,
              source: function(request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request
                  .term), "i");
                response(select.children("option").map(function() {
                  var text = $(this).text();
                  if (this.value && (!request.term || matcher.test(
                      text)))
                    return {
                      label: text.replace(
                        new RegExp(
                          "(?![^&;]+;)(?!<[^<>]*)(" +
                          $.ui.autocomplete.escapeRegex(
                            request.term) +
                          ")(?![^<>]*>)(?![^&;]+;)", "gi"
                        ), "<strong>$1</strong>"),
                      value: text.trim(),
                      option: this
                    };
                }));
              },
              select: function(event, ui) {
                ui.item.option.selected = true;
                self._trigger("selected", event, {
                  item: ui.item.option
                });
              },
              change: function(event, ui) {
                if (!ui.item) {
                  var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex($(
                      this).val()) + "$", "i"),
                    valid = false;
                  select.children("option").each(function() {
                    if ($(this).text().match(matcher)) {
                      this.selected = valid = true;
                      return false;
                    }
                  });
                  if (!valid) {
                    // remove invalid value, as it didn't match anything
                    $(this).val("");
                    select.val("");
                    input.data("autocomplete").term = "";
                    return false;
                  }
                }
              }
            })
            .addClass("ui-widget ui-widget-content ui-corner-left");

          input.data("autocomplete")._renderItem = function(ul, item) {
            return $("<li></li>")
              .data("item.autocomplete", item)
              .append("<a>" + item.label + "</a>")
              .appendTo(ul);
          };

          this.button = $("<button type='button'>&nbsp;</button>")
            .attr("tabIndex", -1)
            .attr("title", "Mostrar Items")
            .insertAfter(input)
            .button({
              icons: {
                primary: "ui-icon-triangle-1-s"
              },
              text: false
            })
            .removeClass("ui-corner-all")
            .addClass("ui-corner-right ui-button-icon")
            .click(function() {
              // close if already visible
              if (input.autocomplete("widget").is(":visible")) {
                input.autocomplete("close");
                return;
              }

              // pass empty string as value to search for, displaying all results
              input.autocomplete("search", "");
              input.focus();
            });
        },

        destroy: function() {
          this.input.remove();
          this.button.remove();
          this.element.show();
          $.Widget.prototype.destroy.call(this);
        }
      });
    })(jQuery);

    $(function() {
      $(".combobox").combobox();
      $("#toggle").click(function() {
        $("#combobox").toggle();
      });
    });
  </script>
</body>

</html>