<?php
date_default_timezone_set('America/Tegucigalpa');
include 'inc/templates/header.php';
include 'inc/conexion.php';
// include 'inc/sesiones.php';
session_start();
$name = $_SESSION['nombre_usuario'];
$accion = $_POST['accion'];
$id_user = $_SESSION['id'];
$idmesa = $_POST['mesa'];
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
$consulta = $conn->query("SELECT * FROM `ordenes` order by id_orden DESC LIMIT 1");
// $contador = 1;
$ultimaorden = 0;

$sql = "SELECT * FROM `ordenes` order by id_orden DESC LIMIT 1";

if ($result = mysqli_query($conn, $sql)) {
	$rowcount = mysqli_num_rows($result);
	if ($rowcount > 0) {
		while ($solicitud = $consulta->fetch_array()) {
			$ultimaorden = $solicitud['id_orden'];
		}
	} else {
		$ultimaorden = 0;
	}
}


?>
<style>
	input[type="text"] {
		background: transparent;
		border: none;
		color: #777676;
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
								<H1>Orden #<?php echo $ultimaorden + 1 ?></H1>
								<table class="table table-striped" id="table1" >
									<thead>
										<tr>
											<th>No.</th>
											<th>Producto</th>
											<th>Cantidad</th>
											<th>Precio Unitario</th>
											<th>Oferta</th>
											<th>Subtotal</th>
											<!-- <th>Estado</th> -->
											<!-- <th>Acciones</th> -->
										</tr>
									</thead>
									<tbody onclick="sumatoria(this)" id="tablebody">
										<?php
										if ($accion === 'newOrden') {
											// include '../conexion.php';
											$mesa = $_POST['mesa'];
											$mesero = $_POST['mesero'];
											// $checkBox = implode(',', $_POST['menu']);

											// echo $mesa . ' Mesa</br>';
											// echo $mesero . ' Mesero</br>';
											$DateAndTime = date('Y-m-d h:i:s', time());
											$date = date('Y-m-d', time());
											$total = 0;
											$contador = 1;
											$elemento = 0;
											foreach ($_POST['menu'] as $key => $val) {
												$consulta = $conn->query("SELECT * FROM `menu` WHERE id = $val");
												// $contador = 1;
												while ($solicitud = $consulta->fetch_array()) {
													$nombre = $solicitud['nombre'];
													$id_plato = $solicitud['id'];
													$precio = $solicitud['precio'];
													$oferta = $solicitud['precio_oferta'];
													if ($oferta == 0.00) {
														$totaloferta = 0.00;
													}else{
														$totaloferta = $precio - $oferta;
													}
													// $totaloferta = $precio - $oferta;
													$subtotal = ($precio - $totaloferta);
													$total +=  $subtotal;
										?>

													<tr id="solicitud:<?php echo $solicitud['id'] ?>" class="elemento<?php echo $elemento++ ?>" onclick="acceso(this);">
														<td><?php echo $contador++; ?></td>
														<td><?php echo $nombre ?></td>
														<td><input type="number" class='cantidad<?php echo $elemento ?>' name="cantidad[]" value="1" placeholder="" onclick="click(this)"></td>
														<td>L.
															<input type="text" name="precio" id="precio<?php echo $elemento ?>" value="<?php echo $precio ?>" readonly>
														</td>
														<td>L.
															<input type="text" name="descuento" id="totaloferta<?php echo $elemento ?>" value="<?php echo $totaloferta ?>" readonly>
														</td>
														<td>L.
															<input type="text" name="subtotal" class='subtotal' id="subtotal<?php echo $elemento ?>" value="<?php echo $subtotal ?>">
														</td>
														<input type="hidden" class="btn btn-primary me-1 mb-1" id="tipo" name="menuplato[]" value="<?php echo $id_plato ?>">
												<?php
												}
											}
												?>
									</tbody>
									<thead>
										<tr>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th>Total</th>
											<th>
												L. <input type="text" name="supertotal" id="supertotal" value="<?php echo sprintf('%.2f', $total) ?>">
											</th>
										</tr>
									</thead>
								<?php
											// echo '<br>Total' . $total . '<br>';
										}

								?>

								</table>
								<div class="col-12 d-flex justify-content-end">
									<input type="hidden" class="btn btn-primary me-1 mb-1" id="tipo" name="mesa" value="<?php echo $idmesa ?>">
									<input type="hidden" class="btn btn-primary me-1 mb-1" id="tipo" name="mesero" value="<?php echo $id_user ?>">
									<input type="hidden" class="btn btn-primary me-1 mb-1" id="tipo" name="accion" value="newOrden">
									<!-- <input type="submit" class="btn btn-primary me-1 mb-1" name="name" value="Cocinar" onclick="enviarorden()"> -->
									<div class="btn btn-primary me-1 mb-1" onclick="enviarorden()" value="Cocinar">Ordenar</div>
									<a href="menu_mesero?idm=<?php echo $idmesa; ?>">
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
					title: '¡Usuario Eliminado!',
					text: 'El usuario fue eliminado correctamente',
					position: 'center',
					showConfirmButton: true
				}).then(function () {
					// window.location = 'usuarios.php';
				});
			</script>";
			} elseif ($_GET['del'] == 0) {
				echo "<script>
				console.log('Hola');
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'El usuario no se pudo eliminar'
				}).then(function () {
					// window.location = 'usuarios.php';
				});
				</script>";
			}
		}
		?>
		<script>
			// console.log(form);
			function acceso(clase) {
				let clasefirme = clase.children[2].firstChild.value;
				clase.addEventListener('click', (event) => {
					cantidad = 1;
					cantidad = clase.children[2].childNodes[0].value;
					let precio = clase.children[3].childNodes[1].value;
					let totaloferta = clase.children[4].childNodes[1].value;
					let result = document.getElementById(clase.children[5].childNodes[1].id);
					let subtotal = cantidad * (precio - totaloferta);
					result.value = subtotal;
				});
			}

			function sumatoria(clase) {
				console.log(clase);
				// console.log(clase.children[1].childNodes[1].childNodes[11].childNodes[1].value);
				let cantidadfilas = clase.children.length;
				// console.log(cantidadfilas);
				let array = [];
				let supertotal = 0;
				for (let i = 0; i < cantidadfilas; i++) {
					// console.log(clase.children[i]);
					let element = clase.children[i].childNodes[11].lastElementChild.value;
					supertotal += Number(element);
					let total = document.getElementById('supertotal');
					total.value = supertotal;
				}

			}

			let total = document.getElementById('supertotal').value;
			// console.log(total)


			function enviarorden() {
				console.log("eliminar");
				Swal.fire({
					title: 'Seguro(a)?',
					text: "Todo lo que el cliente solicitó esta en la orden?",
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
		</script>