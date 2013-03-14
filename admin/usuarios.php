<?php session_start(); ?>

<?php
	include "utilitiesUsuarios.php";
	
	$opt = $_GET['opt'];
	
	switch ($opt) {
		case 1:
			//Opcion para agregar un usuario
			?>
			<script type="text/javascript">
				$(function(){
					$('#frmAgregaUsuario').form({
						url:'accionesUsuarios.php',
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
			<form name="frmAgregaUsuario" id="frmAgregaUsuario" method="post" >
				<input type="hidden" name="opt" id="opt" value="1" >
				<input type="text" required="required" name="txtNombre" id="txtNombre" placeholder="Nombre" >
				<input type="text" required="required" name="txtApPaterno" id="txtApPaterno" placeholder="Apellido paterno" >
				<input type="text"  name="txtApMaterno" id="txtApMaterno" placeholder="Apellido materno" >
				<input type="email" required="required" name="txtCorreo" id="txtCorreo" placeholder="Correo electr&oacute;nico" >
				<input type="text" required="required" name="txtNombreUsuario" id="txtNombreUsuario" placeholder="Nombre de usuario" >
				<input type="password" required="required" name="txtPasswd" id="txtPasswd" placeholder="Contrase&ntilde;a" >
				<input type="password" required="required" name="txtConfirmaPasswd" id="txtConfirmaPasswd" placeholder="Repite contrase&ntilde;a" >
				<?php
				$tiposUsuario = listadoTipoUsuarios();
				if (!empty($tiposUsuario)):
					?>
					<select name="txtTipoUsuario" id="txtTipoUsuario">
					<?php
					$listadoTipoUsuarios = explode("~", $tiposUsuario);
					foreach($listadoTipoUsuarios as $tipoUsuario) {
						$datosTipo = explode("|", $tipoUsuario);
						?>
						<option value="<?php print $datosTipo[0] ?>"><?php print $datosTipo[1] ?></option>
						<?php
					}
					?>
					</select>
					<?php
				endif;
				?>
				<button type="submit" value="Guardar usuario" >Guardar usuario</button>
			</form>
			<?php
			break; //Fin del case 1
			
		case 2: 
			//Case para listar los usuarios registrados en el sistema
			?>
			
			<script>
			$(function(){
				$('#dgUsuarios').datagrid({
					toolbar:[{
						id:'btnAgregar',
						text:'Agregar',
						iconCls:'icon-add',
						handler:function(){
							agregaUsuarios();
						}
					},{
						id:'btnEdit',
						text:'Editar',
						iconCls:'icon-edit',
						handler:function(){
							//$('#btnsave').linkbutton('enable');
							//alert('cut')
							editaUsuarios();
						}
					},{
						id:'btnDelete',
						text:'Desactivar usuario',
						iconCls:'icon-remove',
						handler:function(){
							//$('#btnsave').linkbutton('enable');
							//alert('cut')
							if (confirm("¿Esta seguro de querer desactivar este usuario?")) {
								desactivaUsuario();
							}
						}
					}]
				}); 
			});
		
			function editaUsuarios()
			{
				var row = $('#dgUsuarios').datagrid('getSelected');
				$('#mainContainer').load('usuarios.php?opt=3&id='+row.ID);
			}
			
			function desactivaUsuario() {
				var row = $('#dgUsuarios').datagrid('getSelected');
				$('#mainContainer').load('accionesUsuarios.php?opt=5&id='+row.ID);
			}
		
			function agregaUsuarios()
			{
				$('#mainContainer').load('usuarios.php?opt=2');
			}
		
			function recarga()
			{
				$('#dgUsuarios').datagrid('load', {'campo':$('#txtCampoBusqueda').val(), 'estado':$('#txtEstadoBusqueda').val()});
			}
			</script>
        
        	<h2><strong>Usuarios del Sistema</strong></h2>

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
        
			<table id="dgUsuarios" title="Usuarios del Sistema" class="easyui-datagrid" style="width:600px;height:750px"  
        		url="accionesUsuarios.php?opt=2"  
        		rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" pageSize="50" nowrap="false">  
	    	<thead>  
    	    	<tr>  
        	    	<th field="NOMBRE" width="50">Nombre</th>  
            		<th field="EMAIL" width="50">Correo Electr&oacute;nico</th>
            		<th field="USERNAME" width="50">Nombre de usuario</th>  
	            	<th field="TIPO_USUARIO" width="50">Tipo usuario</th>    
        		</tr>  
	    	</thead>  
			</table>
			
			<?php
			break;//Fin del case 2
	}
?>