<?php

use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';      
    $mail->SMTPAuth   = true;              
    $mail->Username   = 'santibece232@gmail.com';            
    $mail->Password   = 'dexw jsrj szhw vjco';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;                                    

    //Recipients
    $mail->setFrom('santibece232@gmail.com', 'TIENDA ON');
    $mail->addAddress($email);     

    //Content
    $mail->isHTML(true);                                  
    $mail->Subject = 'Detalles de su pedido';

    $cuerpo = '<h4>Gracias por su compra</h4>';
    $cuerpo = '<p>El ID de su compra es <b>'. $id_transaccion . '</b></p>';

    $mail->Body    = utf8_decode($cuerpo);
    $mail->AltBody = 'Le enviamos los detalles de su compra';

    $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');

    $mail->send();
} catch (Exception $e) {
    echo "Error al enviar el correo electronico: {$mail->ErrorInfo}";
    //exit;
}


?>