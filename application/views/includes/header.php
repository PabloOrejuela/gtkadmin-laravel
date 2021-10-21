<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>css/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>css/menu_drop.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>css/bootstrap/bootstrap-theme.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui.theme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/autocomplete.css"  />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/select2.min.css"  />
    <!-- Bootstrap Table Sorter -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/tablas/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>css/estilo.css" />

    <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.12.3.min.js" ></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/livevalid.js" charset="utf-8"></script>
    <script src="https://kit.fontawesome.com/7653d2ff86.js" crossorigin="anonymous"></script>

    <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.10.4.custom.min.js" ></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validationEngine.js" charset="utf8"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js" charset="utf-8"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo base_url(); ?>js/calcular.js" charset="utf-8"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo base_url(); ?>js/smart_menu.js" type="text/javascript"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo base_url(); ?>js/smart_menu_2.js" type="text/javascript"></script>
    <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/jquery.ui.autocomplete.html.js" ></script>
    <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/select2/select2.min.js"></script>

    <!-- Bootstrap Table Sorter -->
    <script type="text/javascript" src="<?php echo base_url(); ?>js/tables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/tables/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $('.dataTable').DataTable();
        });

        function nobackbutton1(){
            
            //Deshabilita el boton de volver atrás del navegador

           window.location.hash="no-back-button";
           window.location.hash="Again-No-back-button" //chrome
           window.onhashchange=function(){window.location.hash="no-back-button";}

        }
    </script>
</head>
<body onload="nobackbutton();">
