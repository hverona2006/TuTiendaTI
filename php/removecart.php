<?php
session_set_cookie_params(3600); session_start();
$prod=$_REQUEST["prod"];
$sp=$_SESSION["carrito"]["prod"];
$sc=$_SESSION["carrito"]["cant"];
$sts=$_SESSION["carrito"]["sts"];
$verifp=0;
$rm=false;
$count=count($sp);
if($count!=0){
  for ($i=0; $i < $count ; $i++) {
    $verifp=$sp[$i];
    if($verifp==$prod){
      array_splice($sp,$i,1);
      array_splice($sc,$i,1);
      array_splice($sts,$i,1);
      $rm=true;
      $i=$count;
    }else{
      $rm=false;
    }
  }
}

$_SESSION["carrito"]["prod"]=$sp;
$_SESSION["carrito"]["cant"]=$sc;
$_SESSION["carrito"]["sts"]=$sts;

echo $rm;
?>
