<?php session_start(); ?>

<?php
include "utilitiesSalidasentradas.php";

$opt = $_POST['opt'];

if (!isset($opt))
	$opt = $_GET['opt'];

switch ($opt) {
	case 1:
		//Opción para registrar una salida
		date_default_timezone_set('America/Mexico_City');
		$txtVehiculoSale = $_POST["txtVehiculoSale"];
		$txtChoferes = $_POST["txtChoferes"];
		
		$txtNombreChoferTemp = "";
		$txtNumLicenciaTemp = "";
		$txtVigenciaLicencia = "";
		
		if ($txtChoferes == "0") {
			//Obtenemos los datos del chofer temporal
			$txtNombreChoferTemp = $_POST['txtNombreChoferTemp'];
			$txtNumLicenciaTemp = $_POST['txtNNumLicenciaTemp'];
			$txtVigenciaLicencia = $_POST['txtVigenciaLicencia'];
		}
		
		$txtTipoSalida = $_POST["txtTipoSalida"];
		$txtActividadComision = $_POST["txtActividadComision"];
		$txtLugarComision = $_POST["txtLugarComision"];
		$otroLugarComision = "";
		if ($txtLugarComision == "0") {
			$otroLugarComision = $_POST["txtOtroLugarComision"];
		}
		$txtNumPasajeros = $_POST["txtNumPasajeros"];
		$txtKMSalida = $_POST["txtKMSalida"];
		$txtObservaciones = $_POST["txtObservaciones"];
		$txtNivelGasolina = $_POST["txtNivelGasolina"];
		$txtNivelAceiteMotor = 0;
		if (isset($_POST["txtNivelAceiteMotor"]))
			$txtNivelAceiteMotor = $_POST["txtNivelAceiteMotor"];
		
		$txtNivelAceiteTransmision = 0;	
		if (isset($_POST["txtNivelAceiteTransmision"]))
			$txtNivelAceiteTransmision = $_POST["txtNivelAceiteTransmision"];
			
		$txtNivelAceiteDireccion = 0;
		if (isset($_POST["txtNivelAceiteDireccion"]))
			$txtNivelAceiteDireccion = $_POST["txtNivelAceiteDireccion"];
			
		$txtNivelLiquidoFrenos = 0;	
		if (isset($_POST["txtNivelLiquidoFrenos"]))
			$txtNivelLiquidoFrenos = $_POST["txtNivelLiquidoFrenos"];
			
		$txtNivelLiquidoAnticongelante = 0;
		if (isset($_POST["txtNivelLiquidoAnticongelante"]))
			$txtNivelLiquidoAnticongelante = $_POST["txtNivelLiquidoAnticongelante"];
			
		$llantaRefaccion = "0";
		if (isset($_POST["llantaRefaccion"]))
			$llantaRefaccion = $_POST["llantaRefaccion"];
		
		$gato = "0";
		if (isset($_POST["gato"]))
			$gato = $_POST["gato"];
		
		$llaveCruz = "0";
		if (isset($_POST["llaveCruz"]))
			$llaveCruz = $_POST["llaveCruz"];
			
		$encargadoComision = $_POST["txtEncargadoComision"];
		$txtActividadComisionOtro = $_POST["txtActividadComisionOtro"];
		$txtHoraComision = $_POST["txtHoraComision"];
		$usuario_creo = $_SESSION["idUsuario"];
		$folio = obtenNumeroFolio();
		
		if ($txtChoferes == "0") {
			$exp_date = $txtVigenciaLicencia;
			$todays_date = date("Y-m-d");

			$today = strtotime($todays_date);
			$expiration_date = strtotime($exp_date);

			if ($expiration_date > $today) {
		
				$res = registraSalida($txtVehiculoSale, $txtChoferes, $txtTipoSalida, $txtNivelGasolina, $txtNivelAceiteMotor, $txtNivelAceiteTransmision, $txtNivelAceiteDireccion, $txtNivelLiquidoFrenos, $txtNivelLiquidoAnticongelante, $llantaRefaccion, $gato, $llaveCruz, $txtActividadComision, $txtLugarComision, $txtObservaciones, $txtKMSalida, $folio, $usuario_creo, $usuario_creo, $txtHoraComision, $encargadoComision, $txtActividadComisionOtro, $txtNombreChoferTemp, $txtNumLicenciaTemp, $txtVigenciaLicencia, $otroLugarComision);
			
				//Verificamos el exito del registro
				if ($res > 0) {
					//Se registro de manera correcta
					print "<div class='exito mobile'>Se registro la salida con número de folio: $folio de manera correcta.</div>";
				} else {
					//Ocurrio algo y no se realizo el registro
					print "<div class='error mobile'>Ocurrio un problema al intentar registrar la salida, por favor int&eacute;ntalo mas tarde.</div>";
				} //Fin del else de if res > 0
			} //Fin de if expiration date
			else {
				print "<div class='error mobile'>La licencia esta expirada.</div>";
			}//Fin del else de la expiracion de fecha
		} //Fin de if choferes
		else {
			$res = registraSalida($txtVehiculoSale, $txtChoferes, $txtTipoSalida, $txtNivelGasolina, $txtNivelAceiteMotor, $txtNivelAceiteTransmision, $txtNivelAceiteDireccion, $txtNivelLiquidoFrenos, $txtNivelLiquidoAnticongelante, $llantaRefaccion, $gato, $llaveCruz, $txtActividadComision, $txtLugarComision, $txtObservaciones, $txtKMSalida, $folio, $usuario_creo, $usuario_creo, $txtHoraComision, $encargadoComision, $txtActividadComisionOtro, $txtNombreChoferTemp, $txtNumLicenciaTemp, $txtVigenciaLicencia);
			
				//Verificamos el exito del registro
				if ($res > 0) {
					//Se registro de manera correcta
					print "<div class='exito mobile'>Se registro la salida con número de folio: $folio de manera correcta.</div>";
				} else {
					//Ocurrio algo y no se realizo el registro
					print "<div class='error mobile'>Ocurrio un problema al intentar registrar la salida, por favor int&eacute;ntalo mas tarde.</div>";
				} //Fin del else de if res > 0
		}
		
		break; //Fin del case 1
		
	case 2:
		//Case para guardar entrada
		$KM_ENTRADA = $_POST['txtKMEntrada'];
		$NIVEL_ACEITE_MOTOR = $_POST['txtNivelAceiteMotor'];
		$OBSERVACIONES = $_POST['txtObservaciones'];
		$llantaRefaccion = "0";
		if (isset($_POST["llantaRefaccion"]))
			$llantaRefaccion = $_POST["llantaRefaccion"];
		
		$gato = "0";
		if (isset($_POST["gato"]))
			$gato = $_POST["gato"];
		
		$llaveCruz = "0";
		if (isset($_POST["llaveCruz"]))
			$llaveCruz = $_POST["llaveCruz"];
		$ESTADO_LLANTAS = ""; 
		/*$NIVEL_LIQUIDO_ANTICONGELANTE = $_POST['txtNivelLiquidoAnticongelante']; 
		$NIVEL_LIQUIDO_FRENOS = $_POST['txtNivelLiquidoFrenos']; 
		$NIVEL_ACEITE_DIRECCION = $_POST['txtNivelAceiteDireccion']; 
		$NIVEL_ACEITE_TRANSMISION = $_POST['txtNivelAceiteTransmision']; */
		$NIVEL_GASOLINA = $_POST['txtNivelGasolina']; 
		$USUARIO_CREO = $_SESSION["idUsuario"]; 
		$USUARIO_MODIFICO = $_SESSION["idUsuario"]; 
		$FACTURA = "0";
		$id_tb_salida = $_POST['txtIdSalida'];
		
		if (esForanea($id_tb_salida)) {
			$FACTURA = "1";
		}
		
		$res = registraEntrada($KM_ENTRADA, /*$NIVEL_ACEITE_MOTOR,*/ $OBSERVACIONES, $llaveCruz, $gato, $llantaRefaccion, $ESTADO_LLANTAS, /*$NIVEL_LIQUIDO_ANTICONGELANTE, $NIVEL_LIQUIDO_FRENOS, $NIVEL_ACEITE_DIRECCION, $NIVEL_ACEITE_TRANSMISION,*/ $NIVEL_GASOLINA, $USUARIO_CREO, $USUARIO_MODIFICO, $FACTURA, $id_tb_salida);
		
		//Verificamos el exito del registro
		if ($res > 0) {
			//Se registro de manera correcta
			desactivaSalida($id_tb_salida);
			print "<div class='exito mobile'>Se registro la entrada de manera correcta.</div>";
		} else {
			//Ocurrio algo y no se realizo el registro
			
			print "<div class='error mobile'>Ocurrio un problema al intentar registrar la entrada, por favor int&eacute;ntalo mas tarde.</div>";
		} //Fin del else de if res > 0
		
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
		$choferResguarda = 0;//$_POST['txtChoferResguardo'];
		
		$res = actualizaVehiculos($placas_viejas, $placas_nuevas, $marca, $modelo, $linea, $capacidad_tanque, $kilometraje_actual, $num_serie, $num_economico, $tipo_unidad, $tipo_combustible, $nom_unidad, $descripcion, $usuario_modifico, $idVehiculo, $activo, $choferResguarda);
			
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