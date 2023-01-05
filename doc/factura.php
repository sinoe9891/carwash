<?php
date_default_timezone_set('America/Tegucigalpa');
include '../inc/conexion.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once 'model.php';
require_once 'convertidor/convertidor.php';
require_once 'convertidor/convertidor_fecha.php';
$modelonumero = new modelonumero();
$modelofecha = new modelofecha();
$stylesheet = file_get_contents('css/style.css');

if (isset($_GET['ID'])) {
	$user_id = $_GET['ID'];
	include '../inc/conexion.php';
	// $consulta1 = $conn->query("SELECT * FROM info_cai a, info_empresa b where a.id_empresa = b.id_empresa");
	$consulta1 = $conn->query("SELECT * FROM facturas a, main_users b, vehiculos_clientes c, vehiculos_modelo d, vehiculos e, clientes f, ordenes g WHERE a.id_orden = '$user_id' and a.id_mesero = b.id and a.id_vehiculo = c.id_vehiculocliente and c.marca_cliente = e.id_vehiculo and c.modelo_cliente = d.id_modelo and f.id_cliente = g.id_cliente");
	//while el id_cuota_pagada
	while ($row = $consulta1->fetch_assoc()) {

		// echo $datetime;
		$datetime = $row['fecha_hora'];
		$no_factura = $row['no_factura'];
		$total = $row['total'];
		$impuesto = $row['impuesto'];
		$subtotal = $row['subtotal'];
		$id_mesero = $row['id_mesero'];
		$cliente = $row['nombrecliente'];
		$correocliente = $row['correo1'];
		$usuarioname = $row['usuario_name'];
	}

	$date = date_create($datetime);
	$datetime =  date_format($date, 'd-m-Y');
	$hora =  date_format($date, 'H:i:s');

	$html .= '<div class="main_factura" >
			<div class="main-container">
			<div class="container_factura">
			<h5>Lalos Carwash</h5>
			<p>Dirección</p>
			<p>RTN: RTN</p>
			<p>Tel. +504 3182-8143</p>
			<hr style="border-style: dashed">
			<p>FACTURA <span class="factura">' . $no_factura . '<span></p>
			<p>ORDEN <span class="factura">' . $user_id . '<span></p>
			<hr>
			<p>CAI</p>
			<p></p>
			<!--<p>Rango autorizado: </p>-->
			<hr>
			<p>Fecha de autorización: </p>
			<p>Fecha límite de emisión: </p>
			<hr>
			<p>Rango inicial: </p>
			<p>Rango final: </p>
			<hr>
			<p>Correo: admin@lalos.com</p>
			<hr>
			<p>Usuario: ' . $usuarioname . '</p>
			
			<p>Fecha: ' . $datetime . '</p>
			<p>Hora: ' . $hora . '</p>
			<hr>
			<p>Detalle: </p>
			<div class="">
				<table class="center-factura">
				';

	$consultaorden = $conn->query("SELECT * FROM `orden_detalle` WHERE id_orden_detalle = '$no_factura'");
	while ($row = $consultaorden->fetch_assoc()) {

		$solicitudes = getCobro($user_id);
		// $len = 16;
		// $new_str1 = str_pad($rango_inicial, $len, "0", STR_PAD_LEFT);
		// $new_str2 = str_pad($rango_final, $len, "0", STR_PAD_LEFT);
		// $cuatro1 = substr($new_str1, 15, 5);
		// $cuatro2 = substr($new_str2, 15, 5);
		// if ($solicitudes->num_rows > 0) {
		// echo $datetime.'<br>';
		// echo $no_factura.'<br>';
		// echo $total.'<br>';
		// echo $id_mesero.'<br>';
		// echo $user_id;
		// while ($row = $solicitudes->fetch_assoc()) {
		// $datetime = $row['datetime'];

		$totalproductos += $row['precio_plato'];

		$html .= '
			<tr>
			
			<th>' . $row['descripcion'] . '</th>
						<th>L. ' . number_format($row['precio_plato'], 2, '.', ',') . '</th>
						<td></td></tr>';
	}


	$html .= '
						
	
				</table>
			</div>
		<hr>
	<div class="">
				<table class="center-factura">
					<tr>
						<th>Subtotal</th>
						<th>L. ' . number_format($totalproductos, 2, '.', ',') . '</th>
						<td></td>
					</tr>
					<tr>
						<th>Total Descuentos</th>
						<th>L. ' . number_format($totalproductos - $subtotal, 2, '.', ',') . '</th>
						<td></td>
					</tr>
					<tr>
						<th>Impuestos (15%)</th>
						<th>L. ' . number_format($total - $subtotal, 2, '.', ',') . '</th>
						<td></td>
					</tr>
					<tr>
						<th>Total</th>
						<th>L. ' . number_format($total, 2, '.', ',') . '</th>
						<td></td>
					</tr>
					<tr>
						<th>Fecha</th>
						<th>' . $datetime . '</th>
						<td></td>
					</tr>
					<tr>
						<th>Hora</th>
						<th>' . $hora . '</th>
						<td></td>
					</tr>
				</table>
			</div>
			<hr>
			<p>Cliente: ' . $cliente . '</p>
			<p class="info"></p>
			<hr>';

	try {
		// $mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
		// son mm 
		$mpdf = new \Mpdf\Mpdf(['format' => [75.9989, 220.6]]);
		$mpdf->adjustFontDescLineheight = 1.2;
		// $mpdf->SetMargins(10, 250, 10);
		$mpdf->AddPageByArray([
			'margin-left' => 2.5,
			'margin-right' => 2.5,
			'margin-top' => 11,
			'margin-bottom' => 0,
		]);
		$mpdf->SetAutoPageBreak(true, 25);
		// $mpdf->debug = true;
		// ob_end_clean();
		$mpdf->WriteHTML($stylesheet, 1);
		$mpdf->WriteHTML($html);
		// $mpdf->Output("Factura.pdf", "D");
		$mpdf->Output("Factura.pdf", "I");
		// $nombrefactura = "Factura.pdf";
		// $mpdf->Output("facturas/" . ucwords(strtolower($nombrefactura)), "F");
		//si no existe el directorio factura se debe crear el directorio

		// $mpdf->Output("Contrato ".$bloque .'-'. $numero .' '. ucwords(strtolower($nombre)) . ".pdf", "D");
	} catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception 
		//       name used for catch
		// Process the exception, log, print etc.
		echo $e->getMessage();
	}
	//convertir pdf a jpg
	// $im = imagecreatefromjpeg('galería/Nota de Duelo '.ucwords(strtolower($row['nombres'].' '.$row['apellidos'])).'.jpg');
	// $mpdf->Output("galería/Nota de Duelo ".ucwords(strtolower($row['nombres'].' '.$row['apellidos'])).".jpg", "F");

	// }
	// }
}
// }
