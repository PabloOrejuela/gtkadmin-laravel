<div id="table_datos">
    <div class="col-md-12">
        <form action="graba_nuevo_testimonio" method="post" accept-charset="utf-8">
        <div class="col-md-12" id="grid_form">
            <h3>Ingresar nuevo Testimonio</h3>
        </div>
        <div class="col-md-12" id="grid_form">
            <div class="col-md-1">
                <label for="titulo">Título:</label>
            </div>
            <div class="col-md-3">
                <input type="text" name="titulo" required="true">
            </div>
        </div>
        <div class="col-md-12" id="grid_form">
            <div class="col-md-1">
                <label for="url">URL:</label>
            </div>
            <div class="col-md-3">
                <input type="text" name="url" required="true">
            </div>
        </div>
        <div class="col-md-12" id="grid_form">
            <div class="col-md-1">
                <label for="descripcion">Descripción:</label>
            </div>
            <div class="col-md-3">
                <input type="text" name="descripcion" required="true">
            </div>
        </div>
        <div class="col-md-12" id="grid_form">
            <div class="col-md-2">
                <button type="submit" class="btn btn-default">Guardar Testimonio</button>
            </div>
            <div class="col-md-3">
                <?php
                    if ($result == 1) {
                        echo '<h4><span style="color:#447C93;">El testimonio se ha registrado correctamente</span></h4>';
                    }elseif($result == 0){
                        echo '<h4> </h4>';
                    }
                ?>
            </div>
        </div>
        </form>
	</div>
</div>
