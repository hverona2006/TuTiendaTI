<?php
session_set_cookie_params(3600); session_start();
require('conexion.php');
$dac="nothing";
$doc=' ';
$email=' ';
if(isset($_REQUEST['doc'])) {
  $doc=$_REQUEST['doc'];
}
if(isset($_SESSION['email'])) {
  $email=$_SESSION['email'];
}

$sql="SELECT doc,nombre,telefono,direccion,departamento,municipio from mcliente where doc=? OR email=?";
$ret=[];
$ac=[];
$init=mysqli_stmt_init($conexion);
$prep=mysqli_stmt_prepare($init,$sql);
if($prep){
  mysqli_stmt_bind_param($init, 'ss', $doc,$email);
  if(mysqli_stmt_execute($init)) {
    mysqli_stmt_store_result($init);
    if(mysqli_stmt_num_rows($init)!=0){
      mysqli_stmt_bind_result($init, $a,$b,$c,$d,$e,$f);
      while (mysqli_stmt_fetch($init)) {
        $ac[]=$a;
        $ac[]=$b;
        $ac[]=$c;
        $ac[]=$d;
        $ac[]=$e;
        $ac[]=$f;
      }
      $dac=implode(",",$ac);
    }else{
      $dac="nothing";
    }
  }else{
    $dac="nothing";
  }
}else{
  $dac="nothing";
}
echo $dac;
?>
