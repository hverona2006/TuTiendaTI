<?php
session_set_cookie_params(3600); session_start();
if(!$_SESSION["userdata"]){
	echo "<h2 align='center'>No ha iniciado sesion o su sesion fue cerrada. Por favor inicie sesion.<br/><a href='admin'>Salir</a></h2>";
}else{
	require("../../php/firstcheck.php");
	if($fetchVS["login"] == 0) {
		session_destroy();
		echo "<h2 align='center'>No ha iniciado sesion o su sesion fue cerrada. Por favor inicie sesion.<br/><a href='admin'>Salir</a></h2>";
	}else if($fetchVS["tipousr"]!=1){
		echo "<h2 align='center'>Acceso denegado. <br />Por favor, vuelva a la <a href='/'>página principal.</a></h2>.";
	}else{
		?>
		<script>
		function readURL(input) {
	    var o = $(input).attr("data-order");
	    if (input.files && input.files[0]) {
	      var reader = new FileReader();

	      reader.onload = function(e) {
	        $('#output'+o).attr('src', e.target.result);
	      }

	      reader.readAsDataURL(input.files[0]);
	    }
	  }

	  $(".fotos").on("change",function() {
	    var o = $(this).attr("data-order");
	    readURL(this);
	    $("#output"+o).removeAttr('hidden');
	  });
		</script>
			<form id="formNuevoProd">
				<div class="form-group">
					<label class="control-label" for="cat">Categoría:</label>
					<select class="form-control" name="cat" id="cat" placeholder="Seleccione categoría">
						<option value="1">Audio</option>
						<option value="2">Video</option>
						<option value="3">Tecnología</option>
						<option value="4">Electrónica</option>
						<option value="5">Cuidado personal</option>
					</select>
				</div>
				<div class="form-group">
					<label class="control-label" for="nombre">Nombre del producto:</label>
					<input class="form-control" name="nombre" id="nombre" placeholder="Tipo de producto">
				</div>
				<div class="form-group">
					<label class="control-label" for="precio">Precio de venta:</label>
					<input class="form-control" name="precio" id="precio" placeholder="Precio de venta">
				</div>
				<div class="form-group">
					<label class="control-label" for="existencias">Existencias iniciales:</label>
					<input class="form-control" name="existencias" id="existencias" placeholder="Existencias">
				</div>
				<div class="form-group">
			    <label class="control-label" for="descripcion">Descripción:</label>
			    <textarea rows="3" class="form-control" name="descripcion" id="descripcion" placeholder="Descripción"></textarea>
			  </div>
				<div class="form-group form-check">
					<input type="checkbox" class="form-check-input" name="activo" id="activo">
					<label class="form-check-label" for="activo">¿Activo?</label>
				</div>
				<div class="form-group form-check">
					<input type="checkbox" class="form-check-input" name="inicio" id="inicio" disabled>
					<label class="form-check-label" for="inicio">Promocional? (página de inicio)</label>
				</div>
				<div class="form-group">
					<label class="control-label" for="fotos"><strong id="fprinc">Fotografía principal (requerida)</strong></label>
					<input class="fotos" id="fotos1" data-order="1" type="file"/>
					<img id="output1" height="70" width="70" hidden>
				</div>
				<div class="form-group">
					<label class="control-label" for="fotos"><strong>Fotografías secundarias (opcional)</strong></label>
					<br />
					<input class="fotos" id="fotos2" data-order="2" type="file"/>
					<img id="output2" height="70" width="70" hidden>
					<br />
					<br />
					<input class="fotos" id="fotos3" data-order="3" type="file"/>
					<img id="output3" height="70" width="70" hidden>
					<br />
					<br />
					<input class="fotos" id="fotos4" data-order="4" type="file"/>
					<img id="output4" height="70" width="70" hidden>
					<br />
					<br />
					<input class="fotos" id="fotos5" data-order="5" type="file"/>
					<img id="output5" height="70" width="70" hidden>
					<br />
					<br />
					<input class="fotos" id="fotos6" data-order="6" type="file"/>
					<img id="output6" height="70" width="70" hidden>
					<br />
					<br />
				</form>
			<?php } }?>
