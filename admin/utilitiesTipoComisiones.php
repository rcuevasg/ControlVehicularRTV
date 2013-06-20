<?php
	//funciones de utilidades para las acciones sobre el catálogo de tipo de comisiones
	
	
	function listaComisiones() {
		$result = "";
		include "connection.php";
		
		$STH = $DBH->prepare("select id_ctg_tipo_comision, descripcion from CTG_TIPO_COMISION");
		$STH->setFetchMode(PDO::FETCH_NUM);
		$STH->execute();
		
		while ($row = $STH->fetch()) {
			$result .= $row[0] . "|" . $row[1] . "~";
		}
		
		include "closeConnection.php";
		return substr($result, 0, strlen($result) -1);
	}
	
?>