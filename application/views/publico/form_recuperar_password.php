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
</style>
<div id="contenedor">
    <div id="wrap">
        <div class="col-md-12" id="form_login" style="width:100%;">
            <h2>Recuperar su contraseña</h2>
            <p>Ingrese su email, declick en "enviar" y su código y contraseña se le enviará a su email</p>
            <?php echo form_open('inicio/recupera_password');?>
            <label>Ingrese su email:</label>
            <input 
                type="email" 
                name="email" 
                value="<?php set_value('email')?>" 
                class="form-control" 
                pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" 
                required
            >
            <!-- <label>Ingrese su cédula:</label>
            <input 
                type="text" 
                name="cedula" 
                value="<?php set_value('cedula')?>" 
                class="form-control" 
                onkeypress="return valida(event)"
                required
            >-->
            <input type="submit" value="Enviar" class="btn btn-default" id="btn_submit">            
            <?php echo form_close();?>
            <br>
            <a href="<?php echo base_url();?>"><i class="fas fa-home"></i> Volver al inicio</a>
        </div>
        <div class="col-md-12" id="form-login">
            <?php echo $message;?> 
        </div>
    </div>
</div>

<script type="text/javascript" charset="utf-8">
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