<?php
//Archivo de utilidades para los destinos frecuentes

function obtenDestinosfrecuentes() {
	$result = "";
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("select id_ctg_destinos_frecuentes, descripcion from CTG_DESTINOS_FRECUENTES where foraneo = true");
		$STH->setFetchMode(PDO::FETCH_NUM);
		$STH->execute();
		while ($row = $STH->fetch()) {
			$result .= $row[0] . "|" . $row[1] . "~";
		}
	}catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return substr($result, 0, strlen($result) - 1);
}

function obtenDestinosfrecuentesLocales() {
	$result = "";
	include "connection.php";
	
	try {
		$STH = $DBH->prepare("select id_ctg_destinos_frecuentes, descripcion from CTG_DESTINOS_FRECUENTES where foraneo = false");
		$STH->setFetchMode(PDO::FETCH_NUM);
		$STH->execute();
		while ($row = $STH->fetch()) {
			$result .= $row[0] . "|" . $row[1] . "~";
		}
	}catch (PDOException $ex) {
		print $ex->getMessage();
	}
	
	include "closeConnection.php";
	return substr($result, 0, strlen($result) - 1);
}

?>