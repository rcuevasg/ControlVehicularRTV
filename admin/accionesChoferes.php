<?php session_start(); ?>

<?php
include "utilitiesChoferes.php";

$opt = $_POST['opt'];

if (!isset($opt))
	$opt = $_GET['opt'];

switch ($opt) {
	case 1:
		//Opción para agregar un chofer al sistema
		$nombre = $_POST['txtNombre'];
		$ap_paterno = $_POST['txtApPaterno'];
		$ap_materno = $_POST['txtApMaterno']; 
		$num_licencia = $_POST['txtNumLicencia']; 
		$vigencia_licencia = $_POST['txtVigLicencia']; 
		$usuario_creo = $_SESSION['idUsuario'];
		
		$array_fecha = explode ( "/", $vigencia_licencia ); 
		$vigencia_licencia = $array_fecha[2].'-'.$array_fecha[1].'-'.$array_fecha[0];
		
		$res = registraChofer($nombre, $ap_paterno, $ap_materno, $num_licencia, $vigencia_licencia, $usuario_creo);
			
		//Verificamos el exito del registro
		if ($res > 0) {
			//Se registro de manera correcta
			print "<div class='exito'>El chofer se registro de manera correcta.</div>";
		} else {
			//Ocurrio algo y no se realizo el registro
			print "<div class='error'>Ocurrio un problema al intentar registrar al chofer, por favor int&eacute;ntalo mas tarde.</div>";
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
		print listaChoferes($estado, $campo, $offset, $rows);
		break; //Fin del case 2

	case 3:
		//Case para modificar un usuario del sistema
		
		$idChofer = $_POST['idChoferAModificar'];
		$nombre = $_POST['txtNombre'];
		$ap_paterno = $_POST['txtApPaterno'];
		$ap_materno = $_POST['txtApMaterno']; 
		$num_licencia = $_POST['txtNumLicencia']; 
		$vigencia_licencia = $_POST['txtVigLicencia']; 
		$usuario_modifico = $_SESSION['idUsuario'];
		$activo = $_POST['txtEstado'];
		
		$array_fecha = explode ( "/", $vigencia_licencia ); 
		$vigencia_licencia = $array_fecha[2].'-'.$array_fecha[1].'-'.$array_fecha[0];
		
		$res = actualizaChofer($nombre, $ap_paterno, $ap_materno, $num_licencia, $vigencia_licencia, $usuario_modifico, $idChofer, $activo);
			
		//Verificamos el exito del registro
		if ($res > 0) {
			//Se registro de manera correcta
			print "<div class='exito'>El chofer se actualizo de manera correcta.</div>";
		} else {
			//Ocurrio algo y no se realizo el registro
			print "<div class='error'>Ocurrio un problema al intentar actualizar al chofer, por favor int&eacute;ntalo mas tarde.</div>";
		} //Fin del else de if res > 0
			
		break; //Fin del case 3
		
	case 4:
		//Case para desactivar un chofer
		$idChofer = $_GET['id'];
		$usuario_modifico = $_SESSION['idUsuario'];
		
		$res = desactivaChofer($idChofer, $usuario_modifico);
		
		//Verifica si se modifico correctamente el registrp
		if ($res > 0) {
			//Se registro de manera correcta
			print "<div class='exito'>El chofer se desactivo de manera correcta.</div>";
		} else {
			//Ocurrio algo y no se realizo el registro
			print "<div class='error'>Ocurrio un problema al intentar desactivar al chofer, por favor int&eacute;ntalo mas tarde.</div>";
		} //Fin del else de if res > 0
		
		break; //Fin del case 4
		
} //Fin del switch $opt

?>