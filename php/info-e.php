<?php
session_set_cookie_params(3600); session_start();
$email=$_REQUEST["email"];
$_SESSION["email"]=$email;
?>
