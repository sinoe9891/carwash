<?php
include 'inc/templates/header.php';
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
				<div class="container text-center my-5 pt-5 pb-4">
					<h1 class="display-3 text-white mb-3 animated slideInDown">Nosotros</h1>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb justify-content-center text-uppercase">
							<li class="breadcrumb-item"><a href="#">Inicio</a></li>
							<li class="breadcrumb-item text-white active" aria-current="page">Nosotros</li>
						</ol>
					</nav>
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
						<h1 class="mb-4">Bienvenidos a  Inversiones Ponce</h1>
						<p class="mb-4">Inversiones la Ponce fue creada el 13 de marzo del 2012, surgió en la colonia flor del campo zona 1, es una empresa totalmente familiar, esto para poder generar ingresos para dicha familia. Asimismo, surge de la necesidad de la zona, ya que no existían ferreterías cercanas a la comunidad.</p>
						<div class="row g-4 mb-4">
							<div class="col-sm-6">
								<div class="d-flex align-items-center border-start border-5 border-primary px-3">
									<h1 class="flex-shrink-0 display-5 text-primary mb-0" >10</h1>
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
					</div>
				</div>
			</div>
		</div>
		<!-- About End -->


		<?php
			include 'inc/templates/equipo.php';

	include 'inc/templates/footer.php';
?>