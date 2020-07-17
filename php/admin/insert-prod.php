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
    $cat=$_REQUEST["cat"];
    $nombre=$_REQUEST["nombre"];
    $precio=$_REQUEST["precio"];
    $existencias=$_REQUEST["existencias"];
    $descripcion=$_REQUEST["descripcion"];
    $activo=$_REQUEST["activo"];
    $inicio=$_REQUEST["inicio"];



    $sql="INSERT INTO mproductos(categoria,nombre,precio,existencias,descripcion,activo,destacado)
    VALUES($cat,'$nombre',$precio,$existencias,'$descripcion',$activo,$inicio)";
    mysqli_query($conexion,$sql);

    $sqlLP=mysqli_query($conexion, "select LAST_INSERT_ID(id) as np, categoria as cat from mproductos order by id desc limit 0,1 ");
    $idpr=mysqli_fetch_array($sqlLP);
    $np=$idpr['np'];
    $cat=$idpr['cat'];
    $dnp=[$np,$cat];
    $snp=implode(",",$dnp);
    echo $snp;
  }
}

?>
