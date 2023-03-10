<?php
	date_default_timezone_set('America/Tegucigalpa');
	//Obtener página actual remplazando .php por vacio.
	function obtenerTodo($tabla = null) {
		include 'conexion.php';
		try {
			return $conn->query("SELECT * FROM {$tabla}");
	
		} catch(Exception $e) {
			echo "Error! : " . $e->getMessage();
			return false;
		}
	}
	function obtenerColaboradores($tabla = null) {
		include 'conexion.php';
		try {
			return $conn->query("SELECT * FROM {$tabla} WHERE role_user = 4 or role_user = 3");

		} catch(Exception $e) {
			echo "Error! : " . $e->getMessage();
			return false;
		}
	}
	function obtenerRoles() {
		include 'conexion.php';
		try {
			return $conn->query("SELECT * FROM main_cargo");

		} catch(Exception $e) {
			echo "Error! : " . $e->getMessage();
			return false;
		}
	}
	function obtenerNumeroMesas() {
		include 'conexion.php';
		try {
			return $conn->query("SELECT * FROM mesas");

		} catch(Exception $e) {
			echo "Error! : " . $e->getMessage();
			return false;
		}
	}
	function obtenerCategoria($id = null) {
		include 'conexion.php';
		try {
			return $conn->query("SELECT * FROM categorias_menu WHERE id_categoria = {$id}");

		} catch(Exception $e) {
			echo "Error! : " . $e->getMessage();
			return false;
		}
	}

?>