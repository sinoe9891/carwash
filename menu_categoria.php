<?php
date_default_timezone_set('America/Tegucigalpa');
include 'inc/templates/header.php';
include 'inc/conexion.php';
// include 'inc/sesiones.php';
session_start();
if (!isset($_SESSION['nombre_usuario'])) {
	header('Location: login.php');
	// echo $_SESSION['session'];
	exit;
}else{
	$name = $_SESSION['nombre_usuario'];
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

$nombreboton = 'Buscar';
$busquedainput = 'Buscar';
$busqueda = '';
if (isset($_GET['menu'])) {
	$busqueda = $_GET['menu'];
	if ($busqueda == '') {
		$busquedainput = '';
		$nombreboton = 'Buscar';
	} else {
		$busquedainput = $_GET['menu'];
	}
} else {
	$nombreboton = 'Buscar';
	$busquedainput = '';
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
		<div class="container-xxl">
			<div class="container">
				<div class="text-center wow fadeInUp" data-wow-delay="0.1s">
					<h5 class="section-title ff-secondary text-center text-primary fw-normal">Control</h5>
					<h1 class="mb-5">Categorías</h1>
				</div>
				<section class="section clientes">
					<div class="card">
						<div class="card-body">
							<table class="table table-striped" id="table1">
								<div class="row">
									<form action="menu_admin.php" method="get">
										<div class="col-3">
											<div class="form-group">

											</div>
										</div>

										<div class="col-3">
											<div class="form-group">

											</div>
										</div>
										<div class="col-3">
											<div class="form-group">

											</div>
										</div>
										<div class="col-3">
											<div class="form-group" style="display: flex;justify-content: space-around;">
												<input type="text" style="text-align: left; margin-right: 10px" class="form-control" id="nome" name="menu" value="<?php echo $busquedainput ?>" placeholder="Buscar">
												<input type="submit" value="<?php echo $nombreboton ?>" class="btn btn-primary" Placeholder>
											</div>
										</div>
									</form>
								</div>
								<thead>
									<tr>
										<th>No.</th>
										<th>Icono</th>
										<th>Nombre Categoría</th>
										<th>Descripción</th>
										<th>Estado</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php

									// $busqueda = $_GET['menu'];

									if ($busqueda == '') {
										$consulta = $conn->query("SELECT * FROM categorias_menu ORDER BY nombre_categoria ASC");
									} else if ($busqueda) {
										$consulta = $conn->query("SELECT * FROM categorias_menu LIKE '%$busqueda%' ORDER BY nombre_categoria ASC");
									}
									// $consulta = $conn->query("SELECT * FROM menu WHERE nombre LIKE '%$busqueda%' ORDER BY nombre ASC");
									$contador = 1;
									while ($solicitud = $consulta->fetch_array()) {
										$id = $solicitud['id_categoria'];
										$url_foto = $solicitud['icono'];
										$descripcion = $solicitud['descripcion'];
										$nombre = $solicitud['nombre_categoria'];
										$categoria = $solicitud['nombre_categoria'];
										$estado = $solicitud['estado'];
										if ($estado == 'a') {
											$estadoUser = 'Habilitado';
											$color = 'bg-success';
										} elseif ($estado == 'd') {
											$estadoUser = 'Deshabilitado';
											$color = 'bg-secondary';
										}
									?>
										<tr id="solicitud:<?php echo $solicitud['id'] ?>">
											<td><?php echo $contador++; ?></td>
											<td><img width="50px" ; src="<?php echo $url_foto; ?>" alt=""></td>
											<td><?php echo '   ' . $nombre; ?></td>
											<td><?php echo $descripcion ?></td>
											<td><?php echo '<span class="badge ' . $color . '">' . $estadoUser . '</span>' ?></td>
											<td>
												<a href="edit-categoria?idcategoria=<?php echo $solicitud['id_categoria'] ?>" target="_self"><span class="badge bg-primary"><i class="fas fa-edit"></i>Editar</span></a>
												<span class="badge bg-danger" id="<?php echo $solicitud['id_categoria'] ?>" onclick="eliminar('<?php echo $solicitud['id_categoria'] ?>')">
													<i class="fas fa-trash"></i>Eliminar</span>
											</td>
										</tr>
									<?php
									}
									?>
								</tbody>
							</table>
							<div class="col-12 d-flex justify-content-end">
								<a href="new-categoria" class="btn btn-primary me-1 mb-1">Nueva Categoría</a>
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
					title: '¡Producto Eliminado!',
					text: 'La categoría fue eliminado correctamente',
					position: 'center',
					showConfirmButton: true
				}).then(function () {
					// window.location = 'menu_categoria.php';
				});
			</script>";
			} elseif ($_GET['del'] == 0) {
				echo "<script>
				console.log('Hola');
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'La categoría no se pudo eliminar'
				}).then(function () {
					// window.location = 'menu_categoria.php';
				});
				</script>";
			}
		}
		?>
		<script>
			function eliminar(idcategoria) {
				console.log("eliminar");
				Swal.fire({
					title: 'Seguro(a)?',
					text: "Esta acción no se puede deshacer",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Sí, borrar!',
					cancelButtonText: 'Cancelar'
				}).then((result) => {
					if (result.isConfirmed) {
						window.location = 'inc/models/delete.php?delete=true&idcategoria=' + idcategoria;
					} else if (result.isDenied) {
						Swal.fire('Changes are not saved', '', 'info')
					}
				})
			}
		</script>