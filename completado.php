<?php

require 'config/config.php';
require 'config/conexion.php';
$db = new Database();
$con = $db->conectar();

$id_transaccion = isset($_GET['key']) ? $_GET['key'] : '0';

$error = '';
if ($id_transaccion == '') {
    $error = 'Error al procesar la petición';
} else {

    $sql = $con->prepare("SELECT count(id) FROM compra WHERE id_transaccion=? AND status=?");
    $sql->execute([$id_transaccion, 'COMPLETED']);
    if ($sql->fetchColumn() > 0) {

        $sql = $con->prepare("SELECT id, fecha, email, total FROM compra WHERE id_transaccion=? AND status=? LIMIT 1");
        $sql->execute([$id_transaccion, 'COMPLETED']);
        $row = $sql->fetch(PDO::FETCH_ASSOC);

        $idCompra = $row['id'];
        $total = $row['total'];
        $fecha = $row['fecha'];

        $sqlDet = $con->prepare("SELECT nombre, precio, cantidad FROM detalle_compra WHERE id_compra = ?");
        $sqlDet->execute([$idCompra]);
    } else {
        $error = 'Error al comprobar la compra';
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- FONT AWESOME  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Estilos CSS  -->
    <link rel="stylesheet" href="css/main.css">

    <title>Carrito</title>
</head>

<body>

    <!-- Nav bar -->
    <?php require 'tools/nav.php'; ?>

    <?php if (strlen($error) > 0) { ?>
        <div class="col">
            <h3>
                <?php echo $error; ?>
            </h3>
        </div>
        </div>

    <?php } else { ?>

    <div class="detalles-compra">
        <b>Folio de la compra: </b>
        <?php echo $id_transaccion; ?><br>
        <b>Fecha de compra: </b>
        <?php echo $fecha; ?><br>
        <b>Total: </b>
        <?php echo MONEDA . number_format($total, 2, '.', ','); ?><br>
    </div>
        <!--Contenido-->
    <div class="containert">
        <table>
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Nombre</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row_det = $sqlDet->fetch(PDO::FETCH_ASSOC)) {
                    $importe = $row_det['precio'] * $row_det['cantidad']; ?>
                <tr>
                    <td><?php echo $row_det['cantidad']; ?></td>
                    <td><?php echo $row_det['nombre']; ?></td>
                    <td><?php echo $importe; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        <?php } ?>
        </table>
    </div>

    <button class="volverBtn"><a href="Index.php">Volver</a></button>

        <div class="whatsapp">
            <a href="http://wa.me/+573228579294">
                <img class="responsive-image" src="recursos\whatsapp.png" alt="Imagen de WhatsApp" />
            </a>
        </div>

    <script src="js/script.js"></script>

</body>

</html>