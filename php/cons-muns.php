<?php

require ("../php/conexion.php");
$sqlm= "SELECT * FROM muns WHERE id_dep=".$_REQUEST['id_dep'];
$querym= mysqli_query($conexion, $sqlm) or die (mysqli_error($conexion));
echo "<option value='0'>Seleccione...</option>";
while($fetch= mysqli_fetch_assoc($querym)){
			echo "<option value='".$fetch['id_mun']."'>".$fetch['mun']."</option>";
	}
?>
