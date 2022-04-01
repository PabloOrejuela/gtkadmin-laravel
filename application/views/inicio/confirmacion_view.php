<div id="contenedor">
    <div id="wrap">
        <div class="col-md-12" id="form_login">
            <h2>Ingreso al sistema de administración</h2>
            <h5>Un email con el código de confirmación ha sido enviado, este código expira en 5 minutos</h5>
            <?php echo form_open('inicio/miembro_admin');?>
            <label for="pin">Ingrese el código:</label>
            <input type="text" name="pin" class="form-control" maxlength="10">
            <?php echo form_hidden('socio', $socio); ?>
            <input type="submit" value="Enviar" class="btn btn-secondary" id="btn_submit">
            <?php echo form_close();?>
            <a href="#">Volver a enviar el código</a>
        </div>
    </div>
</div>
