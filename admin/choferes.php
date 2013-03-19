<?php session_start(); ?>

<?php
	include "utilitiesChoferes.php";
	
	$opt = $_GET['opt'];
	
	switch ($opt) {
		case 1:
			//Opcion para agregar un chofer
			?>
			<script type="text/javascript">
				$(function(){
					$('#frmAgregaChofer').form({
						url:'accionesChoferes.php',
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
			<form name="frmAgregaChofer" id="frmAgregaChofer" method="post" >
				<input type="hidden" name="opt" id="opt" value="1" >
				<input type="text" required="required" name="txtNombre" id="txtNombre" placeholder="Nombre" >
				<input type="text" required="required" name="txtApPaterno" id="txtApPaterno" placeholder="Apellido paterno" >
				<input type="text"  name="txtApMaterno" id="txtApMaterno" placeholder="Apellido materno" >
				<input type="text" required="required" name="txtNumLicencia" id="txtNumLicencia" placeholder="Num. Licencia" >
				<input type="text" required="required" name="txtVigLicencia" id="txtVigLicencia" placeholder="Vigencia Licencia" >
				<button type="submit" value="Guardar usuario" >Guardar usuario</button>
			</form>
			<?php
			break; //Fin del case 1
			
		case 2: 
			//Case para listar los usuarios registrados en el sistema
			?>			
			<script>
			$(function(){
				$('#dgChoferes').datagrid({
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
							editaChofer();
						}
					},{
						id:'btnDelete',
						text:'Desactivar chofer',
						iconCls:'icon-remove',
						handler:function(){
							//$('#btnsave').linkbutton('enable');
							//alert('cut')
							if (confirm("¿Esta seguro de querer desactivar este chofer?")) {
								desactivaChofer();
							}
						}
					}]
				}); 
			});
		
			function editaChofer()
			{
				var row = $('#dgChoferes').datagrid('getSelected');
				if (row == null) {
					alert('Selecciona primero el chofer que quieres editar y luego presiona el botón editar');
				} else {
					$('#mainContent').load('choferes.php?opt=3&id='+row.ID);
				}
			}
			
			function desactivaChofer() {
				var row = $('#dgChoferes').datagrid('getSelected');
				$('#mainContent').load('accionesChoferes.php?opt=4&id='+row.ID);
			}
		
			function agregaChofer()
			{
				$('#mainContent').load('choferes.php?opt=1');
			}
		
			function recarga()
			{
				$('#dgChoferes').datagrid('load', {'campo':$('#txtCampoBusqueda').val(), 'estado':$('#txtEstadoBusqueda').val()});
			}
			</script>
        
        	<h2><strong>Choferes</strong></h2>

        	<div id="buscador">
        		<label>Nombre o parte del mismo</label>
        		<input type="text" id="txtCampoBusqueda" name="txtCampoBusqueda" />
        		<label>Estado</label>
        		<select name="txtEstadoBusqueda" id="txtEstadoBusqueda">
        			<option value="1">Activos</option>
        			<option value="0">Inactivos</option>
        		</select>
        		<input type="button" id="btnBuscar" name="Buscar" value="Buscar" onclick="recarga()" />
        	</div>
        
			<table id="dgChoferes" title="Choferes" class="easyui-datagrid" style="width:600px;height:750px"  
        		url="accionesChoferes.php?opt=2"  
        		rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" pageSize="50" nowrap="false">  
	    	<thead>  
    	    	<tr>  
        	    	<th field="NOMBRE" width="50">Nombre</th>  
            		<th field="NUMLICENCIA" width="50">N&uacute;mero de Licencia</th>
            		<th field="VIGLICENCIA" width="50">Vigencia Licencia</th>  
        		</tr>  
	    	</thead>  
			</table>
			
			<?php
			break;//Fin del case 2
		
		case 3 :
			//Caso para editar la información de un chofer
			$idChofer = $_GET['id'];
			$chofer = obtenDatosChofer($idChofer);
			
			$datosChofer = explode("|", $chofer);
			//nombre|ap_paterno|ap_materno|num_licencia|vigencia_licencia|activo
			
			?>
			
			<script type="text/javascript">
				$(function(){
					$('#frmModificaChofer').form({
						url:'accionesChoferes.php',
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
			<form name="frmModificaChofer" id="frmModificaChofer" method="post" >
				<input type="hidden" name="opt" id="opt" value="3" >
				<input type="hidden" name="idChoferAModificar" id="idChoferAModificar" value="<?php print $idChofer ?>" >
				<input type="text" required="required" name="txtNombre" id="txtNombre" placeholder="Nombre" value="<?php print $datosChofer[0]; ?>" >
				<input type="text" required="required" name="txtApPaterno" id="txtApPaterno" placeholder="Apellido paterno" value="<?php print $datosChofer[1]; ?>" >
				<input type="text"  name="txtApMaterno" id="txtApMaterno" placeholder="Apellido materno" value="<?php print $datosChofer[2]; ?>" >
				<input type="text" required="required" name="txtNumLicencia" id="txtNumLicencia" placeholder="Num. Licencia" value="<?php print $datosChofer[3]; ?>" >
				<input type="text" required="required" name="txtVigLicencia" id="txtVigLicencia" placeholder="Vigencia Licencia" value="<?php print $datosChofer[4]; ?>" >
				<select name="txtEstado" id="txtEstado">
					<option value="1" <?php if ($datosChofer[5] == 1) { print "selected"; } ?> >Activo</option>
					<option value="0" <?php if ($datosChofer[5] == 0) { print "selected"; } ?> >Inactivo</option>
				</select>
				<button type="submit" value="Actualizar usuario" >Actuaizar usuario</button>
			</form>
			
			<?php
			
			break; //Fin del case 3 

	}
?>