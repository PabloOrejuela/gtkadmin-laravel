<div class="row" style="margin-left: 10px;">
	<div class="col-md-12">
        <h2>Reporte de Recompras</h2>
		<br>
		<?php echo form_open('reportes/frm_recompras_mes'); ?>
			<div class="form-group">
				<div class="form-group row">
					<div class="col-sm-10">
                    <label for="">Mes</label>
                    <select class="form-control" name="mes_recompras" id="">
                        <option value="0" selected>Elija un mes para ver el reporte...</option>
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
					<button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
		<?php echo form_close(); ?>
	</div>
</div>