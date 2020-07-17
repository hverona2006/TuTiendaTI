<?php
require("header.php");
$sp=$_SESSION["carrito"]["prod"];
$sc=$_SESSION["carrito"]["cant"];
$sts=$_SESSION["carrito"]["sts"];
$count=count($sp);
$st=[];
$prods=implode(",",$sp);
$cants=implode(",",$sc);
$gt=array_sum($sts);
if($prods){
  $sqlP="SELECT id, nombre, precio FROM mproductos WHERE id IN($prods)";
  $result=mysqli_query($conexion,$sqlP);
  $i=0;
  ?>
  <div class="row h-100 w-100 justify-content-center text-center">
    <div class="col-lg-6 col-12 cont-cart table-responsive-sm text-center">
        <h5 class="bg-light text-dark text-center font-weight-bold">Mi Carrito</h5>
      <table class="table total">
        <thead>
          <tr>
            <th scope="col">Producto</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Valor unitario</th>
            <th scope="col">Subtotal</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $rows=mysqli_num_rows($result);
          if($rows>0){
            while($fila=mysqli_fetch_assoc($result)){ ?>
              <tr>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $sc[$i]; ?></td>
                <td><?php echo "$ ".number_format($fila['precio'],0,",","."); ?></td>
                <td><?php echo "$ ".number_format($sts[$i],0,",","."); ?></td>
                <td class="text-center"><button class="btn btn-danger elim-prod" data-prod="<?php echo $fila['id']; ?>"><span class="icon-circle-with-cross"></span></button></td>
              </tr>
              <?php $st++; $i++; } } ?>
            </tbody>
          </table>
          <button class="btn btn-danger emptycart"><span class="icon-trash"></span> Vaciar Carrito</button>
        </div>
        <div class="col-lg-4 col-12 text-center cont-cart">
          <div class="total item">
            <div class="p-3 mb-2 bg-light text-dark">
              <h5 class="text-center font-weight-bold">Resumen de la compra</h5>
            </div>
            <table class="table">
              <tbody class="item text-center">
                <tr>
                  <?php if($gt>75000){ ?>
                  <td colspan="2"><strong>¡Envío gratis!</strong></td>
                <?php }else{ ?>
                  <td colspan="2"><strong>Envío contraentrega. El valor del envío lo pagas en tu domicilio.</strong></td>
                <?php } ?>
                </tr>
              </tbody>
              <tfoot class="info-total">
                <tr class="">
                  <td>Total a pagar:</td>
                  <td><strong><?php echo "$ ".number_format($gt,0,",","."); ?></strong></td>
                </tr>
              </tfoot>
            </div>
          </table>
          <form>
            <div class="col-12 form-group">
              <div class="form-check text-center" id="div-term">
                <input class="form-check-input" type="checkbox" value="" id="terminos">
                <label class="form-check-label" for="terminos" id="textoterminos">
                  <i>
                    Autorizo a que mis datos sean manejados conforme a la <a href="politica-tratamiento-datos">Política de Tratamiento de Datos</a>, y he leído y aceptado los <a href="tyc">Términos y Condiciones</a> del sitio. (Requerido)
                  </i>
                </label>
                <br />
                <br />
              </div>
              <p class="text-danger">Por favor, verifica y rectifica tus datos cuando te sean solicitados.</p>
            </div>
          </form>
          <div class="col botones">
            <a class="btn btn-warning disabled" id="ir-pagar"> Ir a pagar</a>
          </div>
        </div>
        </div>
      <?php }else{ ?>
      <div class="container">
        <br />
          <h4 id=""class="text-center">Tu carrito está vacío. Haz clic en el botón "Catálogo" o <a class="text-info" href="/">aquí</a> para volver al inicio y comprar un producto.</h4>
      </div>
      <?php } $i=0;?>
    <br />
    <br />
<?php require("footer.php"); ?>
