<?php
// include '../conexion.php';
date_default_timezone_set('America/Tegucigalpa');
// Crear Usuario
//die(json_encode($_POST));
$accion = $_POST['accion'];
if ($accion === 'newUsuario') {
	$name = $_POST['nombre'];
	$apellido = $_POST['apellidos'];
	$nickname = $_POST['nickname'];
	$email = $_POST['email'];
	$role = $_POST['role'];
	$estado = $_POST['estado'];
	$contrasena = $_POST['password'];
	//Hashear Password
	$opciones = array(
		'cost' => 12
	);

	//Necesitamos 3 paramentros, Contraseña, algoritmo de encriptación, opciones(arreglo)
	$hash_password = password_hash($contrasena, PASSWORD_BCRYPT, $opciones);
	//Importar la conexión
	include '../conexion.php';
	include '../functions.php';
	include '../functionsquery.php';
	$primerNombre = explode(" ", $name);
	$primerApellido = explode(" ", $apellido);
	// var_dump($primerNombre);
	$nombre = substr($primerNombre[0], 0, 1);
	$nickname = $nombre . $primerApellido[0];
	$nombre = quitar_acentos($nickname);
	$nickname = strtolower($nombre);
	// echo '@' . $nickname;
	$bandera = false;
	$comparar = obtenerTodo('main_users');
	while ($row = $comparar->fetch_assoc()) {
		$username = $row['nickname'];
		$email_user = $row['email_user'];
		if (strcmp($nickname, $username) === 0) {
			$rand = range(1, 13);
			shuffle($rand);
			foreach ($rand as $val) {
				$alea = $val;
			}
			$nombre = substr($primerNombre[0], 0, 1);
			$nickname = $nombre . $primerApellido[0] . $alea;
			$nombre = quitar_acentos($nickname);
			$nickname = strtolower($nombre);
			echo 'Entró';
		}

		if ($email === $email_user) {
			$bandera = true;
		}
	}
	//Si el usuario existe verificar el password
	if ($bandera) {
		header('Location: ../../new-usuario.php?error=1');
	} else {
		echo 'Procede a Insertar';
		$sql = "INSERT INTO main_users (`id`, `usuario_name`, `apellidos`, `nickname`, `email_user`, `password`, `role_user`, `estado_user`, `asignacion`, `no_asignado`) VALUES (NULL, '$name', '$apellido', '$nickname', '$email', '$hash_password', $role, '$estado', '0', '0')";
		if (mysqli_query($conn, $sql)) {
			echo 'Insertó';
			header('Location: ../../new-usuario.php?add=1');
		} else {
			header('Location: ../../new-usuario.php?add=0');
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
}

if ($accion === 'newasignacion') {
	include '../conexion.php';
	echo $_POST['numero_mesa'];
	echo $name = $_POST['usuario'];
	echo $numero_mesa = $_POST['numero_mesa'];
	echo $id_mesero = $_POST['usuario'];
	echo $estado = $_POST['estado'];

	//Si el usuario existe verificar el password
	echo 'Procede a Insertar';
	$sql = "INSERT INTO `mesas` (`id_asignacion`, `numero_mesa`, `id_mesero`, `estado_mesa`, `asignada`, `ocupada`) VALUES (NULL, '$numero_mesa', '$id_mesero', '$estado', '1', 0);";
	if (mysqli_query($conn, $sql)) {
		echo 'Insertó';
		header('Location: ../../new-mesa.php?add=1');
	} else {
		header('Location: ../../new-mesa.php?add=0');
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}

$imagen = '';

if ($accion === 'newCategoria') {
	include '../conexion.php';
	$nombrecategoria = $_POST['nombrecategoria'];
	$estado = $_POST['estado'];
	// $url = $_POST['url'];
	$descripcion = $_POST['descripcion'];
	$imagen = $_FILES['imagen']['name'];
	// echo $url = $_POST['imagen'];
	echo $fechaActual = date('dmy-h-i-s');
	if (isset($_POST['precioferta'])) {
		$preciooferta = $_POST['precioferta'];
		if ($preciooferta == '') {
			$oferta = 0;
			$preciooferta = 0;
		} else {
			$oferta = 1;
		}
	} else {
		$oferta = 0;
		$preciooferta = 0;
	}
	// $ruta = 'D:/xampp7.2/htdocs/personales/proyecto-conn/images/'.$imagen;
	$rutaproductos = '/Applications/XAMPP/xamppfiles/htdocs/personales/carwash/img/categorias/';

	if (file_exists($rutaproductos)) {
		echo "<br> La carpeta " . $rutaproductos . " ya existe<br>";
		$tipo = $_FILES['imagen']['type'];
		$tamano = $_FILES['imagen']['size'];
		$temp = $_FILES['imagen']['tmp_name'];
		list($base, $extension) = explode('.', $imagen);
		$newname = implode('.', [$fechaActual, $extension]);
		move_uploaded_file($temp, "$rutaproductos/$newname");
		$ruta = '/Applications/XAMPP/xamppfiles/htdocs/personales/carwash/img/categorias/' . $newname;
		// Existe la image?
		if (file_exists($ruta)) {
			echo "<br>La imagen $ruta ya existe<br>";
			//Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
			chmod($rutaproductos, 0777);
			// Mover el archivo a la carpeta
			list($base, $extension) = explode('.', $imagen);
			$newname = implode('.', [$base, $fechaActual, $extension]);
			move_uploaded_file($temp, "$rutaproductos/$newname");
			// move_uploaded_file($temp, $ruta);
			chmod($ruta, 0777);
		} else {
			echo "<br>La imagen $ruta no existe<br>";
			chmod($rutaproductos, 0777);
			// Mover el archivo a la carpeta
			list($base, $extension) = explode('.', $imagen);
			$newname = implode('.', [$fechaActual, $extension]);
			move_uploaded_file($temp, "$rutaproductos/$newname");
			// move_uploaded_file($temp, $ruta);
		}
	} else {
		echo "<br>El fichero $rutaproductos no existe, se procedé a crear<br>";

		mkdir($rutaproductos, 0777);
		chmod($rutaproductos, 0777);
		$tipo = $_FILES['imagen']['type'];
		$tamano = $_FILES['imagen']['size'];
		$temp = $_FILES['imagen']['tmp_name'];
		list($base, $extension) = explode('.', $imagen);
		$newname = implode('.', [$fechaActual, $extension]);
		move_uploaded_file($temp, "$rutaproductos/$newname");
		$ruta = '/Applications/XAMPP/xamppfiles/htdocs/personales/carwash/img/categorias/' . $newname;

		// Existe la image?
		if (file_exists($ruta)) {
			echo "<br>La imagen $newname se procedió a crearse<br>";
		} else {
			echo "<br>La imagen $ruta no se creó<br>";
		}
		//Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
		chmod($ruta, 0777);
		move_uploaded_file($temp, $ruta);
	}
	//Mostramos el mensaje de que se ha subido co éxito
	//Si el usuario existe verificar el password
	// echo 'Procede a Insertar';
	$sql = "INSERT INTO `categorias_menu` (`id_categoria`, `nombre_categoria`, `descripcion`, `icono`, `estado`) VALUES (NULL, '$nombrecategoria', '$descripcion', 'img/categorias/$newname', '$estado')";
	if (mysqli_query($conn, $sql)) {
		echo 'Insertó';
		header('Location: ../../new-categoria.php?add=1');
	} else {
		header('Location: ../../new-categoria.php?add=0');
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}

if ($accion === 'newPlato') {
	include '../conexion.php';
	$nombreplato = $_POST['nombreplato'];
	$precio = $_POST['precio'];
	$precioferta = $_POST['precioferta'];
	$categoria = $_POST['categoria'];
	$estado = $_POST['estado'];
	// $url = $_POST['url'];
	$descripcion = $_POST['descripcion'];
	$imagen = $_FILES['imagen']['name'];
	// echo $url = $_POST['imagen'];
	echo $fechaActual = date('dmy-h-i-s');
	if (isset($_POST['precioferta'])) {
		$preciooferta = $_POST['precioferta'];
		if ($preciooferta == '') {
			$oferta = 0;
			$preciooferta = 0;
		} else {
			$oferta = 1;
		}
	} else {
		$oferta = 0;
		$preciooferta = 0;
	}
	// $ruta = 'D:/xampp7.2/htdocs/personales/proyecto-conn/images/'.$imagen;
	$rutaproductos = '/Applications/XAMPP/xamppfiles/htdocs/personales/carwash/img/productos/';

	if (file_exists($rutaproductos)) {
		echo "<br> La carpeta " . $rutaproductos . " ya existe<br>";
		$tipo = $_FILES['imagen']['type'];
		$tamano = $_FILES['imagen']['size'];
		$temp = $_FILES['imagen']['tmp_name'];
		$ruta = '/Applications/XAMPP/xamppfiles/htdocs/personales/carwash/img/productos/' . $imagen;
		// Existe la image?
		if (file_exists($ruta)) {
			echo "<br>La imagen $ruta ya existe<br>";
			//Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
			chmod($rutaproductos, 0777);
			// Mover el archivo a la carpeta
			list($base, $extension) = explode('.', $imagen);
			$newname = implode('.', [$base, $fechaActual, $extension]);
			move_uploaded_file($temp, "$rutaproductos/$newname");
			// move_uploaded_file($temp, $ruta);
			chmod($ruta, 0777);
		} else {
			echo "<br>La imagen $ruta no existe<br>";
			chmod($rutaproductos, 0777);
			// Mover el archivo a la carpeta
			list($base, $extension) = explode('.', $imagen);
			$newname = implode('.', [$fechaActual, $extension]);
			move_uploaded_file($temp, "$rutaproductos/$newname");
			// move_uploaded_file($temp, $ruta);
		}
	} else {
		echo "<br>El fichero $rutaproductos no existe<br>";

		mkdir($rutaproductos, 0777);
		chmod($rutaproductos, 0777);
		$tipo = $_FILES['imagen']['type'];
		$tamano = $_FILES['imagen']['size'];
		$temp = $_FILES['imagen']['tmp_name'];
		$ruta = '/Applications/XAMPP/xamppfiles/htdocs/personales/carwash/img/productos/' . $newname;

		// Existe la image?
		if (file_exists($ruta)) {
			echo "<br>La imagen $ruta ya existe<br>";
		} else {
			echo "<br>La imagen $ruta no existe<br>";
		}
		//Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
		chmod($ruta, 0777);
		move_uploaded_file($temp, $ruta);
	}
	//Mostramos el mensaje de que se ha subido co éxito
	//Si el usuario existe verificar el password
	// echo 'Procede a Insertar';
	$sql = "INSERT INTO `menu` (`id`, `nombre`, `descripcion`, `precio`, `categoria`, `url_foto`, `oferta`, `precio_oferta`, `estado_plato`) VALUES (NULL, '$nombreplato', '$descripcion', '$precio', '$categoria', 'img/productos/$newname', '$oferta', '$preciooferta', '$estado')";
	if (mysqli_query($conn, $sql)) {
		echo 'Insertó';
		header('Location: ../../new-plato.php?add=1');
	} else {
		header('Location: ../../new-plato.php?add=0');
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}

if ($accion === 'newOrden') {
	include '../conexion.php';
	$mesa = $_POST['mesa'];
	$mesero = $_POST['mesero'];
	$cantidad = $_POST['cantidad'];
	$precio = $_POST['precio'];
	$subtotal = $_POST['subtotal'];
	$supertotal =  $subtotal;

	$checkBox = implode(',', $_POST['menuplato']);
	$DateAndTime = date('Y-m-d h:i:s', time());
	$date = date('Y-m-d', time());
	//Creamos la orden
	$orden = "INSERT INTO `ordenes` (`id_orden`, `datetime`, `estado`, `id_mesa`, `date`, `id_mesero`) VALUES (NULL, '$DateAndTime', 'cola', '$mesa', '$date', '$mesero')";
	if (mysqli_query($conn, $orden)) {
		$ultimoid = $conn->insert_id;
		// echo $insert_id; 
	}
	// echo $ultimoid;
	$i = -1;
	$total = 0;
	$totalSub = 0;
	$totaldescuento = 0;
	foreach ($_POST['menuplato'] as $key => $val) {
		$contador = 1;
		$cantidadElementos = count($cantidad);
		// while ($solicitud = $consulta->fetch_array()) {
		$consulta = $conn->query("SELECT * FROM `menu` WHERE id = $val");
		while ($solicitud = $consulta->fetch_array()) {
			$i++;
			$nombre = $solicitud['nombre'];
			$preciocondescueto = $solicitud['precio'];
			$precio_oferta = ($solicitud['precio_oferta'] * $cantidad[$i]);
			$subtotal = ($cantidad[$i] * $solicitud['precio']) - $precio_oferta;
			echo $precio_oferta . '<br><br>';
			echo $preciocondescueto . '<br><br>';
			if ($precio_oferta == 0) {
				$precio_oferta = $preciocondescueto;
				$subtotal = 0;
			}else{
				$precio_oferta = $precio_oferta;
			}
			$totaldescuento = ($totaldescuento += $subtotal);
			$totalSub = ($totalSub += $precio_oferta);
			$total += $subtotal;
			// echo $totaldescuento . '<br><br>';
			// echo $totalSub . '<br><br>';
			// echo $total . '<br><br>';

			$sql = "INSERT INTO orden_detalle (`id_orden_detalle`, `id_mesero`, `descripcion`, `id_plato`, `precio_plato`,  `descuento`, `subtotal`, `cantidad`) VALUES ('$ultimoid', '$mesero', '$nombre', '$val', '$preciocondescueto',  '$subtotal', $precio_oferta, $cantidad[$i])";
			if (mysqli_query($conn, $sql)) {
				$insertado = true;
			}else{
				$insertado = false;
			}
		}
	}
	if ($insertado) {
		echo 'Insertó Orden';
		header('Location: ../../orden.php?orden=' . $ultimoid . '&fact=true');
	} else {
		header('Location: ../../orden.php?orden=0&fact=false');
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}
// }
echo $accion;
if ($accion === 'facturacrear') {
	include '../conexion.php';
	$id_orden = $_POST['id_orden'];
	echo $id_orden;
	$DateAndTime = date('Y-m-d h:i:s', time());
	$datetime = date('Y-m-d h:i:s', time());
	// echo $DateAndTime;
	// $datetime  = $_POST['datetime'];
	$idmesero = $_POST['idmesero'];
	$total = $_POST['total'];
	$grantotal = $_POST['grantotal'];
	$descuento = $_POST['descuento'];
	$propina = $_POST['propina'];
	$impuesto = $_POST['impuestototal'];
	$estado_factura = 'pagado';

	// echo $url = $_POST['url_foto'];
	if (isset($_POST['precioferta'])) {
		$preciooferta = $_POST['precioferta'];
		if ($preciooferta == '') {
			$oferta = 0;
			$preciooferta = 0;
		} else {
			$oferta = 1;
		}
	} else {
		$oferta = 0;
		$preciooferta = 0;
	}

	//Si el usuario existe verificar el password
	echo 'Procede a Insertar';
	$sql = "INSERT INTO `facturas` (no_factura, fecha_hora, id_orden, id_mesero, total, descuento, propina, impuesto, subtotal, estado_factura, grantotal) VALUES (NULL, '$datetime', '$id_orden', '$idmesero', '$grantotal', '$descuento', '$propina', '$impuesto', '$total', '$estado_factura', '$grantotal')";

	$orden = "UPDATE `ordenes` SET `estado` = 'pagada' WHERE `ordenes`.`id_orden` = $id_orden";

	$conexion = mysqli_query($conn, $sql);
	$conexionorden = mysqli_query($conn, $orden);
	$last_id = mysqli_insert_id($conn);
	echo $last_id;
	if ($conexion && $conexionorden) {
		echo 'Entró';
		header('Location: ../../detalle_factura.php?ID=' . $id_orden . '&add=1');
		// header('Location: ../../doc/factura.php?ID=' . $last_id . '&add=1');
	} else {
		echo 'Entró1';
		// header('Location: ../../ddoc/factura.php?ID=' . $id_orden . '&add=0');
		// header('Location: ../../doc/factura.php?ID=' . $last_id . '&add=0');
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}
if ($accion === 'facturacrearcajero') {
	include '../conexion.php';
	$id_orden = $_POST['id_orden'];
	echo $id_orden;
	$DateAndTime = date('Y-m-d h:i:s', time());
	$datetime = date('Y-m-d h:i:s', time());
	// echo $DateAndTime;
	// $datetime  = $_POST['datetime'];
	$idmesero = $_POST['idmesero'];
	$total = $_POST['total'];
	$grantotal = $_POST['grantotal'];
	$descuento = $_POST['descuento'];
	$propina = $_POST['propina'];
	$impuesto = $_POST['impuestototal'];
	$estado_factura = 'pagado';

	// echo $url = $_POST['url_foto'];
	if (isset($_POST['precioferta'])) {
		$preciooferta = $_POST['precioferta'];
		if ($preciooferta == '') {
			$oferta = 0;
			$preciooferta = 0;
		} else {
			$oferta = 1;
		}
	} else {
		$oferta = 0;
		$preciooferta = 0;
	}

	//Si el usuario existe verificar el password
	echo 'Procede a Insertar';
	$sql = "INSERT INTO `facturas` (no_factura, fecha_hora, id_orden, id_mesero, total, descuento, propina, impuesto, subtotal, estado_factura, grantotal) VALUES (NULL, '$datetime', '$id_orden', '$idmesero', '$grantotal', '$descuento', '$propina', '$impuesto', '$total', '$estado_factura', '$grantotal')";

	$orden = "UPDATE `ordenes` SET `estado` = 'pagada' WHERE `ordenes`.`id_orden` = $id_orden";

	$conexion = mysqli_query($conn, $sql);
	$conexionorden = mysqli_query($conn, $orden);
	$last_id = mysqli_insert_id($conn);
	echo $last_id;
	if ($conexion && $conexionorden) {
		echo 'Entró';
		header('Location: ../../detalle-cajero.php?ID=' . $id_orden . '&add=1');
		// header('Location: ../../doc/factura.php?ID=' . $last_id . '&add=1');
	} else {
		echo 'Entró1';
		// header('Location: ../../ddoc/factura.php?ID=' . $id_orden . '&add=0');
		// header('Location: ../../doc/factura.php?ID=' . $last_id . '&add=0');
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}
