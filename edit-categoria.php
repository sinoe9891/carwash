<?php
date_default_timezone_set('America/Tegucigalpa');
include 'inc/templates/header.php';
include 'inc/conexion.php';
include 'inc/functionsquery.php';
// include 'inc/sesiones.php';
session_start();
$name = $_SESSION['nombre_usuario'];
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
if (isset($_GET['idcategoria'])) {
	$idcategoria = $_GET['idcategoria'];
} else {
	header('Location: menu_admin');
}
?>

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
				<div class="text-center wow fadeInUp" data-wow-delay="0.1s">
					<h5 class="section-title ff-secondary text-center text-primary fw-normal">Administrar</h5>
					<h1 class="mb-5">Editar Categoría</h1>
				</div>
				<section class="section clientes wow fadeInUp" data-wow-delay="0.1s">
					<div class="card">
						<div class="card-body">
							<form class="form" id="editarcategoria" method="post" action="inc/models/update.php" role="form" enctype="multipart/form-data">
								<div class="tab-content" id="myTabContent">
									<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
										<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
											<div class="card-body">
												<div class="row">
													<?php
													$obtenerTodo = obtenerTodo('main_users');
													$consulta = $conn->query("SELECT * FROM `categorias_menu` where id_categoria = '$idcategoria'");
													$numero = 1;
													while ($solicitud = $consulta->fetch_array()) {
														$id = $solicitud['id_categoria'];
														$nombre = $solicitud['nombre_categoria'];
														$descripcion = $solicitud['descripcion'];
														$url_foto = $solicitud['icono'];
														$estado = $solicitud['estado'];

														if ($estado == 'a') {
															$estadoUser = 'Habilitado';
															$color = 'bg-success';
														} elseif ($estado == 'd') {
															$estadoUser = 'Deshabilitado';
															$color = 'bg-secondary';
														}
													?>
														<div class="col-md-6 col-12">
															<div class="form-group">
																<label for="first-name-column">Nombre Categoría</label>
																<input type="hidden" id="idcategoria" name="idcategoria" value="<?php echo $idcategoria; ?>">
																<input type="text" class="form-control" id="nombrecategoria" name="nombrecategoria" value="<?php echo $nombre; ?>">
															</div>
														</div>
														<div class="col-md-6 col-12">
															<div class="form-group">
																<label for="last-name-column">Estado</label>
																<select class="form-select" name="estado" id="estado">
																	<?php
																	if ($estado == 'a') {
																		echo "<option name='estado' value='a' selected>Habilitado</option>";
																		echo "<option name='estado' value='d'>Deshabilitado</option>";
																	} elseif ($estado == 'd') {
																		echo "<option name='estado' value='a'>Habilitado</option>";
																		echo "<option name='estado' value='d' selected>Deshabilitado</option>";
																		$estado = 'Disponible';
																	}
																	?>
																</select>
															</div>
														</div>
														<div class="col-md-6 col-12">
															<div class="form-group">
																<label for="first-name-column">Descripción</label>
																<textarea class="form-control" name="descripcion" id="" cols="30" rows="3"><?php echo $descripcion; ?></textarea>
															</div>
														</div>
														<div class="col-md-6 col-12">
															<div class="form-group">
																<label for="last-name-column">Fotografía (.png, .jpg)</label>
																<input class="form-input form-control-has-validation form-control-last-child" name="imagen" id="imagen" type="file" />
																<input type="text" class="form-control" name="url" value="<?php echo $url_foto; ?>" required readonly>
															</div>
															<div class="form-group">
																<label for="first-name-column"></label>
																<div>
																	<h4>Imagen del Producto Actual</h4>
																	<img width="50%" src="<?php echo $url_foto; ?>" alt="">
																</div>
															</div>
														</div>
													<?php
													}
													?>
												</div>
											</div>
										</div>
									</div>
									<div class="col-12 d-flex justify-content-end">
										<input type="hidden" class="btn btn-primary me-1 mb-1" id="tipo" value="editcategoria">
										<input class="btn btn-primary me-1 mb-1" type="submit" value="Actualizar" name="updatecategoria">
										<a href="menu_admin">
											<div class="btn btn-secondary me-1 mb-1">Regresar</div>
										</a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</section>
			</div>
		</div>
		<!-- Service End -->
		<?php

		?>
		<?php
		include 'inc/templates/footer.php';

		if (isset($_GET['up'])) {
			if ($_GET['up'] == 1) {
				echo "<script>
				console.log('Hola');
				Swal.fire({
					icon: 'success',
					title: 'Categoría Actualizado!',
					text: 'Categoría fue actualizada correctamente',
					position: 'center',
					showConfirmButton: true
				}).then(function () {
					window.location = 'menu_categoria.php';
				});
			</script>";
			} elseif ($_GET['up'] == 0) {
				echo "<script>
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'El Categoría no se actualizó'
				}).then(function () {
					window.location = 'menu_categoria.php';
				});
				</script>";
			}
		} elseif (!isset($_GET['idplato'])) {
			header('Location: mesas');
		};
		?>