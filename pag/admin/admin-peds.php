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
			<div class="panel-heading text-center"><h1>Pedidos solicitados</h1></div>
			<br />
			<div class="panel-body">
				<p>Aquí encontrará el registro de todos los pedidos hechos por los clientes y su estado. Podrá filtrar por estados.</p>
				<br />
				<h4 class="text-center">Filtrar</h4>
				<div class="container-fluid">
					<div class="row justify-content-center">
						<div class="col-12 col-lg"></div>
						<div class="col-12 col-lg-8">
							<button class="btn btn-block btn-primary" id="ped-all"><span class="icon-box"></span> Todos los pedidos</button>
							<button class="btn btn-block btn-warning" id="ped-est" value="1"><span class="icon-warning"></span> Pagados - Pendientes de envío</button>
							<button class="btn btn-block btn-success" id="ped-est" value="2"><span class="icon-check"></span> Enviados</button>
							<button class="btn btn-block btn-danger" id="ped-est" value="0"><span class="icon-back"></span> Cancelados/devueltos</button>
						</div>
						<div class="col-12 col-lg"></div>
					</div>
				</div>
				<br />
				<br />
				<h4 class="text-center" id="filtro-pd"></h4>
				<br />
				<div class="table-responsive-md">
					<table class="table text-center">
						<thead>
							<tr>
								<th scope="col">Referencia</th>
								<th scope="col">Fecha del pedido</th>
								<th scope="col">Valor total del pedido</th>
								<th scope="col">Estado</th>
								<th scope="col">Detalles del pedido</th>
								<th scope="col" colspan="3">Cambiar estado</th>
							</tr>
						</thead>
						<tbody class="filtro-peds">

						</tbody>
					</table>
				</div>
			</div>
		</div>
	<?php } }?>
