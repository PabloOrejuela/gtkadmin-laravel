<style type="text/css">
	input[type="text"]{
		width: 100% !important;
	}
	table td{
		padding-right: 20px;
	}
	.info_personal_row input,select{
		width: 100% !important;
	}
</style>

<script>
  $( function() {
    $( "#fecha" ).datepicker();
    $('.info_personal_row input,select').attr('readonly', 'readonly');
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

  function _get_socio_by_criterio(crit) {
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
	  			$('#patrocinador').val(json[0].idsocio);
			  	$('#cedula_patrocinador_inf').html('<strong>Cédula: </strong>'+json[0].cedula);
				$('#nombres_patrocinador_inf').html('<strong>Nombre: </strong>'+json[0].nombres+' '+json[0].apellidos);
				$('#direccion_patrocinador_inf').html('<strong>Dirección: </strong>'+json[0].direccion);
				$('#btn_enviar').removeAttr('disabled');
				$('#modal_patrocinadores').modal('hide');
	  		}else if (json.length>0) {
	  			for (var i = 0; i < json.length; i++) {
	  				tbod +='<tr>'+
	  					'<td>'+json[i].cedula+'</td>'+
	  					'<td>'+json[i].apellidos+'</td>'+
	  					'<td>'+json[i].nombres+'</td>'+
	  					'<td>'+json[i].direccion+'</td>'+
	  					'<td> '+
	  					'<button class="btn btn-info" type="button" '+
	  					"onclick=\"asignar_socio_elegido('"+json[i].idsocio+"','"+json[i].nombres+"','"+json[i].apellidos+"','"+json[i].cedula+"','"+json[i].direccion+"');\" >Elegir</button> </td>"+
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
	  		$('#direccion_patrocinador_inf').html("No existe un socio registrado con los datos que proporcionó");
	  		$('#btn_enviar').attr('disabled', 'disabled');

	  	}
  	})
  	.fail(function() {
  		console.log("error");
  	})
  	.always(function() {
  		console.log("complete");
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

  function _get_socio_by_cedula_ajax(cedula) {
  	$.ajax({
  		url: '<?php echo base_url(); ?>inicio/get_socio_by_cedula_ajax',
  		type: 'POST',
  		data: {ced: ''+cedula},
  	})
  	.done(function(socio) {
  		if (socio!='0') {
  			var datos = socio.split('<sep>');
	  		var json = $.parseJSON(datos[0]);
	  		var json_cuenta = $.parseJSON(datos[1]);
	  		$('#fecha_nacimiento_socio').val(json.fecha_nacimiento);
	  		$('#fecha_nacimiento_socio').removeClass('fecha');
	  		$('#nombres_socio').val(json.socio_nuevo);
	  		$('#apellidos_socio').val(json.apellidos);
	  		$('#direccion_socio').val(json.direccion);
	  		$('#id_provincia').val(json.idprovincia);
	  		cargar_ciudades();
	  		$('#nombres_socio').val(json.nombres);
	  		$('#id_ciudad').val(json.idciudad);
	  		$('#telf_socio').val(json.telf_casa);
	  		$('#celular_socio').val(json.celular);
	  		$('#id_operadora').val(json.idoperadora);
	  		$('#email_socio').val(json.email);
	  		$('#cuenta_socio').val(json_cuenta.num_cta);
	  		$('#id_banco').val(json_cuenta.idbanco);
	  		$('#tipo_cuenta').val(json_cuenta.idtipo_cuenta);
	  		$('#info_tr').remove();

	  		$('#main_info_tr').after('<tr id="info_tr"><td colspan="2"><strong style="color: green;">Socio ya existe</strong></td><tr>');
	  		$('.info_personal_row input,select').attr('disabled', 'disabled');
	  		$('#patrocinador').focus();
	  		alert('El socio ya se encuentra registrado, usted puede registrar otro código ');
  		}else{
  			$('#fecha_nacimiento_socio').val("");
	  		$('#fecha_nacimiento_socio').removeClass('fecha');
	  		$('#nombres_socio').val("");
	  		$('#apellidos_socio').val("");
	  		$('#direccion_socio').val("");
	  		$('#id_provincia').val("");

	  		$('#nombres_socio').val("");
	  		$('#id_ciudad').empty("");
	  		$('#telf_socio').val("");
	  		$('#celular_socio').val("");
	  		$('#id_operadora').val("");
	  		$('#email_socio').val("");
	  		$('#cuenta_socio').val('');
	  		$('#info_tr').remove();

  			$('#fecha_nacimiento_socio').addClass('fecha');
  			$('#main_info_tr').after('<tr  id="info_tr"><td colspan="2"><strong style="color: blue;">Sin datos registrados por favor complete su información</strong></td><tr>');
  			$('.info_personal_row input,select').removeAttr('readonly');
  			$('.info_personal_row input,select').removeAttr('disabled');
  		}
  		$('.info_patrocinador').removeAttr('readonly');
  		$('.info_patrocinador').removeAttr('disabled');
  	})
  	.fail(function() {
  		console.log("error");
  	})
  	.always(function() {
  		console.log("complete");
  	});

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

<div class="table table-responsive" id="table_datos">
	<div class="row" id="container">
		<h2>Formulario de Inscripción</h2>
		<div>
		<?php echo form_open('inicio/recibe_datos_frm_registro'); ?>
			<table class="table table-responsive" >
			<thead>
				<tr>
					<th style="width: 50%"></th>
				</tr>
			</thead>
				<tbody>
				<tr>
				<td colspan="2"><h3>Información del nuevo socio</h3></td>
				</tr>
					<tr id="main_info_tr">
		        		<td>
		        			<label for="cedula">CI:</label>
		        			<br>
		        			<input type="text" name="cedula" maxlength="10" placeholder="CI" class="form-control" id="txt_cedula_socio" onkeypress="return valida(event)" required>
		        		</td>
		        		<td class="info_personal_row">
		        			<label for="fecha_nacimiento_socio">Fecha de nacimiento:</label>
		        			<br>
				            <input type="text" max="<?php echo date((date('Y')-16).'-m-d')?>"  class="form-control fecha" name="fecha_nacimiento" value="<?php set_value('fecha_nacimiento'); ?>" placeholder="fecha de nacimiento" id="fecha_nacimiento_socio" required>
		        		</td>
		        	</tr>
		        	<tr class="info_personal_row">
		        		<td>
		        			<label for="nombres">Nombres:</label>
		        			<br>
		        			<input type="text" name="nombres" class="form-control" value="<?php set_value('nombres'); ?>" placeholder="nombres" id="nombres_socio" required>
		        		</td>
		        		<td>
		        			<label for="apellidos">Apellidos:</label>
		        			<br>
		        			<input type="text" name="apellidos" class="form-control" value="<?php set_value('apellidos'); ?>" placeholder="apellidos" id="apellidos_socio" required>
		        		</td>
		        	</tr>
		        	<tr class="info_personal_row">
		        		<td colspan="2">
		        			<label for="direccion">Dirección:</label>
		        			<br>
		        			<input type="text" name="direccion" class="form-control" placeholder="direccion" id="direccion_socio" value="<?php set_value('direccion'); ?>" required>
		        		</td>
		        	</tr>
		        	<tr class="info_personal_row">
		        		<td>
		        			<label for="provincia">Provincia:</label>
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
	        			<label for="ciudad">Ciudad:</label>
	        			<br>
	        			<select id="id_ciudad" name="ciudad" class="form-control" required="required"></select>
	        		</td>
	        		</tr>
		        	<tr class="info_personal_row">
		        		<td>
		        			<label for="telf_casa">Telf. CASA/OFICINA:</label>
		        			<br>
		        			<input type="text" name="telf_casa" class="form-control" value="<?php set_value('telf_casa'); ?>" placeholder="teléfono" id="telf_socio">
		        		</td>
		        		<td>
		        			<label for="celular">Celular:</label>
		        			<br>
		        			<input type="text" name="celular" class="form-control"  value="<?php set_value('celular');?>" placeholder="celular" id="celular_socio">
		        		</td>
		        	</tr>
		        	<tr class="info_personal_row">
		        		<td>
		        			<label for="operadora">Operadora:</label>
		        			<br>
		        			<select name="operadora" id="id_operadora" class="form-control">
				        		<option value="1" selected="">MOVISTAR</option>
				        		<option value="2">CLARO</option>
				        		<option value="3">CNT</option>
				        	</select>
		        		</td>
		        		<td>
		        			<label for="email">Email:</label>
		        			<br>
		        			<input type="email" class="form-control" name="email" id="email_socio" value="<?php set_value('email');?>" placeholder="jose@email.com">
		        		</td>
		        	</tr>
		        	<tr><td><h3>Información del Cuenta</h3></td><td><hr></td></tr>
		        	<tr class="info_personal_row">

		        		<td><!-- Los bancos deben venir de base de datos -->
		        			<label for="banco">Banco:</label>
		        			<br>
		        			<?php
		        				$arr_banco = array('' => 'Elija...' );
		        				foreach ($bancos as $key => $value) {
		        					$arr_banco[$value->idbanco] = $value->banco;
		        				}

		        				echo form_dropdown('banco', $arr_banco, '','id="id_banco" class="form-control info_patrocinador" required');
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
		        			<input type="text" class="form-control info_patrocinador" name="num_cta" placeholder="cuenta" id="cuenta_socio" value="<?php set_value('num_cta');?>" required>
		        		</td>
		        		<td></td>
		        	</tr>
		        	<tr><td><h3>Información del patrocinador</h3></td><td><hr></td></tr>
		        	<tr>
		        		<td>
		        			<label for="patrocinador">Cédula del Patrocinador:</label>
		        			<!-- todo: terminar de hacer el autocomplete, falta que se llenen los datos del patrocinadores -->
		        			<br>
		        			<input type="text" class="form-control info_patrocinador" name="patrocinador_criterio" placeholder="patrocinador" id="patrocinador_criterio" value="<?php set_value('patrocinador');?>" required>
		        			<input type="hidden" class="form-control info_patrocinador" name="patrocinador" placeholder="patrocinador" id="patrocinador" value="<?php set_value('patrocinador');?>" required>
		        		</td>
		        		<td>
		        			<label style="text-align: center;">Información de Patrocinador</label><br>
		        			<label id="cedula_patrocinador_inf" style="margin-right: 10px;"></label>
		        			<label id="nombres_patrocinador_inf"></label>
		        			<br>
		        			<label id="direccion_patrocinador_inf"></label>
		        		</td>
		        	</tr>
		        	<tr>
		        		<td>
		        			<label for="idmatrices">Tipo de Matriz:</label>
		        			<br>
				        	<?php
				        	// PABLO: deberia automaticamente elegir la matriz del codigo del patrocinador

                                $dropdown_matriz = array(
                                    'opcion1'  => 'Elegir...'
                                );
                                foreach ($matrices as $key => $value) {
                                	$dropdown_matriz[$value->idmatrices] = $value->matriz;
                                }
                                $js = 'id="idmatrices"; class="form-control info_patrocinador"';
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
		        	<tr>
		        		<td>Hola</td>
		        		<td></td>
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
	        <input type="hidden" name="formulario_id" value="0">
	        <?php echo form_close();?>
	    </div>
	</div>
</div>
<div class="col-md-1" id="flotante">
	<h5><a href="<?php echo base_url(); ?>inicio"><i class="fa fa-users" aria-hidden="true"><br>Ir al login GTK Ecuador</i></a></h5>
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
        			<th>Cédula</th>
        			<th>Apellidos</th>
        			<th>Nombres</th>
        			<th>Dirección</th>
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


</script>
