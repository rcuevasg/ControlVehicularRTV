<?php 
//Archivo de utilidades de las actividades de comision

function agregaActividad ($actividad, $usuario_creo){
	$result = 0;
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("insert into CTG_TIPO_COMISION (descripcion, usuario_creo, usuario_modifico, fecha_creado, fecha_modificado) values (?, ?, ?, now(), now())");
		$STH->bindParam(1, $actividad);
		$STH->bindParam(2, $usuario_creo);
		$STH->bindParam(3, $usuario_creo);
		$STH->execute();
		$result = $STH->rowCount();
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}


/**
*Funcion para obtener el listado de usuarios en formato JSON para el datagrid de la interfaz
*@param int $estado Indica el estado de los usuarios que se van a devolver en la lista, 0 para inactivos y 1 para activos
*@param string $campo Indica un valor de búsqueda para comparar contra el nombre, el correo o el nombre de chofer
*@param integer $empezandoDe indica el valor del indice a partir del cual se obtendra el listado
*@param integer $rowsSolicitados indica el número de rows regresados por la función
*/
function listaActividades($estado, $campo, $empezandoDe, $rowsSolicitados)
{
	$result = "";
	include "connection.php";
	$extraCount = 0;
	
	try
	{
		//Verificamos si viene un valor de búsqueda
		if ($campo != 'null')
		{
			//Obtenemos el total de resultados de la consulta para el paginado
			$STH = $DBH->prepare("select count(id_ctg_tipo_comision) from CTG_TIPO_COMISION where descripcion like ? and activo = ?");
			$campo = '%'.$campo.'%';
			$STH->bindParam(1, $campo);
			$STH->bindParam(2, $estado);
			$STH->setFetchMode(PDO::FETCH_NUM);
			$STH->execute();
			$rowCount = $STH->fetch();
			$extraCount = 0;
			$result = '{"total":' . $rowCount[0] . ',"rows":[';
			//Obtenemos los resultados para la consulta
			$STH = $DBH->prepare("select id_ctg_tipo_comision, descripcion from CTG_TIPO_COMISION where descripcion like ? and activo = ?");
			$campo = '%'.$campo.'%';
			$STH->bindParam(1, $campo);
			$STH->bindParam(2, $estado);
			$STH->setFetchMode(PDO::FETCH_NUM);
			$STH->execute();
			while ($row = $STH->fetch())
			{
				if (!empty($row[1]))
					$extraCount++;
				
				$result .= '{"ID":' . $row[0] . ', "DESCRIPCION":"' . $row[1] . '"},';
			}//Fin de while($row = $STH->fetch())
		}//Fin de if (campo != 'null')
		else
		{
			//No viene campo de búsqueda así que traemos todos los resultados
			//Obtenemos el total de resultados de la consulta para el paginado
			$STH = $DBH->prepare("select count(id_ctg_tipo_comision) from CTG_TIPO_COMISION where activo = ? ");
			$STH->bindParam(1, $estado);
			$STH->setFetchMode(PDO::FETCH_NUM);
			$STH->execute();
			$rowCount = $STH->fetch();
			$extraCount = 0;
			$result = '{"total":' . $rowCount[0] . ',"rows":[';
			//Obtenemos los resultados para la consulta
			$STH = $DBH->prepare("select id_ctg_tipo_comision, descripcion from CTG_TIPO_COMISION where activo = ? ");
			$STH->bindParam(1, $estado);
			$STH->setFetchMode(PDO::FETCH_NUM);
			$STH->execute();
			while ($row = $STH->fetch())
			{
				if (!empty($row[1]))
					$extraCount++;
				
				$result .= '{"ID":' . $row[0] . ', "DESCRIPCION":"' . $row[1] . '"},';
			}//Fin de while($row = $STH->fetch())
		}//Fin de else en if (campo != 'null')
	}//fin try
	catch (PDOException $ex)
	{
		print $ex->getMessage();
	}//fin catch
	
	include "closeConnection.php";
	
	if ($extraCount > 0)
	{
		return substr($result, 0, strlen($result) - 1) . ']}';
	}//Fin if ($extraCount > 0)
	else
	{
		return $result . ']}';
	}//Fin else
}

function obtenDatosActividad($idActividad){
	$result = "";
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("select id_ctg_tipo_comision, descripcion, activo from CTG_TIPO_COMISION where id_ctg_tipo_comision = ?");
		$STH->bindParam(1, $idActividad);
		$STH->setFetchMode(PDO::FETCH_NUM);
		$STH->execute();
		while ($row = $STH->fetch()) {
			$result .= $row[0] . "|" . $row[1] . "|" . $row[2];
		}
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}

function actualizaActividad ($idActividad, $nombreActividad, $usuario_modifica, $activo) {
	$result = 0;
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("update CTG_TIPO_COMISION set descripcion = ?, usuario_modifico = ?, activo = ?,  fecha_modificado = now() where id_ctg_tipo_comision = ?");
		$STH->bindParam(1, $nombreActividad);
		$STH->bindParam(2, $usuario_modifica);
		$STH->bindParam(3, $activo);
		$STH->bindParam(4, $idActividad);
		$STH->execute();
		$result = $STH->rowCount();
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return  $result;
}

function eliminaActividad($idActividad) {
	$result = 0;
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("update CTG_TIPO_COMISION set activo = false where id_ctg_tipo_comision = ?");
		$STH->bindParam(1, $idActividad);
		$STH->execute();
		$result = $STH->rowCount();
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}

?>