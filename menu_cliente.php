<?php
// setlocale(LC_TIME, 'es_ES', 'Spanish_Spain', 'Spanish');
date_default_timezone_set('America/Tegucigalpa');
$oldLocale = setlocale(LC_TIME, 'es_HN');
setlocale(LC_TIME, $oldLocale);
include 'inc/templates/header.php';
include 'inc/conexion.php';

// include 'inc/sesiones.php';
session_start();
$name = $_SESSION['nombre_usuario'];
// $ordenid = $_GET['orden'];
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
				<section class="section clientes">
					<div class="card">
						<div class="card-body">
							<form action="menu_mesero" method="post" enctype="multipart/form-data">
								<h3>Todas los clientes</h3>
								<h4> Hoy es: <?php
												// date_default_timezone_set('America/Tegucigalpa');
												$oldLocale = setlocale(LC_TIME, 'es_HN');
												setlocale(LC_TIME, $oldLocale);
												$date1 = date('d-m-Y', time());
												echo $date1;
												// setlocale(LC_ALL,"es_ES");
												// echo strftime("%A %d de %B del %Y");
												?></h4>
								<table class="table table-striped" id="table1">
									<thead>
										<tr>
											<th>No.</th>
											<th>Nombre</th>
											<th>Vehículo</th>
											<th>Responsable</th>
											<th>Estado</th>
											<!-- <th>Acciones</th> -->
										</tr>
									</thead>
									<tbody>
										<?php
										$date = date('Y-m-d', time());
										$consultacliente = $conn->query("SELECT * FROM `clientes`");
										$contador = 1;
										while ($solicitud = $consultacliente->fetch_array()) {
											$id_cliente = $solicitud['id_cliente'];
											$nombrecliente = $solicitud['nombre_cliente'];
											$apellidos = $solicitud['apellido_cliente'];
											// $email = $solicitud['email_user'];
											$estado = $solicitud['estado'];
											if ($estado == 'cola') {
												$estadoUser = 'En Proceso';
												$color = 'bg-success';
												$ver = '';
											} elseif ($estado == 'cancelada') {
												$estadoUser = 'Cancelada';
												$color = 'bg-secondary';
												$ver = 'display:none';
											} elseif ($estado == 'concluida') {
												$estadoUser = 'Pendiente';
												$color = 'bg-success';
												$ver = '';
											} elseif ($estado == 'pagada') {
												$estadoUser = 'Pagada';
												$color = 'bg-info';
												$ver = 'display:none';
											}
										?>

											<tr id="solicitud:<?php echo $id_cliente ?>">

												<td><?php echo '#' . $contador++; ?></td>
												<td><?php echo $nombrecliente . ' ' . $apellidos ?></td>
												<td>
													<select name="vehiculo<?php echo $id_cliente ?>[]" id="vehiculo">
													<option value="0" name="vehiculo" name="vehiculo<?php echo $id_cliente ?>[]">Seleccionar</option>
														<?php

														$consultavehiculo = $conn->query("SELECT * FROM vehiculos_clientes a, vehiculos b, vehiculos_modelo c where a.id_client = $id_cliente and a.marca_cliente = c.marca_vehiculo and a.marca_cliente = b.id_vehiculo and a.modelo_cliente = c.id_modelo;");
														while ($solicitud = $consultavehiculo->fetch_array()) {
															$id_vehiculocliente = $solicitud['id_vehiculocliente'];
															$marca = $solicitud['marca'];
															$ano_cliente = $solicitud['ano_cliente'];
															$color = $solicitud['color'];
															$placa = $solicitud['placa'];
															// echo $id_vehiculocliente;
														?>
															
															<option value="<?php echo $id_vehiculocliente ?>" name="vehiculo<?php echo $id_cliente ?>[]"><?php echo $marca . ' ' . $color . ', ' . $ano_cliente . ', ' . $placa ?></option>
														<?php
														}
														?>
													</select>
												<td>
													<select name="colaboradores<?php echo $id_cliente ?>[]" id="colaboradores">
													<option value="0" name="colaboradores" name="colaboradores<?php echo $id_cliente ?>[]">Seleccionar</option>
														<?php

														$consultacolaboradores = $conn->query("SELECT * FROM main_users WHERE role_user = 3 or role_user = 5 and asignacion = 0;");
														while ($solicitud = $consultacolaboradores->fetch_array()) {
															$id = $solicitud['id'];
															$usuario_name = $solicitud['usuario_name'];
															$apellidos = $solicitud['apellidos'];
															$nickname = $solicitud['nickname'];
															// echo $id_vehiculocliente;
														?>
															
															<option value="<?php echo $id ?>" name="colaboradores<?php echo $id_cliente ?>[]"><?php echo $usuario_name . ' ' . $apellidos ?></option>
														<?php
														}
														?>
													</select>
												</td>
												<td>
													<input type="hidden" name="idm" value="<?php echo $_GET['idm'] ?>">
													<input type="hidden" name="idcliente" value="<?php echo $id_cliente ?>">
													<input type="hidden" name="" value="<?php echo $nombrecliente . ' ' . $apellidos ?>">
													<!-- <a href="detalle_factura?ID=<?php echo $solicitud['id_orden'] ?>" target="_self"><span class="badge bg-primary"><i class="fas fa-eye"></i>Ver Detalle</span></a> -->
													<label>
														<input type="radio" name="seleccion" value="<?php echo $id_cliente ?>" required>
														Seleccionar
													</label>

												</td>
											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<div class="col-12 d-flex justify-content-end">
									<input type="submit" class="btn btn-primary me-1 mb-1" value="Nuevo Orden">
									<a href="dashboard">
										<div class="btn btn-secondary me-1 mb-1">Regresar</div>
									</a>
								</div>
							</form>
						</div>
					</div>
				</section>
			</div>
		</div>
		<!-- Service End -->
		<?php
		include 'inc/templates/footer.php';
		if (isset($_GET['del'])) {
			if ($_GET['del'] == 1) {
				echo "<script>
				console.log('Hola');
				Swal.fire({
					icon: 'success',
					title: '¡Orden Canceladas!',
					text: 'La orden fue cancelada',
					position: 'center',
					showConfirmButton: true
				}).then(function () {
					// window.location = 'ordenes.php';
				});
			</script>";
			} elseif ($_GET['del'] == 0) {
				echo "<script>
				console.log('Hola');
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'La Orden no se pudo cancelar'
				}).then(function () {
					// window.location = 'ordenes.php';
				});
				</script>";
			}
		}
		?>
		<script>
			function eliminar(orden) {
				console.log("eliminar");
				Swal.fire({
					title: 'Seguro(a)?',
					text: "Esta acción no se puede deshacer",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Sí, cancelar!',
					cancelButtonText: 'Cancelar'
				}).then((result) => {
					if (result.isConfirmed) {
						window.location = 'inc/models/delete.php?delete=true&anular=' + orden;
					} else if (result.isDenied) {
						Swal.fire('Changes are not saved', '', 'info')
					}
				})
			}
		</script>
		<script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
		<script src="assets/js/bootstrap.bundle.min.js"></script>
		<script>
			// Simple Datatable
			let table1 = document.querySelector('#table1');
			let dataTable = new simpleDatatables.DataTable(table1);
		</script>