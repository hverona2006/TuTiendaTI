<?php
	session_set_cookie_params(3600); session_start();
	$ul=false;
	if(isset($_SESSION["userdata"])){
		$ul=true;
	}else{
		$ul=false;
	}
	echo $ul;
?>
