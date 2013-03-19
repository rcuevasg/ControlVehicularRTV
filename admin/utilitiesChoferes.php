<?php
//Archivo para manejar las utilidades relacionadas con el catalogo de usuarios

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
*Funcion para registrar un usuario del sistema
*@param string $nombre Nombre del usuario
*@param string $ap_paterno Apellido paterno del usuario
*@param string $ap_materno Apellido materno del usuario
*@param string $email Correo electrónico del usuario
*@param string $passwd Contraseña de usuario
*@param integer $id_ctg_tipo_usuario Identificador del tipo de usuario, id del catálogo CTG_TIPO_USUARIO
*@param integer $usuario_creo Identificador del usuario que esta creando al usuario
*@result integer 0 en caso de error y 1 en caso de exito
*/
function registraChofer($nombre, $ap_paterno, $ap_materno, $num_licencia, $usuario_creo) {
	$result = 0;
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("insert into TB_CHOFERES (nombre, ap_paterno, ap_materno, num_licencia, fecha_creado, fecha_modificado, usuario_creo, usuario_modifico, activo) values (?, ?, ?, ?, now(), now(), ?, ?, true)");
		$STH->bindParam(1, $nombre);
		$STH->bindParam(2, $ap_paterno);
		$STH->bindParam(3, $ap_materno);
		$STH->bindParam(4, $num_licencia);
		$STH->bindParam(5, $usuario_creo);
		$STH->bindParam(6, $usuario_creo);
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
*@param string $campo Indica un valor de búsqueda para comparar contra el nombre, el correo o el nombre de usuario
*@param integer $empezandoDe indica el valor del indice a partir del cual se obtendra el listado
*@param integer $rowsSolicitados indica el número de rows regresados por la función
*/
function listaUsuarios($estado, $campo, $empezandoDe, $rowsSolicitados)
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
			$STH = $DBH->prepare("select count(id_tb_usuarios) from TB_USUARIOS as tu where concat(nombre, ' ', ap_paterno, ' ', ap_materno) like ? and activo = ?");
			$campo = '%'.$campo.'%';
			$STH->bindParam(1, $campo);
			$STH->bindParam(2, $estado);
			$STH->setFetchMode(PDO::FETCH_NUM);
			$STH->execute();
			$rowCount = $STH->fetch();
			$extraCount = 0;
			$result = '{"total":' . $rowCount[0] . ',"rows":[';
			//Obtenemos los resultados para la consulta
			$STH = $DBH->prepare("select id_tb_usuarios, concat(nombre, ' ', ap_paterno, ' ', ap_materno) as nombre, email, username, (select descripcion from CTG_TIPO_USUARIO as ctu where ctu.id_ctg_tipo_usuario = tu.id_ctg_tipo_usuario) as tipo_usuario from TB_USUARIOS as tu where concat(nombre, ' ', ap_paterno, ' ', ap_materno) like ? and activo = ?");
			$campo = '%'.$campo.'%';
			$STH->bindParam(1, $campo);
			$STH->bindParam(2, $estado);
			$STH->setFetchMode(PDO::FETCH_NUM);
			$STH->execute();
			while ($row = $STH->fetch())
			{
				if (!empty($row[1]))
					$extraCount++;
				
				$result .= '{"ID":' . $row[0] . ',"NOMBRE":"' . $row[1] . '","EMAIL":"' . $row[2] . '", "USERNAME":"' . $row[3] . '","TIPO_USUARIO":"' . $row[4] . '"},';
			}//Fin de while($row = $STH->fetch())
		}//Fin de if (campo != 'null')
		else
		{
			//No viene campo de búsqueda así que traemos todos los resultados
			//Obtenemos el total de resultados de la consulta para el paginado
			$STH = $DBH->prepare("select count(id_tb_usuarios) from TB_USUARIOS as tu where activo = ?");
			$STH->bindParam(1, $estado);
			$STH->setFetchMode(PDO::FETCH_NUM);
			$STH->execute();
			$rowCount = $STH->fetch();
			$extraCount = 0;
			$result = '{"total":' . $rowCount[0] . ',"rows":[';
			//Obtenemos los resultados para la consulta
			$STH = $DBH->prepare("select id_tb_usuarios, concat(nombre, ' ', ap_paterno, ' ', ap_materno) as nombre, email, username, (select descripcion from CTG_TIPO_USUARIO as ctu where ctu.id_ctg_tipo_usuario = tu.id_ctg_tipo_usuario) as tipo_usuario from TB_USUARIOS as tu where activo = ? ");
			$STH->bindParam(1, $estado);
			$STH->setFetchMode(PDO::FETCH_NUM);
			$STH->execute();
			while ($row = $STH->fetch())
			{
				if (!empty($row[1]))
					$extraCount++;
				
				$result .= '{"ID":' . $row[0] . ',"NOMBRE":"' . $row[1] . '","EMAIL":"' . $row[2] . '", "USERNAME":"' . $row[3] . '","TIPO_USUARIO":"' . $row[4] . '"},';
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

?>