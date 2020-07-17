<?php
require('conexion.php');
$numid=$_REQUEST['numid'];
$queryCE=mysqli_query($conexion,"SELECT * from mcliente where doc=$numid");
$rowsCE=mysqli_num_rows($queryCE);
$ret=[];
$ac=[];


if($rowsCE!=0){
  while($cliente=mysqli_fetch_assoc($queryCE)){
    $ac[]=$cliente['email'];
    $ac[]=$cliente['nombres'];
    $ac[]=$cliente['apellidos'];
    $ac[]=$cliente['telefono'];
    $ac[]=$cliente['direccion'];
    $ac[]=$cliente['departamento'];
    $ac[]=$cliente['municipio'];
  }
  $dac=implode(",",$ac);
}else{
  $dac= "nothing";
}
echo $dac;

?>
