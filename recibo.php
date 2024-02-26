<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\main.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <title>Recibo</title>
</head>

<body>
    <!-- NavBar -->
    <?php require 'tools/nav.php'; ?>

    <main class="recibo-container">
        <div class="datos">
            <p>
                <b>Folio de la compra: </b>
                <? //php echo $id_transaccion; ?>123<br>
            </p>
            <p>
                <b>Fecha de compra: </b>
                <? //php echo $fecha; ?> hoy<br>
            </p>
            <p>
                <b>Total: </b>
                <? //php echo MONEDA . number_format($total, 2, '.', ','); ?>0<br>
            </p>
        </div>
        <div class="productos">
            <h3>Productos: </h3>
            <p>hola</p>
        </div>
        <div class="cantidad">
            <h3>Cantidad: </h3>
            <p>1</p>
        </div>
    </main>

    <div class="boton-volver">
        <button class="volver">
            Volver al comercio
        </button>
    </div>

    <!-- FOOTER -->
    <?php require 'tools/footer.php'; ?>

    <script src="js/script.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</body>

</html>