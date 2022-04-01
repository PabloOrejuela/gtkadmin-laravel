<style type="text/css">
	input[type="text"]{
		width: 80% !important;
		text-transform: uppercase;
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

<div class="container-fluid" id="table_datos">
	<div class="row" id="container">
		<h3>Formulario de Inscripción para no distribuidores</h3>
		<div>
		<?php echo form_open('inicio/recibe_datos_form_registro_externo'); ?>
			<table class="table-condensed table-responisve" width="90%" style="margin-bottom; 150px;">
				<tbody>
					<tr>
						<td><h4>Información del nuevo distribuidor</h4></td>
					</tr>
					<tr>
						<td><h6>*Campos en rojo son obligatorios</h6></td>
					</tr>
					<tr id="main_info_tr">
		        		<td>
		        			<label for="cedula" style="color: red;">CI:</label>
							<input type="text" name="cedula" maxlength="10" placeholder="CI" class="form-control" id="cedula" onkeypress="return valida(event)" required>
							<label><?php echo form_error('cedula') ?></label>
		        		</td>
		        		<td class="info_personal_row"></td>
		        	</tr>
		        	<tr class="info_personal_row">
		        		<td>
		        			<label for="nombres" style="color: red;">Nombres:</label>
		        			<input type="text" name="nombres" class="form-control" value="<?php set_value('nombres'); ?>" placeholder="nombres" id="nombres" required>
		        		</td>
		        		<td>
		        			<label for="apellidos" style="color: red;">Apellidos:</label>
		        			<input type="text" name="apellidos" class="form-control" value="<?php set_value('apellidos'); ?>" placeholder="apellidos" id="apellidos" required>
		        		</td>
		        	</tr>
		        	<tr class="info_personal_row">
		        		<td colspan="2">
		        			<label for="direccion">Dirección:</label>
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

							/*
							 * Paso el base_url() a una variable PHP
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
	        			<label for="ciudad" style="color: red;">Ciudad:</label>
	        			<br>
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
							<select class="form-control" name="banco" id="id_banco" onChange="pagoOnChange(this)">
								<?php
									$arr_banco = array('' => 'Elija...' );
									foreach ($bancos as $key => $value) {
										if($value->idbanco == 163){
											echo '<option value="'.$value->idbanco.'" selected>'.$value->banco.'</option>';
										}else{
											echo '<option value="'.$value->idbanco.'">'.$value->banco.'</option>';
										}
									}
								?>
							</select>

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
		        			<label for="num_cta">Cuenta bancaria:</label>
		        			<br>
		        			<input type="text" class="form-control info_patrocinador" name="num_cta" placeholder="cuenta" id="cuenta_socio" value="<?php set_value('num_cta');?>">
		        		</td>
		        		<td></td>
					</tr>
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
					<tr><td><h4> </h4></td><td><hr></td></tr>
		        	<tr><td><h4 style="color: red;">Información del patrocinador</h4></td><td><hr></td></tr>
		        	<tr class="info_personal_row">
		        		<td>
							<input type="text" class="form-control" name="nombre_patrocinador" placeholder="Nombre patrocinador"  value="<?php set_value('nombre_patrocinador');?>" id="nombre_patrocinador" required>
							<input type="text" class="form-control" name="cedula_patrocinador" placeholder="Cédula Patrocinador" id="ci_patroconador" value="<?php set_value('cedula_patrocinador');?>" required>
						</td>
						<td>
							<input type="text" class="form-control" name="apellido_patrocinador" placeholder="Apellido patrocinador" id="apellido_patrocinador" value="<?php set_value('apellido_patrocinador');?>" required>
							<input type="text" class="form-control" name="telefono_patrocinador" placeholder="Teléfono del Patrocinador" id="telf_patrocinador" value="<?php set_value('telefono_patrocinador');?>" required>
		        		</td>
					</tr>
					<tr>
		        		<td>
						<input type="text" class="form-control" name="email_patrocinador" placeholder="email patrocinador" id="email_patrocinador" value="<?php set_value('email_patrocinador');?>" >
						</td>
						<td>
							
						</td>
		        	</tr>
		        	<tr>
		        		<td>
		        			<button type="button" class="btn btn-default"  onClick="document.location.reload();">Refrescar</button>
		        			<button type="submit" class="btn btn-primary" id="btn_enviar">Enviar</button>
		        		</td>
		        		<td>
							<a href="<?php echo base_url();?>"><i class="fas fa-home"></i> Volver al inicio</a>
							<button type="button" class="btn btn-primary" id="btn_enviar" onClick="llenaDatos()" >Llenar datos de prueba para test</button>
		        		</td>
		        	</tr>
		        	</tbody>
	        </table>
	        <input type="hidden" name="formulario_id" value="1">
	        <?php echo form_close();?>
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

function llenaDatos(){
	//Función que llena los datos de los inputs para poder programar o hacer pruebas
	console.log("funciona");
	document.getElementById('cedula').value="1705520235";
	document.getElementById('nombres').value="JUAN";
	document.getElementById('apellidos').value="OREJUELA";
	document.getElementById('direccion_socio').value="RODRIGO NUÑEZ DE BALBOA OE2-180";
	document.getElementById('id_provincia').value=17;
	$("#id_ciudad").empty().removeAttr("disabled");
	document.getElementById('id_ciudad').value=163;
	document.getElementById('celular_socio').value="0992588779";
	document.getElementById('email_socio').value="porejuelac@gmail.com";
	document.getElementById('cuenta_socio').value="00221144";
	document.getElementById('nombre_patrocinador').value="Paola";
	document.getElementById('ci_patroconador').value="1711261428";
	document.getElementById('email_patrocinador').value="pao@gmail.com";
	document.getElementById('telf_patrocinador').value="0968944667";
	document.getElementById('apellido_patrocinador').value="Guerrero";
	document.getElementById('idpaquete').value=1;

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
