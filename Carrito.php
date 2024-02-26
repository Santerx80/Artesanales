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

    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Estilos CSS  -->
    <link rel="stylesheet" href="css/stylej.css">

    <title>Carrito</title>
</head>

<body>

    <!-- NavBar -->
    <?php require 'tools/nav.php'; ?>

    <!-- Contenedores -->
    <div class="contenedorcarrito">
        <section class="izquierdacarro">
            <!--COMPRA 1-->
            <?php if ($lista_carrito == null) {
                echo '<div class = "centrarlista">
                        <div class = "listavacia"> 
                            <b>Lista vacia</b> 
                        </div>
                       </div>';
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
                        <div class="contenedor-carrito">
                            <h1>
                                <?php echo $nombre; ?>
                            </h1>
                            <div class="botonescompra">
                                <div class="center">
                                    <div class="addNumber_cont">
                                    <button id="decrement" data-target-id="cantidad_<?php echo $_id; ?>" onclick="stepper(this)"> - </button>
                                    <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad ?>" size="5"
                                        id="cantidad_<?php echo $_id; ?>"
                                        onchange="actualizaCantidad(this.value, <?php echo $_id; ?>)">
                                    <button id="increment" data-target-id="cantidad_<?php echo $_id; ?>" onclick="stepper(this)"> + </button>
                                    </div>
                                </div>
                                <button class="eliminar">
                                    <td><a id="eliminar" data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal"
                                            data-bs-target="#eliminaModal"><i class="fas fa-trash"></i></a></td>
                                </button>
                            </div>
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
            </div>

            <!--SECCION DE BOTON COMPRAR POR PAYPAL-->
            <div class="botonpagar">
                <?php if (isset($_SESSION['user_cliente'])) { ?>
                <a href="detalles.php">Realizar Pago</a>
                <?php } else { ?>
                    <a href="Iniciarsesion.php?pago">Realizar Pago</a>
                <?php } ?>
            </div>
                <?php } ?>
        </section>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="eliminaModalLabel">Alerta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Desea eliminar el producto de la lista?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="espacio"></div>


      <!-- FOOTER -->
  <?php require 'tools/footer.php'; ?>

    <!-- Boostrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>



    <script src="js/script.js"></script>
    <script src="js/scripts.js"></script>

    <!-- JavaScript -->
    <script>

        let eliminaModal = document.getElementById('eliminaModal')
        eliminaModal.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
            buttonElimina.value = id
        })

        function actualizaCantidad(cantidad, id) {
            let url = 'clases/actualizar_carrito.php'
            let formData = new FormData()
            formData.append('action', 'agregar')
            formData.append('id', id)
            formData.append('cantidad', cantidad)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
                .then(data => {
                    if (data.ok) {

                        let divsubtotal = document.getElementById('subtotal_' + id)
                        divsubtotal.innerHTML = data.sub

                        let total = 0.00
                        let list = document.getElementsByName('subtotal[]')

                        for (let i = 0; i < list.length; i++) {
                            total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''))
                        }

                        total = new Intl.NumberFormat('en-Us', {
                            minimumFractionDigits: 2
                        }).format(total)
                        document.getElementById('total').innerHTML = '<?php echo MONEDA; ?>' + total

                    }
                })
        }

        function eliminar() {

            let botonElimina = document.getElementById('btn-elimina')
            let id = botonElimina.value

            let url = 'clases/actualizar_carrito.php'
            let formData = new FormData()
            formData.append('action', 'eliminar')
            formData.append('id', id)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        location.reload()
                    }
                })
        }
    </script>

</body>

</html>