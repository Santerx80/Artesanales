<?php

require 'config/config.php';
require 'config/conexion.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, id_cat, nombre, imagen, precio FROM productos_im WHERE activo=1 LIMIT 6");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

$sql2 = $con->prepare("SELECT id, id_cat, nombre, imagen, precio FROM productos_im WHERE id_cat='Ropa' AND activo=1 LIMIT 3");
$sql2->execute();
$resultado2 = $sql2->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css\main.css">

  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <title>Pagina 2</title>
</head>

<body>

  <!-- NavBar -->
  <?php require 'tools/menu.php'; ?>

  <!-- Productos Destacados -->
  <div class="destacados">
    <p><strong>Productos destacados</strong></p>
    <div class="outer-card">
      <div class="tarjeta">

        <?php foreach ($resultado as $row) { ?>
          <div class="tarjeta-producto">
            <button class="producto">
              <?php echo $row['nombre'] ?> <br>
              <?php echo MONEDA . number_format($row['precio'], 2, '.', ','); ?>
            </button>
            <img src="data:image/jpg;base64,<?php echo base64_encode($row['imagen']); ?>">
            <div class="botones">
              <a href="Producto.php?id=<?php echo $row['id']; ?>&id_cat=<?php echo $row['id_cat']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>"
                class="ver-mas">Ver más</a>

              <button class="compra" type="button"
                onclick="addProducto(<?php echo $row['id']; ?>, '<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')">
                <i class='fas fa-shopping-cart'></i>
              </button>
            </div>
          </div>
        <?php } ?>

      </div>
    </div>
  </div>

  <!-- Productos Ropa -->
  <div class="product-feed">
    <div class="ropa">
      <p><strong>Ropa</strong></p>
      <div class="tarjeta-feed">

        <?php foreach ($resultado2 as $row) { ?>
          <div class="tarjeta-producto-feed">
            <button class="producto">
              <?php echo $row['nombre'] ?> <br>
              <?php echo MONEDA . number_format($row['precio'], 2, '.', ','); ?>
            </button>
            <img src="data:image/jpg;base64,<?php echo base64_encode($row['imagen']); ?>">
            <div class="botones">
              <a href="Producto.php?id=<?php echo $row['id']; ?>&id_cat=<?php echo $row['id_cat']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>"
                class="ver-mas">Ver más</a>
              <button class="compra" type="button"
                onclick="addProducto(<?php echo $row['id']; ?>, '<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')">
                <i class='fas fa-shopping-cart'></i>
              </button>
            </div>
          </div>
        <?php } ?>

      </div>
      <button class="ver-todo">
        <a href="Busqueda.php">Ver todo</a>
      </button>
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

  <!-- Opciones de la tienda javascript -->
  <script>
      function addProducto(id, token) {
          let url = 'clases/carrito.php'
          let formData = new FormData()
          formData.append('id', id)
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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Busqueda -->
  <script src="js/script.js"></script>

</body>

</html>