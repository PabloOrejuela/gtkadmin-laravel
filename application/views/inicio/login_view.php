<style>
    #link{
        color: #444;
        font-weight: bold;
        text-decoration: none;
    }

    #link:hover{
        color: #003399;
        font-weight: bold;
        text-decoration: none;
    }
	/*Cambio hecho directamente*/
</style>
<div id="contenedor">
    <div id="wrap">
        <div class="col-md-8" id="form_login">
            <h2>Ingreso al sistema</h2>
            <?php echo form_open('inicio/validate_credentials');?>
            <label>Usuario:</label>
            <input type="text" name="user" value="<?php set_value('user')?>" class="form-control">
            <label>Contraseña:</label>
            <input type="password" name="password"  class="form-control">
            <input type="submit" value="Ingresar" class="btn btn-secondary" id="btn_submit">
            <?php echo form_close();?>
        </div>
    </div>
</div>
