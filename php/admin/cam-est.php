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
    require("../conexion.php");
    $est=$_REQUEST["est"];
    $idped=$_REQUEST["idped"];
    $res=false;

    $sql="UPDATE mpedidos SET estado=$est WHERE id=$idped";
    if(mysqli_query($conexion,$sql)){
      $res=true;
    }else{
      $res=false;
    }
    echo $sql;
  }
}
?>
