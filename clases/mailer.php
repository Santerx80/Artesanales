<?php

use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

class Mailer {
    function enviarEmail($email, $asunto, $cuerpo){
        require_once __DIR__ . '/../config/config.php';
        require __DIR__ . '/../phpmailer/src/PHPMailer.php';
        require __DIR__ . '/../phpmailer/src/SMTP.php';
        require __DIR__ . '/../phpmailer/src/Exception.php';

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
    $mail->Subject = mb_convert_encoding($asunto, 'ISO-8859-1', 'UTF-8');

    $mail->Body = mb_convert_encoding($cuerpo, 'ISO-8859-1', 'UTF-8');

    $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');

    if($mail->send()){
        return true;
    } else {
        return false;
    }

} catch (Exception $e) {
    echo "Error al enviar el correo electronico: {$mail->ErrorInfo}";
    return false;
}

    }
    
}

?>