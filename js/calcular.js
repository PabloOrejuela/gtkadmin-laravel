$(function() {
    $("#fecha").datepicker( $.datepicker.regional[ "es" ] );
    $("#fecha").datepicker({ dateFormat: "dd-mm-yy" });
    $(".fecha").datepicker( $.datepicker.regional[ "es" ] );
    $(".fecha").datepicker({ dateFormat: "dd-mm-yy" });
});

jQuery(function($){
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '&#x3C;Ant',
        nextText: 'Sig&#x3E;',
        currentText: 'Hoy',
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
        'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
        'Jul','Ago','Sep','Oct','Nov','Dic'],
        dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd-mm-yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['es']);
});

function pregunta_generar_reporte(){
    document.form_reporte_pagos.submit();
}

function pregunta_borrar(){
    if (confirm('¿Está seguro de querer eliminar este registro?')){
       document.form_borrar.submit();
    }
}

$(document).ready(function(){
    $("#id_provincia").change(function(){
        if($("#id_provincia").val() !=""){
            valor = $("#id_provincia").val();
                $.ajax({
                    type:"POST",
                    dataType:"html",
                    url: varjs+"inicio/ciudades_select",
                    data:"id_provincia="+valor,
                        success:function(msg){
                            $("#id_ciudad").empty().removeAttr("disabled").append(msg);
                        }
                    });
        }
        else{
            $("#id_ciudad").empty().attr("disabled","disabled");
        }
    });
});

$(document).ready(function(){
    $("#idcod_socio").change(function(){
        if($("#idcod_socio").val() !=""){
            valor = $("#idcod_socio").val();
                $.ajax({
                    type:"POST",
                    dataType:"html",
                    url: varjs+"inicio/paquetes_codigo_select",
                    data:"idcod_socio="+valor,
                        success:function(msg){
                            $("#idpaquete").empty().removeAttr("disabled").append(msg);
                        }
                    });
        }
        else{
            $("#idpaquete").empty().attr("disabled","disabled");
        }
    });
});

$(document).ready(function(){
    $("#idmatrices").change(function(){
        if($("#idmatrices").val() !=""){
            valor = $("#idmatrices").val();
            //console.log(valor);
                $.ajax({
                    type:"POST",
                    dataType:"html",
                    url: varjs+"inicio/paquetes_select",
                    data:"idmatrices="+valor,
                        success:function(msg){

                            $("#paquetes").empty().removeAttr("disabled").append(msg);
                        }
                    });
        }
        else{
            $("#paquetes").empty().attr("disabled","disabled");
        }


        if($("#patrocinador").val() !=""){
            var valor = $("#patrocinador").val();
            //console.log('Patrocinador: '+ valor);
                $.ajax({
                    type:"POST",
                    dataType:"html",
                    url: varjs+"inicio/mi_red_select",
                    data:"patrocinador="+valor,
                        success:function(msg){
                            console.log('SI');
                            $("#padre").empty().removeAttr("disabled").append(msg);
                        }
                    });
        }
        else{
            console.log('NO');
            $("#padre").empty().attr("disabled","disabled");
        }
    });
});
