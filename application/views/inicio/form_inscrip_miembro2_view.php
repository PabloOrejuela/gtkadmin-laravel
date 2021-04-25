<style type="text/css">
	input[type="text"]{
		width: 80% !important;
	}
	select{
		width: 80% !important;
	}
	table td{
		width: 50%;
		padding-right: 10px;
	}
	.info_personal_row input,select{
		width: 80% !important;
	}
</style>

<script>
  $( function() {
    $( "#fecha1" ).datepicker();
    //$('.info_personal_row input,select').attr('readonly', 'readonly');
    $('#txt_cedula_socio').focus();
    $('#txt_cedula_socio').on('keyup', function(event) {
    	var cedula = $(this).val();
    	if (cedula.length==10) {
    		_get_socio_by_cedula_ajax(cedula);
    	}else if (cedula.length>10){

    		$('#txt_cedula_socio').focus();
    		alert("El número de cédula debe tener 10 Dígitos");
    	}
    });

    $('#patrocinador_criterio').on('blur', function(event) {
    	var criterio=$(this).val();
    	$('#p_info').remove();
    	if (criterio.length>3) {
			_get_socio_by_criterio(criterio);
		}else{
			$(this).after("<p id='p_info'>Información Insuficiente <br>Debe Ingresar por lo menos 3 caracteres para buscar un patrocinador</p>");
		}
    });

  });

  /*
  * Funcion que trae los datos del Patrocinador y los muestra en un DIV
  *	Pablo Orejuela
  */
  function _get_socio_by_criterio(crit) {
  	
  	//console.log("Criterio "+crit);
  	$.ajax({
  		url: '<?php echo base_url(); ?>inicio/get_socio_by_criterio_ajax',
  		type: 'POST',
  		data: {criterio: ''+crit},
  	})
  	.done(function(socio) {
  		if (socio!='0') {
	  		var json = $.parseJSON(socio);
	  		var tbod='';
	  		if (json.length==1) {
				  console.log(json[0].idsocio);
	  			$('#patrocinador').val(json[0].idsocio);
			  	$('#cedula_patrocinador_inf').html('<strong>Cédula: </strong>'+json[0].cedula);
				$('#nombres_patrocinador_inf').html('<strong>Nombre: </strong>'+json[0].nombres+' '+json[0].apellidos);
				$('#codigo_patrocinador_inf').html('<strong>Código: </strong>'+json[0].codigo_socio_binario);
				$('#direccion_patrocinador_inf').html('<strong>Prov: </strong>'+json[0].provincia);
				$('#btn_enviar').removeAttr('disabled');
				$('#modal_patrocinadores').modal('hide');
	  		}else if (json.length>0) {console.log(json[0].codigo_socio_binario);
	  			for (var i = 0; i < json.length; i++) {
	  				tbod +='<tr>'+
	  					'<td>'+json[i].codigo_socio_binario+'</td>'+
	  					'<td>'+json[i].cedula+'</td>'+
	  					'<td>'+json[i].apellidos+'</td>'+
	  					'<td>'+json[i].nombres+'</td>'+
	  					'<td> '+
	  					'<button class="btn btn-info" type="button" '+
	  					"onclick=\"asignar_socio_elegido('"+json[i].idcod_socio+"','"+json[i].nombres+"','"+json[i].apellidos+"','"+json[i].cedula+"','"+json[i].direccion+"');\" >Elegir</button> </td>"+
	  				'</tr>';
	  			}
	  			$('#tb_socios').empty();
	  			$('#tb_socios').append(tbod);
	  			$('#modal_patrocinadores').modal('show');
	  		}else{
	  			tbod+='<tr><td colspan="5" style="text-align: center">Sin resultados</td></tr>';
	  		}

	  	}else{
	  		//var json = $.parseJSON(socio);
	  		$('#cedula_patrocinador_inf').html("");
	  		$('#nombres_patrocinador_inf').html("");
	  		$('#direccion_patrocinador_inf').html("No existe un socio registrado con los datos proporcionados");
	  		$('#btn_enviar').attr('disabled', 'disabled');

	  	}
  	})
  	.fail(function() {
  		//console.log("error");
  	})
  	.always(function() {
  		//console.log("complete");
  	});

  }
 
  function asignar_socio_elegido(id,nombre,apellido,cedula,direccion) {
  	$('#patrocinador').val(id);
  	$('#cedula_patrocinador_inf').html('<strong>Cédula: </strong>'+cedula);
	$('#nombres_patrocinador_inf').html('<strong>Nombre: </strong>'+nombre+' '+apellido);
	$('#direccion_patrocinador_inf').html('<strong>Dirección: </strong>'+direccion);
	$('#btn_enviar').removeAttr('disabled');
	$('#modal_patrocinadores').modal('hide');
  }

  function cargar_ciudades() {
  	if($("#id_provincia").val() !=""){
    	valor = $("#id_provincia").val();
    	$.ajax({
        type:"POST",
        dataType:"html",
        url: varjs+"inicio/ciudades_select",
        data:"id_provincia="+valor,
            success:function(msg){
                $("#id_ciudad").empty().removeAttr("disabled").append(msg);
            }
        });
    }
  }
