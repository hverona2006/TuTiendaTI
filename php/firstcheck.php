<?php
	require("conexion.php");
	$sqlVS="";
	$queryVS=NULL;
	$fetchVS=NULL;
	if(!isset($_SESSION["userdata"])) {
		session_destroy();
	}else{
		$sqlVS = "SELECT login, tipousr
					FROM musuario
					WHERE	id = ".$_SESSION["userdata"]["id"];
		$queryVS = mysqli_query($conexion, $sqlVS);
		$fetchVS = mysqli_fetch_assoc($queryVS);
	}
?>
