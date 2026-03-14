<?php
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Mexico_City');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer2021/src/Exception.php';
require 'PHPMailer2021/src/PHPMailer.php';
require 'PHPMailer2021/src/SMTP.php';


$mail = new PHPMailer(true);

//Recoger datos del formulario
$notas = strip_tags($_GET['notas']);
$nombre = strip_tags(trim($_GET['nombre']));
$email = strip_tags(strtolower(trim($_GET['email'])));
$celular = $_GET['celular'];
strip_tags(settype($celular, "string"));
$mensajetxt = strip_tags(trim($_GET['mensaje']));
$fhmensaje = date('y/m/d H:i:s', time());
if($notas == 'EXPOSITOR'){
	$dirigido = 'Información sobre los stands';
} else {
	$dirigido = 'Consulta de Visitante';
}

if (isset($_POST['email'])) {
    //guardar información en la BD
    //$host_name = 'db5000813070.hosting-data.io';
    //$database = 'dbs721729';
    //$user_name = 'dbu326748';
    //$password = 'Outlet876..';



    //$dbh = mysqli_connect($host_name, $user_name, $password, $database);
   // mysqli_set_charset($dbh, "utf8mb4"); 

    //if (mysqli_connect_errno()) {
    //    die('<p>Error al conectar con servidor MySQL contacte al +52 3321349874 24 hrs. o enviar correo a miguelbermejo@hotmail: '.mysqli_connect_error().'</p>');
    //    }
//
    //if (!mysqli_query($dbh,"INSERT INTO contactanos(dirigido,nombre,email,celular,mensaje,fhmensaje,notas) VALUES ('$dirigido','$nombre','$email','$celular','$mensajetxt','$fhmensaje','$notas')"))
    //{
    //    echo("Error al ingresar registro de asistente contacte a +52 3321349874: " . mysqli_error($dbh));
    //} else {
    //    echo("Mensaje Guardado=> ");
    //}

    //$idnew = mysqli_insert_id($dbh);
    //echo("DATOS GUARDADOS......");
    //mysqli_close($dbh);



    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                           //Send using SMTP
        $mail->Host       = 'smtp.ionos.mx';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'contacto@outletdemarcas.com.mx';                     //SMTP username
        $mail->Password   = 'Info1929info1992..';                               //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setLanguage('es', 'PHPMailer2021/src/language/');
        
        $mail->setFrom('contacto@outletdemarcas.com.mx', 'Outlet de Marcas - web');
        
        $mail->addCC('rocio.akbaal@outletdemarcas.com.mx', 'Rocio');
        $mail->addAddress('akbaal.eventos@gmail.com', 'Yolanda Rodríguez');
        //$mail->addCC('natalia.cuellar@outletdemarcas.com.mx', 'Natalia');
        
        $mail->addReplyTo('miguelbermejo@hotmail.com', 'Extra');
        // $mail->addBCC('miguelbermejo@hotmail.com');

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Hay un nuevo mensaje de la web';
        $mail->Body    = 'Mensaje de la web para: <b> '.$dirigido.'</b><br>';
        $mail->Body   .= 'Nombre: <b> '.$nombre.'</b><br>';
        $mail->Body   .= 'Email: <b> '.$email.'</b><br>';
        $mail->Body   .= 'Celular: <b> '.$celular.'</b><br>';
        $mail->Body   .= 'Mensaje: <b> '.$mensajetxt.'</b><br>';
        $mail->AltBody = 'Correo para texto plano, ';

        $mail->send();
        echo 'El mensaje fue enviado';
    } catch (Exception $e) {
        echo "ocurrio un errro al enviar el mensaje: {$mail->ErrorInfo}";
    }

    echo "
    <script language='JavaScript'>
    location.href = \"../confirmacion.html\"
    </script>"; 
}

?>