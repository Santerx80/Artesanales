<?php

require 'config/config.php';
require 'config/conexion.php';
$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

// print_r($_SESSION);

$lista_carrito = array();

if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {

        $sql = $con->prepare("SELECT id, nombre, imagen, precio, descuento, $cantidad AS cantidad FROM productos_im WHERE id=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
}

// session_destroy();

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
    <link rel="stylesheet" href="css/stylej.css">

    <title>Carrito</title>
</head>

<body>

    <!-- Nav bar -->
    <?php require 'tools/nav.php'; ?>

    <h1>Detalles de la compra</h1>

    <!-- Contenedores -->
    <div class="contenedorcarrito">
        <section class="izquierdacarro">
            <!--COMPRA 1-->
            <?php if ($lista_carrito == null) {
                echo '<b>Lista vacia</b>';
            } else {

                $total = 0;
                foreach ($lista_carrito as $producto) {
                    $_id = $producto['id'];
                    $nombre = $producto['nombre'];
                    $imagen = 'data:image/jpg;base64,' . base64_encode($producto['imagen']);
                    $precio = $producto['precio'];
                    $descuento = $producto['descuento'];
                    $cantidad = $producto['cantidad'];
                    $precio_desc = $precio - (($precio * $descuento) / 100);
                    $subtotal = $cantidad * $precio_desc;
                    $total += $subtotal;
                    ?>
                    <div class="compras">
                        <img class="imagencarrito" src="<?php echo $imagen; ?>" alt="">
                        <div class="">
                            <h1>
                                <?php echo $nombre; ?>
                            </h1>
                            <p>Precio:
                                <?php echo MONEDA . number_format($precio_desc, 2, '.', ','); ?>
                            </p>
                            <p id="subtotal_<?php echo $_id; ?>" name="subtotal[]">Subtotal:
                                <?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>
            </section>

            <!--SECCION DE LA PARTE DERECHA DE LA PAGINA-->
            <section class="derechacarro">
                <!--SECCION DE RECIBO-->
                <div class="recibo">
                    <div class="detalles">
                        <p class="precio"><strong>Subtotal</strong> 4.999.999 COP</p>
                        <p class="precio"><strong>Gasto de envío</strong> 4.999.999 COP</p>
                        <hr class="linea">
                        <div class="total">
                            <h2>TOTAL</h2>
                            <p id="total">
                                <?php echo MONEDA . number_format($total, 2, '.', ','); ?>
                            </p>
                        </div>
                    <?php } ?>
                    <h3><strong>Identificación</strong></h3>
                    <p>Solicitamos esta información únicamente para la fase de compra</p>
                    <div class="informacion">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email">
                    </div>
                    <div class="informacion2">
                        <div class="infonombre">
                            <label for="text">Nombre</label>
                            <input type="text" id="nombre">
                        </div>
                        <div class="infoapellido">
                            <label for="text">Apellido</label>
                            <input type="text" id="apellido">
                        </div>
                    </div>
                    <div class="informacion3">
                        <div class="infocedula">
                            <label for="text">Cédula</label>
                            <input type="tel" id="cedula">
                        </div>
                        <div class="infotelefono">
                            <label for="phone">Teléfono</label>
                            <input type="tel" id="telefono">
                        </div>
                    </div>
                </div>

                <!--SECCION DE OPCION DE DIRECCION (PAIS, DEPARTAMENTO, MUNICIPIO)-->
                <div class="titulodireccion">
                    <h2>Dirección de envio</h2>
                </div>
                <section class="opciondireccion">
                    <select class="paises">
                        <option selected disabled>País</option>
                        <option value="">Colombia</option>
                        <option value="">Mexico</option>
                        <option value="">Argentina</option>
                    </select>
                    <select class="departamentos">
                        <option selected disabled>Departamento</option>
                        <option value="">Cundinamarca</option>
                        <option value="">San andres</option>
                        <option value="">Arauca</option>
                    </select>
                    <select class="municipios">
                        <option selected disabled>Municipio</option>
                        <option value="">Cartagena</option>
                        <option value="">Cali</option>
                        <option value="">Popayán</option>
                    </select>
                </section>
                <!--SECCION DE ESCRIBIR DIRECCION-->
                <section class="direccion">
                    <div class="informacion">
                        <label for="text">Dirección</label>
                        <input type="text" id="direccion">
                    </div>
                    <div class="informacion">
                        <label for="text">Adicionales</label>
                        <input type="text" id="adicionales">
                    </div>
                    <div class="informacion">
                        <label for="number">Codigo Postal</label>
                        <input type="tel" id="codigo postal">
                    </div>
                </section>

                <!--SECCION DE BOTON COMPRAR POR PAYPAL-->
                <div class="botonpagar">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
        </section>
    </div>

    <div class="whatsapp">
        <a href="http://wa.me/+573228579294">
        <img class="responsive-image" src="recursos/whatsapp.png" alt="Imagen de WhatsApp" />
        </a>
    </div>

    <!-- FOOTER -->
    <?php require 'tools/footer.php'; ?>

    <script src="js/script.js"></script>

    <!-- Paypal -->
    <script
        src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRENCY; ?>"></script>

    <script>
        paypal.Buttons({
            style: {
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: <?php echo $total; ?>
                        }
                    }]
                });
            },

            onApprove: function (data, actions) {
                actions.order.capture().then(function (detalles) {

                    console.log(detalles);

                    let url = 'clases/captura.php'

                    return fetch(url, {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            detalles: detalles
                        })
                    }).then(function (response) {
                        window.location.href = "completado.php?key=" + detalles['id'];
                    })
                });
            },

            onCancel: function (data) {
                alert("Pago cancelado");
                console.log(data)
            }
        }).render('#paypal-button-container');
    </script>

</body>

</html>