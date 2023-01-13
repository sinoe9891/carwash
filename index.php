<?php
include 'inc/templates/header.php';
date_default_timezone_set('America/Tegucigalpa');
include 'inc/conexion.php';
// include 'inc/sesiones.php';
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


<body>
	<div class="container-xxl bg-white p-0">
		<!-- Spinner Start -->
		<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
			<div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
		<!-- Spinner End -->


		<!-- Navbar & Hero Start -->
		<div class="container-xxl position-relative p-0">
			<?php
			include 'inc/templates/navbar.php';
			?>

			<div class="container-xxl py-5 bg-dark hero-header mb-5">
				<div class="container my-5 py-5">
					<div class="row align-items-center g-5">
						<div class="col-lg-6 text-center text-lg-start">
							<h1 class="display-3 text-white animated slideInLeft">Productos de <br>Calidad</h1>
							<p class="text-white animated slideInLeft mb-4 pb-2">El placer comprar.</p>
							<a href="#reservacion" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">Cotizá aquí</a>
						</div>
						<div class="col-lg-6 text-center text-lg-end overflow-hidden">
							<img class="img-fluid" src="img/herramientas.png" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Navbar & Hero End -->





		<!-- About Start -->
		<div class="container-xxl py-5">
			<div class="container">
				<div class="row g-5 align-items-center">
					<div class="col-lg-6">
						<div class="row g-3">
							<div class="col-6 text-start">
								<img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.1s" src="img/about-1.jpg">
							</div>
							<div class="col-6 text-start">
								<img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.3s" src="img/about-2.jpg" style="margin-top: 25%;">
							</div>
							<div class="col-6 text-end">
								<img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.5s" src="img/about-3.jpg">
							</div>
							<div class="col-6 text-end">
								<img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.7s" src="img/about-4.jpg">
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<h5 class="section-title ff-secondary text-start text-primary fw-normal">Sobre Nosotros</h5>
						<h1 class="mb-4">Bienvenidos a Inversiones Ponce</h1>
						<p class="mb-4">Inversiones la Ponce fue creada el 13 de marzo del 2012, surgió en la colonia flor del campo zona 1, es una empresa totalmente familiar, esto para poder generar ingresos para dicha familia. Asimismo, surge de la necesidad de la zona, ya que no existían ferreterías cercanas a la comunidad.</p>

						<div class="row g-4 mb-4">
							<div class="col-sm-6">
								<div class="d-flex align-items-center border-start border-5 border-primary px-3">
									<h1 class="flex-shrink-0 display-5 text-primary mb-0">10</h1>
									<div class="ps-4">
										<p class="mb-0">Años de</p>
										<h6 class="text-uppercase mb-0">Experiencia</h6>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="d-flex align-items-center border-start border-5 border-primary px-3">
									<h1 class="flex-shrink-0 display-5 text-primary mb-0">50+</h1>
									<div class="ps-4">
										<p class="mb-0">Popular</p>
										<h6 class="text-uppercase mb-0">Marcas Reconocidas</h6>
									</div>
								</div>
							</div>
						</div>
						<a class="btn btn-primary py-3 px-5 mt-2" href="about">Leer más</a>
					</div>
				</div>
			</div>
		</div>
		<!-- About End -->


		<!-- Menu Start -->
		<div class="container-xxl py-5">
			<div class="container">
				<div class="text-center wow fadeInUp" data-wow-delay="0.1s">
					<h5 class="section-title ff-secondary text-center text-primary fw-normal">Productos</h5>
					<h1 class="mb-5">Aprovecha nuestras promociones</h1>
				</div>
				<div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
					<ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
						<li class="nav-item">
							<a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-1">
								<!-- <i class="fa fa-coffee fa-2x text-primary"></i> -->
								<img src="img/iconos-03.png" alt="">
								<div class="ps-3">
									<small class="text-body">Popular</small>
									<h6 class="mt-n1 mb-0">Herramientas</h6>
								</div>
							</a>
						</li>
						<li class="nav-item">
							<a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-2">
								<!-- <i class="fa fa-hamburger fa-2x text-primary"></i> -->
								<img src="img/iconos-05.png" alt="">
								<div class="ps-3">
									<small class="text-body">Special</small>
									<h6 class="mt-n1 mb-0">Construcción</h6>
								</div>
							</a>
						</li>
						<li class="nav-item">
							<a class="d-flex align-items-center text-start mx-3 me-0 pb-3" data-bs-toggle="pill" href="#tab-3">
								<!-- <i class="fa fa-utensils fa-2x text-primary"></i> -->
								<img src="img/iconos-04.png" alt="">
								<div class="ps-3">
									<small class="text-body">Lovely</small>
									<h6 class="mt-n1 mb-0">Equipamiento</h6>
								</div>
							</a>
						</li>
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
									$descripcion = $solicitud['descripcion_menu'];
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
									$descripcion = $solicitud['descripcion_menu'];
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
									$descripcion = $solicitud['descripcion_menu'];
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
										</div>
									</div>
								<?php
								};
								?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Menu End -->


		<!-- Reservation Start -->
		<div class="container-xxl py-5 px-0 wow fadeInUp" data-wow-delay="0.1s" id="reservacion">
			<div class="row g-0">
				<div class="col-md-6">
					<div class="video">
						<button type="button" class="btn-play" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
							<span></span>
						</button>
					</div>
				</div>
				<div class="col-md-6 bg-dark d-flex align-items-center">
					<div class="p-5 wow fadeInUp" data-wow-delay="0.2s">
						<h5 class="section-title ff-secondary text-start text-primary fw-normal">Cotizaciones</h5>
						<h1 class="text-white mb-4">Cotiza Aquí</h1>
						<form>
							<div class="row g-3">
								<div class="col-md-6">
									<div class="form-floating">
										<input type="text" class="form-control" id="name" placeholder="Your Name">
										<label for="name">Nombre Completo</label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-floating">
										<input type="email" class="form-control" id="email" placeholder="Your Email">
										<label for="email">Correo Electrónico</label>
									</div>
								</div>
								<!-- <div class="col-md-6">
									<div class="form-floating date" id="date3" data-target-input="nearest">
										<input type="datetime" class="form-control datetimepicker-input" id="datetime" placeholder="Date & Time" data-target="#date3" data-toggle="datetimepicker" />
										<label for="datetime">Fecha y hora</label>
									</div>
								</div> -->
								<div class="col-md-6">
									<div class="form-floating">
										<select class="form-select" id="select1">
											<?php
											$consulta = $conn->query("SELECT * FROM `menu` WHERE estado_plato = 'a';");
											$contador = 1;
											while ($solicitud = $consulta->fetch_array()) {
												$idplato = $solicitud['id'];
												$nombre = $solicitud['nombre'];
											?>
												<option value=""><?php echo $nombre ?></option>
											<?php
											};
											?>
										</select>
										<label for="select1"># de personas</label>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-floating">
										<input type="number" class="form-control" id="cantidadproducto" placeholder="10">
										<label for="select1">Cantidad</label>
									</div>
								</div>
								<div class="col-12">
									<div class="form-floating">
										<textarea class="form-control" placeholder="Special Request" id="message" style="height: 100px"></textarea>
										<label for="message">Solicitud especial</label>
									</div>
								</div>
								<div class="col-12">
									<button class="btn btn-primary w-100 py-3" type="submit">Cotiza</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- Service Start -->
		<?php
		include 'inc/templates/servicios.php';
		?>
		<!-- Service End -->

		<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content rounded-0">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Inversiones Ponce</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<!-- 16:9 aspect ratio -->
						<div class="ratio ratio-16x9"><iframe width="560" height="315" src="https://www.youtube.com/embed/uJfTixW6as4?autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Reservation Start -->


		<?php
		include 'inc/templates/equipo.php';

		include 'inc/templates/comentarios.php';
		include 'inc/templates/footer.php';
		?>