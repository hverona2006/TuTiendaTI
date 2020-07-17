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
    $idped=$_REQUEST['idped'];
    $sql="SELECT ip.*, pr.nombre, pr.precio FROM mitempedidos ip, mpedidos p, mproductos pr
    WHERE ip.MPedidos_id=p.id AND ip.MProductos_id=pr.id AND p.id=$idped";
    $query=mysqli_query($conexion,$sql);
		$rows=mysqli_num_rows($query);
    $queryTR=mysqli_query($conexion,"SELECT p.ref, p.dir_envio, p.total, c.nombres, c.apellidos, c.doc ,c.email, c.direccion, c.telefono
			FROM mpedidos p, mcliente c WHERE p.email_cliente=c.email AND p.id=$idped");
    $fetchTR=mysqli_fetch_assoc($queryTR);
?>
<div class="text-center">
  <strong>Identificador del pedido: <?php echo $fetchTR['ref']; ?></strong><br />
  <strong>Nombre del cliente: <?php echo $fetchTR['nombres']." ".$fetchTR['apellidos']; ?></strong><br />
  <strong>Documento: <?php echo $fetchTR['doc']; ?></strong><br />
  <strong>Dirección de envío: <?php echo $fetchTR['dir_envio']; ?></strong><br />
  <strong>Teléfono: <?php echo $fetchTR['telefono']; ?></strong><br />
  <strong>E-mail: <?php echo $fetchTR['email']; ?></strong><br />

  <br />
<div class="table-responsive-sm text-center">
  <table class="table it-ped">
    <thead>
      <tr>
        <th scope="col">Producto</th>
        <th scope="col">Valor unitario</th>
        <th scope="col">Cantidad</th>
        <th scope="col">Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if($rows>0){
        while($fetch=mysqli_fetch_assoc($query)){
          ?>
          <tr>
            <td><?php echo $fetch["nombre"]; ?></td>
            <td>$ <?php echo number_format($fetch['precio'],0,",","."); ?></td>
            <td><?php echo $fetch["cantidad"]; ?></td>
            <td>$ <?php echo number_format($fetch['subtotal'],0,",","."); ?></td>
        </tr>
      <?php } }else{ ?>
        <tr><td colspan="4"><h3>No existen registros en esta tabla.</h3></td></tr>
      <?php } ?>
      <tr><td colspan="4" class="text-right"><strong>Total del pedido: $ <?php echo number_format($fetchTR['total'],0,",","."); ?></strong></td></tr>
    </tbody>
  </table>
</div>
</div>

<?php } } ?>
