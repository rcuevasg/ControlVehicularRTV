<?php
//Archivo para manejar las utilidades relacionadas con el catalogo de choferes

/**
*Funcion para loguear usuarios al sistema
*@param string $username Nombre de logueo del usuario, es diferente de su correo electronico
*@param string $passwd Contrasela del usuario
*@return string Cadena vacia en caso de no existir el usuario, en caso contrario cadena con el siguiente formato: id|nombre completo|email|tipo de usuario
*/
function logueaUsuario($username, $passwd)
{
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
*Funcion para obtener el listado de los tipos de unidades
*@return string Cadena vacia en caso de no existir datos, en caso contrario regresa una cadena con el siguiente formato: id|tipoUnidad~id|tipoUnidad
*/
function listadoTipoUnidades()
{
	$result = "";
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("select * from CTG_TIPO_UNIDAD");
		$STH->setFetchMode(PDO::FETCH_NUM);
		$STH->execute();
		
		while ($row = $STH->fetch()) {
			$result .= $row[0] . "|" . $row[1] . "~";
		}
		
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return substr($result, 0, strlen($result) -1);
}

/**
*Funcion para obtener el listado de los tipos de combustibles
*@return string Cadena vacia en caso de no existir datos, en caso contrario regresa una cadena con el siguiente formato: id|tipoCombustible~id|tipoCombustible
*/
function listadoTipoCombustible()
{
	$result = "";
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("select * from CTG_TIPO_COMBUSTIBLE");
		$STH->setFetchMode(PDO::FETCH_NUM);
		$STH->execute();
		
		while ($row = $STH->fetch()) {
			$result .= $row[0] . "|" . $row[1] . "~";
		}
		
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return substr($result, 0, strlen($result) -1);
}

/**
*Funcion para registrar un vehiculo
*@param string $placas_viejas Placas anteriores del vehículo
*@param string $placas_nuevas Placas actuales del vehiculo
*@param string $marca Marca del vehiculo
*@param string $modelo Modelo del vehiculo
*@param string $linea Linea del vehiculo
*@param integer $capacidad_tanque Capacidad del tanque de gasolina del vehiculo
*@param integer $kilometraje_actual Kilometraje actual del vehiculo
*@param string $num_serie Número de serie del vehiculo
*@param string $num_economico Número económico que identifica del vehiculo
*@param integer $tipo_unidad Tipo de unidad del vehiculo
*@param integer $tipo_combustible Tipo de combustible que utiliza el vehiculo
*@param string $nom_unidad Nombre de la unidad que identifica el vehiculo
*@param string $descripcion Descripción de las caracteristicas del vehiculo
*@param integer $usuario_creo Identificador del usuario que esta creando al vehiculo
*@param integer $choferResguarda Identificador del chofer que resgiarda el vehiculo
*@result integer 0 en caso de error y 1 en caso de exito
*/
function registraVehiculo($placas_viejas, $placas_nuevas, $marca, $modelo, $linea, $capacidad_tanque, $kilometraje_actual, $num_serie, $num_economico, $tipo_unidad, $tipo_combustible, $nom_unidad, $descripcion, $usuario_creo, $choferResguarda)
{
	$result = 0;
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("insert into CTG_VEHICULOS (placas_viejas, placas_nuevas, marca, modelo, capacidad_tanque, kilometraje_actual,  
		nombre_unidad, linea, descripcion_vehiculo, num_serie, id_ctg_tipo_unidad, id_ctg_tipo_combustible, usuario_creo, 
		usuario_modifico, num_economico, fecha_creado, fecha_modificado, activo, chofer_resguarda) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), now(), true, ?)");
		$STH->bindParam(1, $placas_viejas);
		$STH->bindParam(2, $placas_nuevas);
		$STH->bindParam(3, $marca);
		$STH->bindParam(4, $modelo);
		$STH->bindParam(5, $capacidad_tanque);
		$STH->bindParam(6, $kilometraje_actual);
		$STH->bindParam(7, $nom_unidad);
		$STH->bindParam(8, $linea);
		$STH->bindParam(9, $descripcion);
		$STH->bindParam(10, $num_serie);
		$STH->bindParam(11, $tipo_unidad);
		$STH->bindParam(12, $tipo_combustible);
		$STH->bindParam(13, $usuario_creo);
		$STH->bindParam(14, $usuario_creo);
		$STH->bindParam(15, $num_economico);
		$STH->bindParam(16, $choferResguarda);		
		$STH->execute();
		$result = $STH->rowCount();
		//$STH->bindParam(11, $num_motor);
		//$STH->bindParam(7, $rendimiento_km);
		
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}

