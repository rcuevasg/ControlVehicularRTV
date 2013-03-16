<?php session_start(); ?>

<?php
include "utilitiesUsuarios.php";

$opt = $_POST['opt'];

if (!isset($opt))
	$opt = $_GET['opt'];

switch ($opt) {
	case 1:
		//Opción para agregar un usuario del sistema
		$nombre = $_POST['txtNombre'];
		$ap_paterno = $_POST['txtApPaterno'];
		$ap_materno = $_POST['txtApMaterno']; 
		$email = $_POST['txtCorreo']; 
		$username = $_POST['txtNombreUsuario'];
		$passwd = $_POST['txtPasswd']; 
		$confirmaPasswd = $_POST['txtConfirmaPasswd'];
		$id_ctg_tipo_usuario = $_POST['txtTipoUsuario']; 
		$usuario_creo = $_SESSION['idUsuario'];
		
		//Verificamos que las contraseñas coincidan
		if ($passwd == $confirmaPasswd) {
			//Si las contraseñas coinciden procedemos al registro
			$res = registraUsuario($nombre, $ap_paterno, $ap_materno, $email, $username, $passwd, $id_ctg_tipo_usuario, $usuario_creo);
			
			//Verificamos el exito del registro
			if ($res > 0) {
				//Se registro de manera correcta
				print "<div class='exito'>El usuario se registro de manera correcta.</div>";
			} else {
				//Ocurrio algo y no se realizo el registro
				print "<div class='error'>Ocurrio un problema al intentar registrar al usuario, por favor int&eacute;ntalo mas tarde.</div>";
			} //Fin del else de if res > 0
		} else {
			//Las contraseñas no coinciden, mostramos un mensaje indicandolo
			print "<div class='error'>Las contrase&ntilde;as no coinciden, por favor ingresalas de nuevo, deben ser id&eacute;nticas en los dos campos.</div>";
		}//Fin del else de if passwd == confirmaPasswd
		
		
		break; //Fin del case 1
		
	case 2:
		//Case para el caso listado de los usuarios
		//Obten listado de usuarios
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$campo = isset($_POST['campo']) ? $_POST['campo'] : 'null';
		if ($campo == '')
			$campo = 'null';
		$offset = ($page-1)*$rows;
		$estado = isset($_POST['estado']) ? $_POST['estado'] : '1';
		print listaUsuarios($estado, $campo, $offset, $rows);
		break; //Fin del case 2
		
	case 3:
		//Case para modificar un usuario del sistema
		
		$idUsuario = $_POST['idUsuarioAModificar'];
		$nombre = $_POST['txtNombre'];
		$ap_paterno = $_POST['txtApPaterno'];
		$ap_materno = $_POST['txtApMaterno']; 
		$email = $_POST['txtCorreo']; 
		$username = $_POST['txtNombreUsuario'];
		$passwd = $_POST['txtPasswd']; 
		$confirmaPasswd = $_POST['txtConfirmaPasswd'];
		$id_ctg_tipo_usuario = $_POST['txtTipoUsuario']; 
		$usuario_modifico = $_SESSION['idUsuario'];
		
		//Verificamos que las contraseñas coincidan
		if ($passwd == $confirmaPasswd) {
			//Si las contraseñas coinciden procedemos al registro
			$res = actualizaUsuario($nombre, $ap_paterno, $ap_materno, $email, $passwd, $id_ctg_tipo_usuario, $usuario_modifico, $idUsuario);
			
			//Verificamos el exito del registro
			if ($res > 0) {
				//Se registro de manera correcta
				print "<div class='exito'>El usuario se actualizo de manera correcta.</div>";
			} else {
				//Ocurrio algo y no se realizo el registro
				print "<div class='error'>Ocurrio un problema al intentar actualizar al usuario, por favor int&eacute;ntalo mas tarde.</div>";
			} //Fin del else de if res > 0
		} else {
			//Las contraseñas no coinciden, mostramos un mensaje indicandolo
			print "<div class='error'>Las contrase&ntilde;as no coinciden, por favor ingresalas de nuevo, deben ser id&eacute;nticas en los dos campos.</div>";
		}//Fin del else de if passwd == confirmaPasswd
		
		break; //Fin del case 3
} //Fin del switch $opt

?>