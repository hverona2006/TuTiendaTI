<?php
session_set_cookie_params(3600); session_start();
$prod=$_REQUEST["prod"];
$cant=$_REQUEST["cant"];
$ste=$_REQUEST["st"];
$sp=$_SESSION["carrito"]["prod"];
$sc=$_SESSION["carrito"]["cant"];
$sts=$_SESSION["carrito"]["sts"];
$verifp=0;
$new=false;
$count=count($sp);
if($count!=0){
  for ($i=0; $i < $count ; $i++) {
    $verifp=$sp[$i];
    if($verifp==$prod){
      $new=false;
      $sc[$i]=$cant;
      $sts[$i]=$ste;
      $i=$count;
    }else{
      $new=true;
    }
  }
}else{
  $sp[]=$prod;
  $sc[]=$cant;
  $sts[]=$ste;
  $new=true;
}

if($new){
  if($count==1){
    if($prod<$sp[0]){
      array_unshift($sp,$prod);
      array_unshift($sc,$cant);
      array_unshift($sts,$ste);
    }else{
      $sp[]=$prod;
      $sc[]=$cant;
      $sts[]=$ste;
    }
  }else{
    for ($i=$count-1; $i>=0; $i--) {
      if($prod<=$sp[$i]){
      }elseif($prod>$sp[$i]){
        array_splice($sp,$i+1,0,$prod);
        array_splice($sc,$i+1,0,$cant);
        array_splice($sts,$i+1,0,$ste);
        $i=-1;
      }
      if($i==0){
        array_unshift($sp,$prod);
        array_unshift($sc,$cant);
        array_unshift($sts,$ste);
      }
    }
  }
}

$_SESSION["carrito"]["prod"]=$sp;
$_SESSION["carrito"]["cant"]=$sc;
$_SESSION["carrito"]["sts"]=$sts;
echo $new;
?>
