<?php
	session_set_cookie_params(3600); session_start();
	require("conexion.php");
	$logout=false;
	$sql = "UPDATE musuario
					SET login = 0
					WHERE id = ".$_SESSION["userdata"]["id"];
	mysqli_query($conexion,$sql);
	session_destroy();
	$logout=true;
	echo $logout;
	?>
