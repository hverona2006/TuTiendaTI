<?php
require('header.php');
$sp=$_SESSION["carrito"]["prod"];
$sc=$_SESSION["carrito"]["cant"];
$sts=$_SESSION["carrito"]["sts"];
require('../php/conexion.php');
$ApiKey = "sI1ECeWoKJ1v9H3ZQmw218S2XF";
// $ApiKey = "4Vj8eK4rloUd272L48hsrarnUA";
$merchant_id = $_REQUEST['merchantId'];
$referenceCode = $_REQUEST['referenceCode'];
$TX_VALUE = $_REQUEST['TX_VALUE'];
$New_value = number_format($TX_VALUE, 1, '.', '');
$currency = $_REQUEST['currency'];
$transactionState = $_REQUEST['transactionState'];
$firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
$firmacreada = md5($firma_cadena);
$firma = $_REQUEST['signature'];
$reference_pol = $_REQUEST['reference_pol'];
$cus = $_REQUEST['cus'];
$buyerEmail = $_REQUEST['buyerEmail'];
$extra1 = $_REQUEST['description'];
$pseBank = $_REQUEST['pseBank'];
$lapPaymentMethod = $_REQUEST['lapPaymentMethod'];
$transactionId = $_REQUEST['transactionId'];
$ur=null;
if ($transactionState == 4 ) {
	$estadoTx = "Transacción aprobada";
	$sqlDC="SELECT CONCAT(c.direccion,' - ',m.mun,', ',d.dep) AS direnv FROM mcliente c,depart d,muns m WHERE c.departamento=d.id_dep AND c.municipio=m.id_mun AND m.id_dep=d.id_dep AND c.email='$buyerEmail'";
	$queryDC=mysqli_query($conexion, $sqlDC);
	$fetchDC=mysqli_fetch_array($queryDC);
	$direnv=$fetchDC['direnv'];
	$sqlUR=mysqli_query($conexion, "select LAST_INSERT_ID(id), ref as lastref from mpedidos order by id desc limit 0,1 ");
	$fur=mysqli_fetch_array($sqlUR);
	$ur=$fur['lastref'];
	$rows=mysqli_num_rows($sqlUR);
	if($ur!=$referenceCode || $rows == 0){
		$sql="UPDATE mcliente SET activo=1 WHERE email=".$buyerEmail;
		mysqli_query($conexion,$sql);
		$sqlP="INSERT INTO mpedidos (ref,fecha,estado,total,email_cliente,dir_envio)
		VALUES('$referenceCode',SYSDATE(),1,$TX_VALUE,'$buyerEmail','$direnv')";
		mysqli_query($conexion,$sqlP);
		$sqlLID=mysqli_query($conexion, "select LAST_INSERT_ID(id) as last from mpedidos order by id desc limit 0,1 ");
		$up=mysqli_fetch_array($sqlLID);
		$idnp=$up['last'];
		for ($i=0; $i < count($sp) ; $i++) {
			$sqlIP="INSERT INTO mitempedidos (MPedidos_id, MProductos_id, cantidad, subtotal)
			VALUES ($idnp,$sp[$i],$sc[$i],$sts[$i])";
			mysqli_query($conexion,$sqlIP);
			// $sqlIP="INSERT INTO mconsdetped (MPedidos_id, MProductos_id, cantidad, subtotal)
			// VALUES ($idnp,$sp[$i],$sc[$i],$sts[$i])";
			// mysqli_query($conexion,$sqlIP);
			$sqlCExt="SELECT existencias FROM mproductos WHERE id=$sp[$i]";
			$queryCExt=mysqli_query($conexion,$sqlCExt);
			$fetchCExt=mysqli_fetch_assoc($queryCExt);
			$uex=$fetchCExt['existencias']-$sc[$i];
			$sqlUExt="UPDATE mproductos SET existencias=$uex WHERE id=$sp[$i]";
			mysqli_query($conexion,$sqlUExt);
		}
		$sp=[];
		$sc=[];
		$sts=[];
		$_SESSION["carrito"]["prod"]=$sp;
		$_SESSION["carrito"]["cant"]=$sc;
		$_SESSION["carrito"]["sts"]=$sts;
		$_SESSION["email"]=NULL;
	}
}

else if ($transactionState == 6 ) {
	$estadoTx = "Transacción rechazada";
}

else if ($transactionState == 104 ) {
	$estadoTx = "Error";
}

else if ($transactionState == 7 ) {
	$estadoTx = "Transacción pendiente";
}

else {
	$estadoTx=$_REQUEST['mensaje'];
}


if (strtoupper($firma) == strtoupper($firmacreada)) {
	?>
	<br />
	<br />
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-12"></div>
			<div class="col-lg-6 col-12">
				<h2 class="text-center">Resumen Transacción</h2>
				<table class="table">
					<tr>
						<td>Estado de la transaccion</td>
						<td><strong><?php echo $estadoTx; ?></strong></td>
					</tr>
					<tr>
						<tr>
							<td>ID de la transaccion</td>
							<td><strong><?php echo $transactionId; ?></strong></td>
						</tr>
						<tr>
							<td>Referencia de la venta</td>
							<td><strong><?php echo $reference_pol; ?></strong></td>
						</tr>
						<tr>
							<td>Referencia de la transaccion</td>
							<td><strong><?php echo $referenceCode; ?></strong></td>
						</tr>
						<tr>
							<?php
							if($pseBank != null) {
								?>
								<tr>
									<td>cus </td>
									<td><strong><?php echo $cus; ?></strong></td>
								</tr>
								<tr>
									<td>Banco </td>
									<td><strong><?php echo $pseBank; ?></strong></td>
								</tr>
								<?php
							}
							?>
							<tr>
								<td>Valor total</td>
								<td><strong>$<?php echo number_format($TX_VALUE); ?></strong></td>
							</tr>
							<tr>
								<td>Moneda</td>
								<td><strong><?php echo $currency; ?></strong></td>
							</tr>
							<tr>
								<td>Descripción</td>
								<td><strong><?php echo ($extra1); ?></strong></td>
							</tr>
							<tr>
								<td>Entidad:</td>
								<td><strong><?php echo ($lapPaymentMethod); ?></strong></td>
							</tr>
						</table>
						<?php
					}
					else
					{
						?>
						<h1>Error validando firma digital.</h1>
					<?php } ?>
					<br />
					<br />
					<?php if($ur==$referenceCode){ echo "<p class='text-center text-danger'>Tu transacción ya fue procesada. Por favor vuelve a la página principal.</p>"; } ?>
					<a class="btn btn-block btn-info" style="color:#fff !important;" href="/"><span class="icon-home"></span> Volver al inicio</a>
			</div>
			<div class="col-lg-3 col-12"></div>

		</div>
	</div>
<?php require('footer.php'); ?>
