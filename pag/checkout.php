<?php
require("header.php");
$email=NULL;
$sp=$_SESSION["carrito"]["prod"];
$sc=$_SESSION["carrito"]["cant"];
$sts=$_SESSION["carrito"]["sts"];
if(isset($_SESSION["email"])){
  $email=$_SESSION["email"];
}
$total=array_sum($_SESSION["carrito"]["sts"]);
$count=count($sp);
$st=[];
$prods=implode(",",$sp);
$cants=implode(",",$sc);
$sqldp="SELECT * FROM depart ORDER BY id_dep";
$querydp=mysqli_query($conexion,$sqldp);
if(count($sp)!=0 && $email!=NULL){

  ?>

  <section>
    <br />
    <br />
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-lg-6 cont-cart text-center">
          <h5 class="bg-light text-dark text-center font-weight-bold">Productos seleccionados</h5>
          <?php  if($prods){
            $sqlP="SELECT id, nombre, precio FROM mproductos WHERE id IN($prods)";
            $result=mysqli_query($conexion,$sqlP);
            $i=0;
            ?>
            <div class="table-responsive-sm">
              <table class="table total">
                <thead>
                  <tr>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Valor unitario</th>
                    <th scope="col">Subtotal</th>
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
                      </tr>
                      <?php $st++; $i++;
                    }
                  } ?>
                </tbody>
              </table>
            </div>
          <?php } ?>
          <table class="table">
            <tbody class="item text-center">
              <tr>
                <?php if($total>75000){ ?>
                  <td colspan="2"><strong>¡Envío gratis!</strong></td>
                <?php }else{ ?>
                  <td colspan="2"><strong>Envío contraentrega. El valor del envío lo pagas en tu domicilio.</strong></td>
                <?php } ?>
              </tr>
            </tbody>
            <tfoot class="info-total">
              <tr class="">
                <td>Total a pagar:</td>
                <td><strong><?php echo "$ ".number_format($total,0,",","."); ?></strong></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="col-12 col-lg-6 dat-fac">
          <form id="formCheckout">
            <fieldset id="datos-fac">
              <h3 class="text-center">DATOS DE FACTURACIÓN</h3>
              <p class="text-center text-danger">Todos los datos son requeridos.</p>
              <h5 class="text-left">1. Datos del Comprador</h5>
              <div class="form-row">
                <div class="col-6 form-group">
                  <label for="email">Correo Electronico</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="micorreo@ejemplo.com" value="<?php echo $email; ?>">
                </div>
                <div class="col-6 form-group">
                  <label for="doc">Cédula o NIT</label>
                  <input type="text" class="form-control" name="doc" id="doc" onkeypress='return event.charCode >= 48 && event.charCode <= 57'/ placeholder="Ej. 1969754924">
                </div>
              </div>
              <div class="form-row">
                <div class="col-12 form-group">
                  <label for="nombre">Nombre completo</label>
                  <input type="text" class="form-control" name="nombre" id="nombre">
                </div>
                <div class="col-12 form-group">
                  <label for="tel">Teléfono/Celular</label>
                  <input type="tel" class="form-control" pattern="[0-9]{10}" name="tel" id="tel" placeholder="Ej: 3102345678 / 0312345678" onkeypress='return event.charCode >= 48 && event.charCode <= 57'/>
                </div>
              </div>
              <h5 class="text-left">2. Datos de envío</h5>
              <div class="form-row ">
                <div class="col-6 form-group">
                  <label for="dep">Departamento</label>
                  <select class="form-control"  name="dep" id="dep">
                    <?php while($fetchdp = mysqli_fetch_assoc($querydp)) { ?>
                      <option value="<?php echo $fetchdp["id_dep"]; ?>"><?php echo $fetchdp["dep"]; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-6 form-group">
                  <label for="mun">Ciudad/Municipio</label>
                  <select class="form-control" name="mun" id="mun">
                  </select>
                </div>
                <div class="col-12 form-group">
                  <label for="dir">Dirección completa</label>
                  <input type="text" class="form-control" name="dir" id="dir" placeholder="Ej: Calle 12 # 34-56 Torre H Apto. 202">
                </div>
              </div>
            </fieldset>
          </form>
          <button class="btn btn-block btn-info" type="button" id="confirmar">Confirmar datos de facturación</button>
        </div>
      </div>
    </div>
    <br />
    <br />
  </section>
<?php }else{ ?>
  <div class="container">
    <br />
    <h4 id=""class="text-center">Tu carrito está vacío, o no iniciaste el proceso de compra debidamente. <a class="text-info" href="/">Volver al inicio</a></h4>
  </div>
<?php } ?>
<br />
<br />
<?php require("footer.php"); ?>
