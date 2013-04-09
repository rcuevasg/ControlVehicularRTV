<?php session_start(); ?>

<?php
include "utilitiesVehiculos.php";

$opt = $_POST['opt'];

if (!isset($opt))
	$opt = $_GET['opt'];

switch ($opt) {
	case 1:
		//Opción para agregar un vehiculo al sistema
		$placas_viejas = $_POST['txtPlacasV'];
		$placas_nuevas = $_POST['txtPlacasN'];
		$marca = $_POST['txtMarca']; 
		$modelo = $_POST['txtModelo']; 
		$linea = $_POST['txtLinea'];
		$capacidad_tanque = $_POST['txtTanque'];		
		$kilometraje_actual = $_POST['txtKmActual'];
		//$rendimiento_km = $_POST['txtRendKm'];
		//$num_motor = $_POST['txtNumMotor'];
		$num_serie = $_POST['txtNumSerie'];
		$num_economico = $_POST['txtNumEco'];
		$tipo_unidad = $_POST['txtTipoUnidad'];
		$tipo_combustible = $_POST['txtTipoCombustible'];
		$nom_unidad = $_POST['txtNomUnidad'];
		$descripcion = $_POST['txtDescripcion'];
		$usuario_creo = $_SESSION['idUsuario'];
		
		$res = registraVehiculo($placas_viejas, $placas_nuevas, $marca, $modelo, $linea, $capacidad_tanque, $kilometraje_actual, $num_serie, $num_economico, $tipo_unidad, $tipo_combustible, $nom_unidad, $descripcion, $usuario_creo);
			
		//Verificamos el exito del registro
		if ($res > 0) {
			//Se registro de manera correcta
			print "<div class='exito'>El vehículo se registro de manera correcta.</div>";
		} else {
			//Ocurrio algo y no se realizo el registro
			print "<div class='error'>Ocurrio un problema al intentar registrar el vehículo, por favor int&eacute;ntalo mas tarde.</div>";
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
		print listaVehiculos($estado, $campo, $offset, $rows);
		break; //Fin del case 2 

	case 3:
		//Case para modificar un usuario del sistema
		$idVehiculo = $_POST['idVehiculoAModificar'];
		$placas_viejas = $_POST['txtPlacasV'];
		$placas_nuevas = $_POST['txtPlacasN'];
		$marca = $_POST['txtMarca']; 
		$modelo = $_POST['txtModelo']; 
		$linea = $_POST['txtLinea'];
		$capacidad_tanque = $_POST['txtTanque'];		
		$kilometraje_actual = $_POST['txtKmActual'];
		$num_serie = $_POST['txtNumSerie'];
		$num_economico = $_POST['txtNumEco'];
		$tipo_unidad = $_POST['txtTipoUnidad'];
		$tipo_combustible = $_POST['txtTipoCombustible'];
		$nom_unidad = $_POST['txtNomUnidad'];
		$descripcion = $_POST['txtDescripcion'];
		$usuario_modifco = $_SESSION['idUsuario'];
		$activo = $_POST['txtEstado'];
		
		$res = actualizaVehiculos($placas_viejas, $placas_nuevas, $marca, $modelo, $linea, $capacidad_tanque, $kilometraje_actual, $num_serie, $num_economico, $tipo_unidad, $tipo_combustible, $nom_unidad, $descripcion, $usuario_modifico, $idVehiculo, $activo);
			
		//Verificamos el exito del registro
		if ($res > 0) {
			//Se registro de manera correcta
			print "<div class='exito'>El Vehiculo se actualizo de manera correcta.</div>";
		} else {
			//Ocurrio algo y no se realizo el registro
			print "<div class='error'>Ocurrio un problema al intentar actualizar al Vehiculo, por favor int&eacute;ntalo mas tarde.</div>";
		} //Fin del else de if res > 0
			
		break; //Fin del case 3
		
	case 4:
		//Case para desactivar un Vehiculo
		$idVehiculo = $_GET['id'];
		$usuario_modifico = $_SESSION['idUsuario'];
		
		$res = desactivaVehiculo($idVehiculo, $usuario_modifico);
		
		//Verifica si se modifico correctamente el registrp
		if ($res > 0) {
			//Se registro de manera correcta
			print "<div class='exito'>El Vehiculo se desactivo de manera correcta.</div>";
		} else {
			//Ocurrio algo y no se realizo el registro
			print "<div class='error'>Ocurrio un problema al intentar desactivar al Vehiculo, por favor int&eacute;ntalo mas tarde.</div>";
		} //Fin del else de if res > 0
		
		break; //Fin del case 4
		
} //Fin del switch $opt

?>