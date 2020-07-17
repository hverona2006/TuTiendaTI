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
		$sql="SELECT * FROM mproductos ORDER BY id";
		$query=mysqli_query($conexion,$sql);
		$rows=mysqli_num_rows($query);
if($rows>0){
  while($fetch=mysqli_fetch_assoc($query)){
    ?>
    <tr>
      <td><?php echo $fetch["nombre"]; ?></td>
      <td><?php echo number_format($fetch['precio'],0,",","."); ?></td>
      <td><?php echo $fetch["existencias"]; ?></td>
      <td><?php if($fetch["activo"]==0){echo "Inactivo";}else{echo "Activo";} ?></td>
			<!-- <td>
        <button class="btn btn-secondary ver-ph" data-idprod=" <?php // echo $fetch["id"]; ?>">
          <span class="icon-camera"></span> Ver fotos
        </button>
      </td>
    </td> -->
    <td colspan="2">
      <button class="btn btn-warning editar-prod" data-cat="<?php echo $fetch['categoria']; ?>" data-idprod="<?php echo $fetch["id"]; ?>">
        <span class="icon-pencil"></span> Editar datos
      </button>
    </td>
  </tr>
<?php } }else{ ?>
  <tr><td colspan="8"><h3>No existen registros en esta tabla.</h3></td></tr>
<?php } } } ?>
