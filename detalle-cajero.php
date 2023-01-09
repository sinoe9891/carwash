<?php
date_default_timezone_set('America/Tegucigalpa');
include 'inc/templates/header.php';
include 'inc/conexion.php';
// include 'inc/sesiones.php';
session_start();
$name = $_SESSION['nombre_usuario'];
$id_user = $_SESSION['id'];

if (isset($_GET['ID'])) {
	$ID = $_GET['ID'];
} else {
	header('Location: ordenes_admin');
}

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

$consulta = $conn->query("SELECT * FROM `facturas` order by no_factura DESC LIMIT 1");
// $contador = 1;
$ultimaorden = 0;

$sql = "SELECT * FROM `ordenes` order by id_orden DESC LIMIT 1";

if ($result = mysqli_query($conn, $sql)) {
	$rowcount = mysqli_num_rows($result);
	if ($rowcount > 0) {
		while ($solicitud = $consulta->fetch_array()) {
			$ultimaorden = $solicitud['no_factura'];
		}
	} else {
		$ultimaorden = 0;
	}
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
							<form action="inc/models/insert.php" name="formulario" method="post">
								<?php
									$orden = $conn->query("SELECT * FROM ordenes a, main_users b, clientes c WHERE a.id_orden = $ID and b.id = a.responsable and a.id_cliente = c.id_cliente;");
									$contador = 1;
									$total = 0;
									while ($solicitud = $orden->fetch_array()) {
										$datetime = $solicitud['datetime'];
										$id_mesa = $solicitud['id_mesa'];
										$id_mesero = $solicitud['id_mesero'];
										$username = $solicitud['nickname'];
										$responsable = $solicitud['responsable'];
										$nombre_cliente = $solicitud['nombre_cliente'];
										$apellido_cliente = $solicitud['apellido_cliente'];
										$id_vehiculo = $solicitud['id_vehiculo'];
										$apellidos = $solicitud['apellidos'];
										$estado = $solicitud['estado_orden'];
										if ($estado == 'cola') {
											$estadoFactura = 'En Proceso';
											$color = 'bg-success';
											$ultimaorden = $ultimaorden + 1;
											$verfactura = 'display:none';
										} elseif ($estado == 'cancelada') {
											$estadoFactura = 'Cancelada';
											$color = 'bg-secondary';
											$ver = 'display:none';
											$verfactura = 'display:none';
										} elseif ($estado == 'concluida') {
											$estadoFactura = 'Pendiente';
											$color = 'bg-success';
											$ver = '';
										} elseif ($estado == 'pagada') {
											$estadoFactura = 'Pagada';
											$ultimaorden = $ultimaorden;
											$color = 'bg-success';
											$ver = 'display:none';
											$verfactura = '';
										}elseif ($estado == ''){
											$estadoFactura = '';
											$color = 'bg-success';
											$ver = '';
										}
									};
								?>
								<h3>Factura No. #<?php echo $ultimaorden; ?> <?php echo '| <span style="color:green;">'.$estadoFactura.'</span>' ?></h3>
								<h5>Orden: <?php echo $ID ?></h5>
								<h5>Fecha: <?php echo $datetime ?></h5>
								<h5>Cliente: <?php echo $nombre_cliente . ' ' . $apellido_cliente ?></h5>
								<h5>Responsable: <?php echo $username; ?></h5>
								<h5>Ubicación No. <?php echo $id_mesa; ?></h5>
								<input type="hidden" name="nombrecliente" value="<?php echo $nombre_cliente . ' ' . $apellido_cliente; ?>">
								<input type="hidden" name="responsable" value="<?php echo $responsable; ?>">
								<input type="hidden" name="id_vehiculo" value="<?php echo $id_vehiculo; ?>">
								<table class="table table-striped" id="table1">
									<thead>
										<tr>
											<th>No.</th>
											<th>Producto</th>
											<th>Categoría</th>
											<th>Precio Unitario</th>
											<th>Cantidad</th>
											<th>Oferta</th>
											<th>Subtotal</th>
											<!-- <th>Estado</th> -->
											<!-- <th>Acciones</th> -->
										</tr>
									</thead>
									<tbody>

										<?php
										$consulta = $conn->query("SELECT * FROM orden_detalle a, categorias_menu b, menu c WHERE a.id_orden_detalle = $ID and c.categoria = b.id_categoria and a.id_plato = c.id;");
										$contador = 1;
										$total = 0;
										while ($solicitud = $consulta->fetch_array()) {
											$descripcion = $solicitud['nombre'];
											$nombre_categoria = $solicitud['nombre_categoria'];
											$precio = $solicitud['precio_plato'];
											$cantidad = $solicitud['cantidad'];
											$descuento = $solicitud['descuento'];
											$subtotal = $solicitud['subtotal'];
											$id_orden_detalle = $solicitud['id_orden_detalle'];
											if ($descuento > 0) {
												// $precio = $precioplato;
												$check = 'L. '.$descuento.' ✅ ';
											} else {
												// $precio = $precioplato;
												$check = 'L. 00.00';
											}
										?>
											<tr id="solicitud:<?php echo $solicitud['id'] ?>">
												<td><?php echo $contador++; ?></td>
												<td><?php echo $descripcion; ?></td>
												<td><?php echo $nombre_categoria; ?></td>
												<td><?php echo 'L. ' . $precio ?></td>
												<td><?php echo $cantidad; ?></td>
												<td><?php echo $check; ?></td>
												<td><?php echo 'L. ' . $subtotal; ?></td>
											</tr>
										<?php
											$total += $subtotal;
										}

										?>
									</tbody>
									<thead>
										<tr>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th style="text-align: right;">Subtotal</th>
											<th><?php
												echo 'L. ' . sprintf('%.2f', $total);
												// echo 'L. ' . sprintf('%.2f', $total);
												?></th>
										</tr>
										<tr>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th style="text-align: right;">Impuesto</th>
											<th><?php
												$impuesto = 0.15;
												$impuestototal = $total * $impuesto;
												echo 'L. ' . sprintf('%.2f', ($impuestototal));
												// echo 'L. ' . sprintf('%.2f', $total);
												?></th>
										</tr>
										<tr>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th style="text-align: right;">Total</th>
											<th><?php
												$grantotal = $total + $impuestototal;
												$descuento = 0;
												$propina = 0;
												echo 'L. ' . sprintf('%.2f', $grantotal);
												?></th>
										</tr>
									</thead>
									<?php
									// echo '<br>Total' . $total . '<br>';
									?>
								</table>
								<div class="col-12 d-flex justify-content-end">
									<input type="hidden" class="btn btn-primary me-1 mb-1" name="id_orden" value="<?php echo $ID ?>">
									<input type="hidden" class="btn btn-primary me-1 mb-1" name="datetime" value="<?php echo $datetime  ?>">
									<input type="hidden" class="btn btn-primary me-1 mb-1" name="idmesero" value="<?php echo $id_mesero ?>">
									<input type="hidden" class="btn btn-primary me-1 mb-1" name="total" value="<?php echo $total ?>">
									<input type="hidden" class="btn btn-primary me-1 mb-1" name="id_mesa" value="<?php echo $id_mesa ?>">
									<input type="hidden" class="btn btn-primary me-1 mb-1" name="descuento" value="<?php echo $descuento ?>">
									<input type="hidden" class="btn btn-primary me-1 mb-1" name="propina" value="<?php echo $propina ?>">
									<input type="hidden" class="btn btn-primary me-1 mb-1" name="grantotal" value="<?php echo $grantotal ?>">
									<input type="hidden" class="btn btn-primary me-1 mb-1" name="impuestototal" value="<?php echo $impuestototal ?>">
									<input type="hidden" class="btn btn-primary me-1 mb-1" name="accion" value="facturacrearcajero">
									<div class="btn btn-info me-1 mb-1" style='<?php echo $verfactura ?>' onclick="verFactura()" value="Cocinar">Ver Factura</div>
									<div class="btn btn-primary me-1 mb-1" style='<?php echo $ver ?>' onclick="enviarFactura()" value="Cocinar">Pagar</div>
									<a href="ordenes">
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
					title: 'Pago realizado!',
					text: 'El pago fue realizado correctamente',
					position: 'center',
					showConfirmButton: true
				}).then(function () {
					// window.location = 'usuarios.php';
				});
			</script>";
			} elseif ($_GET['del'] == 0) {
				echo "<script>
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'El pago no se pudo realizar'
				}).then(function () {
					// window.location = 'usuarios.php';
				});
				</script>";
			}
		}
		?>
		<script>
			function enviarFactura() {
				Swal.fire({
					title: 'Seguro(a)?',
					text: "Todo lo que el cliente solicitó esta en la factura?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Sí, ordenar!',
					cancelButtonText: 'Cancelar'
				}).then((result) => {
					if (result.isConfirmed) {
						document.formulario.submit()
						// window.location = 'inc/models/insert.php';
					} else if (result.isDenied) {
						Swal.fire('No sé ordenó', '', 'info')
					}
				})
			}
			function verFactura() {
				Swal.fire({
					title: 'Seguro(a)?',
					text: "Ver factura",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ver Factura!',
					cancelButtonText: 'Cancelar'
				}).then((result) => {
					if (result.isConfirmed) {
						// document.formulario.submit()
						window.open('doc/factura.php?ID=<?php echo $ID; ?>&add=1', '_blank');
					} else if (result.isDenied) {
						Swal.fire('No sé ordenó', '', 'info')
					}
				})
			}
		</script>