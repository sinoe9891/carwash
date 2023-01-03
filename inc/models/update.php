<?php
include '../conexion.php';
// Actualizar Usuario
if (isset($_POST['user_id']) && isset($_POST['update'])) {
	$bandera = $_POST['update'];
	$id_usuario = $_POST['user_id'];

	if ($bandera == 'Actualizar') {
		$user_id = $_POST['user_id'];
		$nombre = $_POST['nombre'];
		$apellidos = $_POST['apellidos'];
		$nickname = $_POST['nickname'];
		$email = $_POST['email'];
		$role = $_POST['role'];
		$estado = $_POST['estado'];
		$nickname = trim($nickname);
		$email = trim($email);
		$nombre = trim($nombre);
		$apellidos = trim($apellidos);
		$sql = "UPDATE main_users SET usuario_name = '$nombre', apellidos = '$apellidos', nickname = '$nickname', email_user = '$email',  role_user = $role, estado_user = '$estado' WHERE id = $id_usuario";

		if ($conn->query($sql) === TRUE) {
			echo "Record updated successfully";
			header('Location: ../../edit-usuario.php?ID=' . $id_usuario . '&up=1');
		} else {
			header('Location: ../../edit-usuario.php?ID=' . $id_usuario . '&up=0');
		}
	}
};

if (isset($_POST['idm']) && isset($_POST['updatemesa'])) {
	$bandera = $_POST['updatemesa'];
	$idm = $_POST['idm'];
	$role = $_POST['role'];
	$estado = $_POST['estado'];
	if ($role == 0) {
		$asignar = 0;
	} else {
		$asignar = 1;
	}

	if ($bandera == 'Actualizar') {
		$role = $_POST['role'];
		$estado = $_POST['estado'];
		$sql = "UPDATE `mesas` SET `id_mesero` = '$role', `estado_mesa` = '$estado', `asignada` = '$asignar'  WHERE `mesas`.`id_asignacion` = $idm";

		if ($conn->query($sql) === TRUE) {
			echo "Record updated successfully";
			header('Location: ../../edit-mesa.php?idm=' . $idm . '&up=1');
		} else {
			// header('Location: ../../edit-mesa.php?idm='.$idm.'&up=0');
		}
	}
};

