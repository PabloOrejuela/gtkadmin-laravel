<style type="text/css">
	#table_socios{
		max-width: 600px;
		margin:0 auto;
	}
</style>
<script type="text/javascript">
	$(function(){
		$('#table_resumen').dataTable();
	});
</script>
<div class="row-fluid">
    <div class="col-md-12">
<h1>Comisiones por Ciudad:</h1>
<p>Digite un parte de la información de la ciudad que desea generar el reporte</p>
<?php echo form_open('reportes/buscar_resumen_socios_ciudad'); ?>
	
	<div class="form-group" style="max-width: 300px">
	<table class="table table-responsive">
		<tr>
			<td>Buscar:</td>
			<td>
				<input type="text" autocomplete="off" class="ciudad" name="ciudad" placeholder="CIUDAD"></input>
			<td>
				<button class="btn btn-primary" type="submit" style="margin: 0">Buscar</button>
			</td>
		</tr>
	</table>
	</div>

<?php echo form_close(); ?>
<?php if( isset($socios) && $socios!=null){ ?>
<table class="table table-bordered dataTable" id="table_resumen" >
	<thead>
		<tr>
			
			<th>Cedula</th>
			<th>Nombres</th>
			<th>Ciudad</th>
			<th>Dirección</th>
			<th>Email</th>
			<th>Teléfono</th>
			<th>Celular</th>
		</tr>
	</thead>
	<tbody>
	
	<?php $i=1;  foreach ($socios as $key => $value) {?>	
		<tr>
			
			<td><a href="<?php echo base_url(); ?>reportes/resumen_mensual_socio_individual/<?php echo $value->idsocio; ?>"><?php echo $value->cedula; ?></a></td>
			<td><?php echo $value->apellidos.' '. $value->nombres; ?></td>
			<td><?php echo $value->ciudad; ?></td>
			<td><?php echo $value->direccion; ?></td>
			<td><?php echo $value->email; ?></td>
			<td><?php echo $value->telf_casa; ?></td>
			<td><?php echo $value->celular; ?></td>
		</tr>
		
		<?php $i++;} ?>
		
	</tbody>
</table>
<?php }else{ ?>
<h3>Sin datos relacionados</h3>
<?php } ?>
</div>
</div>
</div>

<script type="text/javascript">
	function validarn(e) { 
	    tecla = (document.all) ? e.keyCode : e.which; // 2
	    if (tecla==8) return true; // 3
		 if (tecla==9) return true; // 3
		 if (tecla==11) return true; // 3
	    patron = /[0-9 \s\t]/; // 4
	 
	    te = String.fromCharCode(tecla); // 5
	    return patron.test(te); // 6
	} 

  $(document).ready(function() {html:true
    $(function() {
        $( ".ciudad" ).autocomplete({
            source: function(request, response) {
                $.ajax({ url: "<?php echo site_url('reportes/suggestions_ciudades'); ?>",
                data: { term: $(".ciudad").val()},
                dataType: "json",
                type: "POST",
                success: function(data){
                  console.log('Consola: '+data);
                    response(data);
                }
            });
        },
        minLength: 1
        });
      });
   });
</script>