<div class="row-fluid">
    <div class="col-md-12">
    	<h3>Reporte de matriz individual</h3>
    	<?php  
    		$form_attributes = array(
	    		'class' => 'form-inline',
	    		'class' => 'form-inline',
	    		'id' => 'form_cabecera',
	    	);

	    	echo form_open('reportes/ver_resumen_matriz_individual', $form_attributes);
    	?>
          <div class="form-group">
            <label for="cedula">Cédula:</label>
            <input type="text" class="form-control" id="cedula" name="cedula" placeholder="CI" onkeypress="return validarn(event)" required="true">
          </div>
          <button type="submit" class="btn btn-default">Enviar</button>
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
</script>