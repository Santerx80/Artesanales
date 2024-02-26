<?php

require 'config/config.php';
require 'config/conexion.php';
$db = new Database();
$con = $db->conectar();


$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
$id_cat = isset($_GET['id_cat']) ? $_GET['id_cat'] : '';


$sql2 = $con->prepare("SELECT id, id_cat, nombre, imagen, precio FROM productos_im WHERE id_cat=? AND activo=1 LIMIT 5");
$sql2->execute([$id_cat]);
$result2 = $sql2->fetchAll(PDO::FETCH_ASSOC);

if ($id == '' || $token == '' || $id_cat == '') {
    echo 'Error al procesar la peticion';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp) {
        $sql = $con->prepare("SELECT count(id) FROM productos_im WHERE id=? AND activo=1");
        $sql->execute([$id]);
        if ($sql->fetchColumn() > 0) {

            $sql = $con->prepare("SELECT nombre, imagen, imagen2, imagen3, imagen4, imagen5, imagen6, precio, descripcion, descuento FROM productos_im WHERE id=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $precio = $row['precio'];
            $descripcion = $row['descripcion'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
            $imagen = 'data:image/jpg;base64,' . base64_encode($row['imagen']);
            $imagen2 = 'data:image/jpg;base64,' . base64_encode($row['imagen2']);
            $imagen3 = 'data:image/jpg;base64,' . base64_encode($row['imagen3']);
            $imagen4 = 'data:image/jpg;base64,' . base64_encode($row['imagen4']);
            $imagen5 = 'data:image/jpg;base64,' . base64_encode($row['imagen5']);
            $imagen6 = 'data:image/jpg;base64,' . base64_encode($row['imagen6']);

        }

        $sqlCaracter = $con->prepare("SELECT DISTINCT(det.id_caracteristica) AS idCat, cat.caracteristica  FROM det_prod_caracter AS det INNER JOIN caracteristicas AS cat ON det.id_caracteristica = cat.id WHERE det.id_producto=?");
        $sqlCaracter->execute([$id]);

    } else {
        echo 'Error al procesar la peticion';
        exit;
    }
}

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
    <title>Producto</title>
</head>

<body>
    <!--SECCION DE NAV-->
    <?php require 'tools/nav.php'; ?>

    <!--SECCION DE PRODUCTO-->
    <div class="h1producto">
        <h1>
            <?php echo $nombre; ?>
        </h1>
    </div>
    <div class="contenedor ">
        <div class="izquierda" id="izquierda">

            <?php if(empty($imagen) || $imagen == 'data:image/jpg;base64,') { 
                echo '';    
            } else {     
            ?>
            <div class="contenedores" onclick="swapImages(this)">
                <img src="<?php echo $imagen; ?>" alt="Imagen 1" class="image">
            </div>
            <?php } ?>
            
            <?php if(empty($imagen2) || $imagen2 == 'data:image/jpg;base64,') { 
                echo '';    
            } else {     
            ?>
            <div class="contenedores" onclick="swapImages(this)">
                <img src="<?php echo $imagen2; ?>" alt="Imagen 1" class="image">
            </div>
            <?php } ?>

            <?php if(empty($imagen3) || $imagen3 == 'data:image/jpg;base64,') { 
                echo '';    
            } else {   
            ?>
            <div class="contenedores" onclick="swapImages(this)">
                <img src="<?php echo $imagen3; ?>" alt="Imagen 1" class="image">
            </div>
            <?php } ?>

            <?php if(empty($imagen4) || $imagen4 == 'data:image/jpg;base64,') { 
                echo '';    
            } else {   
            ?>
            <div class="contenedores" onclick="swapImages(this)">
                <img src="<?php echo $imagen4; ?>" alt="Imagen 1" class="image">
            </div>
            <?php } ?>

            <?php if(empty($imagen5) || $imagen5 == 'data:image/jpg;base64,') { 
                echo '';    
            } else {  
            ?>
            <div class="contenedores" onclick="swapImages(this)">
                <img src="<?php echo $imagen5; ?>" alt="Imagen 1" class="image">
            </div>
            <?php } ?>

            <?php if(empty($imagen6) || $imagen6 == 'data:image/jpg;base64,') { 
                echo '';    
            } else {    
            ?>
            <div class="contenedores" onclick="swapImages(this)">
                <img src="<?php echo $imagen6; ?>" alt="Imagen 1" class="image">
            </div>
            <?php } ?>
            
        </div>

        
        <div class="medio" id="medio">
            <img src="<?php echo $imagen; ?>" alt="Imagen 2" class="image">
        </div>
        
        <div class="derecha">
            <h3>
                <?php echo MONEDA . number_format($precio, 2, '.', ','); ?>
            </h3>

            <p>
                <?php echo $descripcion; ?>
            </p>
            <!-- <h6>Stock disponibles : 120unidades</h6> -->

            <!--div de seleccion de talla y color-->
            <div class="contenedor-talla">
                <?php

                while ($row_cat = $sqlCaracter->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class ='talla'>";
                    $idCat = $row_cat['idCat'];
                    //echo $row_cat['caracteristica'] . ": ";
                

                    echo "<select class = 'form-select' id='cat_$idCat'>";

                    $sqlDet = $con->prepare("SELECT id, valor, stock FROM det_prod_caracter WHERE id_producto=? AND id_caracteristica=?");
                    $sqlDet->execute([$id, $idCat]);
                    while ($row_det = $sqlDet->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option id='>" . $row_det['id'] . "'>" . $row_det['valor'] . "</option>";
                    }

                    echo "</select>";
                    echo "</div>";
                }

                ?>
            </div>


            <div class="botoncomprar">
            <button class="btnagregar" type="button" onclick="addProducto(<?php echo $id; ?>, cantidad.value, '<?php echo $token_tmp; ?>')">
                    Agregar al carrito
                    <span class="overlay"></span>
            </button>
            </div>
            <div class="container">

                <!-- Cantidad: <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" max="10" value="1"> -->

                <button id="decrement" onclick="stepper(this)"> - </button>
                <input type="number" min="0" max="100" step="1" value="1" id="cantidad" readonly>
                <button id="increment" onclick="stepper(this)"> + </button>
                <!-- my-input -->

            </div>
        </div>
    </div>

    <!--SECCION DE TARJETAS-->
    <div class="h1tarjetas">
        <h1> Productos similares </h1>
        <div class="contenido-imagenes">
            <button class="flecha-izquierda">←</button>
            <div class="contenedor-tarjetas">
                <?php foreach ($result2 as $row) { ?>
                    <div class="tarjetas">
                        <img src="data:image/jpg;base64,<?php echo base64_encode($row['imagen']); ?>" alt="">
                        <a href="Producto.php?id=<?php echo $row['id']; ?>&id_cat=<?php echo $row['id_cat']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>"
                            class="ver-mas">Ver más</a>
                    </div>
                <?php } ?>
            </div>
            <button class="flecha-derecha">→</button>
        </div>
    </div>

    <div class="whatsapp">
        <a href="http://wa.me/+573228579294">
            <img class="responsive-image" src="recursos/whatsapp.png" alt="Imagen de WhatsApp" />
        </a>
    </div>

    <!-- FOOTER -->
  <?php require 'tools/footer.php'; ?>

    <script src="js/script.js"></script>
    <script src="js/scriptj.js"></script>


    <!-- JavaScript -->
    <script>
        function addProducto(id, cantidad, token) {
            let url = 'clases/carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('cantidad', cantidad)
            formData.append('token', token)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                  let elemento = document.getElementById("num_cart")
                  let oldCount = parseInt(elemento.getAttribute('data-count'));
                  let newCount = data.numero;
                  if (newCount > oldCount) {
                      elemento.style.animation = 'none';
                      setTimeout(function() {
                          elemento.style.animation = 'jump 1s';
                      }, 100);
                  }
                  elemento.innerHTML = newCount;
                  elemento.setAttribute('data-count', newCount);
                  elemento.style.display = newCount != 0 ? 'inline' : 'none';
              }
          })
      }
    </script>
</body>

</html>