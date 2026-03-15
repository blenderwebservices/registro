<?php
// TEMPORAL: Habilitar reporte de errores para depurar el HTTP 500
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Mexico_City');

require_once "phpqrcode/qrlib.php";

$dir = 'codigos/';
if (!file_exists($dir))
				mkdir($dir);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "PHPMailer/src/Exception.php";
require_once "PHPMailer/src/PHPMailer.php";

$Mail = new PHPMailer();

require_once __DIR__ . '/db_config.php';
$host_name = $db_0_host;
$database = $db_0_name;
$user_name = $db_0_user;
$password = $db_0_pass;

/**
 * Quita acentos, diéresis y convierte la cadena a Mayúsculas.
 * Soluciona el error de corrupción de consonantes en UTF-8.
 */
function quitar_acentos($cadena) {
    // 1. Convertimos todo a mayúsculas de forma segura para UTF-8 primero.
    // Esto reduce el tamaño del mapa de traducción a la mitad.
    $cadena = mb_strtoupper($cadena, 'UTF-8');

    // 2. Definimos el mapa de reemplazos usando un array asociativo.
    // strtr() con un array es "multi-byte safe", lo que evita que se rompan las consonantes.
    $mapa = [
        'Á' => 'A', 'À' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
        'É' => 'E', 'È' => 'E', 'Ê' => 'E', 'Ë' => 'E',
        'Í' => 'I', 'Ì' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ó' => 'O', 'Ò' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O',
        'Ú' => 'U', 'Ù' => 'U', 'Û' => 'U', 'Ü' => 'U',
        // 'Ñ' => 'N' // Descomenta esta línea si también quieres quitar la Ñ
    ];

    // 3. Retornamos la cadena traducida.
    return strtr($cadena, $mapa);
}


	$guardar = trim($_POST['guardar']);
	//if ($guardar == 'ok'){

	// Validación reCAPTCHA v3
	$recaptcha_secret = '6LdESIssAAAAAPhM5FcdA7sYDL0WyHeJyRFSiTiY';
	$recaptcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
	
	if(empty($recaptcha_response)){
		die("<script>alert('Error: Falta validación reCAPTCHA.'); history.back();</script>");
	}
	
	$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
	$recaptcha_post_data = array(
		'secret' => $recaptcha_secret,
		'response' => $recaptcha_response
	);

	if (function_exists('curl_init')) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $recaptcha_url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($recaptcha_post_data));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$recaptcha_verify = curl_exec($curl);
		curl_close($curl);
	} else {
		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($recaptcha_post_data)
			)
		);
		$context  = stream_context_create($options);
		$recaptcha_verify = file_get_contents($recaptcha_url, false, $context);
	}
	
	$recaptcha_data = json_decode($recaptcha_verify);
	
	if (!is_object($recaptcha_data) || !isset($recaptcha_data->success) || !$recaptcha_data->success) {
		die("<script>alert('Error de reCAPTCHA. Verificación fallida.'); history.back();</script>");
	}
	
	// Optional snippet to check ReCaptcha v3 score (0.0 to 1.0)
	if (isset($recaptcha_data->score) && $recaptcha_data->score < 0.5) {
	     die("<script>alert('Actividad sospechosa detectada. Por favor, intenta de nuevo más tarde.'); history.back();</script>");
	}

	$tipoasis = trim($_POST['tipoasis']);
	$origen = trim($_POST['origen']);
	$email = strtolower(trim($_POST['email']));
	$nombres = strtoupper(trim($_POST['nombres']));
	$nombres=quitar_acentos($nombres);

	$apellidos = strtoupper(trim($_POST['apellidos']));
	$apellidos=quitar_acentos($apellidos);

	$celular = $_POST['celular'];
	strip_tags(settype($celular, "string"));
	
	$ciudad = trim($_POST['ciudad']);
	$ciudad=quitar_acentos($ciudad);

	$estado = trim($_POST['estado']);
	$estado=quitar_acentos($estado);

	$pais = trim($_POST['pais']);
	$pais=quitar_acentos($pais);

	$empresa = trim($_POST['empresa']);
	$empresa=quitar_acentos($empresa);

	/* $grupo = trim($_POST['grupo']);
	$grupo=quitar_acentos($grupo); */

	if (isset($_POST['giro1'])) {
		$giro1=1;
	}else{
		$giro1=0;
	}
	if (isset($_POST['giro2'])) {
		$giro2=1;
	}else{
		$giro2=0;
	}
	if (isset($_POST['giro3'])) {
		$giro3=1;
	}else{
		$giro3=0;
	}
	if (isset($_POST['giro4'])) {
		$giro4=1;
	}else{
		$giro4=0;
	}
	if (isset($_POST['giro5'])) {
		$giro5=1;
	}else{
		$giro5=0;
	}
	if (isset($_POST['giro6'])) {
		$giro6=1;
	}else{
		$giro6=0;
	}
	if (isset($_POST['giro7'])) {
		$giro7=1;
	}else{
		$giro7=0;
	}
	if (isset($_POST['giro8'])) {
		$giro8=1;
	}else{
		$giro8=0;
	}
	if (isset($_POST['giro9'])) {
		$giro9=1;
	}else{
		$giro9=0;
	}
	if (isset($_POST['giro10'])) {
		$giro10=1;
	}else{
		$giro10=0;
	}

