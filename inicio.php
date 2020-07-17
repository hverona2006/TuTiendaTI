<?php
$cat="";
$cnct=1;
?>
<section id="slider">
  <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel" align="center">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
      <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <?php
      require("php/conexion.php");
      $slider="SELECT photo FROM mphotos WHERE slider=1 LIMIT 3";
      $productos=mysqli_query($conexion,$slider);
      $c=0;
      while ($img=mysqli_fetch_assoc($productos)) {
        $c+=1;
        ?>
        <div class="carousel-item <?php if($c==1){echo'active';} ?>">
          <?php echo "<img class='d-block' src='photo/".$img['photo']."'>"; ?>
        </div>
      <?php } ?>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
      <span aria-hidden="true">
        <svg class="bi bi-chevron-double-left text-dark" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 010 .708L2.707 8l5.647 5.646a.5.5 0 01-.708.708l-6-6a.5.5 0 010-.708l6-6a.5.5 0 01.708 0z" clip-rule="evenodd"/>
          <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 010 .708L6.707 8l5.647 5.646a.5.5 0 01-.708.708l-6-6a.5.5 0 010-.708l6-6a.5.5 0 01.708 0z" clip-rule="evenodd"/>
        </svg>
      </span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
      <span aria-hidden="true">
        <svg class="bi bi-chevron-double-right text-dark" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 01.708 0l6 6a.5.5 0 010 .708l-6 6a.5.5 0 01-.708-.708L9.293 8 3.646 2.354a.5.5 0 010-.708z" clip-rule="evenodd"/>
          <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 01.708 0l6 6a.5.5 0 010 .708l-6 6a.5.5 0 01-.708-.708L13.293 8 7.646 2.354a.5.5 0 010-.708z" clip-rule="evenodd"/>
        </svg>
      </span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</section>
<section>
  <div class="main" id="main">
    <div class="container-fluid wrap">
      <a class='catego'><h4>Productos destacados</h4>
        <?php
        for ($i=1; $i <=5 ; $i++) {
          switch ($i) {
            case 1:
            $cat="<a class='catego text-center' href='pag/categorias?cat=1'><h5>Audio</h5></a><hr />";
            break;
            case 2:
            $cat="<a class='catego text-center' href='pag/categorias?cat=2'><h5>Video</h5></a><hr />";
            break;
            case 3:
            $cat="<a class='catego text-center' href='pag/categorias?cat=3'><h5>Tecnología</h5></a><hr />";
            break;
            case 4:
            $cat="<a class='catego text-center' href='pag/categorias?cat=4'><h5>Electrónica</h5></a><hr />";
            break;
            case 5:
            $cat="<a class='catego text-center' href='pag/categorias?cat=5'><h5>Cuidado Personal</h5></a><hr />";
            break;
          }
          echo $cat;
          ?>
          <div class="row justify-content-center text-center">
            <?php
            $consultap="SELECT * FROM mproductos WHERE destacado=1 and activo=1 AND categoria=$i LIMIT 5";
            $resultado=mysqli_query($conexion,$consultap);
            $rows=mysqli_num_rows($resultado);
        if($rows>0){
            while ($fila=mysqli_fetch_array($resultado)) { ?>
              <div class="col-12 col-sm-5 col-md-3 col-xl-2 shadow text-center">
                <div class="top_box">
                  <div class="nprod">
                    <h3 class="m_1"><?php echo $fila['nombre']; ?></h3>
                  </div>
                  <br />
                  <div class="css3 text-center">
                  <?php
                  $consultaip="SELECT * FROM mphotos WHERE MProductos_id=" .$fila['id']." LIMIT 1";
                  $resultadoip=mysqli_query($conexion,$consultaip);
                  while ($ph=mysqli_fetch_array($resultadoip)) {
                    ?>
                    <a href="pag/single?prod=<?php echo $fila["id"]; ?>" id="despro"><?php echo "<img src='photo/thumbs-md/md-".$ph['photo']."'>"; ?></a>
                  <?php } ?>
                  </div>
                  <div>
                    <input type="hidden" id="price-<?php echo $fila["id"]; ?>" value="<?php echo $fila['precio']; ?>"></input>
                    <div class="price">$ <?php echo number_format($fila['precio'],0,",","."); ?> COP</div>
                  </div>
                </div>
                <div class="container-fluid">
                  <div class="row">
                    <div class="col d-flex justify-content-center align-items-center">
                      <input type="hidden" id="ex" value="<?php echo $fila['existencias']; ?>"/>
                      <button class="btn btn-sm btn-info" id="menos" value="<?php echo $fila["id"]; ?>"><span class="icon-minus"></span></button>
                      <input id="cant-<?php echo $fila["id"]; ?>" class="col-6 text-center" type="text" value="1" readonly>
                      <button class="btn btn-sm btn-info" id="mas" value="<?php echo $fila["id"]; ?>"><span class="icon-plus"></span></button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="botones">
                        <button type="button" class="btn btn-warning addcart" value="<?php echo $fila["id"]; ?>"><span class="icon-shopping-cart"></span> Añadir al carrito</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } }else{
              echo "<p class='price'>No hay productos destacados.</p>";
            }?>
          </div>
          <br />
        <?php } ?>
        </div>
      </div>
    </div>
  </section>