if (isset($_POST['idplato']) && isset($_POST['updateplato'])) {
	$idplato = $_POST['idplato'];
	$nombreplato = $_POST['nombreplato'];
	$precio = $_POST['precio'];
	$precioferta = $_POST['precioferta'];
	$categoria = $_POST['categoria'];
	$estado = $_POST['estado'];
	$descripcion = $_POST['descripcion'];
	if (isset($_POST['precioferta'])) {
		$preciooferta = $_POST['precioferta'];
		if ($preciooferta == 0) {
			echo 'Entró3';
			$oferta = 0;
			$preciooferta = 0.00;
		} else {
			echo 'Entró2';
			$oferta = 1;
		}
	}


	$url = $_POST['url'];
	$fechaActual = date('dmy-h-i-s');
	if ($_FILES['imagen']['name'] != null) {
		// echo "Tiene datos La variable";
		$imagen = $_FILES['imagen']['name'];
		// $ruta = 'D:/xampp7.2/htdocs/ceutec/proyecto-conn/images/'.$url;
		$rutaproductos = '/Applications/XAMPP/xamppfiles/htdocs/personales/carwash/img/productos/';
		if (file_exists($rutaproductos)) {
			// echo "<br> La carpeta " . $rutaproductos . " ya existe<br>";
			$tipo = $_FILES['imagen']['type'];
			$tamano = $_FILES['imagen']['size'];
			$temp = $_FILES['imagen']['tmp_name'];
			$ruta = '/Applications/XAMPP/xamppfiles/htdocs/personales/carwash/img/productos/' . $imagen;
			// echo $imagen;
			// Existe la image?
			if (file_exists($ruta)) {
				// echo "<br>La imagen $ruta ya existe se generará una nueva<br>";
				//Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
				chmod($rutaproductos, 0777);
				// Mover el archivo a la carpeta
				list($base, $extension) = explode('.', $imagen);
				$newname = implode('.', [$base, $fechaActual, $extension]);
				move_uploaded_file($temp, "$rutaproductos/$newname");
				echo $newname . '<br>';
			} else {
				echo "<br>La imagen $ruta no existe<br>";
				chmod($rutaproductos, 0777);
				// Mover el archivo a la carpeta
				list($base, $extension) = explode('.', $imagen);
				$newname = implode('.', [$fechaActual, $extension]);
				move_uploaded_file($temp, "$rutaproductos/$newname");
			}
			$sql = "UPDATE `menu` SET `nombre` = '$nombreplato', `descripcion` = '$descripcion', `precio` = '$precio', `categoria` = '$categoria', `url_foto` = 'img/productos/$newname', `oferta` = '$oferta', `precio_oferta` = '$preciooferta', `estado_plato` = '$estado'  WHERE `menu`.`id` = $idplato";

			if ($conn->query($sql) === TRUE) {
				echo "Record updated successfully";
				header('Location: ../../edit-plato.php?idplato='.$idplato.'&up=1');
			} else {
				// header('Location: ../../edit-plato.php?idm='.$idm.'&up=0');
			}
		} else {
			// echo "<br>El fichero $rutaproductos no existe<br>";
			mkdir($rutaproductos, 0777);
			chmod($rutaproductos, 0777);
			// Mover el archivo a la carpeta
			list($base, $extension) = explode('.', $imagen);
			$newname = implode('.', [$fechaActual, $extension]);
			move_uploaded_file($temp, "$rutaproductos/$newname");

			$tipo = $_FILES['imagen']['type'];
			$tamano = $_FILES['imagen']['size'];
			$temp = $_FILES['imagen']['tmp_name'];
			$ruta = '/Applications/XAMPP/xamppfiles/htdocs/personales/carwash/img/productos/' . $newname;
			echo $newname . '<br>';
			// Existe la image?
			if (file_exists($ruta)) {
				echo "<br>La imagen $ruta ya existe<br>";
			} else {
				echo "<br>La imagen $ruta no existe<br>";
			}
			//Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
			chmod($ruta, 0777);
			move_uploaded_file($temp, $ruta);
			$sql = "UPDATE `menu` SET `nombre` = '$nombreplato', `descripcion` = '$descripcion', `precio` = '$precio', `categoria` = '$categoria', `url_foto` = 'img/productos/$newname', `oferta` = '$oferta', `precio_oferta` = '$preciooferta', `estado_plato` = '$estado'  WHERE `menu`.`id` = $idplato";

			if ($conn->query($sql) === TRUE) {
				echo "Record updated successfully";
				header('Location: ../../edit-plato.php?idplato='.$idplato.'&up=1');
			} else {
				// header('Location: ../../edit-plato.php?idm='.$idm.'&up=0');
			}
		}
	} else {
		$sql = "UPDATE `menu` SET `nombre` = '$nombreplato', `descripcion` = '$descripcion', `precio` = '$precio', `categoria` = '$categoria', `url_foto` = '$url', `oferta` = '$oferta', `precio_oferta` = '$preciooferta', `estado_plato` = '$estado'  WHERE `menu`.`id` = $idplato";
		echo $url;
		echo 'Entró en el último';
		if ($conn->query($sql) === TRUE) {
			echo "Record updated successfully";
			header('Location: ../../edit-plato.php?idplato='.$idplato.'&up=1');
		} else {
			// header('Location: ../../edit-plato.php?idm='.$idm.'&up=0');
		}
	}
};
// Editar Categoría
if (isset($_POST['idcategoria']) && isset($_POST['updatecategoria'])) {
	$idcategoria = $_POST['idcategoria'];
	$nombrecategoria = $_POST['nombrecategoria'];
	$estado = $_POST['estado'];
	$descripcion = $_POST['descripcion'];
	$url = $_POST['url'];
	$fechaActual = date('dmy-h-i-s');
	if ($_FILES['imagen']['name'] != null) {
		// echo "Tiene datos La variable";
		$imagen = $_FILES['imagen']['name'];
		// $ruta = 'D:/xampp7.2/htdocs/ceutec/proyecto-conn/images/'.$url;
		$rutaproductos = '/Applications/XAMPP/xamppfiles/htdocs/personales/carwash/img/categorias/';
		if (file_exists($rutaproductos)) {
			// echo "<br> La carpeta " . $rutaproductos . " ya existe<br>";
			$tipo = $_FILES['imagen']['type'];
			$tamano = $_FILES['imagen']['size'];
			$temp = $_FILES['imagen']['tmp_name'];
			$ruta = '/Applications/XAMPP/xamppfiles/htdocs/personales/carwash/img/categorias/' . $imagen;
			// echo $imagen;
			// Existe la image?
			if (file_exists($ruta)) {
				// echo "<br>La imagen $ruta ya existe se generará una nueva<br>";
				//Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
				chmod($rutaproductos, 0777);
				// Mover el archivo a la carpeta
				list($base, $extension) = explode('.', $imagen);
				$newname = implode('.', [$base, $fechaActual, $extension]);
				move_uploaded_file($temp, "$rutaproductos/$newname");
				echo $newname . '<br>';
			} else {
				echo "<br>La imagen $ruta no existe<br>";
				chmod($rutaproductos, 0777);
				// Mover el archivo a la carpeta
				list($base, $extension) = explode('.', $imagen);
				$newname = implode('.', [$fechaActual, $extension]);
				move_uploaded_file($temp, "$rutaproductos/$newname");
			}
			$sql = "UPDATE `categorias_menu` SET `nombre_categoria` = '$nombrecategoria', `descripcion` = '$descripcion', `icono` = 'img/categorias/$newname',  `estado` = '$estado'  WHERE `categorias_menu`.`id_categoria` = $idcategoria";

			if ($conn->query($sql) === TRUE) {
				echo "Record updated successfully";
				header('Location: ../../edit-categoria?idcategoria='.$idcategoria.'&up=1');
			} else {
				// header('Location: ../../edit-categoria?idm='.$idm.'&up=0');
			}
		} else {
			// echo "<br>El fichero $rutaproductos no existe<br>";
			mkdir($rutaproductos, 0777);
			chmod($rutaproductos, 0777);
			// Mover el archivo a la carpeta
			list($base, $extension) = explode('.', $imagen);
			$newname = implode('.', [$fechaActual, $extension]);
			move_uploaded_file($temp, "$rutaproductos/$newname");

			$tipo = $_FILES['imagen']['type'];
			$tamano = $_FILES['imagen']['size'];
			$temp = $_FILES['imagen']['tmp_name'];
			$ruta = '/Applications/XAMPP/xamppfiles/htdocs/personales/carwash/img/categorias/' . $newname;
			echo $newname . '<br>';
			// Existe la image?
			if (file_exists($ruta)) {
				echo "<br>La imagen $ruta ya existe<br>";
			} else {
				echo "<br>La imagen $ruta no existe<br>";
			}
			//Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
			chmod($ruta, 0777);
			move_uploaded_file($temp, $ruta);
			$sql = "UPDATE `categorias_menu` SET `nombre_categoria` = '$nombrecategoria', `descripcion` = '$descripcion', `icono` = 'img/categorias/$newname', `estado` = '$estado'  WHERE `categorias_menu`.`id_categoria` = $idcategoria";

			if ($conn->query($sql) === TRUE) {
				echo "Record updated successfully";
				// header('Location: ../../edit-categoria?idcategoria='.$idcategoria.'&up=1');
			} else {
				// header('Location: ../../edit-categoria?idm='.$idm.'&up=0');
			}
		}
	} else {
		$sql = "UPDATE `categorias_menu` SET `nombre_categoria` = '$nombrecategoria', `descripcion` = '$descripcion', `icono` = '$url', `estado` = '$estado'  WHERE `categorias_menu`.`id_categoria` = $idcategoria";
		echo $url;
		echo 'Entró en el último';
		if ($conn->query($sql) === TRUE) {
			echo "Record updated successfully";
			header('Location: ../../edit-categoria?idcategoria='.$idcategoria.'&up=1');
		} else {
			// header('Location: ../../edit-categoria.php?idm='.$idm.'&up=0');
		}
	}
};
