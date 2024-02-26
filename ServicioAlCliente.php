<?php
require 'config/config.php';
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
    <title>Servicio al Cliente</title>
</head>

<body>
    <!--SECCION DE NAV-->
    <?php require 'tools/nav.php'; ?>
    <div class="h1">
        <h1>Servicio al cliente</h1>
    </div>
    <!-- SECCION CONTACTO -->
    <section id="contacto" class="contacto">
        <div class="contenido-seccion">
            <div class="fila">
                <!-- Formulario -->
                <div class="col">
                    <input type="text" placeholder="Nombre">
                    <input type="text" placeholder="Asunto">
                    <textarea name="" id="" cols="30" rows="10" placeholder="Mensaje"></textarea>
                    <button>
                        Enviar
                        <span class="overlay"></span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <div class="whatsapp">
        <a href="http://wa.me/+573228579294">
            <img class="responsive-image" src="recursos\whatsapp.png" alt="Imagen de WhatsApp" />
        </a>
    </div>

    <!-- FOOTER -->
    <?php require 'tools/footer.php';?>
</body>

</html>