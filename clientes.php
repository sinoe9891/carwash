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
							<h3>Clientes</h3>
							<table class="table table-striped" id="table1">
								<thead>
									<tr>
										<th>Código</th>
										<th>Nombre</th>
										<th>Autos</th>
										<th>Estado</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$date = date('Y-m-d', time());
									// while ($solicitud = $consulta->fetch_array()) {
									// $consulta = $conn->query("SELECT * FROM ordenes a, main_users b WHERE a.date = '$date' and a.id_mesero = b.id and a.estado = 'concluida' ORDER BY a.datetime DESC");
									// $consulta = $conn->query("SELECT * FROM ordenes a, main_users b WHERE a.id_mesero = b.id and `estado` NOT IN ('cola') ORDER BY `a`.`id_orden` DESC;");
									$consulta = $conn->query("SELECT * FROM clientes ORDER BY id_cliente ASC;");


									$contador = 1;
									$total = 0;
									while ($solicitud = $consulta->fetch_array()) {
										$id_cliente = $solicitud['id_cliente'];
										$nombre_cliente = $solicitud['nombre_cliente'];
										$apellido_cliente = $solicitud['apellido_cliente'];
										$color = '';
										$estadoUser = '';
										// $email = $solicitud['email_user'];
										$estado = $solicitud['estado'];
										if ($estado == 'habilitado') {
											$estadoUser = 'Habilitado';
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
										<tr id="solicitud:<?php echo $solicitud['id_cliente'] ?>">
											<td><?php echo '#' . $id_cliente; ?></td>
											<td><?php echo $nombre_cliente . ' ' . $apellido_cliente; ?></td>
											<td>
												
													<?php
													$consultacolaboradores = $conn->query("SELECT * FROM clientes a, vehiculos_clientes b WHERE b.id_client = $id_cliente  and a.id_cliente = b.id_client;");
													//contar numero de filas php mysql
													// echo 'SELECT * FROM clientes a, vehiculos_clientes b WHERE b.id_vehiculocliente ='. $id_cliente;
													$rowcount=mysqli_num_rows($consultacolaboradores);
													echo $rowcount;
													?>
												
											</td>
											<td><?php echo '<span class="badge ' . $color . '">' . $estadoUser . '</span>' ?></td>
											<td>
												<a href="detalle_factura?ID=<?php echo $solicitud['id_orden'] ?>" target="_self"><span class="badge bg-primary"><i class="fas fa-eye"></i>Ver Detalle</span></a>

												<span class="badge bg-danger" style='<?php echo $ver ?>' id="<?php echo $solicitud['id_orden'] ?>" onclick="eliminar(<?php echo $id_orden ?>, <?php echo $id_mesa ?>)">
													<i class="fas fa-trash"></i>Anular
												</span>
											</td>
										</tr>
									<?php
									}
									?>
								</tbody>
							</table>
							<div class="col-12 d-flex justify-content-end">
								<a href="new-cliente" class="btn btn-primary me-1 mb-1">Nuevo Registro</a>
								<a href="dashboard">
									<div class="btn btn-secondary me-1 mb-1">Regresar</div>
								</a>
							</div>
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
			function eliminar(orden, idmesa) {
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
						window.location = 'inc/models/delete.php?delete=true&lugar=' + idmesa + '&anular=' + orden;
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