<?php
    header('Content-Type: text/html; charset=UTF-8');
    date_default_timezone_set('America/Mexico_City');
   
    

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'plugins/PHPMailer/src/SMTP.php';
    require 'plugins/PHPMailer/src/Exception.php';
    require 'plugins/PHPMailer/src/PHPMailer.php';

    //Recoger datos del formulario
    $notas = strip_tags($_POST['notas']);

    $nombre = strip_tags(trim($_POST['nombre']));
    $email = strip_tags(strtolower(trim($_POST['email'])));
    $celular = $_POST['celular'];
    strip_tags(settype($celular, "string"));
    $mensajetxt = strip_tags(trim($_POST['mensaje']));
    $fhmensaje = date('y/m/d H:i:s', time());

    if($notas == 'EXPOSITOR'){

        $dirigido = 'Información sobre los stands';
    } else {
        $dirigido = 'Consulta de Visitante';
    }


       try {
        // crear una nueva instancia de la clase PHPMailer
        $mail = new PHPMailer(true);

        $fromemail = "contacto@outletdemarcas.com.mx";
        $fromname = "Expo Outlet de Marcas";       
        
        $emailTo = "rocio.akbaal@gmail.com";
        $emailTo2 = "miguelbermejo@hotmail.com";

        
        //if ($debug) {
            // Emitir un registro detallado de
        //    $mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
        //}
        $mail->isSMTP(true);

        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Host = "smtp.ionos.mx";
        $mail->Port = "587";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Username = "contacto@outletdemarcas.com.mx";
        $mail->Password = "Info1929info1992..";

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
           )
        );

        
        $mail->setFrom($fromemail, $fromname);
        $mail->addAddress($emailTo);
        $mail->addAddress($emailTo2);
        

        $mail->isHTML(true);
        $mail->Subjet = $subjetct;

        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Hay un nuevo mensaje de la web';
        $mail->Body    = 'Mensaje de la web para: <b> '.$dirigido.'</b><br>';
        $mail->Body   .= 'Nombre: <b> '.$nombre.'</b><br>';
        $mail->Body   .= 'Email: <b> '.$email.'</b><br>';
        $mail->Body   .= 'Celular: <b> '.$celular.'</b><br>';
        $mail->Body   .= 'Mensaje: <b> '.$mensajetxt.'</b><br>';
        $mail->AltBody = 'Correo para texto plano, ';

        if(!$mail->send()) {
            error_log("MAILER: No se pudo enviar el correo");
        }
        echo "Correo enviado con [exito";


       

    } catch (Exception $e) {
            echo "Mailer Error: ".$mail->ErrorInfo;
    }

    echo "
    <script language='JavaScript'>
    location.href = \"../confirmacion.html\"
    </script>"; 

   

 ?>