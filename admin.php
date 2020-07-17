<?php
session_set_cookie_params(3600); session_start();
if($_SESSION){
  if($_SESSION['userdata']['tipousr']!=1){
    session_destroy();
  }
}
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Tu Tienda TI</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="fonts/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/popper.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/bootbox.all.min.js"></script>
  <script type="text/javascript" src="js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="js/messages_es.min.js"></script>
  <script type="text/javascript" src="js/masterscript.js"></script>
  <script type="text/javascript" src="js/move-top.js"></script>
  <script type="text/javascript" src="js/easing.js"></script>
  <?php if($_SESSION){ if($_SESSION['userdata']['tipousr']==1){ ?>
  <script>
  $(document).ready(function() {
    consulta("php/verif-al.php",{},function(result){
  		if(result==true){
  			cargarPrincipalAdmin();
  		}else{
        bootbox.alert("Se ha producido un error. Por favor <a href='admin'>vuelva a iniciar sesión</a>.");
  		}
  	});
  });
  </script>
<?php } } ?>
</head>
<body>
  <div class="header-top">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 text-center text-sm-left align-middle">
          <a><img class="inicio" src="img/Logotipo.png" alt=""/></a>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 cssmenu text-center text-sm-right">
          <ul>
            <li class="catego"><span class="adminsesion"><h5><span class="icon-tools"></span> Módulo de Administración</h5></span></li>
            <li><a hidden class="btn btn-danger logout"><span class="icon-log-out"></span> Cerrar sesión</a></li>
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
        <a class="nav-item nav-link active productos" href="#" hidden><span class="icon-price-tag"></span> Administración de Productos</a>
        <a class="nav-item nav-link active pedidos" href="#" hidden><span class="icon-local_atm"></span> Registro de pedidos</a>
      </div>
    </div>
  </nav>
  <div class="admin-main">
    <div class="row justify-content-center">
      <div class="col-sm-4"></div>
      <div class="col-sm-4 text-center">
        <h3>INGRESO DE ADMINISTRADOR</h3>
        <div>
          <form class="form-horizontal" id="form-login">
            <fieldset>
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control" name="user" id="user" placeholder="Usuario">
                 </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="password" class="form-control" name="pw" id="pw" placeholder="Contraseña">
                </div>
              </div>
              <div class="form-group" align="center">
                <button type="button" class="btn btn-info" id="veriflogin-a"><span class="icon-login"></span> Entrar</button>
              </div>
              <div hidden="hidden" class='alert alert-danger error-login'><p>Los datos son incorrectos o no existen.</p></div>
            </fieldset>
          </form>
        </div>
      </div>
      <div class="col-sm-4"></div>
    </div>
  </div>
  <footer class="footer text-center">
    <div class="container">
      <div class="des">
        <img id="des" src="img/desarrollo.png" width=30% alt="Multielectronicos">
      </div>
      <span class="text-light">TuTiendaTI. Todos los derechos reservados &copy; 2020</span>
    </div>
  </footer>
  <a href="#" id="toTop" style="display: block;"><span id="toTopHover" style="opacity: 1;"></span></a>
</body>
</html>
