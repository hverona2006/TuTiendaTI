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
		<div class="panel panel-default">
			<div class="panel-heading text-center"><h1>Productos</h1></div>
			<br />
			<div class="panel-body">
				<p>Aquí encontrará el inventario de todos los productos, sus existencias y precio de venta.</p>
				<br />
				<h4 class="text-center">Filtrar</h4>
				<div class="container-fluid justify-content-center">
					<div class="row">
						<div class="col-12 col-lg"></div>
						<div class="col-12 col-lg-4">
							<button class="btn btn-block btn-info" id="todos"><span class="icon-price-tag"></span> Todos los productos</button>
						</div>
						<div class="col-12 col-lg-4">
							<button class="btn btn-block btn-warning" id="activos"><span class="icon-check"></span> Ver solo productos activos</button>
						</div>
						<div class="col-12 col-lg"></div>
					</div>
					<br />
					<div class="row">
						<div class="col-12 col-lg"></div>
						<div class="col-12 col-lg-8">
							<button class="btn btn-block btn-secondary" id="ctg" value="1"><span class="icon-music"></span> Audio</button>
							<button class="btn btn-block btn-secondary" id="ctg" value="2"><span class="icon-video"></span> Video</button>
							<button class="btn btn-block btn-secondary" id="ctg" value="3"><span class="icon-laptop"></span> Tecnología</button>
							<button class="btn btn-block btn-secondary" id="ctg" value="4"><span class="icon-flash"></span> Electrónica</button>
							<button class="btn btn-block btn-secondary" id="ctg" value="5"><span class="icon-fitness_center"></span> Cuidado personal</button>
						</div>
						<div class="col-12 col-lg"></div>
					</div>
				</div>
				<br />
				<br />
				<h4 class="text-center" id="filtro"></h4>
				<br />
				<div class="table-responsive-md">
					<table class="table text-center">
						<thead>
							<tr>
								<th scope="col">Nombre del producto</th>
								<th scope="col">Precio unitario</th>
								<th scope="col">Existencias</th>
								<th scope="col">Estado</th>
								<!-- <th scope="col">Fotos</th> -->
								<th scope="col" colspan="2">
									<button class="btn btn-success nuevo-prod"><span class="icon-plus"></span> Nuevo</button>
								</th>
							</tr>
						</thead>
						<tbody class="filtro-prods">

						</tbody>
					</table>
				</div>
			</div>
		</div>
	<?php } }?>
