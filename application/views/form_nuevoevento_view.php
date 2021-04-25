<div class="row-fluid">
    <div class="col-md-12">
        <form action="graba_nuevo_evento" method="post" accept-charset="utf-8">
        <div class="col-md-12" id="grid_form">
            <h3>Ingresar nuevo evento</h3>
            <div class="col-md-1">
                <label for="fecha_evento">Fecha:</label>
            </div>
            <div class="col-md-3">
                <input type="date" name="fecha_evento" required="true">
            </div>
        </div>
        <div class="col-md-12" id="grid_form">
            <div class="col-md-1">
                <label for="lugar_evento">Lugar:</label>
            </div>
            <div class="col-md-3">
                <input type="text" name="lugar_evento" required="true">
            </div>
        </div>
        <div class="col-md-12" id="grid_form">
            <div class="col-md-1">
                <label for="descripcion_evento">Descripción:</label>
            </div>
            <div class="col-md-3">
                <input type="text" name="descripcion_evento" required="true">
            </div>
        </div>
        <div class="col-md-12" id="grid_form">
            <div class="col-md-1">
                <button type="submit" class="btn btn-default">Guardar</button>
            </div>
            <div class="col-md-3">
                <?php
                    if ($result == 1) {
                        echo '<h4>El evento se ha registrado correctamente</h4>';
                    }elseif($result == 0){
                        echo '<h4></h4>';
                    }
                ?>
            </div>
        </div>
        </form>
	</div><!-- /.col-nd-12 --> 	
</div>