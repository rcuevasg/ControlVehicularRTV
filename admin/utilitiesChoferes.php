<?php
//Archivo para manejar las utilidades relacionadas con el catalogo de choferes

/**
*Funcion para loguear usuarios al sistema
*@param string $username Nombre de logueo del usuario, es diferente de su correo electronico
*@param string $passwd Contrasela del usuario
*@return string Cadena vacia en caso de no existir el usuario, en caso contrario cadena con el siguiente formato: id|nombre completo|email|tipo de usuario
*/
function logueaUsuario($username, $passwd) {
	$result = "";
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("select id_tb_usuarios, concat(nombre,' ',ap_paterno,' ',ap_materno) as nombre, email, id_ctg_tipo_usuario from TB_USUARIOS where username = ? and passwd = MD5(?) and activo = true");
		$STH->bindParam(1, $username);
		$STH->bindParam(2, $passwd);
		$STH->setFetchMode(PDO::FETCH_NUM);
		$STH->execute();
		
		while ($row = $STH->fetch()) {
			$result = $row[0] . "|" . $row[1] . "|" . $row[2] . "|" . $row[3];
		}
		
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}

/**
*Funcion para registrar un chofer del sistema
*@param string $nombre Nombre del chofer
*@param string $ap_paterno Apellido paterno del chofer
*@param string $ap_materno Apellido materno del chofer
*@param string $num_licencia Numero de Licencia del chofer
*@param string $vigencia_licencia Vigencia de licencia del chofer
*@param integer $usuario_creo Identificador del usuario que esta creando al chofer
*@result integer 0 en caso de error y 1 en caso de exito
*/
function registraChofer($nombre, $ap_paterno, $ap_materno, $num_licencia, $vigencia_licencia, $usuario_creo) {
	$result = 0;
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("insert into TB_CHOFERES (nombre, ap_paterno, ap_materno, num_licencia, vigencia_licencia, fecha_creado, fecha_modificado, usuario_creo, usuario_modifico, activo) values (?, ?, ?, ?, ?, now(), now(), ?, ?, true)");
		$STH->bindParam(1, $nombre);
		$STH->bindParam(2, $ap_paterno);
		$STH->bindParam(3, $ap_materno);
		$STH->bindParam(4, $num_licencia);
		$STH->bindParam(5, $vigencia_licencia);
		$STH->bindParam(6, $usuario_creo);
		$STH->bindParam(7, $usuario_creo);
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
function listaChoferes($estado, $campo, $empezandoDe, $rowsSolicitados)
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
			$STH = $DBH->prepare("select count(id_tb_choferes) from TB_CHOFERES as tu where concat(nombre, ' ', ap_paterno, ' ', ap_materno) like ? and activo = ?");
			$campo = '%'.$campo.'%';
			$STH->bindParam(1, $campo);
			$STH->bindParam(2, $estado);
			$STH->setFetchMode(PDO::FETCH_NUM);
			$STH->execute();
			$rowCount = $STH->fetch();
			$extraCount = 0;
			$result = '{"total":' . $rowCount[0] . ',"rows":[';
			//Obtenemos los resultados para la consulta
			$STH = $DBH->prepare("select id_tb_choferes, concat(nombre, ' ', ap_paterno, ' ', ap_materno) as nombre, num_licencia, date_format(vigencia_licencia,'%d/%m/%Y') from TB_CHOFERES as tu where concat(nombre, ' ', ap_paterno, ' ', ap_materno) like ? and activo = ?");
			$campo = '%'.$campo.'%';
			$STH->bindParam(1, $campo);
			$STH->bindParam(2, $estado);
			$STH->setFetchMode(PDO::FETCH_NUM);
			$STH->execute();
			while ($row = $STH->fetch())
			{
				if (!empty($row[1]))
					$extraCount++;
				
				$result .= '{"ID":' . $row[0] . ',"NOMBRE":"' . $row[1] . '","NUMLICENCIA":"' . $row[2] . '", "VIGLICENCIA":"' . $row[3] . '"},';
			}//Fin de while($row = $STH->fetch())
		}//Fin de if (campo != 'null')
		else
		{
			//No viene campo de búsqueda así que traemos todos los resultados
			//Obtenemos el total de resultados de la consulta para el paginado
			$STH = $DBH->prepare("select count(id_tb_choferes) from TB_CHOFERES as tu where activo = ?");
			$STH->bindParam(1, $estado);
			$STH->setFetchMode(PDO::FETCH_NUM);
			$STH->execute();
			$rowCount = $STH->fetch();
			$extraCount = 0;
			$result = '{"total":' . $rowCount[0] . ',"rows":[';
			//Obtenemos los resultados para la consulta
			$STH = $DBH->prepare("select id_tb_choferes, concat(nombre, ' ', ap_paterno, ' ', ap_materno) as nombre, num_licencia, date_format(vigencia_licencia,'%d/%m/%Y') from TB_CHOFERES as tu where activo = ? ");
			$STH->bindParam(1, $estado);
			$STH->setFetchMode(PDO::FETCH_NUM);
			$STH->execute();
			while ($row = $STH->fetch())
			{
				if (!empty($row[1]))
					$extraCount++;
				
				$result .= '{"ID":' . $row[0] . ',"NOMBRE":"' . $row[1] . '","NUMLICENCIA":"' . $row[2] . '", "VIGLICENCIA":"' . $row[3] . '"},';
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

/**
*Función para obtener todos los datos de un chofer
*@param integer $id Identificador del chofer, id de tabla
*@return string Cadena con el siguiente formato: nombre|ap_paterno|ap_materno|num_licencia|vigencia_licencia|fecha_creado|fecha_modificado|usuario_creo|usuario_modifico|activo
*/
function obtenDatosChofer($id) {
	$result = "";
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("select nombre, ap_paterno, ap_materno, num_licencia, date_format(vigencia_licencia,'%d/%m/%Y'), activo from TB_CHOFERES where id_tb_choferes = ?");
		$STH->bindParam(1, $id);
		$STH->setFetchMode(PDO::FETCH_NUM);
		$STH->execute();
		
		while ($row = $STH->fetch()) {
			$result .= $row[0] . "|" . $row[1] . "|" . $row[2] . "|" . $row[3] . "|" . $row[4] . "|" . $row[5] ;
		}
		
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}

/**
*Funcion para actualizar los datos de un chofer
*@param string $nombre Nombre del chofer
*@param string $ap_paterno Apellido paterno del chofer
*@param string $ap_materno Apellido materno del chofer
*@param string $num_licencia Numero de Licencia del chofer
*@param string $vigencia_licencia Vigencia de licencia del chofer
*@param integer $usuario_modifico Identificador del usuario que esta modificando al usuario
*@param integer $idChofer Identificador del chofer a modificar, id de tabla
*@param integer $estado Estado del chofer 0 para inactivo y 1 para activo
*@return integer 0 en caso de error y 1 en caso de exito
*/
function actualizaChofer($nombre, $ap_paterno, $ap_materno, $num_licencia, $vigencia_licencia, $usuario_modifico, $idChofer, $estado) {
	$result = 0;
	include "connection.php";
	
	try {
		//La contraseña viene vacia por lo que no se actualiza el campo
		$STH = $DBH->prepare("update TB_CHOFERES set nombre = ?, ap_paterno = ?, ap_materno = ?, num_licencia = ?, vigencia_licencia = ?, fecha_modificado = now(), usuario_modifico = ?, activo = ? where id_tb_choferes = ?");
		$STH->bindParam(1, $nombre);
		$STH->bindParam(2, $ap_paterno);
		$STH->bindParam(3, $ap_materno);
		$STH->bindParam(4, $num_licencia);
		$STH->bindParam(5, $vigencia_licencia);
		$STH->bindParam(6, $usuario_modifico);
		$STH->bindParam(7, $estado);
		$STH->bindParam(8, $idChofer);
		$STH->execute();	
		$result = $STH->rowCount();
		
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}


/**
*Funcion para desactivar la cuenta de un chofer
*@param integer $idChofer Identificador del chofer a modificar, id de tabla
*@param integer $usuario_modifico Identificador del usuario que esta realizando la modificacion, id de tabla
*@return integer 0 en caso de error y 1 en caso de éxito
*/
function desactivaChofer($idChofer, $usuario_modifico) {
	$result = 0;
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("update TB_CHOFERES set activo = false, fecha_modificado = now(), usuario_modifico = ? where id_tb_choferes = ?");
		$STH->bindParam(1, $usuario_modifico);
		$STH->bindParam(2, $idChofer);
		$STH->execute();
		$result = $STH->rowCount();
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}
?>