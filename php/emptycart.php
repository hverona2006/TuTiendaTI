<?php
session_set_cookie_params(3600); session_start();
$sp=$_SESSION["carrito"]["prod"];
$sc=$_SESSION["carrito"]["cant"];
$sts=$_SESSION["carrito"]["sts"];

$sp=[];
$sc=[];
$sts=[];

$_SESSION["carrito"]["prod"]=$sp;
$_SESSION["carrito"]["cant"]=$sc;
$_SESSION["carrito"]["sts"]=$sts;
?>
