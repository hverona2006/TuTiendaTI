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
    ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col contenido">
          <div class="jumbotron text-justify">
            <h3>Sistema de Administración - TuTiendaTI</h3>
            <p><h4>Bienvenido al Módulo de Administración de TuTiendaTI. Aquí podrá gestionar su Catálogo de productos<!-- y visualizar las compras realizadas-->.</h4></p>
          </div>
        </div>
      </div>
    </div>
  <?php } } ?>
