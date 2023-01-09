<?php
date_default_timezone_set('America/Tegucigalpa');
include 'inc/templates/header.php';
include 'inc/conexion.php';
// include 'inc/sesiones.php';
session_start();
$name = $_SESSION['nombre_usuario'];
$id_user = $_SESSION['id'];
$idmesa = $_POST['idm'];
$seleccion = $_POST['seleccion'];

$idcliente = $_POST['idcliente'];
// $vehiculo = $_POST['vehiculo'];
// var_dump($_POST);
$bandera = 0;
foreach ($_POST as $nombre_campo => $valor) {

	if (gettype($valor) == 'array') {
		$bandera++;
		// echo '<br>'.$bandera++.'<br>';
		for ($i = 0; $i < count($valor); $i++) {
			// $idvehiculo = $valor[$i];
			// echo $bandera;
			if ($bandera == 1) {
				$idvehiculo = $valor[$i];
				// echo $nombre_campo.': '. $idvehiculo.'<br>';
				// $idresponsable = $valor[$i];
			}
			if ($bandera == 2) {
				$responsable = $valor[$i];
				// echo $nombre_campo.': '. $idvehiculo.'<br>';
				// $idresponsable = $valor[$i];
			} else {
				$alerta = 'No se seleccionó ningún vehículo';
			}
			// $consultavehiculo = $conn->query0("SELECT * FROM vehiculos_clientes a, vehiculos b, vehiculos_modelo c, clientes d where a.id_client = d.id_cliente and a.id_vehiculocliente = $valor[$i] and a.id_client = $seleccion and a.marca_cliente = c.marca_vehiculo and a.marca_cliente = b.id_vehiculo and a.modelo_cliente = c.id_modelo;");
			// while ($solicitud = $consultavehiculo->fetch_array()) {
			// 	$id_vehiculocliente = $solicitud['id_vehiculocliente'];
			// 	$marca = $solicitud['marca'];
			// 	$ano = $solicitud['ano_cliente'];
			// 	$color = $solicitud['color'];
			// 	echo '<h5>Vehículo:' . $marca . '</h5>';
			// 	echo '<h5>Año:' . $ano . '</h5>';
			// 	echo '<h5>Color:' . $color . '</h5>';
			// 	echo '<br>';
			// }
			// echo 'ENTRÓ';
		}
	}
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
				<div class="tab-class text-center wow " data-wow-delay="0.1s">
					<form action="ordenar" method="post" enctype="multipart/form-data">
						<div class="text-center wow " data-wow-delay="0.1s">
							<h5 class="section-title ff-secondary text-center text-primary fw-normal">Orden</h5>
							<div class="cliente" style="text-align: left;">
								<?php
								$consultavehiculo = $conn->query("SELECT * FROM vehiculos_clientes a, vehiculos b, vehiculos_modelo c, clientes d, main_users e where a.id_client = d.id_cliente and a.id_vehiculocliente = $idvehiculo and a.id_client = $seleccion and a.marca_cliente = c.marca_vehiculo and a.marca_cliente = b.id_vehiculo and a.modelo_cliente = c.id_modelo and a.modelo_cliente = c.id_modelo and e.id = $responsable;");
								// var_dump($consultavehiculo);
								while ($solicitud = $consultavehiculo->fetch_array()) {
									$id_vehiculocliente = $solicitud['id_vehiculocliente'];
									$nombre_cliente = $solicitud['nombre_cliente'];
									$apellido_cliente = $solicitud['apellido_cliente'];
									$nickname = $solicitud['nickname'];
									$id_cliente = $solicitud['id_cliente'];
									$marca = $solicitud['marca'];
									$ano = $solicitud['ano_cliente'];
									$color = $solicitud['color'];
									echo '<h5>ID: ' . $id_cliente . '</h5>';
									echo '<h5>Cliente: ' . $nombre_cliente . ' ' . $apellido_cliente . '</h5>';
									echo '<h5>Vehículo: ' . $marca . '</h5>';
									echo '<h5>Año: ' . $ano . '</h5>';
									echo '<h5>Color: ' . $color . '</h5>';
									echo '<h5>Responsable: ' . $nickname . '</h5>';
								?>

								<?php
								}
								?>

							</div>
						</div>
						<section class="section clientes">
							<div class="card">
								<div class="card-body">
									<h3>Seleccionar Productos</h3>
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
												<th>Fecha</th>
												<th>Producto</th>
												<th>Categoría</th>
												<th>Precio</th>
												<!-- <th>Oferta</th> -->
												<th>Acciones</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$date = date('Y-m-d', time());
											// while ($solicitud = $consulta->fetch_array()) {
											// $consulta = $conn->query("SELECT * FROM ordenes a, main_users b WHERE a.date = '$date' and a.id_mesero = b.id and a.estado = 'concluida' ORDER BY a.datetime DESC");
											// $consulta = $conn->query("SELECT * FROM ordenes a, main_users b WHERE a.id_mesero = b.id and `estado` NOT IN ('cola') ORDER BY `a`.`id_orden` DESC;");
											$consulta = $conn->query("SELECT * FROM menu a, categorias_menu b WHERE estado_plato = 'a' and a.categoria = b.id_categoria ORDER BY `b`.`nombre_categoria` DESC");
											$contador = 1;
											while ($solicitud = $consulta->fetch_array()) {
												$idplato = $solicitud['id'];
												$nombre = $solicitud['nombre'];
												$nombre_categoria = $solicitud['nombre_categoria'];
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
												<tr id="solicitud:<?php echo $solicitud['id_orden'] ?>">
													<td><?php echo $idplato; ?></td>
													<td><img class="flex-shrink-0 img-fluid rounded" src="<?php echo $url_foto ?>" alt="" style="width: 80px;"></td>
													<td><?php echo $nombre ?></td>
													<td><?php echo $nombre_categoria ?></td>
													<td><?php if ($oferta == 1) {
															echo '<div style="text-align:;"><div><span class="text-primary" style="font-size: 13px;text-decoration: line-through !important;">Antes L.' . $precio . '</span></div><div><span class="text-primary" style="color:#dc3545 !important;">Oferta L. ' . $precio_oferta . '</span></div></div>';
														} else {
															echo '<span style="text-align: right;" class="text-primary">L.' . $precio . '</span>';
														}; ?></td>
													<!-- <td><?php echo $precio_oferta ?></td> -->
													<td>
														<label>
															<input type="checkbox" name="menu[]" id="" value="<?php echo $idplato ?>">
															Seleccionar
														</label>

													</td>
												</tr>
											<?php
											}
											?>
										</tbody>
									</table>

									<div class="col-12 d-flex justify-content-end wow fadeInUp" data-wow-delay="0.1s">
										<input type="hidden" class="btn btn-primary me-1 mb-1" id="tipo" name="idvehiculocliente" value="<?php echo $idvehiculo  ?>">
										<input type="hidden" class="btn btn-primary me-1 mb-1" id="tipo" name="seleccion" value="<?php echo $seleccion ?>">
										<input type="hidden" class="btn btn-primary me-1 mb-1" id="tipo" name="responsable" value="<?php echo $responsable ?>">
										<input type="hidden" class="btn btn-primary me-1 mb-1" id="tipo" name="mesa" value="<?php echo $idmesa ?>">
										<input type="hidden" class="btn btn-primary me-1 mb-1" id="tipo" name="mesero" value="<?php echo $id_user ?>">
										<input type="hidden" class="btn btn-primary me-1 mb-1" id="tipo" name="accion" value="newOrden">
										<input class="btn btn-primary me-1 mb-1" type="submit" value="Siguiente" name="crearorden">
										<a href="menu_cliente?idm=<?php echo $idmesa ?>">
											<div class="btn btn-secondary me-1 mb-1">Regresar</div>
										</a>
									</div>
								</div>
							</div>
						</section>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- Menu End -->


	<?php
	include 'inc/templates/footer.php';
	?>
	<script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script>
		// Simple Datatable
		let table1 = document.querySelector('#table1');
		let dataTable = new simpleDatatables.DataTable(table1);
	</script>