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

?>