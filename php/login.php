<?php
session_set_cookie_params(3600); session_start();
require("conexion.php");
$login=false;
$sql="SELECT id,usuario,tipousr,activo FROM musuario	WHERE usuario = ? AND pw = ?";
$init=mysqli_stmt_init($conexion);
$prep=mysqli_stmt_prepare($init,$sql);
if($prep){
	$user=$_REQUEST["user"];
	$pw=$_REQUEST["pw"];
	mysqli_stmt_bind_param($init, 'ss', $user, $pw);
	if(mysqli_stmt_execute($init)) {
		mysqli_stmt_bind_result($init, $a, $b, $c, $d);
		while (mysqli_stmt_fetch($init)) {
			if($d!=0){
				$id=intval($a);
				$_SESSION["userdata"]["id"] = $id;
				$_SESSION["userdata"]["user"] = $b;
				$_SESSION["userdata"]["tipousr"] = intval($c);
				if ($c!=1){
					$_SESSION["userdata"]["activo"] = intval($d);
				}
				$sql="UPDATE musuario SET login=1 WHERE id=$id";
				$prep=mysqli_stmt_prepare($init,$sql);
				if($prep){
					if(mysqli_stmt_execute($init)){
						$login=true;
					}else{
						$login=false;
					}
				}else{
					$login=false;
				}
			}else{
				$login=false;
			}
		}
	}else{
		$login=false;
	}
}
mysqli_stmt_close($init);
echo $login;
?>
