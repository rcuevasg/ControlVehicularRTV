<?php session_start(); ?>

<?php
include "utilitiesActividadComision.php";

$opt = $_POST['opt'];

if (!isset($opt))
	$opt = $_GET['opt'];

switch ($opt) {
	case 1:
		//Opción para agregar un chofer al sistema
		$nombre = $_POST['txtNombre']; 
		$usuario_creo = $_SESSION['idUsuario'];
		
		$res = agregaActividad ($nombre, $usuario_creo);
			
		//Verificamos el exito del registro
		if ($res > 0) {
			//Se registro de manera correcta
			print "<div class='exito'>La actividad de comisi&oacute;n se registro de manera correcta.</div>";
		} else {
			//Ocurrio algo y no se realizo el registro
			print "<div class='error'>Ocurrio un problema al intentar registrar la actividad, por favor int&eacute;ntalo mas tarde.</div>";
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
		print listaActividades($estado, $campo, $offset, $rows);
		break; //Fin del case 2

	case 3:
		//Case para modificar un usuario del sistema
		
		$idActividad = $_POST['idActividadAModificar'];
		$nombreActividad = $_POST['txtNombre'];
		$activo = $_POST['txtActivo'];
		$usuario_modifica = $_SESSION['idUsuario'];
				
		$res = actualizaActividad ($idActividad, $nombreActividad, $usuario_modifica, $activo);
			
		//Verificamos el exito del registro
		if ($res >= 0) {
			//Se registro de manera correcta
			print "<div class='exito'>La actividad se actualizo de manera correcta.</div>";
		} else {
			//Ocurrio algo y no se realizo el registro
			print "<div class='error'>Ocurrio un problema al intentar actualizar, por favor int&eacute;ntalo mas tarde.</div>";
		} //Fin del else de if res > 0
			
		break; //Fin del case 3
		
	case 4:
		//Case para desactivar un chofer
		$idActividad = $_GET['id'];
		//$usuario_modifico = $_SESSION['idUsuario'];
		
		$res = eliminaActividad($idActividad);
		
		//Verifica si se modifico correctamente el registrp
		if ($res > 0) {
			//Se registro de manera correcta
			print "<div class='exito'>La actividad se desactivo de manera correcta.</div>";
		} else {
			//Ocurrio algo y no se realizo el registro
			print "<div class='error'>Ocurrio un problema al intentar desactivar la actividad, por favor int&eacute;ntalo mas tarde.</div>";
		} //Fin del else de if res > 0
		
		break; //Fin del case 4
		
} //Fin del switch $opt

?>