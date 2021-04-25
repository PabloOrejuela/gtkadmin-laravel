<div class="row-fluid" id="header">
    <div id="logo"><a href="<?php echo base_url().'inicio/miembros';?>"><img src="<?php echo base_url();?>images/logo_ruso.png" id="img_logo"/></a></div>
    <div id="version">Versión: <?php echo $this->config->item('system_version'); ?></div>
    <div id="user">Bienvenido: <?php echo $this->session->userdata('nombre'); ?></div>
</div>