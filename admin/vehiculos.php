<?php session_start(); ?>

<?php
	include "utilitiesVehiculos.php";
	
	$opt = $_GET['opt'];
	
	switch ($opt) {
		case 1:
			//Opcion para agregar un Vehiculo
			?>
			<script type="text/javascript">
				$(function(){
					$('#frmAgregaVehiculo').form({
						url:'accionesVehiculos.php',
						onSubmit:function(){
							return $(this).form('validate');
						},
						success:function(data){
							if (data.indexOf('php') > -1)
								document.location = data;
							else
								$('#mensajes').html(data);//data;
						}
					});
				});
			</script>
			<div id="mensajes"></div>
			<h3>Registrar un veh&iacute;culo</h3>
			<form name="frmAgregaVehiculo" id="frmAgregaVehiculo" method="post" >
				<input type="hidden" name="opt" id="opt" value="1" >
				<input type="text" name="txtPlacasV" id="txtPlacasV" placeholder="Placas Anteriores" >
				<input type="text" required="required" name="txtPlacasN" id="txtPlacasN" placeholder="Placas Actuales" >
				<input type="text" required="required" name="txtMarca" id="txtMarca" placeholder="Marca" >
				<input type="text" required="required" name="txtModelo" id="txtModelo" placeholder="Modelo" >
				<input type="text" required="required" name="txtLinea" id="txtLinea" placeholder="Línea" >
				<input type="text" name="txtTanque" id="txtTanque" placeholder="Capacidad Tanque" >
				<input type="text" name="txtKmActual" id="txtKmActual" placeholder="Kilometraje actual" >
				<input type="text" required="required" name="txtNumSerie" id="txtNumSerie" placeholder="Num. Serie" >
				<input type="text" name="txtNumEco" id="txtNumEco" placeholder="Num. Económico" >

				<?php
				$tipoUnidades = listadoTipoUnidades();
				if (!empty($tipoUnidades)):
					?>
					<select name="txtTipoUnidad" id="txtTipoUnidad">
					<?php
					$listadoTipoUnidades = explode("~", $tipoUnidades);
					foreach($listadoTipoUnidades as $tipoUnidades) {
						$datosTipo = explode("|", $tipoUnidades);
						?>
						<option value="<?php print $datosTipo[0] ?>"><?php print $datosTipo[1] ?></option>
						<?php
					}
					?>
					</select>
					<?php
				endif;
				
				$tipoCombustible = listadoTipoCombustible();
				if (!empty($tipoUnidades)):
					?>
					<select name="txtTipoCombustible" id="txtTipoCombustible">
					<?php
					$listadoTipoCombustible = explode("~", $tipoCombustible);
					foreach($listadoTipoCombustible as $tipoCombustible) {
						$datosTipoC = explode("|", $tipoCombustible);
						?>
						<option value="<?php print $datosTipoC[0] ?>"><?php print $datosTipoC[1] ?></option>
						<?php
					}
					?>
					</select>
					<?php
				endif;	
				
				include_once("utilitiesChoferes.php");
				$choferes = listaSimpleChoferes();
				?>
					<select name="txtChoferResguardo" id="txtChoferResguardo">
						<option value="0">Elige el chofer que resguarda este veh&iacute;culo</option>
						<?php
				if (!empty($choferes)) :
					
						$listadoChoferes = explode("~", $choferes);
						foreach ($listadoChoferes as $chofer) {
							$datosChofer = explode("|", $chofer);
							?>
							<option value="<?php print $datosChofer[0] ?>"><?php print $datosChofer[1] ?></option>
							<?php
						}
						
				endif;
				?>
				
					</select>
				
				<input type="text" name="txtNomUnidad" id="txtNomUnidad" placeholder="Nombre de la Unidad" >
				<textarea name="txtDescripcion" id="txtDescripcion"  placeholder="Descripción" cols="80" rows="3"></textarea>
				
				<button class="button" type="submit" value="Guardar vehiculo" >Guardar veh&iacute;culo</button>
			</form>
			<?php
			break; //Fin del case 1
			
		case 2: 
			//Case para listar los usuarios registrados en el sistema
			?>			
			<script>
			$(function(){
				$('#dgVehiculos').datagrid({
					toolbar:[{
						id:'btnAgregar',
						text:'Agregar',
						iconCls:'icon-add',
						handler:function(){
							agregaVehiculo();
						}
					},{
						id:'btnEdit',
						text:'Editar',
						iconCls:'icon-edit',
						handler:function(){
							editaVehiculo();
						}
					},{
						id:'btnDelete',
						text:'Desactivar Vehiculo',
						iconCls:'icon-remove',
						handler:function(){
							//$('#btnsave').linkbutton('enable');
							//alert('cut')
							if (confirm("¿Esta seguro de querer desactivar este Vehiculo?")) {
								desactivaVehiculo();
							}
						}
					}]
				}); 
			});
		
			function editaVehiculo()
			{
				var row = $('#dgVehiculos').datagrid('getSelected');
				if (row == null) {
					alert('Selecciona primero el Vehiculo que quieres editar y luego presiona el botón editar');
				} else {
					$('#mainContent').load('vehiculos.php?opt=3&id='+row.ID);
				}
			}
			
			function desactivaVehiculo() {
				var row = $('#dgVehiculos').datagrid('getSelected');
				$('#mainContent').load('accionesvehiculos.php?opt=4&id='+row.ID);
			}
		
			function agregaVehiculo()
			{
				$('#mainContent').load('vehiculos.php?opt=1');
			}
		
			function recarga()
			{
				$('#dgVehiculos').datagrid('load', {'campo':$('#txtCampoBusqueda').val(), 'estado':$('#txtEstadoBusqueda').val()});
			}
			</script>
        
        	<h3>Veh&iacute;culos</h3>

        	<div id="buscador">
        		<input type="text" id="txtCampoBusqueda" name="txtCampoBusqueda" placeholder="Placas o nombre del veh&iacute;culo" />
        		<label>Estado</label>
        		<select name="txtEstadoBusqueda" id="txtEstadoBusqueda" style="width:90px; display:inline-block;" >
        			<option value="1">Activos</option>
        			<option value="0">Inactivos</option>
        		</select>
        		<input type="button" id="btnBuscar" name="Buscar" class="button" value="Buscar" onclick="recarga()" />
        	</div>
        
			<table id="dgVehiculos" title="Vehiculos" class="easyui-datagrid" style="width:800px;height:720px"  
        		url="accionesVehiculos.php?opt=2"  
        		rownumbers="true" fitColumns="true" singleSelect="true" pagination="true" pageSize="50" nowrap="false">  
	    	<thead>  
    	    	<tr>  
        	    	<th field="PLACAS" width="50">Placas</th>  
            		<th field="KM" width="50">Kilometraje</th>
            		<th field="DESCRIPCION" width="50">Descripcion</th>  
					<th field="NECONOMICO" width="50">No. Economico</th> 
					<th field="UNIDAD" width="50">Tipo Unidad</th> 
					<th field="COMBUSTIBLE" width="50">Tipo Combustible</th> 					
        		</tr>  
	    	</thead>  
			</table>
			
			<?php
			break;//Fin del case 2
		
		case 3 :
			//Caso para editar la información de un Vehiculo
			$idVehiculo = $_GET['id'];
			$Vehiculo = obtenDatosVehiculo($idVehiculo);
			
			$datosVehiculo = explode("|", $Vehiculo);
			//nombre|ap_paterno|ap_materno|num_licencia|vigencia_licencia|activo
			
			?>
			
			<script type="text/javascript">
				$(function(){
					$('#frmModificaVehiculo').form({
						url:'accionesVehiculos.php',
						onSubmit:function(){
							return $(this).form('validate');
						},
						success:function(data){
							//$.messager.alert('Info', data, 'info');
							if (data.indexOf('php') > -1)
								document.location = data;
							else
								$('#mensajes').html(data);//data;
						}
					});
				});
			</script>
			<div id="mensajes"></div>
			<h3>Modificar veh&iacute;culo</h3>
			<form name="frmModificaVehiculo" id="frmModificaVehiculo" method="post" >
				<input type="hidden" name="opt" id="opt" value="3" >
				<input type="hidden" name="idVehiculoAModificar" id="idVehiculoAModificar" value="<?php print $idVehiculo ?>" >
				<input type="text" name="txtPlacasV" id="txtPlacasV" placeholder="Placas Anteriores"  value="<?php print $datosVehiculo[0]; ?>">
				<input type="text" required="required" name="txtPlacasN" id="txtPlacasN" placeholder="Placas Actuales"  value="<?php print $datosVehiculo[1]; ?>">
				<input type="text" required="required" name="txtMarca" id="txtMarca" placeholder="Marca"  value="<?php print $datosVehiculo[2]; ?>">
				<input type="text" required="required" name="txtModelo" id="txtModelo" placeholder="Modelo" value="<?php print $datosVehiculo[3]; ?>">
				<input type="text" required="required" name="txtLinea" id="txtLinea" placeholder="Línea" value="<?php print $datosVehiculo[7]; ?>">
				<input type="text" name="txtTanque" id="txtTanque" placeholder="Capacidad Tanque" value="<?php print $datosVehiculo[4]; ?>">
				<input type="text" name="txtKmActual" id="txtKmActual" placeholder="Kilometraje actual" value="<?php print $datosVehiculo[5]; ?>">
				<input type="text" required="required" name="txtNumSerie" id="txtNumSerie" placeholder="Num. Serie" value="<?php print $datosVehiculo[9]; ?>">
				<input type="text" name="txtNumEco" id="txtNumEco" placeholder="Num. Económico" value="<?php print $datosVehiculo[12]; ?>">
				<?php
				$tipoUnidades = listadoTipoUnidades();
				if (!empty($tipoUnidades)):
					?>
					<select name="txtTipoUnidad" id="txtTipoUnidad">
					<?php
					$listadoTipoUnidades = explode("~", $tipoUnidades);
					foreach($listadoTipoUnidades as $tipoUnidades) {
						$datosTipo = explode("|", $tipoUnidades);
						?>
						<option value="<?php print $datosTipo[0] ?>" <?php if ($datosTipo[0] == $datosVehiculo[10]) { print "selected"; } ?> ><?php print $datosTipo[1] ?></option>
						<?php
					}
					?>
					</select>
					<?php
				endif;
				
				$tipoCombustible = listadoTipoCombustible();
				if (!empty($tipoUnidades)):
					?>
					<select name="txtTipoCombustible" id="txtTipoCombustible">
					<?php
					$listadoTipoCombustible = explode("~", $tipoCombustible);
					foreach($listadoTipoCombustible as $tipoCombustible) {
						$datosTipoC = explode("|", $tipoCombustible);
						?>
						<option value="<?php print $datosTipoC[0] ?>" <?php if ($datosTipo[0] == $datosVehiculo[11]) { print "selected"; } ?> ><?php print $datosTipoC[1] ?></option>
						<?php
					}
					?>
					</select>
					<?php
				endif;			
				
				//Chofer resguardando vehiculo
				include_once("utilitiesChoferes.php");
				$choferes = listaSimpleChoferes();
				$chofeResguardando = obtenDatosChofer($datosVehiculo[14]);
				$datosChoferResguardando = explode("|", $chofeResguardando);
				?>
					<label>Chofer resguardando: <?php print $datosChoferResguardando[0] . " " . $datosChoferResguardando[1] . " " . $datosChoferResguardando[2] ?>. Cambiar por: </label>
					<select name="txtChoferResguardo" id="txtChoferResguardo">
						<option value="0">Elige el chofer que resguarda este veh&iacute;culo</option>
						<?php
				if (!empty($choferes)) :
					
						$listadoChoferes = explode("~", $choferes);
						foreach ($listadoChoferes as $chofer) {
							$datosChofer = explode("|", $chofer);
							?>
							<option value="<?php print $datosChofer[0] ?>"><?php print $datosChofer[1] ?></option>
							<?php
						}
						
				endif;
				?>
				
					</select> <!-- #txtChoferResguardo -->
					
				<input type="text" name="txtNomUnidad" id="txtNomUnidad" placeholder="Nombre de la Unidad"  value="<?php print $datosVehiculo[6]; ?>">
				<textarea name="txtDescripcion" id="txtDescripcion"  placeholder="Descripción" cols="80" rows="3"><?php print $datosVehiculo[8]; ?></textarea>

				<select name="txtEstado" id="txtEstado">
					<option value="1" <?php if ($datosVehiculo[13] == 1) { print "selected"; } ?> >Activo</option>
					<option value="0" <?php if ($datosVehiculo[13] == 0) { print "selected"; } ?> >Inactivo</option>
				</select>
				<button class="button" type="submit" value="Actualizar usuario" >Actuaizar usuario</button>
			</form>
			
			<?php
			
			break; //Fin del case 3 

	}
?>