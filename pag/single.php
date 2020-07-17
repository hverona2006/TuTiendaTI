<?php require("../pag/header.php");

$prod=$_REQUEST["prod"];
$cc=count($_SESSION["carrito"]["prod"]);
?>
<section class="single">
  <div class="container-fluid justify-content-center">
    <div class="row text-center align-items-center">
      <?php
      $mas = "1.20";
      $sql="SELECT id,nombre,precio,existencias,descripcion FROM mproductos WHERE id=?";
      $init=mysqli_stmt_init($conexion);
      $prep=mysqli_stmt_prepare($init,$sql);
      if($prep){
        mysqli_stmt_bind_param($init, 'i', $prod);
        if(mysqli_stmt_execute($init)) {
          mysqli_stmt_bind_result($init, $a,$b,$c,$d,$e);
          while (mysqli_stmt_fetch($init)) {
        ?>
        <div class="col"></div>
        <div class="col"></div>
        <div class="col-md-4 text-center">
          <br />
          <br />
          <h3 class="m_3"><?php echo $b;?></h3>
          <div class="price_single">
            <input type="hidden" class="price-<?php echo $prod; ?>" value="<?php echo $c; ?>"></input>
            <div class="w-100"><span class="reducedfrom">$ <?php echo number_format($c*$mas,0,",","."); ?> COP</span></div>
            <div class="w-100"><span class="actual">$ <?php echo number_format($c,0,",","."); ?> COP</span></div>
          </div>
          <div class="row">
            <div class="col"></div>
            <div class="col-sm-7 d-flex justify-content-center align-items-center">
              <input type="hidden" id="ex" value="<?php echo $d; ?>"/>
              <button class="btn btn-info" id="menos" value="<?php echo $a; ?>"><span class="icon-minus"></span></button>
              <input id="cant-<?php echo $a; ?>" class="col-6 text-center" type="text" value="1" readonly>
              <button class="btn btn-info" id="mas" value="<?php echo $a; ?>"><span class="icon-plus"></span></button>
            </div>
            <div class="col"></div>
          </div>
          <br />
          <button type="button" class="btn btn-warning addcart-s" value="<?php echo $a; ?>"><span class="icon-shopping-cart"></span> Añadir al carrito</button>
          <br />
          <br />
          <p class="text-secondary"><?php echo nl2br($e); ?></p>
        </div>
      <? } } } ?>
        <div class="col-md-7 justify-content-center">
          <div class="fotorama" data-nav="thumbs" data-width="100%" data-ratio="810/540" data-loop="true" data-arrows="true">
            <?php
            $sqlph="SELECT photo FROM mphotos WHERE MProductos_id=$a LIMIT 6";
            $qph=mysqli_query($conexion,$sqlph);
            while ($ph=mysqli_fetch_array($qph)) { ?>
              <a href="../photo/<?php echo $ph['photo']; ?>">
                <?php echo "<img src='../photo/thumbs-sm/sm-".$ph['photo']."' width='100' height='100'></a>" ; ?>
              </a>
            <?php } ?>
          </div>
        </div>
        <div class="col"></div>
      </div>
    </div>
</section>
<?php require("../pag/footer.php");
mysqli_stmt_close($init); ?>
