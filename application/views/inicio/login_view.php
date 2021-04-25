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
            <input type="submit" value="Ingresar" class="btn btn-default" id="btn_submit">
            <?php echo form_close();?>
        </div>
        <div class="col-md-4" id="form_login">
            <h4>
            <i class="fas fa-shopping-cart"></i>
            <h4>Desea comprar producto sin estar registrado?</h4>
                <a href="<?php echo base_url().'compras/recompra_externa'; ?>" id="link"> 
                     Click aquí: "COMPRAR PRODUCTO"!!
                </a>
            </h4>
            <hr />
            <h4>
                <i class="fas fa-user-circle"></i>
                <a href="<?php echo base_url().'inicio/form_nuevo_distribuidor_externo'; ?>" id="link"> 
                    Inscribir nuevo distribuidor
                </a>
            </h4>
            <hr />
            <h6>
                <i class="fas fa-key"></i>
                <a href="<?php echo base_url().'inicio/recuperar_password'; ?>" id="link"> 
                    Click aquí si ha olvidado su contraseña o su código?
                </a>
            </h6>
        </div>
    </div>
</div>
