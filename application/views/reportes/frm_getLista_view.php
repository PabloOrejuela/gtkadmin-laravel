<div id="table_datos">
	<div class="col-md-12">
		<h2>Lista de Códigos</h2>
		<br>
		<?php echo form_open('reportes/genera_lista_codigos'); ?>
			<div class="form-group">
				<div class="form-group row">
					<div class="col-sm-10">
					<button type="submit" class="btn btn-primary">Generar lista</button>
						<input type="checkbox" aria-label="Checkbox para provincias" name="ordenar"> <label for="ordenar">Ordenar por provincia</label>
					</div>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>