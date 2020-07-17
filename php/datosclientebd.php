<?php
session_set_cookie_params(3600); session_start();
require("../php/conexion.php");
$res=false;
$doc=$_REQUEST["doc"];
$email=$_REQUEST["email"];
$_SESSION["email"]=$email;
$doc=$_REQUEST["doc"];
$nombre=$_REQUEST["nombre"];
$tel=$_REQUEST["tel"];
$dep=$_REQUEST["dep"];
$mun=$_REQUEST["mun"];
$dir=$_REQUEST["dir"];

$queryCE="SELECT id from mcliente where doc=?";
$init=mysqli_stmt_init($conexion);
$prep=mysqli_stmt_prepare($init,$queryCE);
if($prep){
  mysqli_stmt_bind_param($init, 's', $doc);
  if(mysqli_stmt_execute($init)) {
    mysqli_stmt_store_result($init);
    if(mysqli_stmt_num_rows($init)==0){
      $sql="INSERT INTO mcliente(usuario, doc, nombre, telefono, direccion, email, departamento, municipio, activo)
      VALUES (NULL,?,?,?,?,?,?,?,0)";
      $prep=mysqli_stmt_prepare($init,$sql);
      if($prep){
        mysqli_stmt_bind_param($init, 'sssssii',$doc,$nombre,$tel,$dir,$email,$dep,$mun);
        if(mysqli_stmt_execute($init)) {
          $res=true;
        }else{
          $res=false;
        }
      }
    }else{
      mysqli_stmt_bind_result($init, $a);
      while (mysqli_stmt_fetch($init)) { $id=$a; }
      $sql="UPDATE mcliente SET telefono=?,direccion=?,email=?,departamento=?,municipio=? WHERE id=$id";
      $prep=mysqli_stmt_prepare($init,$sql);
      mysqli_stmt_bind_param($init, 'sssii',$tel,$dir,$email,$dep,$mun);
      if(mysqli_stmt_execute($init)) {
        $res=true;
      }else{
        $res=false;
      }
    }
  }
}

mysqli_stmt_close($init);
echo $res;
?>
