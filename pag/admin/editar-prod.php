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
    require('../../php/conexion.php');
    $idprod=$_REQUEST['idprod'];
    $query=mysqli_query($conexion,"SELECT * FROM mproductos WHERE id= $idprod");
    $fetch=mysqli_fetch_assoc($query);
		?>
			<form id="formEditarProd">
        <input type="hidden" id="idprod" value="<?php echo $fetch['id']; ?>" />
				<div class="form-group">
					<label class="control-label" for="cat">Categoría:</label>
					<select class="form-control" name="cat" id="cat" placeholder="Seleccione categoría">
						<option value="1" <?php if(!strcmp($fetch["categoria"],1)) { ?>selected<?php } ?>>Audio</option>
						<option value="2" <?php if(!strcmp($fetch["categoria"],2)) { ?>selected<?php } ?>>Video</option>
						<option value="3" <?php if(!strcmp($fetch["categoria"],3)) { ?>selected<?php } ?>>Tecnología</option>
						<option value="4" <?php if(!strcmp($fetch["categoria"],4)) { ?>selected<?php } ?>>Electrónica</option>
						<option value="5" <?php if(!strcmp($fetch["categoria"],5)) { ?>selected<?php } ?>>Cuidado personal</option>
					</select>
				</div>
				<div class="form-group">
					<label class="control-label" for="nombre">Nombre del producto:</label>
					<input class="form-control" name="nombre" id="nombre" placeholder="Tipo de producto" value="<?php echo $fetch["nombre"]; ?>">
				</div>
				<div class="form-group">
					<label class="control-label" for="precio">Precio de venta:</label>
					<input class="form-control" name="precio" id="precio" placeholder="Precio de venta" value="<?php echo $fetch["precio"]; ?>">
				</div>
				<div class="form-group">
					<label class="control-label" for="existencias">Existencias iniciales:</label>
					<input class="form-control" name="existencias" id="existencias" placeholder="Existencias" value="<?php echo $fetch["existencias"]; ?>">
				</div>
				<div class="form-group">
			    <label class="control-label" for="descripcion">Descripción:</label>
			    <textarea rows="3" class="form-control" name="descripcion" id="descripcion" placeholder="Descripción"><?php echo $fetch["descripcion"]; ?></textarea>
			  </div>
				<div class="form-group form-check">
					<input type="checkbox" class="form-check-input" name="activo" id="activo" <?php if($fetch['activo']==1){ ?>checked<?php } ?>>
					<label class="form-check-label" for="activo">¿Activo?</label>
				</div>
				<div class="form-group form-check">
					<input type="checkbox" class="form-check-input" name="inicio" id="inicio" <?php if($fetch['destacado']==1){ ?>checked<?php } ?> <?php if($fetch['activo']==0){ ?>disabled<?php } ?>>
					<label class="form-check-label" for="inicio">Promocional? (página de inicio)</label>
				</div>
				<!-- <div class="form-group">
					<label class="control-label" for="fotos"><strong>Agregue fotografías</strong></label>
					<input type="file" class="form-control-file" multiple="multiple" enctype="multipart/form-data" id="fotos"></div> -->
				</form>
			<?php } }?>
