<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
	<title>Panel de Administraci&oacute;n | Sistema de Control Vehicular RTV</title>
	
	<LINK REL="StyleSheet"  HREF="../js/jquery-easyui-1/themes/bootstrap/easyui.css" TYPE="text/css" MEDIA="screen" />
	<LINK REL="StyleSheet"  HREF="../js/jquery-easyui-1/themes/icon.css" TYPE="text/css" MEDIA="screen" />
	<link rel="stylesheet" href="../css/style.css" media="screen" />
	
	<script type="text/javascript" src="../js/jquery-easyui-1/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="../js/jquery-easyui-1/jquery.easyui.min.js"></script>
	
</head>

<body>
	<div id="centrado">
	<div id="barraTituloAdmin">
		<div id="logoRTV"></div>
		<div id="tituloSistema">Sistema de Control Vehicular</div>
		<div id="divBienvenido">Bienvenido <?php print $_SESSION['nombre']; ?> ( <a href="logout.php" style="color:white;">Terminar la sesi&oacute;n</a> )</div>
	</div>
	<?php
	if (isset( $_SESSION['tipoUsuario'] ) && ($_SESSION['tipoUsuario'] == 1) ) {
		//Existe sesion así que mostramos el menu
		?>
		<div id="menuAdmin">
			<div id="mainMenu" class="easyui-accordion" style="width:200px;">  
				<div title="Usuarios" data-options="selected:true"  >  
					<ul>
						<li><a href="#" onclick="$('#mainContent').load('usuarios.php?opt=2')" >Usuarios del sistema</a></li>
						<li><a href="#" onclick="$('#mainContent').load('usuarios.php?opt=1')" >Agregar usuario</a></li>
					</ul>
				</div>  
				<div title="Tipos de Comision"   >  
					<ul>
						<li><a href="#" onclick="$('#mainContent').load('actividadComision.php?opt=2')" >Actividades de comisi&oacute;n</a></li>
						<li><a href="#" onclick="$('#mainContent').load('actividadComision.php?opt=1')" >Agregar actividad</a></li>
					</ul>
				</div>  
				<div title="Choferes" >  
					<ul>
						<li><a href="#" onclick="$('#mainContent').load('choferes.php?opt=2')" >Listado de choferes</li>
						<li><a href="#" onclick="$('#mainContent').load('choferes.php?opt=1')" >Agregar chofer</a></li>
					</ul>  
				</div>  
				<div title="Salidas y Entradas">  
					<ul>
						<li>Registrar salida</li>
						<li>Registrar entrada</li>
					</ul>  
				</div>  
				<div title="Veh&iacute;culos">  
					<ul>
						<li><a href="#" onclick="$('#mainContent').load('vehiculos.php?opt=2')" >Listado de veh&iacute;culos</a></li>
						<li><a href="#" onclick="$('#mainContent').load('vehiculos.php?opt=1')" >Agregar veh&iacute;culos</a></li>
					</ul> 
				</div>
				<div title="Reportes">  
					content3  
				</div>
			</div>
		</div>
		
		<div id="mainContent"></div>
		<?php
	} elseif (isset( $_SESSION['tipoUsuario'] ) && ($_SESSION['tipoUsuario'] == 2)) {
	?>
		<button class="button btnMobile" type="button" value="Registrar salida" onclick="document.location = 'index.php';" >Inicio</button>
		<div id="mainContentRegistro">
		<button id="btnRegistraSalida" class="button" type="button" value="Registrar salida" onclick="$('#mainContentRegistro').load('salidasEntradas.php?opt=1')" >Registrar salida</button>
		<button id="btnRegistraEntrada" class="button" type="button" value="Registrar entrada" onclick="$('#mainContentRegistro').load('salidasEntradas.php?opt=2')" >Registrar entrada</button>
		</div> <!-- #mainContent -->
	<?php
	} else {
		//La sesion no existe por lo que mostramos un mensaje indicando que no hay acceso al panel
		?>
		<div class="noSesion">Lo sentimos, pero debes estar logueado para poder ver esta p&aacute;gina.</div>
		<?php
	}
	?>
	</div>
</body>
</html>