<?php
$ent="srv";
$conexion="";
if ($ent=="loc") {
  $conexion=mysqli_connect("localhost","root","","tutiendati");
}else {
  $conexion=mysqli_connect("50.87.144.54","marcoagu_Tti2020","Tel:04129246%*-","marcoagu_tutiendati");
}
mysqli_query($conexion, "SET CHARACTER SET UTF8");
setlocale(LC_TIME, "Spanish_Colombia");
?>