/**
*Funcion para obtener el listado de los vehiculos en formato JSON para el datagrid de la interfaz
*@param int $estado Indica el estado de los vehiculos que se van a devolver en la lista, 0 para inactivos y 1 para activos
*@param string $campo Indica un valor de búsqueda para comparar contra las placas actuales
*@param integer $empezandoDe indica el valor del indice a partir del cual se obtendra el listado
*@param integer $rowsSolicitados indica el número de rows regresados por la función
*/
function listaVehiculos($estado, $campo, $empezandoDe, $rowsSolicitados)
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
			$STH = $DBH->prepare("select count(id_ctg_vehiculos) from CTG_VEHICULOS where placas_nuevas like ? and activo = ?");
			$campo = '%'.$campo.'%';
			$STH->bindParam(1, $campo);
			$STH->bindParam(2, $estado);
			$STH->setFetchMode(PDO::FETCH_NUM);
			$STH->execute();
			$rowCount = $STH->fetch();
			$extraCount = 0;
			$result = '{"total":' . $rowCount[0] . ',"rows":[';
			//Obtenemos los resultados para la consulta
			$STH = $DBH->prepare("select id_ctg_vehiculos, placas_nuevas, kilometraje_actual, descripcion_vehiculo, num_economico, 
			(select descripcion from CTG_TIPO_UNIDAD as ctu where ctu.id_ctg_tipo_unidad = tv.id_ctg_tipo_unidad) as tipo_unidad, 
			(select descripcion from CTG_TIPO_COMBUSTIBLE as ctc where ctc.id_ctg_tipo_combustible = tv.id_ctg_tipo_combustible) as tipo_combustible
			from CTG_VEHICULOS as tv where placas_nuevas like ? and activo = ?");
			$campo = '%'.$campo.'%';
			$STH->bindParam(1, $campo);
			$STH->bindParam(2, $estado);
			$STH->setFetchMode(PDO::FETCH_NUM);
			$STH->execute();
			while ($row = $STH->fetch())
			{
				if (!empty($row[1]))
					$extraCount++;
				
				$result .= '{"ID":' . $row[0] . ',"PLACAS":"' . $row[1] . '","KM":"' . $row[2] . '", "DESCRIPCION":"' . $row[3] . '", "NECONOMICO":"' . $row[4] . '", "UNIDAD":"' . $row[5] . '", "COMBUSTIBLE":"' . $row[6] . '"    },';
			}//Fin de while($row = $STH->fetch())
		}//Fin de if (campo != 'null')
		else
		{
			//No viene campo de búsqueda así que traemos todos los resultados
			//Obtenemos el total de resultados de la consulta para el paginado
			$STH = $DBH->prepare("select count(id_ctg_vehiculos) from CTG_VEHICULOS where activo = ?");
			$STH->bindParam(1, $estado);
			$STH->setFetchMode(PDO::FETCH_NUM);
			$STH->execute();
			$rowCount = $STH->fetch();
			$extraCount = 0;
			$result = '{"total":' . $rowCount[0] . ',"rows":[';
			//Obtenemos los resultados para la consulta
			$STH = $DBH->prepare("select id_ctg_vehiculos, placas_nuevas, kilometraje_actual, descripcion_vehiculo, num_economico, 
			(select descripcion from CTG_TIPO_UNIDAD as ctu where ctu.id_ctg_tipo_unidad = tv.id_ctg_tipo_unidad) as tipo_unidad, 
			(select descripcion from CTG_TIPO_COMBUSTIBLE as ctc where ctc.id_ctg_tipo_combustible = tv.id_ctg_tipo_combustible) as tipo_combustible
			from CTG_VEHICULOS as tv where activo = ?");
			$STH->bindParam(1, $estado);
			$STH->setFetchMode(PDO::FETCH_NUM);
			$STH->execute();
			while ($row = $STH->fetch())
			{
				if (!empty($row[1]))
					$extraCount++;
				
				$result .= '{"ID":' . $row[0] . ',"PLACAS":"' . $row[1] . '","KM":"' . $row[2] . '", "DESCRIPCION":"' . $row[3] . '", "NECONOMICO":"' . $row[4] . '", "UNIDAD":"' . $row[5] . '", "COMBUSTIBLE":"' . $row[6] . '"    },';
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
*Función para obtener todos los datos de un vehiculo
*@param integer $id Identificador del vehiculo, id de tabla
*@return string Cadena con el siguiente formato: placas_viejas|placas_nuevas|marca|modelo|capacidad_tanque|kilometraje_actual|nombre_unidad|linea|descripcion_vehiculo|num_serie|id_ctg_tipo_unidad|id_ctg_tipo_combustible|num_economico|activo
*/
function obtenDatosVehiculo($id) 
{
	$result = "";
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("select placas_viejas, placas_nuevas, marca, modelo, capacidad_tanque, kilometraje_actual, nombre_unidad, linea, descripcion_vehiculo, num_serie, id_ctg_tipo_unidad, id_ctg_tipo_combustible, num_economico, activo, chofer_resguarda from CTG_VEHICULOS where id_ctg_vehiculos = ?");
		$STH->bindParam(1, $id);
		$STH->setFetchMode(PDO::FETCH_NUM);
		$STH->execute();
		
		while ($row = $STH->fetch()) {
			$result .= $row[0] . "|" . $row[1] . "|" . $row[2] . "|" . $row[3] . "|" . $row[4] . "|" . $row[5] . "|" . $row[6]. "|" . $row[7]. "|" . $row[8]. "|" . $row[9]. "|" . $row[10]. "|" . $row[11]. "|" . $row[12]. "|" . $row[13] . "|" . $row[14]  ;
		}
		
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}

/**
*Funcion para actualizar los datos de un vehiculo
*@param string $placas_viejas Placas anteriores del vehículo
*@param string $placas_nuevas Placas actuales del vehiculo
*@param string $marca Marca del vehiculo
*@param string $modelo Modelo del vehiculo
*@param string $linea Linea del vehiculo
*@param integer $capacidad_tanque Capacidad del tanque de gasolina del vehiculo
*@param integer $kilometraje_actual Kilometraje actual del vehiculo
*@param string $num_serie Número de serie del vehiculo
*@param string $num_economico Número económico que identifica del vehiculo
*@param integer $tipo_unidad Tipo de unidad del vehiculo
*@param integer $tipo_combustible Tipo de combustible que utiliza el vehiculo
*@param string $nom_unidad Nombre de la unidad que identifica el vehiculo
*@param string $descripcion Descripción de las caracteristicas del vehiculo
*@param integer $usuario_modifico Identificador del usuario que esta modificando al usuario
*@param integer $idVehiculo Identificador del vehiculo a modificar, id de tabla
*@param integer $activo Estado del vehiculo 0 para inactivo y 1 para activo
*@return integer 0 en caso de error y 1 en caso de exito
*/
function actualizaVehiculos($placas_viejas, $placas_nuevas, $marca, $modelo, $linea, $capacidad_tanque, $kilometraje_actual, $num_serie, $num_economico, $tipo_unidad, $tipo_combustible, $nom_unidad, $descripcion, $usuario_modifico, $idVehiculo, $activo, $choferResguarda) 
{
	$result = 0;
	include "connection.php";
	
	try {
		//La contraseña viene vacia por lo que no se actualiza el campo
		$STH = $DBH->prepare("update CTG_VEHICULOS set placas_viejas = ?, placas_nuevas = ?, marca = ?, modelo = ?, capacidad_tanque = ?, 
		kilometraje_actual = ?, nombre_unidad = ?,  linea = ?, descripcion_vehiculo = ?, num_serie = ?, id_ctg_tipo_unidad = ?, id_ctg_tipo_combustible = ?, 
		num_economico = ?, fecha_modificado = now(), usuario_modifico = ?, activo = ?, chofer_resguarda = ?  
		where id_ctg_vehiculos = ?");
		$STH->bindParam(1, $placas_viejas);
		$STH->bindParam(2, $placas_nuevas);
		$STH->bindParam(3, $marca);
		$STH->bindParam(4, $modelo);
		$STH->bindParam(5, $capacidad_tanque);
		$STH->bindParam(6, $kilometraje_actual);
		$STH->bindParam(7, $nom_unidad);
		$STH->bindParam(8, $linea);
		$STH->bindParam(9, $descripcion);
		$STH->bindParam(10, $num_serie);
		$STH->bindParam(11, $tipo_unidad);
		$STH->bindParam(12, $tipo_combustible);
		$STH->bindParam(13, $num_economico);	
		$STH->bindParam(14, $usuario_modifico);
		$STH->bindParam(15, $activo);	
		$STH->bindParam(16, $choferResguarda);
		$STH->bindParam(17, $idVehiculo);	
		$STH->execute();	
		$result = $STH->rowCount();
		
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}


/**
*Funcion para desactivar la cuenta de un vehiculo
*@param integer $idVehiculo Identificador del vehiculo a modificar, id de tabla
*@param integer $usuario_modifico Identificador del usuario que esta realizando la modificacion, id de tabla
*@return integer 0 en caso de error y 1 en caso de éxito
*/
function desactivaVehiculo($idVehiculo, $usuario_modifico)
{
	$result = 0;
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("update CTG_VEHICULOS set activo = false, fecha_modificado = now(), usuario_modifico = ? where id_ctg_vehiculos = ?");
		$STH->bindParam(1, $usuario_modifico);
		$STH->bindParam(2, $idVehiculo);
		$STH->execute();
		$result = $STH->rowCount();
	} catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return $result;
}
?>