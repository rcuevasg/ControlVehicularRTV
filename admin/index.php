<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
	<title>Panel de Administraci&oacute;n | Sistema de Control Vehicular RTV</title>
	
	<script type="text/javascript" src="../js/jquery-easyui-1/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="../js/jquery-easyui-1/jquery.easyui.min.js"></script>
	
</head>

<body>

	<?php
	if (isset( $_SESSION['tipoUsuario'] ) ) {
		//Existe sesion así que mostramos el menu
	} else {
		//La sesion no existe por lo que mostramos un mensaje indicando que no hay acceso al panel
		?>
		<div class="noSesion">Lo sentimos, pero debes estar logueado para poder ver esta p&aacute;gina.</div>
		<?php
	}
	?>

</body>
</html>