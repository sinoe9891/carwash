<?php
date_default_timezone_set('America/Tegucigalpa');
include 'inc/templates/header.php';
include 'inc/conexion.php';
// include 'inc/sesiones.php';
session_start();
$name = $_SESSION['nombre_usuario'];
$id_user = $_SESSION['id'];

$idmesa = $_POST['idm'];
$idcliente = $_POST['idcliente'];
$vehiculo = $_POST['vehiculo'];
$nombrecliente = $_POST['nombrecliente'];

// var_dump($_POST);

$today = getdate();
$hora = $today["hours"];
if ($hora < 6) {
	$saludo = " Hoy has madrugado mucho... ";
} elseif ($hora < 12) {
	$saludo = " Buenos días ";
} elseif ($hora <= 18) {
	$saludo = "Buenas Tardes ";
} else {
	$saludo = "Buenas Noches ";
}
?>
<style>
	input[type=checkbox] {
		padding: 10px;
		font-size: 40px;
		transform: scale(2);
		margin: 40px;
	}
</style>

<body>
	<div class="container-xxl bg-white p-0">
		<!-- Spinner Start -->
		<!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
			<div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div> -->
		<!-- Spinner End -->


		<!-- Navbar & Hero Start -->
		<div class="container-xxl position-relative p-0">
			<?php
			include 'inc/templates/navbar-admin.php';
			?>

			<div class="container-xxl py-5 bg-dark hero-header mb-5">
				<div class="container text-center my-5 pt-5 pb-4">
					<h1 class="display-3 text-white mb-3 animated slideInDown">Menú</h1>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center text-uppercase">
							<li class="breadcrumb-item"><a href="#">Inicio</a></li>
							<li class="breadcrumb-item text-white active" aria-current="page">Menú</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<!-- Navbar & Hero End -->

		<!-- Menu Start -->
		<div class="container-xxl py-5">
			<div class="container">
				<div class="text-center wow fadeInUp" data-wow-delay="0.1s">
					<h5 class="section-title ff-secondary text-center text-primary fw-normal">Orden</h5>
					<div class="cliente" style="text-align: left;">

						<h5>ID:<? echo $idcliente; ?></h5>
						<h5>Cliente:<? echo $nombrecliente; ?></h5>
						<?php

						$consultavehiculo = $conn->query("SELECT * FROM vehiculos_clientes a, vehiculos b, vehiculos_modelo c where a.id_vehiculocliente = $vehiculo and a.id_client = $idcliente and a.marca_cliente = c.marca_vehiculo and a.marca_cliente = b.id_vehiculo and a.modelo_cliente = c.id_modelo;");
						while ($solicitud = $consultavehiculo->fetch_array()) {
							$id_vehiculocliente = $solicitud['id_vehiculocliente'];
							$marca = $solicitud['marca'];
							$ano = $solicitud['ano_cliente'];
							$color = $solicitud['color'];
							echo '<h5>Vehículo:' . $marca . '</h5>';
							echo '<h5>Año:' . $ano . '</h5>';
							echo '<h5>Color:' . $color . '</h5>';
						}
						?>

					</div>
					<h1 class="mb-5">Selecciona los productos</h1>
				</div>
				<div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
					<form action="ordenar" method="post" enctype="multipart/form-data">
						<ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
							<?php
							$consultacategoria = $conn->query("SELECT * FROM `categorias_menu` WHERE estado = 'a'");
							$contador = 0;
							while ($solicitud = $consultacategoria->fetch_array()) {
								$id_categoria = $solicitud['id_categoria'];
								$nombre_categoria = $solicitud['nombre_categoria'];
								$icono = $solicitud['icono'];
								$contador++;
								$active = 'active';
								if ($contador == 1) {
									$active = 'active';
								} else {
									$active = '';
								}
							?>
								<li class="nav-item">
									<a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 <?php echo $active ?>" data-bs-toggle="pill" href="#tab-<?php echo $id_categoria ?>">
										<!-- <i class="fa fa-coffee fa-2x text-primary"></i> -->
										<img src="<?php echo $icono ?>" alt="">
										<div class="ps-3">
											<!-- <small class="text-body">Popular</small> -->
											<h6 class="mt-n1 mb-0"><?php echo $nombre_categoria ?></h6>
										</div>
									</a>
								</li>

							<?php
							};
							?>
						</ul>
						<div class="tab-content">
							<div id="tab-1" class="tab-pane fade show p-0 active">
								<div class="row g-4">
									<?php
									$consulta = $conn->query("SELECT * FROM `menu` WHERE estado_plato = 'a' and categoria = 1;");
									$contador = 1;
									while ($solicitud = $consulta->fetch_array()) {
										$idplato = $solicitud['id'];
										$nombre = $solicitud['nombre'];
										$descripcion = $solicitud['descripcion'];
										$precio = $solicitud['precio'];
										$url_foto = $solicitud['url_foto'];
										$oferta = $solicitud['oferta'];
										$precio_oferta = $solicitud['precio_oferta'];
										$estado = $solicitud['estado_plato'];
										if ($estado == 'a') {
											$estadoMesa = 'Habilitado';
											$color = 'bg-success';
										} elseif ($estado == 'd') {
											$estadoMesa = 'Deshabilitado';
											$color = 'bg-secondary';
										}
									?>
										<div class="col-lg-6">
											<div class="d-flex align-items-center">
												<img class="flex-shrink-0 img-fluid rounded" src="<?php echo $url_foto ?>" alt="" style="width: 80px;">
												<div class="w-100 d-flex flex-column text-start ps-4">
													<h5 class="d-flex justify-content-between border-bottom pb-2">
														<span><?php echo $nombre ?></span>
														<?php
														if ($oferta == 1) {
															echo '<div style="text-align: right;"><div><span class="text-primary" style="font-size: 13px;text-decoration: line-through !important;">Antes L.' . $precio . '</span></div><div><span class="text-primary" style="color:#dc3545 !important;">Oferta L. ' . $precio_oferta . '</span></div></div>';
														} else {
															echo '<span class="text-primary">L.' . $precio . '</span>';
														};
														?>
													</h5>
													<small class="fst-italic"><?php echo $descripcion ?></small>
												</div>
												<div>
													<input type="checkbox" name="menu[]" id="" value="<?php echo $idplato ?>">
													<!-- <input type="number" name="number[]" id="" value="1"> -->
												</div>
											</div>
										</div>
									<?php
									};
									?>
								</div>
							</div>
							<div id="tab-2" class="tab-pane fade show p-0">
								<div class="row g-4">
									<?php
									$consulta = $conn->query("SELECT * FROM `menu` WHERE estado_plato = 'a' and categoria = 2;");
									$contador = 1;
									while ($solicitud = $consulta->fetch_array()) {
										$idplato = $solicitud['id'];
										$nombre = $solicitud['nombre'];
										$descripcion = $solicitud['descripcion'];
										$precio = $solicitud['precio'];
										$url_foto = $solicitud['url_foto'];
										$oferta = $solicitud['oferta'];
										$precio_oferta = $solicitud['precio_oferta'];
										$estado = $solicitud['estado_plato'];
										if ($estado == 'a') {
											$estadoMesa = 'Habilitado';
											$color = 'bg-success';
										} elseif ($estado == 'd') {
											$estadoMesa = 'Deshabilitado';
											$color = 'bg-secondary';
										}
									?>
										<div class="col-lg-6">
											<div class="d-flex align-items-center">
												<img class="flex-shrink-0 img-fluid rounded" src="<?php echo $url_foto ?>" alt="" style="width: 80px;">
												<div class="w-100 d-flex flex-column text-start ps-4">
													<h5 class="d-flex justify-content-between border-bottom pb-2">
														<span><?php echo $nombre ?></span>
														<?php
														if ($oferta == 1) {
															echo '<div style="text-align: right;"><div><span class="text-primary" style="font-size: 13px;text-decoration: line-through !important;">Antes L.' . $precio . '</span></div><div><span class="text-primary" style="color:#dc3545 !important;">Oferta L. ' . $precio_oferta . '</span></div></div>';
														} else {
															echo '<span class="text-primary">L.' . $precio . '</span>';
														};
														?>
													</h5>
													<small class="fst-italic"><?php echo $descripcion ?></small>
												</div>
												<div>
													<input type="checkbox" name="menu[]" id="" value="<?php echo $idplato ?>">
													<!-- <input type="number" name="number[]" id="" value="1"> -->
												</div>
											</div>
										</div>
									<?php
									};
									?>
								</div>
							</div>
							<div id="tab-3" class="tab-pane fade show p-0">
								<div class="row g-4">
									<?php
									$consulta = $conn->query("SELECT * FROM `menu` WHERE estado_plato = 'a' and categoria = 3;");
									$contador = 1;
									while ($solicitud = $consulta->fetch_array()) {
										$idplato = $solicitud['id'];
										$nombre = $solicitud['nombre'];
										$descripcion = $solicitud['descripcion'];
										$precio = $solicitud['precio'];
										$url_foto = $solicitud['url_foto'];
										$oferta = $solicitud['oferta'];
										$precio_oferta = $solicitud['precio_oferta'];
										$estado = $solicitud['estado_plato'];
										if ($estado == 'a') {
											$estadoMesa = 'Habilitado';
											$color = 'bg-success';
										} elseif ($estado == 'd') {
											$estadoMesa = 'Deshabilitado';
											$color = 'bg-secondary';
										}
									?>
										<div class="col-lg-6">
											<div class="d-flex align-items-center">
												<img class="flex-shrink-0 img-fluid rounded" src="<?php echo $url_foto ?>" alt="" style="width: 80px;">
												<div class="w-100 d-flex flex-column text-start ps-4">
													<h5 class="d-flex justify-content-between border-bottom pb-2">
														<span><?php echo $nombre ?></span>
														<span class="text-primary">L.<?php echo $precio ?></span>
													</h5>
													<small class="fst-italic"><?php echo $descripcion ?></small>
												</div>
												<div>
													<input type="checkbox" name="menu[]" id="" value="<?php echo $idplato ?>">
												</div>
											</div>
										</div>
									<?php
									};
									?>
								</div>
							</div>
						</div>
						<div class="col-12 d-flex justify-content-end wow fadeInUp" data-wow-delay="0.1s">
							<input type="hidden" class="btn btn-primary me-1 mb-1" id="tipo" name="mesa" value="<?php echo $idmesa ?>">
							<input type="hidden" class="btn btn-primary me-1 mb-1" id="tipo" name="mesero" value="<?php echo $id_user ?>">
							<input type="hidden" class="btn btn-primary me-1 mb-1" id="tipo" name="accion" value="newOrden">
							<input class="btn btn-primary me-1 mb-1" type="submit" value="Ordenar" name="crearorden">
							<a href="mesas_mesero">
								<div class="btn btn-secondary me-1 mb-1">Regresar</div>
							</a>
						</div>
				</div>
				</form>
			</div>
		</div>
		<!-- Menu End -->


		<?php
		include 'inc/templates/footer.php';
		?>