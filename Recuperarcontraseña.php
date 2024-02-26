<?php

require 'config/config.php';
require 'config/conexion.php';
require 'clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

$errors = [];

if (!empty($_POST)) {

    $email = trim($_POST['email']);

    if (esNulo([$email])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (!esEmail($email)) {
        $errors[] = "La direccion de correo no es válida";
    }

    if (count($errors) == 0) {
        if (emailExiste($email, $con)) {
            $sql = $con->prepare("SELECT usuarios.id, clientes.nombres FROM usuarios INNER JOIN clientes ON usuarios.id_cliente=clientes.id WHERE clientes.email LIKE ? LIMIT 1");
            $sql->execute([$email]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $user_id = $row['id'];
            $nombres = $row['nombres'];

            $token = solicitaPassword($user_id, $con);

            if ($token !== null) {
                require 'clases/mailer.php';
                $mailer = new Mailer();

                $url = SITE_URL . '/reset-password.php?id=' . $user_id . '&token=' . $token;

                $asunto = "Recuperar contraseña - Tienda online";
                $cuerpo = "Estimado $nombres: <br> Si has solicitado el cambio de tu contraseña da click en el siguiente link <a href='$url'>$url</a>.";
                $cuerpo .= "<br>Si no hiciste esta solicitud puedes ignorar este correo.";

                if ($mailer->enviarEmail($email, $asunto, $cuerpo)) {
                    echo "<p><b>Correo enviado</b></p>";
                    echo "<p>Hemos enviado un correo electrónico a la dirección $email para restablecer la contraseña.</p>";

                    exit;
                }

            }
        } else {
            $errors[] = "No existe una cuenta asociada a esta dirección de correo";
        }
    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylej.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Recuperar contraseña</title>
</head>

<body>
    <!--H E A D E R-->
    <?php require 'tools/nav.php'; ?>

    <!--SECTION DE R E C U P E R A R * C O N T R A S E Ñ A-->
    <div class="cuerpo">

        <?php mostrarMensajes($errors); ?>

        <form action="Recuperarcontraseña.php" method="post" class="forminicio" autocomplete="off">
            <h2>Recuperar contraseña</h2>

            <div class="input-group">

                <label for="email">Correo electrónico</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="Correo electrónico"
                    required>

                <input class="btniniciar" type="submit" value="Continuar">

                <div class="registrar">
                    <p>¿No tiene cuenta? <a href="registrar.php">Registrate aqui</a></p>
                </div>
            </div>
        </form>
    </div>

    <!-- FOOTER -->
    <?php require 'tools/footer.php';?>

    <div class="whatsapp">
        <a href="http://wa.me/+573228579294">
        <img class="responsive-image" src="recursos/whatsapp.png" alt="Imagen de WhatsApp" />
        </a>
    </div>
</body>

</html>