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
			
			<h3>Agregar usuario nuevo</h3>
			
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
				<button class="button" type="submit" value="Guardar usuario" >Guardar usuario</button>
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
				if (row == null) {
					alert('Selecciona primero el usuario que quieres editar y luego presiona el botón editar');
				} else {
					$('#mainContent').load('usuarios.php?opt=3&id='+row.ID);
				}
			}
			
			function desactivaUsuario() {
				var row = $('#dgUsuarios').datagrid('getSelected');
				$('#mainContent').load('accionesUsuarios.php?opt=4&id='+row.ID);
			}
		
			function agregaUsuarios()
			{
				$('#mainContent').load('usuarios.php?opt=1');
			}
		
			function recarga()
			{
				$('#dgUsuarios').datagrid('load', {'campo':$('#txtCampoBusqueda').val(), 'estado':$('#txtEstadoBusqueda').val()});
			}
			</script>
        
        	<h3>Usuarios del Sistema</h3>

        	<div id="buscador">
        		<input type="text" id="txtCampoBusqueda" name="txtCampoBusqueda" placeholder="Nombre del usuario o parte del mismo" />
        		<label>Estado</label>
        		<select name="txtEstadoBusqueda" id="txtEstadoBusqueda" style="width:90px; display:inline-block;">
        			<option value="1">Activos</option>
        			<option value="0">Inactivos</option>
        		</select>
        		<input class="button" type="button" id="btnBuscar" name="Buscar" value="Buscar" onclick="recarga()" />
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
			
		case 3 :
			//Caso para editar la información de un usuario
			$idUsuario = $_GET['id'];
			$usuario = obtenDatosUsuario($idUsuario);
			
			$datosUsuario = explode("|", $usuario);
			//nombre|ap_paterno|ap_materno|email|username|id_ctg_tipo_usuario|fecha_creado|fecha_modificado|usuario_creo|usuario_modifico|activo
			
			?>
			
			<script type="text/javascript">
				$(function(){
					$('#frmModificaUsuario').form({
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
			<h3>Editar usuario</h3>
			<form name="frmModificaUsuario" id="frmModificaUsuario" method="post" >
				<input type="hidden" name="opt" id="opt" value="3" >
				<input type="hidden" name="idUsuarioAModificar" id="idUsuarioAModificar" value="<?php print $idUsuario ?>" >
				<input type="text" required="required" name="txtNombre" id="txtNombre" placeholder="Nombre" value="<?php print $datosUsuario[0]; ?>" >
				<input type="text" required="required" name="txtApPaterno" id="txtApPaterno" placeholder="Apellido paterno" value="<?php print $datosUsuario[1]; ?>" >
				<input type="text"  name="txtApMaterno" id="txtApMaterno" placeholder="Apellido materno" value="<?php print $datosUsuario[2]; ?>" >
				<input type="email" required="required" name="txtCorreo" id="txtCorreo" placeholder="Correo electr&oacute;nico" value="<?php print $datosUsuario[3]; ?>" >
				<input type="text" required="required" name="txtNombreUsuario" id="txtNombreUsuario" placeholder="Nombre de usuario" value="<?php print $datosUsuario[4]; ?>" readonly >
				<input type="password" name="txtPasswd" id="txtPasswd" placeholder="Contrase&ntilde;a" >
				<input type="password" name="txtConfirmaPasswd" id="txtConfirmaPasswd" placeholder="Repite contrase&ntilde;a" >
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
						<option value="<?php print $datosTipo[0] ?>" <?php if ($datosTipo[0] == $datosUsuario[5]) { print "selected"; } ?> ><?php print $datosTipo[1] ?></option>
						<?php
					}
					?>
					</select>
					<?php
				endif;
				?>
				<select name="txtEstado" id="txtEstado">
					<option value="1" <?php if ($datosUsuario[10] == 1) { print "selected"; } ?> >Activo</option>
					<option value="0" <?php if ($datosUsuario[10] == 0) { print "selected"; } ?> >Inactivo</option>
				</select>
				<button class="button" type="submit" value="Actualizar usuario" >Actuaizar usuario</button>
			</form>
			
			<?php
			
			break; //Fin del case 3 
	}
?>