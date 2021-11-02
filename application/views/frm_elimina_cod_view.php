<div class="row-fluid">
    <div class="col-md-12" style="margin-bottom: 20px;">
	    <div class="input-group">
            <?php echo form_open('inicio/elimina_codigo') ?>
            <input type="text" class="form-control" placeholder="cedula" name="cedula">
            <button class="btn btn-default" type="submit">Buscar</button>
            <?php echo form_close() ?>
	    </div><!-- /input-group -->
	</div>

    <div class="col-md-12">
    	<table class="table table-bordered" style="width: 80%;font-size: 12px;">
    		<thead>
    			<tr>
    				<th style="width: 20px !important;">CEDULA</th>
    				<th style="width: auto !important;">NOMBRE</th>
    				<th style="width: 20px !important;">MATRIZ</th>
    				<th>CODIGO</th>
    				<th>CIUDAD</th>
                    <th>FECHA INSCRIPCION</th>
    				<th>ESTADO</th>
                    <th></th>
    			</tr>
    		</thead>
    		<tbody>
                <?php 
                    if (!isset($info_socio)) {
                        echo "<tr>
                            <td>NO HAY DATOS</td>
                        </tr>";
                    }else{
                        foreach ($info_socio as $key => $value) {
                            $ultima_compra = $this->procesos_model->_get_ultima_compra($value->idcodigo_socio_binario);
                            $estado = $this->procesos_model->_calcula_estado($value->fecha_inscripcion, $ultima_compra);
                            echo "<tr>
                                    <td>".$value->cedula."</td>
                                    <td>".$value->nombres.' '.$value->apellidos."</td>
                                    <td>BINARIA</td>
                                    <td>".$value->codigo_socio_binario."</td>
                                    <td>".$value->ciudad."</td>
                                    <td>".$value->fecha_inscripcion."</td>";
                                    if ($estado == 0) {
                                        echo "<td>INACTIVO</td>";
                                    }else{
                                        echo "<td>ACTIVO</td>";
                                    }
                                echo '<td style=" width: 30px;">';
                                echo form_open('inicio/elimina_codigo_process');
                                echo form_hidden('idmatrices', 2);
                                echo '<input type="hidden" name="idcodigo_socio_binario" id="id_codigo" value="'.$value->idcodigo_socio_binario.'">';
                                echo '<button type="submit" onclick="pregunta(event)" class="btn btn-danger">Eliminar</button>';
                                echo form_close();
                                echo "</tr>";


                        }
                    }
                ?>
    			
    		</tbody>
    	</table>
    </div>
</div>
<script type="text/javascript">

    /**
     * Verifica que el usuario esté seguro de eliminar ese CODIGO BINARIO
     *
     * @return void
     * @author Pablo Orejuela
     **/
    function pregunta(event){ 
        if (confirm('¿Esta seguro de que desea ELIMINAR el registro seleccionado?')){ 
            document.formborrar.submit();
        }
        else{
            event.preventDefault();
        }
    }
</script>