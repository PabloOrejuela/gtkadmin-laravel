<div class="row-fluid">
    <div class="col-md-12">
    <h3>Reporte de pagos por Ciudad</h3>
    <h5>Todos los campos son obligatorios</h5>
    	<?php
            $form_attributes = array(
                'class' => 'form-inline',
                'class' => 'form-inline',
                'id' => 'form_cabecera',
                'name' => 'form_reporte_pagos'
            );

            echo form_open('reportes/resumen_pagos_ciudad', $form_attributes);
    	?>
          <div class="col-md-12 form-group">
            <div class="col-md-12">
              <label for="cedula">Provincia:</label><br>
              <?php
                $dropdown_provincia = array(
                    'opcion1'  => 'Elegir...',
                );
                foreach ($provincias as $key => $value) {
                    $dropdown_provincia[$value->idprovincia] = $value->provincia;
                }
                $js = 'id="id_provincia"; class="form-control"';
                echo form_dropdown('id_provincia', $dropdown_provincia,'opcion1', $js);

                /*Paso el base_url() a una variable PHP
                 * y luego a una variable Javascript para
                 * poder usar el combo AJAX
                 */
                $url = base_url();
                echo '<script languaje="JavaScript">
                        var varjs="'.$url.'";
                        </script>';
              ?>
            </div>
            <div class="col-md-12">
              <label for="ciudad">Ciudad:</label>
                <br>
                <select id="id_ciudad" name="id_ciudad" class="form-control" value='<?php set_value("id_ciudad"); ?>' required="required"></select>
            </div>
            <div class="col-md-12">
              <label for="idmatrices">Matriz:</label><br>
              <select name="idmatrices" id="idmatrices"class="form-control" required="true">
                  <option value="NULL" selected>Elegir...</option>
                    <?php
                      foreach ($matrices as $key => $value) {
                        if ($value->idmatrices != 1) {
                          echo '<option value="'.$value->idmatrices.'">'.$value->matriz.'</option>';
                        }
                      }
                    ?>
              </select>
            </div>
             <div class="col-md-12">
             <!--  <button type="submit" class="btn btn-default" formtarget="_blank">Generar</button> -->
             <button type="submit" class="btn btn-default" target="_blank">Generar</button>
             <button type="reset" class="btn btn-default" onclick="limpiar()">Limpiar campos</button>
            </div>
          </div>
        <?php echo form_close(); ?>
	</div><!-- /.col-nd-12 -->
</div>

<script type="text/javascript">
    function validarn(e) {
        tecla = (document.all) ? e.keyCode : e.which; // 2
        if (tecla==8) return true; // 3
        if (tecla==9) return true; // 3
        if (tecla==11) return true; // 3
        patron = /[0-9 \s\t]/; // 4

        te = String.fromCharCode(tecla); // 5
        return patron.test(te); // 6
    }

  $(document).ready(function() {html:true
    $(function() {
        $( ".ciudad" ).autocomplete({
            source: function(request, response) {
                $.ajax({ url: "<?php echo site_url('reportes/suggestions_ciudades'); ?>",
                data: { term: $(".ciudad").val()},
                dataType: "json",
                type: "POST",
                success: function(data){
                  console.log('Consola: '+data);
                    response(data);
                }
            });
        },
        minLength: 1
        });
      });
   });
   
   function limpiar(){
    document.location.reload()
    
    console.log('Limpios');
   }
</script>