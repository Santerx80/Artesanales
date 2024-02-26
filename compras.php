<?php

    require 'config/config.php';
    require 'config/conexion.php';
    require 'clases/clienteFunciones.php';

    $db = new Database();
    $con = $db -> conectar();

    $token = generarToken();
    $_SESSION['token'] = $token;
    $idCliente = $_SESSION['user_cliente'];

    $sql = $con->prepare("SELECT id_transaccion, fecha, status, total FROM compra WHERE id_cliente = ? ORDER BY DATE(fecha) DESC");
    $sql->execute([$idCliente]);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Compras</title>

    <!-- FONT AWESOME -->
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>
<body>

    <!-- NavBar -->
    <?php include 'tools/nav.php'; ?>

    <!--Contenido-->
    <div class="containerc">

    <?php while($row = $sql->fetch(PDO::FETCH_ASSOC)) { ?>

        <div class="card">

            <div class="top-row background-top-row">
                <h4><i class="fas fa-clock" aria-hidden="true"></i> <?php echo $row['fecha']; ?></h4>
            </div>

            <div class="content">
                <h2><?php echo $row['id_transaccion']; ?></h2>
                <p>Total: <?php echo MONEDA . number_format($row['total'], 2, '.', ','); ?></p>
                <a href="compra_detalle.php?orden=<?php echo $row['id_transaccion']; ?>&token=<?php echo $token; ?>" class="button background-top-row" type="button">Ver compra</a>
            </div>
        </div>

    <?php } ?>

    </div>

    <!-- FOOTER -->
    <?php require 'tools/footer.php'; ?>
    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</body>
</html>