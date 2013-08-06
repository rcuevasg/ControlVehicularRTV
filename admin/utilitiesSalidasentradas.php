<?php

/**
*Funcion para registrar una salida de un vehiculo
*@result 1 en caso de exito y 0 en caso contrario
*/
function registraSalida($id_ctg_vehiculos, $id_tb_choferes, $tipo_salida, $nivel_gasolina, $nivel_aceite_motor, $nivel_aceite_transmision, $nivel_aceite_direccion, $nivel_liquido_frenos, $nivel_liquido_anticongelante, $llanta_refaccion, $gato, $llave_cruz, $actividad_comision, $lugar_comision, $observaciones, $km_salida, $folio, $usuario_creo, $usuario_modifico, $horaComision, $responsableComision, $actividadComisionOtro, $choferTemp, $numLicenciaTemp, $vigenciaLicenciaTemp){
	$result = 0;
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("insert into TB_SALIDA (id_ctg_vehiculos, id_tb_choferes, tipo_salida, nivel_gasolina, nivel_aceite_motor, nivel_aceite_transmision, nivel_aceite_direccion, nivel_liquido_frenos, nivel_liquido_anticongelante, llanta_refaccion, gato, llave_cruz, actividad_comision, lugar_comision, observaciones, fecha_creado, fecha_modificado, km_salida, folio, usuario_creo, usuario_modifico, hora_comision, responsable_comision, actividad_comision_otro, activo, nombre_chofer_temp, num_licencia_temp, VIGENCIA_LICENCIA_TEMP) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), now(), ?, ?, ?, ?, ?, ?, ?, true, ?, ?, ?)");
		$STH->bindParam(1, $id_ctg_vehiculos);
		$STH->bindParam(2, $id_tb_choferes);
		$STH->bindParam(3, $tipo_salida);
		$STH->bindParam(4, $nivel_gasolina);
		$STH->bindParam(5, $nivel_aceite_motor);
		$STH->bindParam(6, $nivel_aceite_transmision);
		$STH->bindParam(7, $nivel_aceite_direccion);
		$STH->bindParam(8, $nivel_liquido_frenos);
		$STH->bindParam(9, $nivel_liquido_anticongelante);
		$STH->bindParam(10, $llanta_refaccion);
		$STH->bindParam(11, $gato);
		$STH->bindParam(12, $llave_cruz);
		$STH->bindParam(13, $actividad_comision);
		$STH->bindParam(14, $lugar_comision);
		$STH->bindParam(15, $observaciones);
		$STH->bindParam(16, $km_salida);
		$STH->bindParam(17, $folio);
		$STH->bindParam(18, $usuario_creo);
		$STH->bindParam(19, $usuario_modifico);
		$STH->bindParam(20, $horaComision);
		$STH->bindParam(21, $responsableComision);
		$STH->bindParam(22, $actividadComisionOtro);
		$STH->bindParam(23, $choferTemp);
		$STH->bindParam(24, $numLicenciaTemp);
		$STH->bindParam(25, $vigenciaLicenciaTemp);
		$STH->execute();
		$result = $STH->rowCount();
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}


