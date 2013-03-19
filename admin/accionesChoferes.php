<?php session_start(); ?>

<?php
include "utilitiesChoferes.php";

$opt = $_POST['opt'];

if (!isset($opt))
	$opt = $_GET['opt'];

switch ($opt) {
	case 1:
		//Opción para agregar un usuario del sistema
		$nombre = $_POST['txtNombre'];
		$ap_paterno = $_POST['txtApPaterno'];
		$ap_materno = $_POST['txtApMaterno']; 
		$num_licencia = $_POST['txtNumLicencia']; 
		$usuario_creo = $_SESSION['idUsuario'];
		
			$res = registraChofer($nombre, $ap_paterno, $ap_materno, $num_licencia, $usuario_creo);
			
			//Verificamos el exito del registro
			if ($res > 0) {
				//Se registro de manera correcta
				print "<div class='exito'>El usuario se registro de manera correcta.</div>";
			} else {
				//Ocurrio algo y no se realizo el registro
				print "<div class='error'>Ocurrio un problema al intentar registrar al usuario, por favor int&eacute;ntalo mas tarde.</div>";
			} //Fin del else de if res > 0
			
		
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
} //Fin del switch $opt

?>