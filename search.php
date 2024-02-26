<?php

require 'config/config.php';
require 'config/conexion.php';
$db = new Database();
$con = $db->conectar();

$q = isset($_GET['q']) ? $_GET['q'] : '';

$sql = $con->prepare("SELECT id, nombre, id_cat, imagen, precio FROM productos_im WHERE activo=1 AND nombre LIKE ?");
$sql->execute(['%' . $q . '%']);
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


  echo '<div class="tarjeta-feed">';

foreach ($resultado as $row) {
  echo '<div class="tarjeta-producto-feed">';
  echo '<button class="producto">' . htmlspecialchars($row['nombre']) . '<br>' . MONEDA . number_format($row['precio'],  2, '.', ',') . '</button>';
  echo '<img src="data:image/jpg;base64,' . base64_encode($row['imagen']) . '">';
  echo '<div class="botones">';
  echo '<a href="Producto.php?id=' . $row['id'] . '&id_cat=' . $row['id_cat'] . '&token=' . hash_hmac('sha1', $row['id'], KEY_TOKEN) . '" class="ver-mas">Ver más</a>';
  echo '<button class="compra" type="button" onclick="addProducto(' . $row['id'] . ', \'' . hash_hmac('sha1', $row['id'], KEY_TOKEN) . '\')"><i class=\'fas fa-shopping-cart\'></i></button>';
  echo '</div>';
  echo '</div>';
}
  echo '</div>';
?>
