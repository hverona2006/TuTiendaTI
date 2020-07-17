<?php require("header.php");?>
<section>
  <?php
  $consultap="SELECT * FROM mproductos WHERE activo=1";
  $resultado=mysqli_query($conexion,$consultap);
  ?>
  <div class="main" id="main">
    <div class="container-fluid wrap">
      <a class='catego'><h4>¡Disfruta de nuestro amplio catálogo de productos!</h4>
        <?php
        for ($i=1; $i <=5 ; $i++) {
          switch ($i) {
            case 1:
            $cat="<a class='catego text-center' href='categorias?cat=1'><h5>Audio</h5></a><hr />";
            break;
            case 2:
            $cat="<a class='catego text-center' href='categorias?cat=2'><h5>Video</h5></a><hr />";
            break;
            case 3:
            $cat="<a class='catego text-center' href='categorias?cat=3'><h5>Tecnología</h5></a><hr />";
            break;
            case 4:
            $cat="<a class='catego text-center' href='categorias?cat=4'><h5>Electrónica</h5></a><hr />";
            break;
            case 5:
            $cat="<a class='catego text-center' href='categorias?cat=5'><h5>Cuidado Personal</h5></a><hr />";
            break;
          }
          echo $cat;
          ?>
          <div class="row justify-content-center text-center">
            <?php
            $consultap="SELECT * FROM mproductos WHERE activo=1 AND categoria=$i";
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
                    <a href="single?prod=<?php echo $fila["id"]; ?>" id="despro"><?php echo "<img src='../photo/thumbs-md/md-".$ph['photo']."'>"; ?></a>
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
                        <button type="button" class="btn btn-warning addcart-s" value="<?php echo $fila["id"]; ?>"><span class="icon-shopping-cart"></span> Añadir al carrito</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } }else{
              echo "<p class='price'>Próximamente...</p>";
            }?>
          </div>
          <br />
        <?php } ?>
      </div>
  </div>
</section>
<?php require("footer.php");?>
