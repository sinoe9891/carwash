<?php
date_default_timezone_set('America/Tegucigalpa');
include 'inc/templates/header.php';
// include 'inc/sesiones.php';
session_start();
// if (!isset($_SESSION['session'])) {
// 	// header('Location: login.php');
// 	echo $_SESSION['session'];
// 	exit;
// }
$name = $_SESSION['nombre_usuario'];
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
// echo $_SESSION['login'];
// print_r($_SESSION);
// print_r($_POST);
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
			include 'inc/templates/navbar-admin.php';
			?>

			<div class="container-xxl py-5 bg-dark hero-header mb-5">
				<div class="container my-5 py-5">
					<div class="row ">
						<div class="col-lg-12 text-center text-lg-start">
							<h6 class="display-3 text-white animated text-center" style="font-size: 40px;"><?php echo $saludo . $_SESSION["nombre_usuario"]; ?></h6>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Navbar & Hero End -->


		<!-- Service Start -->
		<div class="container-xxl py-5">
			<div class="container">
				<div class="row g-4">

					<div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
						<div class="service-item rounded pt-3">
							<a href="usuarios">
								<div class="p-4">
									<i class="fa fa-3x fa-user-tie text-primary mb-4"></i>
									<h5>Usuarios</h5>
									<!-- <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p> -->
								</div>
							</a>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
						<div class="service-item rounded pt-3">
							<a href="mesas">
								<div class="p-4">
									<img class="iconomesa" src="img/mesa.svg" alt="">
									<h5>Departamentos</h5>
								</div>
							</a>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
						<div class="service-item rounded pt-3">
							<a href="menu_admin">
								<div class="p-4">
									<img src="img/iconos-03.svg" alt="" height="48px" style="margin: 0 0 24px;">
									<!-- <i class="fa fa-3x fa-utensils text-primary mb-4"></i> -->
									<h5>Productos</h5>
								</div>
							</a>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
						<div class="service-item rounded pt-3">
							<a href="ordenes_admin">
								<div class="p-4">
									<i class="fa fa-3x fa-cart-plus text-primary mb-4"></i>
									<h5>Ordenes</h5>
								</div>
							</a>
						</div>
					</div>
					<!-- <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
						<div class="service-item rounded pt-3">
							<div class="p-4">
								<i class="fa fa-3x fa-headset text-primary mb-4"></i>
								<h5>24/7 Soporte</h5>
								<p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
						<div class="service-item rounded pt-3">
							<div class="p-4">
								<i class="fa fa-3x fa-headset text-primary mb-4"></i>
								<h5>Comentarios</h5>
								<p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
						<div class="service-item rounded pt-3">
							<div class="p-4">
								<i class="fa fa-3x fa-headset text-primary mb-4"></i>
								<h5>Recetas</h5>
								<p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
						<div class="service-item rounded pt-3">
							<div class="p-4">
								<i class="fa fa-3x fa-headset text-primary mb-4"></i>
								<h5>Métricas</h5>
								<p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
						<div class="service-item rounded pt-3">
							<div class="p-4">
								<i class="fa fa-3x fa-headset text-primary mb-4"></i>
								<h5>Facturación</h5>
								<p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
							</div>
						</div>
					</div> -->
				</div>
			</div>
		</div>
		<!-- Service End -->
		<?php
		include 'inc/templates/comentarios.php';
		include 'inc/templates/footer.php';
		?>