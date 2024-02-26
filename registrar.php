<?php

require 'config/config.php';
require 'config/conexion.php';
require 'clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

$errors = [];

if (!empty($_POST)) {

    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $dni = trim($_POST['dni']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if (esNulo([$nombres, $apellidos, $email, $telefono, $dni, $usuario, $password, $repassword])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (!esEmail($email)) {
        $errors[] = "La direccion de correo no es válida";
    }

    if (!validaPassword($password, $repassword)) {
        $errors[] = "Las contraseñas no coinciden";
    }

    if (usuarioExiste($usuario, $con)) {
        $errors[] = "El nombre de usuario $usuario ya existe";
    }

    if (emailExiste($email, $con)) {
        $errors[] = "El correo electrónico $email ya existe";
    }

    if (count($errors) == 0) {

        $id = registrarCliente([$nombres, $apellidos, $email, $telefono, $dni], $con);

        if ($id > 0) {
            require 'clases/mailer.php';
            $mailer = new Mailer();
            $token = generarToken();

            $pass_hash = password_hash($password, PASSWORD_DEFAULT);

            $idUsuario = registrarUsuario([$usuario, $pass_hash, $token, $id], $con);

            if ($idUsuario > 0) {

                $url = SITE_URL . '/activa_cliente.php?id=' . $idUsuario . '&token=' . $token;
                $asunto = "Activar cuenta - Tienda online";
                $cuerpo = "Estimado $nombres: <br> Para continuar con el proceso de registro porfavor darle click al siguiente link <a href='$url'>Activar cuenta</a>";

                if ($mailer->enviarEmail($email, $asunto, $cuerpo)) {
                    echo "Para terminar el proceso de registro siga las instrucciones que le hemos enviado a la direccion de correo electronico $email";

                    exit;
                }

            } else {
                $errors[] = "Error al registrar usuario";
            }
        } else {
            $errors[] = "Error al registrar cliente";
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
    <title>Registro</title>
</head>

<body>
    <!--H E A D E R-->
    <?php require 'tools/nav.php'; ?>

    <!--SECTION DE REGISTRO-->
    <div class="cuerporegistro">
        <form class="formregistro" action="registrar.php" method="post" autocomplete="off">
            <h2>Registro</h2>
            <div class="input-box">
                <div class="input-field">
                    <label for="contraseña">
                        <h4>*</h4>Nombre
                    </label>
                    <input type="text" name="nombres" id="nombres" class="form-control" required>
                </div>
                <div class="input-field">
                    <label for="contraseña">
                        <h4>*</h4>Apellido
                    </label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                </div>
                <div class="input-field">
                    <label for="contraseña">
                        <h4>*</h4>Correo electrónico
                    </label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <span id="validarEmail" class="text-danger"></span>
                </div>
                <div class="input-field">
                    <label for="contraseña">
                        <h4>*</h4>Telefono
                    </label>
                    <input type="tel" name="telefono" id="telefono" class="form-control" required>
                </div>
                <div class="input-field">
                    <label for="contraseña">
                        <h4>*</h4>Cedula
                    </label>
                    <input type="text" name="dni" id="dni" class="form-control" required>
                </div>
                <div class="input-field">
                    <label for="contraseña">
                        <h4>*</h4>Usuario
                    </label>
                    <input type="text" name="usuario" id="usuario" class="form-control" required>
                    <span id="validarUsuario" class="text-danger"></span>
                </div>
                <div class="input-field">
                    <label for="contraseña">
                        <h4>*</h4>Contraseña
                    </label>
                    <div class="password-container">
                        <input type="password" name="password" id="password" class="form-control" required>
                        <i class="toggle-password fas fa-eye" onclick="togglePassword('password')"></i>
                    </div>
                </div>
                <div class="input-field">
                    <label for="contraseña">
                        <h4>*</h4>Repetir contraseña
                    </label>
                    <div class="password-container">
                        <input type="password" name="repassword" id="repassword" class="form-control" required>
                        <i class="toggle-password fas fa-eye" onclick="togglePassword('repassword')"></i>
                    </div>
                </div>
            </div>
            <p><strong>Nota: </strong>Los campos con asterisco son obligatorios</p>
            <button type="submit" class="btnregistrar">Registrarse</button>
        </form>
        <div class="final"></div>
    </div>

    <div class="whatsapp">
        <a href="http://wa.me/+573228579294">
        <img class="responsive-image" src="recursos/whatsapp.png" alt="Imagen de WhatsApp" />
        </a>
    </div>

    <!-- FOOTER -->
    <?php require 'tools/footer.php';?>

    <script src="js/script.js"></script>

    <!-- Javascript para el formulario -->
    <script>
        let txtUsuario = document.getElementById('usuario')
        txtUsuario.addEventListener("blur", function () {
            existeUsuario(txtUsuario.value)
        }, false)

        let txtEmail = document.getElementById('email')
        txtEmail.addEventListener("blur", function () {
            existeEmail(txtEmail.value)
        }, false)

        function existeUsuario(usuario) {
            let url = "clases/clienteAjax.php"
            let formData = new FormData()
            formData.append("action", "existeUsuario")
            formData.append("usuario", usuario)

            fetch(url, {
                method: 'POST',
                body: formData
            }).then(response => response.json())
                .then(data => {

                    if (data.ok) {
                        document.getElementById('usuario').value = ''
                        document.getElementById('validarUsuario').innerHTML = 'Usuario no disponible'
                    } else {
                        document.getElementById('validarUsuario').innerHTML = ''
                    }

                })
        }

        function existeEmail(email) {
            let url = "clases/clienteAjax.php"
            let formData = new FormData()
            formData.append("action", "existeEmail")
            formData.append("email", email)

            fetch(url, {
                method: 'POST',
                body: formData
            }).then(response => response.json())
                .then(data => {

                    if (data.ok) {
                        document.getElementById('email').value = ''
                        document.getElementById('validarEmail').innerHTML = 'El email ya existe'
                    } else {
                        document.getElementById('validarEmail').innerHTML = ''
                    }

                })
        }
    </script>

</body>

</html>