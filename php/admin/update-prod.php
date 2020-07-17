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
    $idprod=$_REQUEST["idprod"];
    $cat=$_REQUEST["cat"];
    $nombre=$_REQUEST["nombre"];
    $precio=$_REQUEST["precio"];
    $existencias=$_REQUEST["existencias"];
    $descripcion=$_REQUEST["descripcion"];
    $activo=$_REQUEST["activo"];
    $inicio=$_REQUEST["inicio"];



    $sql="UPDATE mproductos SET
    categoria=$cat, nombre='$nombre', precio=$precio, existencias=$existencias,
    descripcion='$descripcion', activo=$activo, destacado=$inicio WHERE id=$idprod";
    mysqli_query($conexion,$sql);
  }
}

?>