if (!empty($nombres)) {


	$giroqr = (string)$giro1.(string)$giro2.(string)$giro3.(string)$giro4.(string)$giro5.(string)$giro6.(string)$giro7.(string)$giro8.(string)$giro9.(string)$giro10;
	

	
	$fhregistro = date('y/m/d H:i:s', time());
	
	$completo = "$nombres $apellidos";

	 
	$dbh = mysqli_connect($host_name, $user_name, $password, $database);
	mysqli_set_charset($dbh, "utf8mb4"); 

	if (mysqli_connect_errno()) {
		die('<p>Error al conectar con servidor MySQL contacte al +52 3321349874 24 hrs. o enviar correo a miguelbermejo@hotmail: '.mysqli_connect_error().'</p>');
	  }

	  if (!mysqli_query($dbh,"INSERT INTO registro_leon_2026(tipoasis,email,nombres,apellidos,celular,ciudad,estado,pais,empresa,giroqr	,giro1,giro2,giro3,giro4,giro5,giro6,giro7,giro8,giro9,giro10,origen,fhregistro,grupo) VALUES ('$tipoasis','$email','$nombres','$apellidos','$celular','$ciudad','$estado','$pais','$empresa','$giroqr','$giro1','$giro2','$giro3','$giro4','$giro5','$giro6','$giro7','$giro8','$giro9','$giro10','$origen','$fhregistro','1')"))
	{
		echo("Error al ingresar registro de asistente contacte a +52 3321349874: " . mysqli_error($dbh));
	} else {
		echo("Registro de nuevo asistente ingresado => ");

		$idnew = mysqli_insert_id($dbh);
	echo("DATOS GUARDADOS......");
	mysqli_close($dbh);
	if ($origen	== "PREREGISTRO"){
		$origenqr = "PRE";
	} elseif ($origen	== "EXPRESS"){
		$origenqr = "EX";
	} else {
		$origenqr = "TAB";
	}
	
	if ($origen	<> "TABLET"){
		$filename = $dir.$idnew.'.png';
		$tamaño = 8; //Tamaño de Pixel
		$level = 'L'; //Precisión Baja
		$framSize = 3; //Tamaño en blanco
		$contenido = "$idnew##$tipoasis##$nombres##$apellidos##$giroqr##$empresa##$email"; //Texto

		QRcode::png($contenido, $filename, $level, $tamaño, $framSize); 

	}

//IF ($origen == "PREREGISTRO"){
	//try {
		
		
		$Mail->addReplyTo('miguelbermejo@hotmail.com', 'Extra');
		$Mail->addBCC('miguelbermejo@hotmail.com');

		//Content
		$Mail->CharSet = 'UTF-8';
		$Mail->isHTML(true);                                  //Set email format to HTML
		
		$Mail->setFrom('mail@registro.expomecanico.mx');
		$Mail->Subject = 'Registro terminado exitosamente';//utf8_decode('Registro terminado exitosamente');
		$Mail->addAddress($email);


		$Mensaje = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<title></title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><!-- Hotmail ignores some valid styling, so we have to add this -->
			<style type="text/css">.ReadMsgBody
		{width: 100%; background-color: #c4c4c4; background-image:url(http://outletdemarcas.ip-zone.com/ccm/templates/bienes-raices/images/bg_body.jpg); }
		.ExternalClass
		{width: 100%; background-color: #c4c4c4; background-image:url(http://outletdemarcas.ip-zone.com/ccm/templates/bienes-raices/images/bg_body.jpg); }
		body
		{width: 100%; height: 100%; background-image:url(http://outletdemarcas.ip-zone.com/ccm/templates/bienes-raices/images/bg_body.jpg); margin:0; padding:0; -webkit-font-smoothing: antialiased;}
		html
		{width: 100%; height: 100%;}

		@media only screen and (max-device-width: 480px) {

		.mobile_text_1 { font-family:Arial, Helvetica, sans-serif; font-size:11pt; color:#000; }

		.mobile_text_2 { font-family:Arial, Helvetica, sans-serif; font-size:14pt; font-weight:bold; color:#e9910c; }

		.mobile_text_3 { font-family:Arial, Helvetica, sans-serif; font-size:12pt; color:#e95d0f; font-weight:bold; text-align:center; }

		.mobile_text_4 { font-family:Arial, Helvetica, sans-serif; font-size:9pt; color:#898989; text-align:center; }

		.mobile_text_5 { font-family:Arial, Helvetica, sans-serif; font-size:11pt; color:#fff; text-align:center; }

		.mobile_text_6 { font-family:Arial, Helvetica, sans-serif; font-size:12pt; font-weight:bold; color:#fff; text-align:center; }

		.mobile_text_7 { font-family:Arial, Helvetica, sans-serif; font-size:10pt; font-weight:bold; color:#535353; text-align:center; }

		.mobile_text_8 { font-family:Arial, Helvetica, sans-serif; font-size:8pt; color:#7d7d7d; text-align:justify; }

		.mobile_text_9 { font-family:Arial, Helvetica, sans-serif; font-size:10pt; font-weight:bold; color:#fff; text-align:center; }

		.mobile_text_10 { font-family:Arial, Helvetica, sans-serif; font-size:9pt; color:#006f9f; text-align:center;
		}

		.mobile_text_11 { font-family:Arial, Helvetica, sans-serif; font-size:9pt; color:#626262; text-align:center;
		}
			</style>
		</head>
		<body leftmargin="0" marginheight="0" marginwidth="0" topmargin="0"><!-- Wrapper -->
		<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
			<tbody>
				<tr>
					<td height="100%" valign="top" width="100%"><!-- Main wrapper -->
					<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
						<tbody>
							<tr>
								<td><!-- Iphone Wrapper -->
								<table align="center" border="0" cellpadding="0" cellspacing="0" width="660">
									<tbody>
										<tr>
											<td width="30">&nbsp;</td>
											<td bgcolor="#ffffff" valign="top" width="601"><span style="font-size:20px;"><span style="color:#ffffff;"><!--INICIO DEL CONTENIDO PRINCIPAL--><!-- Top --></span></span>
											<!--<table align="center" bgcolor="black" border="0" cellpadding="0" cellspacing="0" width="600">
												<tbody>
													<tr>
														<td align="center" height="80" valign="top">
														<table border="0" cellpadding="0" cellspacing="0" width="600">
															<tbody>
																<tr>
																	<td align="center" valign="top" width="25">&nbsp;</td>
																	<td align="center" height="80" valign="top" width="97"><span style="font-size:20px;"><span style="color:#ffffff;"><a href="https://outletdemarcas.com.mx" target="_blank"><img src="https://outletdemarcas.com.mx/images/mailing/web.jpg" style="border-width: 0px; border-style: solid; width: 97px; height: 80px; display: block;" /></a></span></span></td>
																	<td align="center" height="80" valign="top" width="108"><span style="font-size:20px;"><span style="color:#ffffff;"><a href="https://www.outletdemarcas.com.mx/#marcas" target="_blank"><img src="https://outletdemarcas.com.mx/images/mailing/marcas.jpg" style="border-width: 0px; border-style: solid; width: 97px; height: 80px; display: block;" /></a></span></span></td>
																	<td align="center" height="80" valign="top" width="104"><span style="font-size:20px;"><span style="color:#ffffff;"><a href="mailto:contacto@outletdemaras.com.mx"><img src="https://outletdemarcas.com.mx/images/mailing/contacto.jpg" style="border-width: 0px; border-style: solid; width: 97px; height: 80px; display: block;" /></a></span></span></td>
																	
																	<td align="center" bgcolor="black" valign="top" width="25">&nbsp;</td>
																																<td align="center" valign="top"><span style="font-size:20px;"><span style="color:#ffffff;"><a href="#"><img src="https://outletdemarcas.com.mx/images/mailing/negro.jpg" style="border-width: 0px; border-style: solid; width: 97px; height: 80px; display: block;" /></a></span></span></td>
																	
																	<td align="center" bgcolor="black" valign="top" width="25">&nbsp;</td>
																</tr>
															</tbody>
														</table>
														</td>
													</tr>
												</tbody>
											</table> -->

											<table border="0" cellpadding="0" cellspacing="0" width="600">
												<tbody>
													<tr>
														<td align="center" valign="top"><img src="https://outletdemarcas.congresosmexico.org/images/mailing/encabezado_terminado.jpg" style="width: 600px; height: 200px; display: block;" /></td>
													</tr>
												</tbody>
											</table>
																				

											<table bgcolor="black" border="0" cellpadding="0" cellspacing="0" width="600">
												<tbody>
													<tr>
														<td height="5">
														<span style="color:#ED164F;">&nbsp;Nombre: </span><span style="font-size:20px; color:white;">
																	';
		$Mensaje .= ''.'&nbsp;&nbsp;&nbsp;'.$nombres.' '.$apellidos.'<br>';
		$Mensaje .= '<span style="color:#ED164F;">Email: </span>'.$email.'</b><br>';
		$Mensaje .= '</span></td>
														</tr>
													</tbody>
												</table>

												<table bgcolor="black" border="0" cellpadding="0" cellspacing="0" width="600">
													<tbody>
														<tr>
															<td height="5">
																<span style="color:#ED164F;">&nbsp;&nbsp;&nbsp;ID: <span style="font-size:20px; color:white;">
																		';
		$Mensaje .= ''.'&nbsp;&nbsp;&nbsp;'.$idnew.'';
		$Mensaje  .= '</span></span></td>
														</tr>
													</tbody>
												</table>
												<table bgcolor="black" border="0" cellpadding="0" cellspacing="0" width="600">
													<tbody>
														<tr>
															<td height="5"><span style="color:#ED164F;"><span style="font-size:20px;"></span></span></td>
														</tr>
													</tbody>
												</table>
																			
												<table border="0" cellpadding="0" cellspacing="0" width="600">
													<tbody>
														<tr>

														</tr>
													</tbody>
												</table>

												<table border="0" cellpadding="0" cellspacing="0" width="600">
													<tbody>
														<tr>
															<td align="center" valign="top">
															';
		$Mensaje .= ''.'<img src="https://registro.expomecanico.mx/php/codigos/'.$idnew.'.png" style="width: 300px; height: 300px; display: block;" />';
		$Mensaje .= '</td>
														</tr>
													</tbody>
												</table>

												<table border="0" cellpadding="0" cellspacing="0" width="600">
													<tbody>
														<tr>
															<td height="5"><span style="color: black; display:block; margin: o auto; font-size:15px; text-align: center;"> Guarde su QR en su celular y pres&eacute;ntelo en el m&oacute;dulo de registro para obtener su gafete
																		</span></td>
														</tr>
													</tbody>
												</table>
												

												<table border="0" cellpadding="0" cellspacing="0" height="150" width="600">
													<tbody>
														<tr>
															<td align="center" valign="middle">
															<table border="0" cellpadding="0" cellspacing="3" width="550">
																<tbody>
																	<tr>
																		<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:9pt; color:#006f9f; text-align:center;" valign="top">
																		<section class="mobile_text_10">&copy; Copyright 2024 CNT. Todos los derechos reservados.<br />
																		www.expomecanico.mx | contacto@expomecanico.mx</section>
																		</td>
																	</tr>
																	<tr>
																		<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:9pt; color:#626262; text-align:center;" valign="top">
																		<section class="mobile_text_11">Si este correo le llego por error puede eliminar su registro <a href="[unsubscribe_url]" style="text-decoration:none; color:#f29400; font-weight:bold;">aqu&iacute;</a>.</section>
																		</td>
																	</tr>
																	<tr>
																		<td height="15">&nbsp;</td>
																	</tr>
																</tbody>
															</table>
															</td>
														</tr>
													</tbody>
												</table>
												<!--FIN DEL CONTENIDO PRINCIPAL--></td>
												<td width="29">&nbsp;</td>
											</tr>
										</tbody>
									</table>
									<!-- End Iphone Wrapper --></td>
								</tr>
							</tbody>
						</table>
						<!-- End Main wrapper --></td>
					</tr>
				</tbody>
			</table>
			<!-- End Wrapper --><!-- Done --></body>
			</html>
				';
		//$mensaje = 'Correo para texto plano, ';
		$Mail->Body = mb_convert_encoding($Mensaje, "UTF-8");
		/* if (!$Mail->Send()){
			echo "Error-> " . $Mail->ErrorInfo;
		}else{ */
			echo "El mensaje fue enviado";
			?>
			<script type="text/javascript">
			var id="<?php echo $idnew; ?>";
			var completo="<?php echo $completo; ?>";
			var filename="<?php echo $filename; ?>";
			</script>
			<?php
		// }

}	
	
	
	

	if ($origen=="PREREGISTRO"){
		//echo "<script type='text/javascript'>alert('Tu registro se ha realizado exitosamente');</script>";
		echo "<script type='text/javascript'>window.location.href='../registro_terminado.html?id='+id+'&completo='+completo+'&filename='+filename;</script>";
	 } else{
	 	echo "<script type='text/javascript'>window.location.href='../registro_express_terminado.html?id='+id+'&completo='+completo+'&filename='+filename;</script>";
	 } 
	
	

	//}
	
	
//}

}else{
	echo "<script type='text/javascript'>window.location.href='../registro.expomecanico.mx;</script>";
}
	?>