<?php

    require 'config/config.php';
    require 'config/conexion.php';
    require 'clases/clienteFunciones.php';

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
    <title>About us</title>
</head>
<body>
    <!--Barra de navegación-->
    <?php include 'tools/nav.php'; ?>

    <!-- Contenido -->
    <div class="heading">
        <h1>About us</h1>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolor sint tempore unde nisi quos quam quis vero aliquam.</p>
    </div>
    <div class="containers">
        <section class="about">
            <div class="about-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d497.1127268668469!2d-74.07100914798154!3d4.611591383208291!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f999954b6e50d%3A0x25285727e9f8709b!2sResidencias%20Col%C3%B3n!5e0!3m2!1ses!2sco!4v1706647614912!5m2!1ses!2sco" width="600" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <div class="about-content">
                <h2>Warm embrace in a  cup</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit placeat saepe, neque asperiores voluptatibus, dignissimos autem accusamus, similique in natus expedita! Dignissimos voluptate adipisci minus cum et laborum sint inventore, corrupti reprehenderit. Facere sed eius quam nemo eos a id mollitia, aspernatur sequi, at nihil enim earum laboriosam soluta adipisci quo similique? Veniam vero iusto temporibus ullam perferendis nisi sed.</p>
            </div>
        </section>
    </div>

    <!-- FOOTER -->
    <?php include 'tools/footer.php';?>

</body>
</html>