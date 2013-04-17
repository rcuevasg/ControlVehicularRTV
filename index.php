<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
	<title>Sistema de Control Vehicular de RTV</title>
	
	<link href="css/style.css" rel="stylesheet" media="screen" />
	<script type="text/javascript" src="./js/jquery-easyui-1/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="./js/jquery-easyui-1/jquery.easyui.min.js"></script>
	
	<script type="text/javascript">
		$(function(){
			$('#frmLogin').form({
				url:'admin/verifyUserLocal.php',
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
	
</head>

<body>

	<div id="divLogin">
	<div id="tituloLogin"><img src="images/logoRTVBarraSuperior.png" /><span>Sistema de Control Vehicular</span></div>
	<div id="mensajes"></div>
	<h3>Ingresa tu usuario y contrase&ntilde;a para ingresar al sistema.</h3>
	<form name="frmLogin" id="frmLogin" method="post" action="admin/verifyUserLocal.php">
		<input type="text" name="txtUser" id="txtUser" placeholder="Correo electr&oacute;nico" > <br />
		<input type="password" name="txtPassword" id="txtPassword" placeholder="Contrase&ntilde;a" > <br />
				
		<button type="submit" name="btnEnviar" id="btnEnviar" class="button">Ingresar</button>
	</form>
	</div><!-- Fin de la forma login -->

</body>
</html>