//funcion para obtener el número de peticion para el folio
function obtenNumeroFolio(){
	$result = "";
	include "connection.php";
	
	try{
		$STH = $DBH->prepare("show table status like 'TB_SALIDA'");
		$STH->setFetchMode(PDO::FETCH_ASSOC);
		$STH->execute();
		while ($row = $STH->fetch()){
			$result = $row['Auto_increment'];
		}
	} catch (PDOException $ex){
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}//Fin de la funcion obtenNumeroFolio


function listaSalidasActivas() {
	$result = "";
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("select id_tb_salida, (select concat(ctv.num_economico,' - ',ctv.nombre_unidad,'. Placas: ',ctv.placas_nuevas) from CTG_VEHICULOS as ctv where ctv.id_ctg_vehiculos = ts.id_ctg_vehiculos) as vehiculo, IF (ts.id_tb_choferes, (select concat(tc.nombre,' ',tc.ap_paterno,' ',tc.ap_materno) from TB_CHOFERES as tc where tc.id_tb_choferes = ts.id_tb_choferes), ts.nombre_chofer_temp ) as chofer, folio, IF (ts.actividad_comision, (select ctc.descripcion from CTG_TIPO_COMISION as ctc where ctc.id_ctg_tipo_comision = ts.actividad_comision), ts.actividad_comision_otro) as comision, lugar_comision, DATE_FORMAT(fecha_creado, '%d/%c/%Y a las %H:%i hrs') as salida from TB_SALIDA as ts where activo = true");
		$STH->setFetchMode(PDO::FETCH_NUM);
		$STH->execute();
		while ($row = $STH->fetch()) {
			$result .= $row[0] . "|" . $row[1] . "|" . $row[2] . "|" . $row[3] . "|" . $row[4] . "|" . $row[5] . "|" . $row[6] . "~";
		}
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return substr($result, 0, strlen($result) - 1);
}

function datosSalida($idSalida) {
	$result = "";
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("select id_tb_salida, (select concat(ctv.num_economico,' - ',ctv.nombre_unidad,'. Placas: ',ctv.placas_nuevas) from CTG_VEHICULOS as ctv where ctv.id_ctg_vehiculos = ts.id_ctg_vehiculos) as vehiculo, (select concat(tc.nombre,' ',tc.ap_paterno,' ',tc.ap_materno) from TB_CHOFERES as tc where tc.id_tb_choferes = ts.id_tb_choferes) as chofer, folio, (select ctc.descripcion from CTG_TIPO_COMISION as ctc where ctc.id_ctg_tipo_comision = ts.actividad_comision) as comision, lugar_comision, DATE_FORMAT(fecha_creado, '%d/%c/%Y a las %H:%i hrs') as salida from TB_SALIDA as ts where id_tb_salida = ?");
		$STH->bindParam(1, $idSalida);
		$STH->setFetchMode(PDO::FETCH_NUM);
		$STH->execute();
		while ($row = $STH->fetch()) {
			$result .= $row[0] . "|" . $row[1] . "|" . $row[2] . "|" . $row[3] . "|" . $row[4] . "|" . $row[5] . "|" . $row[6];
		}
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}

function registraEntrada($KM_ENTRADA, /*$NIVEL_ACEITE_MOTOR,*/ $OBSERVACIONES, $LLAVE_CRUZ, $GATO, $LLANTA_REFACCION, $ESTADO_LLANTAS, /*$NIVEL_LIQUIDO_ANTICONGELANTE, $NIVEL_LIQUIDO_FRENOS, $NIVEL_ACEITE_DIRECCION, $NIVEL_ACEITE_TRANSMISION,*/ $NIVEL_GASOLINA, $USUARIO_CREO, $USUARIO_MODIFICO, $FACTURA, $id_tb_salida){
	$result = 0;
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("insert into TB_ENTRADA (KM_ENTRADA, NIVEL_ACEITE_MOTOR, OBSERVACIONES, LLAVE_CRUZ, GATO, LLANTA_REFACCION, ESTADO_LLANTAS, NIVEL_LIQUIDO_ANTICONGELANTE, NIVEL_LIQUIDO_FRENOS, NIVEL_ACEITE_DIRECCION, NIVEL_ACEITE_TRANSMISION, NIVEL_GASOLINA, FECHA_CREADO, FECHA_MODIFICADO, USUARIO_CREO, USUARIO_MODIFICO, FACTURA, id_tb_salida) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), now(), ?, ?, ?, ?)");
		
		$STH->bindParam(1, $KM_ENTRADA);
		$STH->bindParam(2, $NIVEL_ACEITE_MOTOR);
		$STH->bindParam(3, $OBSERVACIONES);
		$STH->bindParam(4, $LLAVE_CRUZ);
		$STH->bindParam(5, $GATO);
		$STH->bindParam(6, $LLANTA_REFACCION);
		$STH->bindParam(7, $ESTADO_LLANTAS);
		$STH->bindParam(8, $NIVEL_LIQUIDO_ANTICONGELANTE);
		$STH->bindParam(9, $NIVEL_LIQUIDO_FRENOS);
		$STH->bindParam(10, $NIVEL_ACEITE_DIRECCION);
		$STH->bindParam(11, $NIVEL_ACEITE_TRANSMISION);
		$STH->bindParam(12, $NIVEL_GASOLINA);
		$STH->bindParam(13, $USUARIO_CREO);
		$STH->bindParam(14, $USUARIO_MODIFICO);
		$STH->bindParam(15, $FACTURA);
		$STH->bindParam(16, $id_tb_salida);
		$STH->execute();
		$result = $STH->rowCount();
		
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}

function desactivaSalida($idSalida) {
	$result = 0;
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("update TB_SALIDA set activo = false where id_tb_salida = ?");
		$STH->bindParam(1, $idSalida);
		$STH->execute();
		$result = $STH->rowCount();
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}

function esForanea($idSalida) {
	$result = false;
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("select tipo_salida from TB_SALIDA where id_tb_salida = ?");
		$STH->bindParam(1, $idSalida);
		$STH->setFetchMode(PDO::FETCH_NUM);
		$STH->execute();
		$val = "";
		while ($row = $STH->fetch()) {
			$val = $row[0];
		}
		if ($val == "1") {
			$result = true;
		}
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}

?>