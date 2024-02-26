<head>
    <link rel="stylesheet" href="../css/main.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<!-- NavBar -->
<nav class="container-menu">
  <div class="tutorial">
    <button class="btn-inicio">
      <a href="index.php">
      <strong>• Inicio</strong>
      </a>
    </button>
    <button class="btn-servicio">
      <a href="ServicioAlCliente.php">
      <strong>Servicio al cliente</strong>
      </a>
    </button>
    <button class="btn-nosotros">
      <a href="sobrenosotros.php">
      <strong>Sobre nosotros</strong>
      </a>
    </button>

    <?php if(isset($_SESSION['user_id'])) { ?>
      <ul>
        <li>
        <button class="btn-ingresar" type="button" id="btn_session" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user"></i> &nbsp; <strong><?php echo $_SESSION['user_name']; ?></strong> 
        </button>
        <ul class="dropdown" aria-labelledby="btn_session">
          <li><a href="compras.php">Mis compras</a></li>
          <li><a href="config/logout.php">Cerrar sesión</a></li>
        </ul>
        </li>
      </ul>

      <?php } else { ?>
      <button class="btn-ingresar">
      <a href="iniciarsesion.php"><i class="fas fa-user"></i><strong> Ingresar</strong></a>
      </button>
    <?php } ?>

    <div class='search-box-container'>
      <button class='submit' onclick="cambiarAncho()">
        <i class='fa fa-search'></i>
      </button>
      <input class='search-box' id="searchInput">
    </div>
  </div>

  <div class="circle-container">
    <a href="Carrito.php" class="shopping">
      <i class='fas fa-shopping-cart'>
        <span id="num_cart" style="<?php echo (isset($num_cart) && $num_cart != 0) ? '' : 'display: none;'; ?>" data-count="<?php echo $num_cart; ?>">
          <?php echo $num_cart; ?>
        </span>
      </i>
    </a>
  </div>
</nav>

<div id="menu"></div>

<div class="container-mobile">
  <div class="mobile-menu">
    <img src="icon\icons8-menú.svg" class="menu-mobile">
    <div class="circle-container">
      <button class="shopping">
        <i class='fas fa-shopping-cart'></i>
      </button>
    </div>
  </div>
</div>

<div class="mobile-menu-categories inactive">
  <img src="icon\arrow-right-1-svgrepo-com (1).svg" class="arrow-before">
  <ul>
    <li>
      <a href="index.php">Inicio</a>
    </li>
    <li>
      <a href="ServicioAlCliente.php">Servicio al cliente</a>
    </li>
    <li>
      <a href="sobrenosotros.php">Sobre nosotros</a>
    </li>
    <div class="linea"></div>
    <li>
      <a href="Busqueda.php?id_cat=<?php echo $row['id_cat'] = 'Ropa'; ?>&token=<?php echo hash_hmac('sha1', $row['id_cat'], KEY_TOKEN2); ?>">Ropa</a>
    </li>
    <li>
      <a href="Busqueda.php?id_cat=<?php echo $row['id_cat'] = 'Accesorios'; ?>&token=<?php echo hash_hmac('sha1', $row['id_cat'], KEY_TOKEN2); ?>">Accesorios</a>
    </li>
    <li>
      <a href="Busqueda.php?id_cat=<?php echo $row['id_cat'] = 'Artesanias'; ?>&token=<?php echo hash_hmac('sha1', $row['id_cat'], KEY_TOKEN2); ?>">Artesanias</a>
    </li>
    <li>
      <a href="Busqueda.php?id_cat=<?php echo $row['id_cat'] = 'Hogar'; ?>&token=<?php echo hash_hmac('sha1', $row['id_cat'], KEY_TOKEN2); ?>">>Hogar</a>
    </li>
    <li>
      <a href="Busqueda.php?id_cat=<?php echo $row['id_cat'] = 'Libros'; ?>&token=<?php echo hash_hmac('sha1', $row['id_cat'], KEY_TOKEN2); ?>">Libros</a>
    </li>
  </ul>
</div>

<div class="categoria">
  <button class="ropa">
    <a href="Busqueda.php?id_cat=<?php echo $row['id_cat'] = 'Ropa'; ?>&token=<?php echo hash_hmac('sha1', $row['id_cat'], KEY_TOKEN2); ?>">
    <strong>Ropa</strong>
    </a>
  </button>
  <button class="accesorios">
    <a href="Busqueda.php?id_cat=<?php echo $row['id_cat'] = 'Accesorios'; ?>&token=<?php echo hash_hmac('sha1', $row['id_cat'], KEY_TOKEN2); ?>">
    <strong>Accesorios</strong>
    </a>
  </button>
  <button class="artesanias">
    <a href="Busqueda.php?id_cat=<?php echo $row['id_cat'] = 'Artesanias'; ?>&token=<?php echo hash_hmac('sha1', $row['id_cat'], KEY_TOKEN2); ?>">
    <strong>Artesanias</strong>
    </a>
  </button>
  <button class="hogar">
    <a href="Busqueda.php?id_cat=<?php echo $row['id_cat'] = 'Hogar'; ?>&token=<?php echo hash_hmac('sha1', $row['id_cat'], KEY_TOKEN2); ?>">
    <strong>Hogar</strong>
    </a>
  </button>
  <button class="libros">
    <a href="Busqueda.php?id_cat=<?php echo $row['id_cat'] = 'Libros'; ?>&token=<?php echo hash_hmac('sha1', $row['id_cat'], KEY_TOKEN2); ?>">
    <strong>Libros</strong>
    </a>
  </button>
</div>

<img class="evento" src="recursos\5594188.jpg" alt="Promociones">