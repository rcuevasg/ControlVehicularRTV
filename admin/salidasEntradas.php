<?php session_start(); ?>

<?php
	include "utilitiesSalidasEntradas.php";
	
	$opt = $_GET['opt'];
	
	switch ($opt) {
		case 1:
			//Opcion para registrar salida
			include "utilitiesVehiculos.php";
			include "utilitiesChoferes.php";
			?>
			<script type="text/javascript">
				function changeSlider(label, idSlider){
					var idLabel = "label"+idSlider;
					document.getElementById(idLabel).innerHTML = label +  " ( " + document.getElementById(idSlider).value + "% )";
				};
				
				function otroChofer() {
					var e = document.getElementById("txtChoferes");
					var strUser = e.options[e.selectedIndex].value;
					if (strUser == "0") {
						document.getElementById('choferTemporal').style.display = 'block';
					} else {
						document.getElementById('choferTemporal').style.display = 'none';
					}
					//alert(strUser);
				}
				
				function otroLugarComision(){
					var e = document.getElementById("txtLugarComision");
					var strUser = e.options[e.selectedIndex].value;
					if (strUser == "0") {
						document.getElementById('otroLugarComision').style.display = 'block';
					} else {
						document.getElementById('otroLugarComision').style.display = 'none';
					}
				}
				
				function cambioTipoSalida(){
					var e = document.getElementById("txtTipoSalida");
					var strUser = e.options[e.selectedIndex].value;
					if (strUser == "0") {
						document.getElementById('foraneo').style.display = 'none';
						document.getElementById('local').style.display = 'block';
					} else {
						document.getElementById('foraneo').style.display = 'block';
						document.getElementById('local').style.display = 'none';
					}
				}
			
				$(function(){
					$('#frmRegistraSalida').form({
						url:'accionesSalidasEntradas.php',
						onSubmit:function(){
							return $(this).form('validate');
						},
						success:function(data){
							if (data.indexOf('php') > -1)
								document.location = data;
							else
								$('#mainContentRegistro').html(data);//data;
						}
					});
				});
			</script>
			<div id="mensajes"></div>
			<h3>Registrar salida</h3>
			<form name="frmRegistraSalida" id="frmRegistraSalida" method="post" >
				<input type="hidden" name="opt" id="opt" value="1" >
				
				
				<fieldset >
				<legend > Datos de Asignaci&oacute;n</legend>
				<?php
				$vehiculos = listaNombresVehiculos();
				?>
				<label  for="txtVehiculoSale">Vehiculo asignado</label>
				<select name="txtVehiculoSale" id="txtVehiculoSale" required >
					<?php 
					if (!empty($vehiculos)) {
						$listaVehiculos = explode("~", $vehiculos);
						foreach ($listaVehiculos as $vehiculo) {
							$datosVehiculo = explode("|", $vehiculo);
							?>
							<option value="<?php print $datosVehiculo[0] ?>"><?php print $datosVehiculo[1] ?></option>
							<?php
						}
					}
					?>
				</select>
				
				<?php
				$choferes = listaSimpleChoferes();
				?>
				<label  for="txtChoferes">Chofer asignado</label>
				<select name="txtChoferes" id="txtChoferes" onchange="otroChofer()" required>
				<option value="0">Otro</option>
					<?php
					if (!empty($choferes)) {
						$listaChoferes = explode("~", $choferes);
						foreach ($listaChoferes as $chofer) {
							$datosChofer = explode("|", $chofer);
							?>
							<option value="<?php print $datosChofer[0] ?>"><?php print $datosChofer[1] ?></option>
							<?php
						}
					}
					?>
				</select>
				
				<div id="choferTemporal" style="display:block">
					<label for="txtNombreChoferTemp">Nombre Chofer</label>
					<input  type="text" name="txtNombreChoferTemp" id="txtNombreChoferTemp" />
					
					<label for="txtNumLicenciaTemp">N&uacute;mero de licencia</label>
					<input  type="number" name="txtNNumLicenciaTemp" id="txtNumLicenciaTemp" />
					
					<label for="txtVigenciaLicencia">Vigencia de licencia</label>
					<input type="date" name="txtVigenciaLicencia" id="txtVigenciaLicencia" />
				</div>
				
				<label  for="txtTipoSalida">Tipo de salida</label>
				<select name="txtTipoSalida" id="txtTipoSalida" onchange="cambioTipoSalida()">
					<option value="0">Local</option>
					<option value="1">Foranea</option>
				</select>
				
				<label for="txtActividadComision">Actividad de comisión</label>
				<?php
				include "utilitiesTipoComisiones.php";
				$comisiones = listaComisiones();
				?>
				<select name="txtActividadComision" id="txtActividadComision">
					<option value="0">Otro</option>
					<?php
					if (!empty($comisiones)) {
						$listaComisiones = explode("~", $comisiones);
						foreach ($listaComisiones as $comision) {
							$datosComision = explode("|", $comision);
							?>
							<option value="<?php print $datosComision[0] ?>"><?php print $datosComision[1] ?></option>
							<?php
						}
					}
					?>
				</select>
				
				<label for="txtActividadComisionOtro">Especifique otro</label>
				<input type="text" name="txtActividadComisionOtro" id="txtActividadComisionOtro">
				
				<label for="txtLugarComision">Destino de la comisión</label>
				<div id="foraneo" style="display:none;">
				<?php
				include "utilitiesDestinosFrecuentes.php";
				$destinos = obtenDestinosfrecuentes();
				if (!empty($destinos)){
					?>
					<select name="txtLugarComision" id="txtLugarComision" onchange="otroLugarComision()">
						<option value="0">Otro destino</option>
					<?php
						$listaDestinos = explode("~", $destinos);
						foreach($listaDestinos as $destino){
							$datosDestino = explode("|", $destino);
							?>
							<option value="<?php print $datosDestino[0] ?>"><?php print $datosDestino[1] ?></option>
							<?php
						}
					?>
					</select>
					<?php
				}
				?>
				</div><!-- #fin div foraneo -->
				
				<div id="local" style="display:block;">
				<?php
				$destinos = obtenDestinosfrecuentesLocales();
				if (!empty($destinos)){
					?>
					<select name="txtLugarComision" id="txtLugarComision" onchange="otroLugarComision()">
						<option value="0">Otro destino</option>
					<?php
						$listaDestinos = explode("~", $destinos);
						foreach($listaDestinos as $destino){
							$datosDestino = explode("|", $destino);
							?>
							<option value="<?php print $datosDestino[0] ?>"><?php print $datosDestino[1] ?></option>
							<?php
						}
					?>
					</select>
					<?php
				}
				?>
				</div><!-- #fin div local -->
				
				<div id="otroLugarComision" style="display:block;">
				<label  for="txtOtroLugarComision">Otro destino de la comisión</label>
				<input type="text" name="txtOtroLugarComision" id="txtOtroLugarComision">
				</div>
				
				<label for="txtEncargadoComision">Responsable de la comisión</label>
				<input type="text" name="txtEncargadoComision" id="txtEncargadoComision" required="required">
				
				<label for="txtHoraComision">Hora programada</label>
				<input type="time" name="txtHoraComision" id="txtHoraComision" required="required">
				
				<label for="txtNumPasajeros">Número de pasajeros</label>
				<input type="number" name="txtNumPasajeros" id="txtNumPasajeros" required="required">
				
				<label for="txtKMSalida">Km de salida</label>
				<input type="number" name="txtKMSalida" id="txtKMSalida" required="required">
				
				<label for="txtObservaciones">Observaciones</label><br />
				<center><textarea name="txtObservaciones" id="txtObservaciones" cols="60" rows="10" style="font-size:20px;" required="required"></textarea></center>
				</fieldset>
				
				<fieldset >
				<legend >Niveles del vehiculo</legend>
				<label id="labeltxtNivelGasolina"  for="txtNivelGasolina">Nivel de gasolina</label>
				<input type="range" name="txtNivelGasolina" id="txtNivelGasolina" min="0" max="100" step="5" onchange="changeSlider('Nivel de gasolina','txtNivelGasolina');">
				<input type="checkbox" name="txtNivelAceiteMotor" id="txtNivelAceiteMotor" value="1">Nivel de aceite del motor <br/>
				<!-- <label id="labeltxtNivelAceiteMotor"  for="txtNivelAceiteMotor">Nivel de aceite del motor</label>
				<input type="range" name="txtNivelAceiteMotor" id="txtNivelAceiteMotor" min="1" max="100" step="1" onchange="changeSlider('Nivel de aceite del motor','txtNivelAceiteMotor');"> -->
				<input type="checkbox" name="txtNivelAceiteTransmision" id="txtNivelAceiteTransmision" value="1">Nivel de aceite de la transmisi&oacute;n<br/>
				<!-- <label id="labeltxtNivelAceiteTransmision"  for="txtNivelAceiteTransmision">Nivel de aceite de la transmisi&oacute;n</label>
				<input type="range" name="txtNivelAceiteTransmision" id="txtNivelAceiteTransmision" min="1" max="100" step="1" onchange="changeSlider('Nivel de aceite de la transmisión','txtNivelAceiteTransmision');"> -->
				<input type="checkbox" name="txtNivelAceiteDireccion" id="txtNivelAceiteDireccion" value="1">Nivel de aceite de la direcci&oacute;n<br/>
				<!-- <label id="labeltxtNivelAceiteDireccion" for="txtNivelAceiteDireccion">Nivel de aceite de la direcci&oacute;n</label>
				<input type="range" name="txtNivelAceiteDireccion" id="txtNivelAceiteDireccion" min="1" max="100" step="1" onchange="changeSlider('Nivel de aceite de la dirección','txtNivelAceiteDireccion');"> -->
				<input type="checkbox" name="txtNivelLiquidoFrenos" id="txtNivelLiquidoFrenos" value="1">Nivel de liquido de frenos<br/>
				<!-- <label id="labeltxtNivelLiquidoFrenos"  for="txtNivelLiquidoFrenos">Nivel de liquido de frenos</label>
				<input type="range" name="txtNivelLiquidoFrenos" id="txtNivelLiquidoFrenos" min="1" max="100" step="1" onchange="changeSlider('Nivel de liquido de frenos','txtNivelLiquidoFrenos');"> -->
				<input type="checkbox" name="txtNivelLiquidoAnticongelante" id="txtNivelLiquidoAnticongelante" value="1">Nivel de liquido anticongelante
				<!-- <label id="labeltxtNivelLiquidoAnticongelante" for="txtNivelLiquidoAnticongelante">Nivel de liquido anticongelante</label>
				<input type="range" name="txtNivelLiquidoAnticongelante" id="txtNivelLiquidoAnticongelante" min="1" max="100" step="1" onchange="changeSlider('Nivel de liquido anticongelante','txtNivelLiquidoAnticongelante');"> -->
				</fieldset>
				
				<fieldset >
					<legend >Elementos en el vehículo</legend>
					<input name="llantaRefaccion" id="llantaRefaccion" type="checkbox" value="1">Llanta de refacci&oacute;n
					<input name="gato" id="gato" type="checkbox" value="1">Gato
					<input name="llaveCruz" id="llaveCruz" type="checkbox" value="1">Llave de cruz
				</fieldset>
				
				<button id="btnGuardaRegistroSalida" class="button" type="submit" value="Registrar salida" >Registrar salida</button>
			</form>
			<?php
			break; //Fin del case 1
			
		case 2: 
			//Case para listar los usuarios registrados en el sistema
			$comisiones = listaSalidasActivas();
			?>	
        
        	<h3>Veh&iacute;culos en comisi&oacute;n</h3>
			
			<?php
			if (!empty($comisiones)) {
				//Iniciamos el listado
				$listaComisiones = explode("~", $comisiones);
				
				foreach ($listaComisiones as $comision) {
					$datosComision = explode("|", $comision);
					$idSalida = $datosComision[0];
					$vehiculo = $datosComision[1];
					$chofer = $datosComision[2];
					$folio = $datosComision[3];
					$tipoComision = $datosComision[4];
					$lugarComision = $datosComision[5];
					$fechaSalida = $datosComision[6];
					
					?>
					<div class="itemComision">
						<div class="itemInfo">
							<span><strong>Veh&iacute;culo: </strong> <?php print $vehiculo; ?>  </span>
							<span><strong >Chofer: </strong> <?php print $chofer; ?></span>
							<span><strong >Comisi&oacute;n: </strong><?php print $tipoComision; ?></span>
							<span ><strong>Lugar: </strong> <?php print $lugarComision; ?> </span>
							<span><strong>Fecha de salida: </strong> <?php print $fechaSalida; ?> </span>
						</div>
						<button class="button mobile" type="button" value="Registrar entrada" onclick="$('#mainContentRegistro').load('salidasEntradas.php?opt=3&idSalida=<?php print $idSalida; ?>')" >Registrar entrada</button>
					</div>
					<?php
					
				}
			}
			break;//Fin del case 2
		
		case 3 :
			
			//include "utilitiesVehiculos.php";
			$idSalida = $_GET['idSalida'];
			$salida = datosSalida($idSalida);

			?>
			<script type="text/javascript">
				function changeSlider(label, idSlider){
					var idLabel = "label"+idSlider;
					document.getElementById(idLabel).innerHTML = label +  " ( " + document.getElementById(idSlider).value + "% )";
				};
			
				$(function(){
					$('#frmRegistraSalida').form({
						url:'accionesSalidasEntradas.php',
						onSubmit:function(){
							return $(this).form('validate');
						},
						success:function(data){
							if (data.indexOf('php') > -1)
								document.location = data;
							else
								$('#mainContentRegistro').html(data);//data;
						}
					});
				});
			</script>
			<div id="mensajes"></div>
			<h3>Registrar entrada</h3>
			<form name="frmRegistraSalida" id="frmRegistraSalida" method="post" >
				<input type="hidden" name="opt" id="opt" value="2" >
				
				
				<fieldset >
				<legend > Datos de Asignaci&oacute;n</legend>
				
				<?php
				if (!empty($salida)) {
						$datosComision = explode("|", $salida);
						$idSalida = $datosComision[0];
						$vehiculo = $datosComision[1];
						$chofer = $datosComision[2];
						$folio = $datosComision[3];
						$tipoComision = $datosComision[4];
						$lugarComision = $datosComision[5];
						$fechaSalida = $datosComision[6];
					
						?>
						<div class="itemComision">
							<div class="itemInfo">
								<span><strong>Veh&iacute;culo: </strong> <?php print $vehiculo; ?>  </span>
								<span><strong >Chofer: </strong> <?php print $chofer; ?></span>
								<span><strong >Comisi&oacute;n: </strong><?php print $tipoComision; ?></span>
								<span ><strong>Lugar: </strong> <?php print $lugarComision; ?> </span>
								<span><strong>Fecha de salida: </strong> <?php print $fechaSalida; ?> </span>
							</div>
						</div>
						<?php
					
						}
				?>
				
				<input type="hidden" name="txtIdSalida" id="txtIdSalida" value="<?php print $idSalida; ?>">
				<p />
				<label for="txtKMEntrada">KM de entrada</label>
				<input type="number" id="txtKMEntrada" name="txtKMEntrada">
				
				<label for="txtObservaciones">Observaciones de entrada</label><br />
				<center><textarea name="txtObservaciones" id="txtObservaciones" cols="60" rows="10" style="font-size:20px;"></textarea></center>
				</fieldset>
				
				<fieldset >
				<legend >Niveles del vehiculo</legend>
				<label id="labeltxtNivelGasolina"  for="txtNivelGasolina">Nivel de gasolina</label>
				<input type="range" name="txtNivelGasolina" id="txtNivelGasolina" min="0" max="100" step="5" onchange="changeSlider('Nivel de gasolina','txtNivelGasolina');">
				<!-- <label id="labeltxtNivelAceiteMotor"  for="txtNivelAceiteMotor">Nivel de aceite del motor</label>
				<input type="range" name="txtNivelAceiteMotor" id="txtNivelAceiteMotor" min="1" max="100" step="1" onchange="changeSlider('Nivel de aceite del motor','txtNivelAceiteMotor');">
				<label id="labeltxtNivelAceiteTransmision"  for="txtNivelAceiteTransmision">Nivel de aceite de la transmisi&oacute;n</label>
				<input type="range" name="txtNivelAceiteTransmision" id="txtNivelAceiteTransmision" min="1" max="100" step="1" onchange="changeSlider('Nivel de aceite de la transmisión','txtNivelAceiteTransmision');">
				<label id="labeltxtNivelAceiteDireccion" for="txtNivelAceiteDireccion">Nivel de aceite de la direcci&oacute;n</label>
				<input type="range" name="txtNivelAceiteDireccion" id="txtNivelAceiteDireccion" min="1" max="100" step="1" onchange="changeSlider('Nivel de aceite de la dirección','txtNivelAceiteDireccion');">
				<label id="labeltxtNivelLiquidoFrenos"  for="txtNivelLiquidoFrenos">Nivel de liquido de frenos</label>
				<input type="range" name="txtNivelLiquidoFrenos" id="txtNivelLiquidoFrenos" min="1" max="100" step="1" onchange="changeSlider('Nivel de liquido de frenos','txtNivelLiquidoFrenos');">
				<label id="labeltxtNivelLiquidoAnticongelante" for="txtNivelLiquidoAnticongelante">Nivel de liquido anticongelante</label>
				<input type="range" name="txtNivelLiquidoAnticongelante" id="txtNivelLiquidoAnticongelante" min="1" max="100" step="1" onchange="changeSlider('Nivel de liquido anticongelante','txtNivelLiquidoAnticongelante');"> -->
				</fieldset>
				
				<fieldset >
					<legend >Elementos en el vehículo</legend>
					<input name="llantaRefaccion" id="llantaRefaccion" type="checkbox" value="1">Llanta de refacci&oacute;n
					<input name="gato" id="gato" type="checkbox" value="1">Gato
					<input name="llaveCruz" id="llaveCruz" type="checkbox" value="1">Llave de cruz
				</fieldset>
				
				<button id="btnGuardaRegistroSalida" class="button" type="submit" value="Registrar entrada" >Registrar entrada</button>
			</form>
			
			<?php
			
			break; //Fin del case 3 

	}
?>