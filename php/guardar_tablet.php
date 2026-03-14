<?php
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Mexico_City');
require "phpqrcode/qrlib.php";
$dir = 'codigos/';
if (!file_exists($dir))
				mkdir($dir);


$host_name = 'db630619280.db.1and1.com';
$database = 'db630619280';
$user_name = 'dbo630619280';
$password = 'Outlet876..';

function quitar_acentos($cadena){
	$originales = 'ÀÁÂÃÄÅÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜàáâãäåèéêëìíîïòóôõöùúû';
	$modificadas = 'AAAAAAEEEEIIIIOOOOOUUUUAAAAAAEEEEIIIIOOOOOUUU';
	$cadena = utf8_decode($cadena);
	$cadena = strtr($cadena, utf8_decode($originales), $modificadas);
	return utf8_encode($cadena);
}

$guardar = trim($_GET['guardar']);
if ($guardar == 'ok'){
	$email = strtolower(trim($_GET['email']));


	// $telefono = trim($_GET['telefono']);
	$genero = trim($_GET['genero']);
	$generoqr = $genero;
	if ($genero==1) {
		$genero = "Hombre";
	}elseif ($genero == 2){
		$genero="Mujer";
	}
	$edad = trim($_GET['edad']);
	$edadqr = $edad;
	if ($edad == 1) {
		$edad = "Menor de 20";
	} elseif ($edad == 2) {
		$edad = "20-30";
	} elseif ($edad == 3) {
		$edad = "31-40";
	} elseif ($edad == 4) {
		$edad = "41-50";
	} elseif ($edad == 5) {
		$edad = "51-60";
	} elseif ($edad == 6) {
		$edad = "Mayor de 60";
	}

	if (isset($_GET['entero1'])) {
		$entero1=1;
	}else{
		$entero1=0;
	}
	if (isset($_GET['entero2'])) {
		$entero2=1;
	}else{
		$entero2=0;
	}
	if (isset($_GET['entero3'])) {
		$entero3=1;
	}else{
		$entero3=0;
	}
	if (isset($_GET['entero4'])) {
		$entero4=1;
	}else{
		$entero4=0;
	}
	if (isset($_GET['entero5'])) {
		$entero5=1;
	}else{
		$entero5=0;
	}
	if (isset($_GET['entero6'])) {
		$entero6=1;
	}else{
		$entero6=0;
	}
	if (isset($_GET['entero7'])) {
		$entero7=1;
	}else{
		$entero7=0;
	}

	$enteroqr = (string)$entero1.(string)$entero2.(string)$entero3.(string)$entero4.(string)$entero5.(string)$entero6.(string)$entero7;
	// $mayorista = trim($_GET['mayorista']);
	// $mayoristaqr = $mayorista;
	// if ($mayorista==1) {
	// 	$mayorista = "Si";
	// }elseif ($mayorista == 2){
	// 	$mayorista="No";
	// }
	$asistido = trim($_GET['asistido']);
	$ediciones = $_GET['ediciones'];
	$fuente = trim($_GET['fuente']);
	$origen = trim($_GET['origen']);
	$fhregistro = date('y/m/d H:i:s', time());
	
	
	// Asignar dias restantes
	$fecha_25 = "2019-12-13";
	list( $ano, $mes, $dia ) = explode( "-", $fecha_25 );
    	$primer_dia = date( "z", mktime( 0, 0, 0, $mes, $dia, $ano ) );
    	$dia_actual = date( "z" );
    	$dias_restantes = $primer_dia - $dia_actual;
    	if ( $dias_restantes < 0 ) {
        	$dias_restantes += 365;
        	if ( date( "L", mktime( 0, 0, 0, 0, 0, $ano+1 ) ) ) {
            	if ( date( "m", mktime( 0, 0, 0, $mes, $dia, $ano ) ) > 2 ) {
                $dias_restantes++;
            }
        }
    }
 
	
	$dbh = mysqli_connect($host_name, $user_name, $password, $database);
	mysqli_set_charset($dbh, "utf8mb4"); 

	if (mysqli_connect_errno()) {
		die('<p>Error al conectar con servidor MySQL contacte al +52 3321349874 24 hrs. o enviar correo a miguelbermejo@hotmail: '.mysqli_connect_error().'</p>');
	  }

	if (!mysqli_query($dbh,"INSERT INTO registro25(email,genero,edad,entero,entero1,entero2,entero3,entero4,entero5,entero6,entero7,asistido,ediciones,fuente,origen,fhregistro,dias_fal) VALUES ('$email','$genero','$edad','$enteroqr','$entero1','$entero2','$entero3','$entero4','$entero5','$entero6','$entero7','$asistido','$ediciones','$fuente','$origen','$fhregistro','$dias_restantes')"))
	{
		echo("Error al ingresar registro de asistente contacte a +52 3321349874: " . mysqli_error($dbh));
	} else {
		echo("Registro de nuevo asistente ingresado => ");

		$idnew = mysqli_insert_id($dbh);
	echo("DATOS GUARDADOS......");
	mysqli_close($dbh);

	

	
	?>
	<script type="text/javascript">
	var id="<?php echo $idnew; ?>";
	var completo="<?php echo $completo; ?>";
	var filename="<?php echo $filename; ?>";
	</script>
	<?php
	
	 	echo "<script type='text/javascript'>window.location.href='../registro_tablet_terminado.html';</script>";
	

	}
	
	
}
	?>