<?php
include '../conexion.php';

if (isset($_GET['delete']) && isset($_GET['id'])) {
	$accion = $_GET['delete'];
	$id = $_GET['id'];
	if ($accion === 'true') {

		$sql = "DELETE FROM `main_users` WHERE `main_users`.`id` = '$id'";
		if (mysqli_query($conn, $sql)) {
			echo 'Insertó';
			header('Location: ../../usuarios?del=1');
		} else {
			// header('Location: ../../usuarios?del=0');
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
}
if (isset($_GET['delete']) && isset($_GET['orden'])) {
	$accion = $_GET['delete'];
	$id_orden = $_GET['orden'];
	$lugar = $_GET['lugar'];
	if ($accion === 'true') {
		$sql = "UPDATE ordenes SET estado_orden = 'cancelada' WHERE id_orden = $id_orden";
		if (mysqli_query($conn, $sql)) {
			echo 'Insertó';
			$sqlmesa = "UPDATE mesas SET ocupada = 0, noordenocupada = 0 WHERE id_asignacion = $lugar";
			mysqli_query($conn, $sqlmesa);
			header('Location: ../../ordenes?del=1');
		} else {
			// header('Location: ../../usuarios?del=0');
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
}

if (isset($_GET['delete']) && isset($_GET['anular'])) {
	$accion = $_GET['delete'];
	$id_orden = $_GET['anular'];
	$lugar = $_GET['lugar'];
	if ($accion === 'true') {
		$sql = "UPDATE ordenes SET estado_orden = 'cancelada' WHERE id_orden = $id_orden";
		if (mysqli_query($conn, $sql)) {
			echo 'Insertó';
			$sqlmesa = "UPDATE mesas SET ocupada = 0, noordenocupada = 0 WHERE id_asignacion = $lugar";
			mysqli_query($conn, $sqlmesa);
			header('Location: ../../ordenes_admin?del=1');
			echo "Error: " . $sqlmesa . "<br>" . mysqli_error($conn);
		} else {
			header('Location: ../../ordenes_admin?del=0');
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
}

if (isset($_GET['delete']) && isset($_GET['idm'])) {
	$accion = $_GET['delete'];
	$id = $_GET['idm'];
	if ($accion === 'true') {
		$sql = "DELETE FROM `mesas` WHERE `mesas`.`id` = '$id'";
		if (mysqli_query($conn, $sql)) {
			echo 'Insertó';
			header('Location: ../../mesas?del=1');
		} else {
			header('Location: ../../mesas?del=0');
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
}

if (isset($_GET['delete']) && isset($_GET['idplato'])) {
	$accion = $_GET['delete'];
	$id = $_GET['idplato'];
	if ($accion === 'true') {
		$sql = "DELETE FROM `menu` WHERE `menu`.`id` = '$id'";
		if (mysqli_query($conn, $sql)) {
			echo 'Insertó';
			header('Location: ../../menu_admin?del=1');
		} else {
			header('Location: ../../menu_admin?del=0');
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
}

if (isset($_GET['delete']) && isset($_GET['idcategoria'])) {
	$accion = $_GET['delete'];
	$id = $_GET['idcategoria'];
	if ($accion === 'true') {
		$sql = "DELETE FROM `categorias_menu` WHERE `categorias_menu`.`id_categoria` = '$id'";
		if (mysqli_query($conn, $sql)) {
			echo 'Insertó';
			header('Location: ../../menu_categoria?del=1');
		} else {
			header('Location: ../../menu_categoria?del=0');
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
}