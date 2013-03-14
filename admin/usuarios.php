<?php session_start(); ?>

<?php
	include "utilitiesUsuarios.php";
	
	$opt = $_GET['opt'];
	
	switch ($opt) {
		case 1:
			//Opcion para agregar un usuario
			?>
			<form name="frmAgregaUsuario" id="frmAgregaUsuario" method="post" >
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
			break;
	}
?>