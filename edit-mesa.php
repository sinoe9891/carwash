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
if (isset($_GET['idm'])) {
	$idm = $_GET['idm'];
} else {
	header('Location: mesas');
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
					<h1 class="mb-5">Editar Asignación</h1>
				</div>
				<section class="section clientes">
					<div class="card">
						<div class="card-body">
							<form class="form" id="editarMesa" method="post" action="inc/models/update.php" role="form">
								<div class="tab-content" id="myTabContent">
									<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

										<div class="card-body">
											<?php
											$obtenerTodo = obtenerTodo('main_users');
											$consulta = $conn->query("SELECT * FROM `mesas` where id_asignacion = '$idm'");
											$numero = 1;
											while ($solicitud = $consulta->fetch_array()) {
												$id = $solicitud['id_asignacion'];
												$estado = $solicitud['estado_mesa'];
												$numero_mesa = $solicitud['numero_mesa'];
												$id_mesero = $solicitud['id_mesero'];

												if ($estado == 'v') {
													$estadoLote = 'Vendido';
													$color = 'bg-secondary';
												} elseif ($estado == 'd') {
													$estadoLote = 'Disponible';
													$color = 'bg-success';
												} elseif ($estado == 'r') {
													$estadoLote = 'Reservado';
													$color = 'bg-info';
												}
											?>
												<div class="row">
													<div class="col-md-6 col-12">
														<div class="form-group">
															<label for="first-name-column">Número de Asignación</label>
															<input type="hidden" id="idm" name="idm" value="<?php echo $idm; ?>">
															<input type="text" class="form-control" id="numero_mesa" name="numero_mesa" value="<?php echo $numero_mesa; ?>" disabled readonly>
															<!-- <select class="form-select" name="role" id="role">
																		<?php
																		$obtenerNumeroMesas = obtenerNumeroMesas();
																		if ($obtenerNumeroMesas->num_rows > 0) {
																			while ($row = $obtenerNumeroMesas->fetch_assoc()) {
																				$id_mesa = $row['id'];
																				$descripcion = $row['numero_mesa'];
																				if ($id_mesa == $id) {
																					echo '<option name="role" value="' . $id_mesa . '" selected>' . $descripcion . '</option>';
																				} else {
																					echo '<option name="role" value="' . $id_mesa . '">' . $descripcion . '</option>';
																				}
																			}
																		}
																		?>
																	</select> -->
														</div>
													</div>
													<div class="col-md-6 col-12">
														<div class="form-group">
															<label for="first-name-column">Empleado</label>
															<select class="form-select" name="role" id="role">
																<option name="role" value="0" selected>Sin Asignar</option>
																<?php
																$obtenerTodo = obtenerColaboradores('main_users');
																if ($obtenerTodo->num_rows > 0) {
																	while ($row = $obtenerTodo->fetch_assoc()) {
																		$usuario_name = $row['usuario_name'];
																		$apellidos = $row['apellidos'];
																		$id_user = $row['id'];
																		$descripcion = $row['numero_mesa'];
																		if ($id_user == $id_mesero) {
																			echo '<option name="role" value="' . $id_user . '" selected>' . $usuario_name . ' ' . $apellidos . '</option>';
																		} else {
																			echo '<option name="role" value="' . $id_user . '">' . $usuario_name . ' ' . $apellidos . '</option>';
																		}
																	}
																}
																?>
															</select>
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
												</div>
											<?php
											}
											?>
										</div>
									</div>
									<div class="col-12 d-flex justify-content-end">
										<input type="hidden" class="btn btn-primary me-1 mb-1" id="tipo" value="editMesa">
										<input class="btn btn-primary me-1 mb-1" type="submit" value="Actualizar" name="updatemesa">
										<a href="mesas">
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
					title: 'Asignación Actualizada!',
					text: 'Asignación fue actualizada correctamente',
					position: 'center',
					showConfirmButton: true
				}).then(function () {
					window.location = 'mesas.php';
				});
			</script>";
			} elseif ($_GET['up'] == 0) {
				echo "<script>
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Asignación no se actualizó'
				}).then(function () {
					window.location = 'mesas.php';
				});
				</script>";
			}
		} elseif (!isset($_GET['idm'])) {
			header('Location: mesas');
		};
		?>