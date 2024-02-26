<?php

require 'config/config.php';
require 'config/conexion.php';
$db = new Database();
$con = $db->conectar();

$id_cat = isset($_GET['id_cat']) ? $_GET['id_cat'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id_cat == '' || $token == '') {
  if (isset($_GET['orden']) && $_GET['orden'] == 'mayor') {
    $sql = $con->prepare("SELECT id, nombre, id_cat, imagen, precio FROM productos_im WHERE activo=1 ORDER BY precio DESC");
    $sql->execute();
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
  } else if (isset($_GET['orden']) && $_GET['orden'] == 'menor') {
    $sql = $con->prepare("SELECT id, nombre, id_cat, imagen, precio FROM productos_im WHERE activo=1 ORDER BY precio ASC");
    $sql->execute();
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
  } else {
    $sql = $con->prepare("SELECT id, nombre, id_cat, imagen, precio FROM productos_im WHERE activo=1");
    $sql->execute();
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
  }

} else {
  $token_tmp = hash_hmac('sha1', $id_cat, KEY_TOKEN2);

  if ($token == $token_tmp) {
    $sql = $con->prepare("SELECT count(id_cat) FROM productos_im WHERE id_cat=? AND activo=1");
    $sql->execute([$id_cat]);

    if ($sql->fetchColumn() > 0) {

      $sql = $con->prepare("SELECT id, nombre, id_cat, imagen, precio FROM productos_im WHERE id_cat=? AND activo=1");
      $sql->execute([$id_cat]);
      $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    }

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
  <link rel="stylesheet" href="css/main.css">
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <title>Busqueda</title>
</head>

<body>

  <!-- NavBar -->
  <?php require 'tools/nav.php'; ?>

  <main class="product-found" id="datafetch">
    <div class="titulo">
      <p><strong>
          <?php echo $id_cat; ?>
        </strong></p>
      <div class="tarjeta-feed">

        <?php foreach ($resultado as $row) { ?>
          <div class="tarjeta-producto-feed">
            <button class="producto">
              <?php echo $row['nombre']; ?> <br>
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
      <aside class="categoria-busqueda">
        <h1><strong>Categorias</strong></h1>
        <p><strong><a
              href="Busqueda.php?id_cat=<?php echo $row['id_cat'] = 'Ropa'; ?>&token=<?php echo hash_hmac('sha1', $row['id_cat'], KEY_TOKEN2); ?>">Ropa</a></strong>
        </p>
        <p><strong><a
              href="Busqueda.php?id_cat=<?php echo $row['id_cat'] = 'Accesorios'; ?>&token=<?php echo hash_hmac('sha1', $row['id_cat'], KEY_TOKEN2); ?>">Accesorios</a></strong>
        </p>
        <p><strong><a
              href="Busqueda.php?id_cat=<?php echo $row['id_cat'] = 'Artesanias'; ?>&token=<?php echo hash_hmac('sha1', $row['id_cat'], KEY_TOKEN2); ?>">Artesanias</a></strong>
        </p>
        <p><strong><a
              href="Busqueda.php?id_cat=<?php echo $row['id_cat'] = 'Hogar'; ?>&token=<?php echo hash_hmac('sha1', $row['id_cat'], KEY_TOKEN2); ?>">Hogar</a></strong></strong>
        </p>
        <p><strong><a
              href="Busqueda.php?id_cat=<?php echo $row['id_cat'] = 'Libros'; ?>&token=<?php echo hash_hmac('sha1', $row['id_cat'], KEY_TOKEN2); ?>">Libros</a></strong></strong>
        </p>
        <h1><strong>Costo</strong></h1>
        <p><strong><a href="Busqueda.php?orden=mayor&token=<?php echo hash_hmac('sha1', 'mayor', KEY_TOKEN2); ?>">Mayor
              precio</a></strong></p>
        <p><strong><a href="Busqueda.php?orden=menor&token=<?php echo hash_hmac('sha1', 'menor', KEY_TOKEN2); ?>">Menor
              precio</a></strong></p>
      </aside>
    </div>
  </main>

  <div class="whatsapp">
    <a href="http://wa.me/+573228579294">
      <img class="responsive-image" src="recursos/whatsapp.png" alt="Imagen de WhatsApp" />
    </a>
  </div>

    <!-- FOOTER -->
    <?php require 'tools/footer.php'; ?>

  <script src="js/script.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
            elemento.innerHTML = data.numero
          }
        })
    }
  </script>

</body>

</html>