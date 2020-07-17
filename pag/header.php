<?php
session_set_cookie_params(3600); session_start();

require("../php/conexion.php");
$email=NULL;
if(!$_SESSION){
  $_SESSION["carrito"]["prod"]=[];
  $_SESSION["carrito"]["cant"]=[];
  $_SESSION["carrito"]["sts"]=[];
  $_SESSION["userdata"]=NULL;
  $_SESSION["email"]=NULL;
}
$cc=count($_SESSION["carrito"]["prod"]);
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Tu Tienda TI</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link  rel="icon" href="../img/favicon.png" type="image/png" >
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="../fonts/style.css">
  <link rel="stylesheet" href="../css/wa.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
  <link type="text/css" rel="stylesheet" href="../css/fotorama.css" >
  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../js/popper.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../js/bootbox.all.min.js"></script>
  <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="../js/messages_es.min.js"></script>
  <script type="text/javascript" src="../js/fotorama.js"></script>
  <script type="text/javascript" src="../js/masterscript.js"></script>
  <script type="text/javascript" src="../js/move-top.js"></script>
  <script type="text/javascript" src="../js/easing.js"></script>
</head>
<body>
<a href="https://wa.me/573002800626?text=Hola.%20Me%20interesa%20uno%20de%20tus%20productos." class="float" target="_blank">
<i class="fab fa-whatsapp my-float"></i>
</a>
  <div class="header-top">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 text-center text-sm-left align-middle">
          <a href="/"><img class="inicio" src="../img/Logotipo.png" alt=""/></a>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 cssmenu text-center text-sm-right">
          <ul>
            <!-- <li><a href="#" id="login"><span class="icon-user"></span>Mi cuenta</a></li>
            <li class="active"><a href="#" id="register">Registrate</a></li>
            <li><a href="#" id="login">Iniciar Sesión</a></li> -->
            <?php if($_SESSION["userdata"]["tipousr"]==1){ ?>
            <li><a href="../admin" class="btn btn-danger"><span class="icon-warning"></span> ADMIN CONECTADO</a></li>
          <?php } ?>
            <li><a href="cart" class="btn btn-warning carrito-s"><span class="icon-shopping-cart"></span> MI CARRITO (<span id="cc"><?php echo $cc; ?></span>)</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-dark navbar-expand-md" style="background-color: #3e98a2;">
    <button class="navbar-toggler mr-auto ml-auto" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span> MENÚ
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav mr-auto ml-auto text-center">
        <a class="nav-item nav-link active inicio" href="/"><span class="icon-home"></span> Inicio</a>
        <a class="nav-item nav-link catalogo" href="catalogo"><span class="icon-book"></span> Catálogo</a>
        <a class="nav-item nav-link" href="categorias?cat=1"><span class="icon-music"></span> Audio</a>
        <a class="nav-item nav-link" href="categorias?cat=2"><span class="icon-video"></span> Video</a>
        <a class="nav-item nav-link" href="categorias?cat=3"><span class="icon-laptop"></span> Tecnología</a>
        <a class="nav-item nav-link" href="categorias?cat=4"><span class="icon-flash"></span> Electrónica</a>
        <a class="nav-item nav-link" href="categorias?cat=5"><span class="icon-fitness_center"></span> Cuidado personal</a>
      </div>
    </div>
  </nav>