</script>

<div class="container-fluid">
	<div class="row" id="container" style="margin-left: 7px;">
		<h2>Formulario de Inscripción</h2>
		<div>
		<?php echo form_open('inicio/recibe_datos_frm_registro'); ?>
			<table class="table-condensed table-responisve" width="80%">
			<thead>
				<tr>
					<th style="width: 50%"></th>
				</tr>
			</thead>
				<tbody>
				<tr>
				<td colspan="2"><h4>Información del nuevo distribuidor</h4></td>
				</tr>
					<tr id="main_info_tr">
		        		<td>
		        			<label for="cedula" style="color: red;">CI:</label>
		        			<br>
		        			<input type="text" name="cedula" maxlength="10" placeholder="CI" class="form-control" id="txt_cedula_socio" onkeypress="return valida(event)" required>
		        		</td>
		        		<td class="info_personal_row">
		        			<!-- <label for="fecha_nacimiento_socio" style="color: red;">Fecha de nacimiento:</label> -->
		        			
		        		</td>
		        	</tr>
					<tr id="main_info_tr">
		        		<td class="info_personal_row" colspan="4">
				            <?php echo form_error('cedula') ?>
		        		</td>
		        	</tr>
		        	<tr class="info_personal_row">
		        		<td>
		        			<label for="nombres" style="color: red;">Nombres:</label>
		        			<br>
		        			<input type="text" name="nombres" class="form-control" value="<?php set_value('nombres'); ?>" placeholder="nombres" id="nombres_socio" required>
		        		</td>
		        		<td>
		        			<label for="apellidos" style="color: red;">Apellidos:</label>
		        			<br>
		        			<input type="text" name="apellidos" class="form-control" value="<?php set_value('apellidos'); ?>" placeholder="apellidos" id="apellidos_socio" required>
		        		</td>
		        	</tr>
		        	<tr class="info_personal_row">
		        		<td colspan="2">
		        			<label for="direccion">Dirección:</label>
		        			<br>
		        			<input type="text" name="direccion" class="form-control" placeholder="direccion" id="direccion_socio" value="<?php set_value('direccion'); ?>">
		        		</td>
		        	</tr>
		        	<tr class="info_personal_row">
                        <td>
                            <label for="provincia" style="color: red;">Provincia:</label>
                                <br>
                                <?php
                            $dropdown_provincia = array(
                                'opcion1'  => 'Elegir...',
                            );
                            foreach ($provincias as $key => $value) {
                                $dropdown_provincia[$value->idprovincia] = $value->provincia;
                            }
                            $js = 'id="id_provincia"; class="form-control"';
                            echo form_dropdown('id_provincia', $dropdown_provincia, 'opcion1', $js);

                            /*Paso el base_url() a una variable PHP
                             * y luego a una variable Javascript para
                             * poder usar el combo AJAX
                             */
                            $url = base_url();
                            echo '<script languaje="JavaScript">
                                    var varjs="'.$url.'";
                                    </script>';
                        ?>
                        </td>
		        	<td>
	        			<label for="ciudad" style="color: red;">Ciudad:</label><span id="add_new"> Click aquí para agregar ciudad</span>
	        			<br>
	        			<input type="text" name="ciudad" id="ciudad_new" style="display: none">
	        			<select id="id_ciudad" name="ciudad" class="form-control" value="<?php set_value('ciudad'); ?>" required="required"></select>
	        		</td>
	        		</tr>
		        	<tr class="info_personal_row">
		        		<td>
							<label for="celular" style="color: red;">Celular:</label>
		        			<br>
		        			<input type="text" name="celular" class="form-control"  value="<?php set_value('celular');?>" placeholder="celular" id="celular_socio" >
		        		</td>
		        		<td>
							<label for="email">Email:</label>
		        			<br>
		        			<input type="email" class="form-control" name="email" id="email_socio" value="<?php set_value('email');?>" placeholder="jose@email.com">
		        		</td>
		        	</tr>
					<tr><td><h4></h4></td><td><hr></td></tr>
		        	<tr><td><h4>Información de la Cuenta</h4></td><td><hr></td></tr>
		        	<tr class="info_personal_row">

		        		<td>
		        			<label for="banco">Banco:</label>
		        			<br>
		        			<?php
		        				$arr_banco = array('' => 'Elija...' );
		        				foreach ($bancos as $key => $value) {
		        					$arr_banco[$value->idbanco] = $value->banco;
		        				}

		        				echo form_dropdown('banco', $arr_banco, '','id="id_banco" class="form-control info_patrocinador" onChange="pagoOnChange(this)"');
		        			 ?>

		        		</td>
		        		<td>
		        			<label for="tipo_cuenta">Tipo de cta:</label>
		        			<br>
		        			<select name="tipo_cuenta" class="form-control info_patrocinador" id="tipo_cuenta">
				        		<option value="1" selected="">AHORROS</option>
				        		<option value="2">CORRIENTE</option>
				        	</select>
		        		</td>
		        	</tr>
		        	<tr class="info_personal_row" >
		        		<td>
		        			<label for="celular">Cuenta bancaria:</label>
		        			<br>
		        			<input type="text" class="form-control info_patrocinador" name="num_cta" placeholder="cuenta" id="cuenta_socio" value="<?php set_value('num_cta');?>">
		        		</td>
		        		<td></td>
		        	</tr>
					<tr><td><h4></h4></td><td><hr></td></tr>
		        	<tr><td><h4>Ubicacion en la red</h4></td><td><hr></td></tr>
		        	<tr>
		        		<td>
		        			<label for="idmatrices" style="color: red;">Tipo de Matriz:</label>
		        			<br>
				        	<?php

                                $dropdown_matriz = array(
                                    'opcion1'  => 'Elegir...'
                                );
                                foreach ($matrices as $key => $value) {
                                	$dropdown_matriz[$value->idmatrices] = $value->matriz;
                                }
                                $js = 'id="idmatrices"; class="form-control info_patrocinador;"';
                                echo form_dropdown('idmatrices', $dropdown_matriz, 'opcion1', $js);

                                /*Paso el base_url() a una variable PHP
                                 * y luego a una variable Javascript para
                                 * poder usar el combo AJAX
                                 */
                                $url = base_url();
                                echo '<script languaje="JavaScript">
                                        var varjs="'.$url.'";
                                        </script>';
                            ?>
		        		</td>
		        		<td>
		        		<label for="paquetes">Paquete:</label>
		        		<select id="paquetes" name="paquetes" class="form-control info_patrocinador" required="required"></select>
		        		</td>
		        	</tr>
		        	<tr id="tr_1" style="display:none;">
		        		<td><label style="text-align: center;">Ubicación en la red binaria</label></td>
						<td><input type="text" name="ubicacion" maxlength="5" placeholder="posicion" class="form-control" id="txt_ubicacion" onkeypress="return valida(event)" required></td>
		        	</tr>
		        	<tr>
		        		<td>
		        			<button type="button" class="btn btn-default"  onClick="document.location.reload();">Refrescar</button>
		        			<button type="submit" class="btn btn-primary" id="btn_enviar">Enviar</button>
		        		</td>
		        		<td>
		        		</td>
		        	</tr>
		        	</tbody>
	        </table>
			<input type="hidden" name="patrocinador" value="<?php echo $idcodigo_socio_binario; ?>">
	        <input type="hidden" name="formulario_id" value="1">
	        <?php echo form_close();?>
			<div>
				<?php
				echo form_open('reportes/mi_red_binaria');
				echo form_hidden('idmatrices', 2);
				echo '<input type="hidden" name="idcodigo_socio_binario" id="id_codigo" value="'.$idcodigo_socio_binario.'">';
				echo '<button type="submit" class="btn btn-primary" formtarget="_blank">VER MIS DIRECTOS</button></td></tr>';
				echo form_close();
				?>
			</div>
	    </div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_patrocinadores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Patrocinadores encontrados</h4>
      </div>
      <div class="modal-body">
        <table class="table table-responisve" style="width: 100%">
        	<thead>
        		<tr>
        			<th>Código</th>
        			<th>Cédula</th>
        			<th>Apellidos</th>
        			<th>Nombres</th>
        			<th></th>
        		</tr>
        	</thead>
        	<tbody id="tb_socios">

        	</tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {html:true
    $(function() {
        $( "#patrocinador" ).autocomplete({
            source: function(request, response) {
                $.ajax({ url: "<?php echo site_url('inicio/suggestions_patrocinador'); ?>",
                data: { term: $("#patrocinador").val()},
                dataType: "json",
                type: "POST",
                success: function(data){

                    response(data);
                }
            });
        },
        minLength: 1
        });
      });
   });

	$("#add_new" ).click(function() {
		$("#ciudad_new" ).css('display', 'block');
		$("#id_ciudad" ).css('display', 'none');
	});

//Valida campo solo numeros
function valida(e){
	tecla = (document.all) ? e.keyCode : e.which;

	//Tecla de retroceso para borrar, siempre la permite
	if (tecla==8){
	    return true;
	}

	// Patron de entrada, en este caso solo acepta numeros
	patron =/[0-9]/;
	tecla_final = String.fromCharCode(tecla);
	return patron.test(tecla_final);
}


$( function(){
    $('#idmatrices').on('change', function(){
        var disabled = $(this).val() == 2 ? true : false;
        //console.log("Disabled: " + disabled);

        if (disabled == true) {
        	$('#tr_1').css("display", "");
        	$('#tr_2').css("display", "");
        }else{
    		$('#tr_1').css("display", "none");
    		$('#tr_2').css("display", "none");
    	}
    });
});
</script>