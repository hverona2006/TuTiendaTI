<?php
session_set_cookie_params(3600); session_start();
$email=$_SESSION["email"];
$total=array_sum($_SESSION["carrito"]["sts"]);
require("../php/conexion.php");
require("../php/func-random.php");
$sqlrf=mysqli_query($conexion, "select LAST_INSERT_ID(id) as last from mpedidos order by id desc limit 0,1 ");
$rw=mysqli_fetch_array($sqlrf);
$rfc=$rw['last']+1;
$APIKey="sI1ECeWoKJ1v9H3ZQmw218S2XF";
$rnd=rndstrgen(3);
$hash=hash("md5",$APIKey."~558067~TTI-".$rnd."-".$rfc."~".$total."~COP");
?>
<div class="col-12 text-center">
  <div class="table-responsive-sm">
    <table class="table">
      <tr><th colspan="2">Resumen de datos de facturación</th></tr>
      <tr>
        <td><strong>Nombre:</strong></td>
        <td id="nombre"></td>
      </tr>
      <tr>
        <td><strong>Teléfono:</strong></td>
        <td id="tel"></td>
      </tr>
      <tr>
        <td><strong>Dirección de envío:</strong></td>
        <td id="dir"></td>
      </tr>
      <tr>
        <td><strong>Correo electrónico:</strong></td>
        <td><?php echo $email; ?></td>
      </tr>
    </table>
  </div>
  <form method="post" action="https://checkout.payulatam.com/ppp-web-gateway-payu/">
    <div class="form-row">
      <div class="col-3"></div>
      <div class="col-6 botones">
        <input name="merchantId"    type="hidden"  value="558067"   >
        <input name="accountId"     type="hidden"  value="560486" >
        <input name="description"   type="hidden"  value="Venta en Linea - TuTiendaTI"  >
        <input name="referenceCode" type="hidden"  value="TTI-<?php echo $rnd."-".$rfc; ?>" >
        <input name="amount"        type="hidden"  value="<?php echo $total; ?>"   >
        <input name="tax"           type="hidden"  value="<?php echo $total*.19; ?>"  >
        <input name="taxReturnBase" type="hidden"  value="<?php echo $total*.81; ?>" >
        <input name="currency"      type="hidden"  value="COP" >
        <input name="signature"     type="hidden"  value="<?php echo $hash; ?>">
        <input name="shippingAddress" id="shippingAddress" type="hidden"  value="" >
        <input name="shippingCity" id="shippingCity" type="hidden"  value="" >
        <input name="shippingCountry" type="hidden"  value="CO" >
        <input name="buyerEmail" id="buyerEmail" type="hidden" value="<?php echo $email; ?>" >
        <input name="responseUrl" type="hidden" value="https://www.tutiendati.com/pag/payurespuesta.php" >
        <!-- <input name="confirmationUrl"    type="hidden"  value="http://localhost/tutiendati/pag/payuconfirma.php" > -->
        <p class="text-center text-danger" id="adv-regreso">
          ¡No olvides dar click en "Regresar al sitio de la tienda" al terminar tu transacción!
          Solo así quedará confirmada.
        </p>
        <input class="btn btn-warning" id="submit" type="submit"  value="Ir a página de pago">
      </div>
      <div class="col-3"></div>
    </div>
  </form>
</div>
