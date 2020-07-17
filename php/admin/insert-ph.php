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
    require('../conexion.php');
    require('gen-th.php');
    $sqlLP=mysqli_query($conexion, "select LAST_INSERT_ID(id) as lp, categoria as cat from mproductos order by id desc limit 0,1 ");
    $idpr=mysqli_fetch_array($sqlLP);
    $lp=$idpr['lp'];
    $cat=$idpr['cat'];
    $lc="";
    $nn="";
    $i=0;
    switch ($cat) {
      case "1":
      $lc="A-";
      break;
      case "2":
      $lc="V-";
      break;
      case "3":
      $lc="T-";
      break;
      case "4":
      $lc="E-";
      break;
      case "5":
      $lc="C-";
      break;
    }
    if(is_array($_FILES)){
      if(count($_FILES)!=0){
        for ($i=0; $i < count($_FILES) ; $i++) {
          $file_name = explode(".", $_FILES[$i]['name']);
          $allowed_extension = array("jpg", "jpeg", "png");
          if(in_array($file_name[1], $allowed_extension)){
            $foto=$_FILES[$i]["name"];
            $sourcePath = $_FILES[$i]["tmp_name"];
            $targetPath = "../../photo/".$foto;
            move_uploaded_file($sourcePath, $targetPath);
            $suf=$i+1;
            $ext=".".$file_name[1];
            $nn="../../photo/".$lc.$lp."-".$suf.$ext;
            rename($targetPath,$nn);
            $bn=basename($nn);
            $sqlPH="INSERT into mphotos(photo,MProductos_id,slider) VALUES ('$bn',$lp,0)";
            mysqli_query($conexion,$sqlPH);
            $img = icreate($nn);
            $imgmd = resizeAspect($img, 400);
            $imgsm = resizeAspect($img, 100);
            imagejpeg($imgmd,$rtmd."md-".$bn);
            imagejpeg($imgsm,$rtsm."sm-".$bn);
          }
        }
      } else{
        $sqlUP="UPDATE mproductos SET activo=0 WHERE id=$lp";
        mysqli_query($conexion,$sqlUP);
      }
    }
  }
}
?>
