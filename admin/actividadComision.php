<?php session_start(); ?>

<?php
	include "utilitiesActividadComision.php";
	
	$opt = $_GET['opt'];
	
	switch ($opt) {
		case 1:
			//Opcion para agregar una actividad de comision
			?>
			<script type="text/javascript">
				$(function(){
					$('#frmAgregaComision').form({
						url:'accionesActividadComision.php',
						onSubmit:function(){
							return $(this).form('validate');
						},
						success:function(data){
							if (data.indexOf('php') > -1)
								document.location = data;
							else
								$('#mensajes').html(data);//data;
						}
					});
				});
			</script>
			<div id="mensajes"></div>
			<h3>Agregar una actividad de comisi&oacute;n</h3>
			<form name="frmAgregaComision" id="frmAgregaComision" method="post" >
				<input type="hidden" name="opt" id="opt" value="1" >
				<input type="text" required="required" name="txtNombre" id="txtNombre" placeholder="Nombre" >
				
				<button class="button" type="submit" value="Guardar usuario" >Guardar actividad</button>
			</form>
			<?php
			break; //Fin del case 1
			
		case 2: 
			//Case para listar los usuarios registrados en el sistema
			?>			
			<script>
			$(function(){
				$('#dgActividades').datagrid({
					toolbar:[{
						id:'btnAgregar',
						text:'Agregar',
						iconCls:'icon-add',
						handler:function(){
							agregaChofer();
						}
					},{
						id:'btnEdit',
						text:'Editar',
						iconCls:'icon-edit',
						handler:function(){
							editaActividad();
						}
					},{
						id:'btnDelete',
						text:'Desactiva actividad',
						iconCls:'icon-remove',
						handler:function(){
							//$('#btnsave').linkbutton('enable');
							//alert('cut')
							if (confirm("¿Esta seguro de querer eliminar esta actividad?")) {
								eliminarActividad();
							}
						}
					}]
				}); 
			});
		
			function editaActividad()
			{
				var row = $('#dgActividades').datagrid('getSelected');
				if (row == null) {
					alert('Selecciona primero la actividad que quieres editar y luego presiona el botón editar');
				} else {
					$('#mainContent').load('actividadComision.php?opt=3&id='+row.ID);
				}
			}
			
			function eliminarActividad() {
				var row = $('#dgActividades').datagrid('getSelected');
				$('#mainContent').load('accionesActividadComision.php?opt=4&id='+row.ID);
			}
		
			function agregaChofer()
			{
				$('#mainContent').load('actividadComision.php?opt=1');
			}
		
			function recarga()
			{
				$('#dgActividades').datagrid('load', {'campo':$('#txtCampoBusqueda').val(), 'estado':$('#txtEstadoBusqueda').val()});
			}
			</script>
        
        	<h3>Actividades de comisi&oacute;n</h3>

        	<div id="buscador">
        		<input type="text" id="txtCampoBusqueda" name="txtCampoBusqueda" placeholder="Nombre o parte del mismo" />
        		<label>Estado</label>
        		<select name="txtEstadoBusqueda" id="txtEstadoBusqueda" style="width:90px; display:inline-block;" >
        			<option value="1">Activos</option>
        			<option value="0">Inactivos</option>
        		</select>
        		<input type="button" id="btnBuscar" name="Buscar" class="button" value="Buscar" onclick="recarga()" />
        	</div>
        
			<table id="dgActividades" title="Actividades" class="easyui-datagrid" style="width:600px;height:750px"  
        		url="accionesActividadComision.php?opt=2"  
        		rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" pageSize="50" nowrap="false">  
	    	<thead>  
    	    	<tr>  
        	    	<th field="DESCRIPCION" width="200">Actividad de comisi&oacute;n</th>  
            		<!-- <th field="NUMLICENCIA" width="50">N&uacute;mero de Licencia</th>
            		<th field="VIGLICENCIA" width="50">Vigencia Licencia</th>   -->
        		</tr>  
	    	</thead>  
			</table>
			
			<?php
			break;//Fin del case 2
		
		case 3 :
			//Caso para editar la información de un chofer
			$idActividad = $_GET['id'];
			$actividad = obtenDatosActividad($idActividad);
			
			$datosActividad = explode("|", $actividad);
			//nombre|ap_paterno|ap_materno|num_licencia|vigencia_licencia|activo
			
			?>
			
			<script type="text/javascript">
				$(function(){
					$('#frmModificaActividad').form({
						url:'accionesActividadComision.php',
						onSubmit:function(){
							return $(this).form('validate');
						},
						success:function(data){
							//$.messager.alert('Info', data, 'info');
							if (data.indexOf('php') > -1)
								document.location = data;
							else
								$('#mensajes').html(data);//data;
						}
					});
				});
			</script>
			<div id="mensajes"></div>
			<h3>Editar actividad de comisi&oacute;n</h3>
			<form name="frmModificaActividad" id="frmModificaActividad" method="post" >
				<input type="hidden" name="opt" id="opt" value="3" >
				<input type="hidden" name="idActividadAModificar" id="idActividadAModificar" value="<?php print $idActividad ?>" >
				<input type="text" required="required" name="txtNombre" id="txtNombre" placeholder="Nombre" value="<?php print $datosActividad[1]; ?>" >
				
				<select id="txtActivo" name="txtActivo">
					<option  value="0" <?php if ($datosActividad[2] == "0") { print "selected"; } ?>>Inactivo</option>
					<option value="1" <?php if ($datosActividad[2] == "1") { print "selected"; } ?> >Activo</option>
				</select>
			
				<button type="submit" class="button" value="Actualizar actividad" >Actuaizar actividad</button>
			</form>
			
			<?php
			
			break; //Fin del case 3 

	}
?>