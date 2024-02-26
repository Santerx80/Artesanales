<?php

    require 'config/config.php';
    require 'config/conexion.php';
    require 'clases/clienteFunciones.php';

    $db = new Database();
    $con = $db -> conectar();

    $proceso = isset($_GET['pago']) ? 'pago' : 'login';

    $errors = [];

    if(!empty($_POST)){

        $usuario = trim($_POST['usuario']);
        $password = trim($_POST['password']);
        $proceso = $_POST['proceso'] ?? 'login';

        if(esNulo([$usuario, $password])){
            $errors[] = "Debe llenar todos los campos";
        }

        if (count($errors) == 0){
        $errors[] = login($usuario, $password, $con, $proceso);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylej.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Iniciar sesion</title>
</head>
<body>
    <!--H E A D E R-->
    <?php require 'tools/nav.php'; ?>

    <!--SECTION DE I N I C I A R * S E S I O N-->
    <div class="cuerpo">

            <?php mostrarMensajes($errors); ?>

        <form action="iniciarsesion.php" class="forminicio" method="post" autocomplete="off">

            <h2>Iniciar sesión</h2>

            <input type="hidden" name="proceso" value="<?= $proceso; ?>">

            <div class="input-group">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" required>

                <label for="contraseña">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Contraseña" required>

                <div class="olvido-password">
                    <a href="Recuperarcontraseña.php">¿Olvido la contraseña?</a>
                </div>

                <input class="btniniciar" type="submit" value="Ingresar">

                <div class="registrar">
                    <p>¿No tiene cuenta?</p>
                    <a href="registrar.php">Registrate aqui</a>
                </div>
            </div>
        </form>
    </div>

    <!-- FOOTER -->
  <?php require 'tools/footer.php'; ?>
</body>
</html>