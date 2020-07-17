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
		$sql="SELECT mpedidos.ref,mpedidos.id, mpedidos.fecha, mpedidos.estado, mpedidos.total
    FROM mcliente INNER JOIN mpedidos ON mcliente.email=mpedidos.email_cliente ORDER BY mpedidos.fecha DESC";
		$query=mysqli_query($conexion,$sql);
		$rows=mysqli_num_rows($query);
if($rows>0){
  while($fetch=mysqli_fetch_assoc($query)){
    ?>
    <tr <?php
		switch ($fetch["estado"]) {
			case 0:
				echo "class='table-danger'";
				break;
			case 1:
				echo "class='table-warning'";
				break;
			case 2:
				echo "class='table-success'";
				break;
		}
		?>
		>
			<td><?php echo $fetch["ref"]; ?></td>
			<td><?php echo strftime("%A, %d de %B de %Y, %r",strtotime($fetch["fecha"])); ?></td>
      <td>$ <?php echo number_format($fetch['total'],0,",","."); ?></td>
      <td>
        <?php
        switch ($fetch["estado"]) {
          case 0:
            echo "Cancelado/devuelto";
            break;
          case 1:
            echo "Pendiente de envío";
            break;
          case 2:
            echo "Enviado";
            break;
        }
        ?>
      </td>
    <td>
      <button class="btn btn-info" id="it-ped" data-idped="<?php echo $fetch['id']; ?>">
        <span class="icon-eye"></span> Detalles
      </button>
    </td>
		<td><button class="btn btn-success cam-est" value="2" data-ref="<?php echo $fetch["ref"]; ?>" data-idped="<?php echo $fetch['id']; ?>" <?php if($fetch["estado"]==2){ ?>disabled<?php } ?>><span class="icon-check"></span></button></td>
		<td><button class="btn btn-warning cam-est" value="1" data-ref="<?php echo $fetch["ref"]; ?>" data-idped="<?php echo $fetch['id']; ?>" <?php if($fetch["estado"]==1){ ?>disabled<?php } ?>><span class="icon-warning"></span></button></td>
		<td><button class="btn btn-danger cam-est" value="0" data-ref="<?php echo $fetch["ref"]; ?>" data-idped="<?php echo $fetch['id']; ?>" <?php if($fetch["estado"]==0){ ?>disabled<?php } ?>><span class="icon-back"></span></button></td>
  </tr>
<?php } }else{ ?>
  <tr><td colspan="8"><h3>No existen registros en esta tabla.</h3></td></tr>
<?php } } } ?>
