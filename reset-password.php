<?php

    require 'config/config.php';
    require 'config/conexion.php';
    require 'clases/clienteFunciones.php';

    $user_id = $_GET['id'] ?? $_POST['user_id'] ?? ''; // isset($_GET['id']) ? $_GET['id'] : '';
    $token = $_GET['token'] ?? $_POST['token'] ?? '';

    if($user_id == '' || $token == '') {
        header("Location: index.php");
        exit;
    }

    $db = new Database();
    $con = $db -> conectar();

    $errors = [];

    if(!verificaTokenRequest($user_id, $token, $con)){
        echo "No se pudo verificar la informacion";
        exit;
    }

    if(!empty($_POST)){

        $password = trim($_POST['password']);
        $repassword = trim($_POST['repassword']);

        if(esNulo([$user_id, $token, $password, $repassword])){
            $errors[] = "Debe llenar todos los campos";
        }

        if(!validaPassword($password, $repassword)){
            $errors[] = "Las contraseñas no coinciden"; 
        }

        if(count($errors) == 0){
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            if(actualizaPassword($user_id, $pass_hash, $con)){
                echo "Contraseña modificada.<br><a href='Iniciarsesion.php'>Iniciar sesión</a>";
                exit;
            } else {
                $errors[] = "Error al modificar contraseña. Intentalo nuevamente.";
            }
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Cambiar contraseña</title>
</head>
<body>
    <!--H E A D E R-->
    <header class="headerinicio">
        <h1>SOMOS LA MEJOR TIENDA</h1>
    </header>

    <!--SECTION DE R E C U P E R A R * C O N T R A S E Ñ A-->
    <div class="cuerpo">

    <?php mostrarMensajes($errors); ?>

        <form action="reset-password.php" method="post" class="forminicio" autocomplete="off">
            <h2>Cambiar contraseña</h2>

            <input type="hidden" name="user_id" id="user_id" value="<?= $user_id; ?>">
            <input type="hidden" name="token" id="token" value="<?= $token; ?>">

    
            <div class="input-group">
                <label for="password">Nueva contraseña</label>
                <input class="form-control" type="password" name="password" id="password" placeholder="Nueva contraseña" required>

                <label for="repassword">Confirmar contraseña</label>
                <input class="form-control" type="password" name="repassword" id="repassword" placeholder="Confirmar contraseña" required>
    
            <input class="btniniciar" type="submit" value="Continuar">
    
            <div class="registrar">
                <a href="login.php">Iniciar sesión</a>
            </div>
            </div>
        </form>
        </div>
</body>
</html>