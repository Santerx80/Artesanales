<?php

    require 'config/config.php';
    require 'config/conexion.php';
    require 'clases/clienteFunciones.php';

    $token_session = $_SESSION['token'];
    $orden = $_GET['orden'] ?? null;
    $token = $_GET['token'] ?? null;

    if($orden == null || $token == null || $token != $token_session){
        header("Location: compras.php");
        exit;
    }
    
    $db = new Database();
    $con = $db -> conectar();

    $sqlCompra = $con->prepare("SELECT id, id_transaccion, fecha, total FROM compra WHERE id_transaccion = ? LIMIT 1");
    $sqlCompra->execute([$orden]);
    $rowCompra = $sqlCompra->fetch(PDO::FETCH_ASSOC);
    $idCompra = $rowCompra['id'];

    $fecha = new DateTime($rowCompra['fecha']);
    $fecha = $fecha->format("d/m/Y H:i");

    $sqlDetalle = $con->prepare("SELECT id, nombre, precio, cantidad FROM detalle_compra WHERE id_compra = ?");
    $sqlDetalle->execute([$idCompra]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- FONT AWESOME  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Estilos CSS  -->
        <link rel="stylesheet" href="css/main.css">
    <title>Compras</title>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">
</head>
<body>
    <!--Barra de navegación-->
    <?php include 'tools/nav.php'; ?>

    <!--Contenido-->
    <div class="containert">
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                while($row = $sqlDetalle->fetch(PDO::FETCH_ASSOC)){ 
                $precio = $row['precio'];    
                $cantidad = $row['cantidad'];    
                $subtotal = $precio * $cantidad;    
            ?>
                <tr>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></td>
                    <td><?php echo $cantidad; ?></td>
                    <td><?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- FOOTER -->
    <?php require 'tools/footer.php'; ?>

    <!-- JavaScript -->
    
</body>
</html>