<?php require("header.php");?>
<section>
  <?php
  $cat=$_REQUEST["cat"];
  $sql="SELECT id,nombre,precio,existencias FROM mproductos WHERE activo=1 and categoria=?";
  $init=mysqli_stmt_init($conexion);
  $prep=mysqli_stmt_prepare($init,$sql);

  ?>
  <div class="main" id="main">
    <div class="container-fluid wrap">
      <?php
      if($prep){
        if($cat<=5){
            mysqli_stmt_bind_param($init, 'i', $cat);
        }
        if(mysqli_stmt_execute($init)) {
      switch ($cat) {
        case 1:
        echo "<div class='catego'><h4>Audio</h4></div>";
        break;
        case 2:
        echo "<div class='catego'><h4>Video</h4></div>";
        break;
        case 3:
        echo "<div class='catego'><h4>Tecnología</h4></div>";
        break;
        case 4:
        echo "<div class='catego'><h4>Electrónica</h4></div>";
        break;
        case 5:
        echo "<div class='catego'><h4>Cuidado Personal</h4></div>";
        break;
      }
      ?>
      <div class="row justify-content-center">
        <?php
        mysqli_stmt_store_result($init);
        if(mysqli_stmt_num_rows($init)!=0){
          mysqli_stmt_bind_result($init, $a,$b,$c,$d);
          while (mysqli_stmt_fetch($init)) {
          ?>
          <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3 shadow text-center">
            <div class="top_box">
              <div class="nprod">
                <h3 class="m_1"><?php echo $b; ?></h3>
              </div>
              <br />
              <div class="css3 text-center">
              <?php
              $sqlph="SELECT photo FROM mphotos WHERE MProductos_id=$a LIMIT 1";
              $qph=mysqli_query($conexion,$sqlph);
              while ($ph=mysqli_fetch_array($qph)) { ?>
                <a href="single?prod=<?php echo $a; ?>" id="despro"><?php echo "<img src='../photo/thumbs-md/md-".$ph['photo']."'>"; ?></a>
              <?php } ?>
              </div>
              <div>
                <input type="hidden" id="price-<?php echo $a; ?>" value="<?php echo $c; ?>"></input>
                <div class="price">$ <?php echo number_format($c,0,",","."); ?> COP</div>
              </div>
            </div>
            <div class="container-fluid">
              <div class="row">
                <div class="col d-flex justify-content-center align-items-center">
                  <input type="hidden" id="ex" value="<?php echo $d; ?>"/>
                  <button class="btn btn-sm btn-info" id="menos" value="<?php echo $a; ?>"><span class="icon-minus"></span></button>
                  <input id="cant-<?php echo $a; ?>" class="col-6 text-center" type="text" value="1" readonly>
                  <button class="btn btn-sm btn-info" id="mas" value="<?php echo $a; ?>"><span class="icon-plus"></span></button>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="botones">
                    <button type="button" class="btn btn-warning addcart-s" value="<?php echo $a; ?>"><span class="icon-shopping-cart"></span> Añadir al carrito</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } }else{
          echo "<p class='price'>Próximamente...</p>";
        }?>
      </div>
    <?php }else{
      echo '<p class="display-4 text-center">Error inesperado. Vuelva al sitio principal.</p>';
    } } ?>
    </div>
  </div>
</section>
<?php require("footer.php");?>
