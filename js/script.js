document.addEventListener('DOMContentLoaded', function () {
    const menuMobile = document.querySelector('.mobile-menu-categories');
    const menuIcon = document.querySelector('.menu-mobile');
    const closeMenu = document.querySelector('.arrow-before');

    menuIcon.addEventListener('click', toggleMobileMenu);
    closeMenu.addEventListener('click', addMobileMenu);

    function toggleMobileMenu() {
        menuMobile.classList.toggle('inactive');
    }

    function addMobileMenu() {
        menuMobile.classList.add('inactive');
    }
});

let isExpanded = false;

function cambiarAncho() {
    var searchBox = document.getElementById('searchInput');
    var searchContainer = document.querySelector('.search-box-container');

    if (!isExpanded) {
        searchContainer.classList.add('expanded');
        isExpanded = true;
    } else {
        if (searchBox && searchBox.value.trim() === '') {
            searchContainer.classList.remove('expanded');
            isExpanded = false;
        }
    }
}

let lastScrollTop = 0;

window.onscroll = function() {
    let nav = document.querySelector('nav');
    let st = window.pageYOffset || document.documentElement.scrollTop;

    if (st > lastScrollTop) {
      // Hacia abajo, ocultar el menú
        nav.style.top = '-100px';
    } else {
      // Hacia arriba, mostrar el menú
        nav.style.top = '0';
    }

    lastScrollTop = st <= 0 ? 0 : st;
};


document.addEventListener("DOMContentLoaded", function () {
  const slider = document.querySelector(".slider");
  const slides = document.querySelector(".slides");
  const dotsContainer = document.querySelector(".dots");
  const prev = document.querySelector(".prev");
  const next = document.querySelector(".next");
  const totalSlides = document.querySelectorAll(".slide").length;

  // Agrega puntos indicadores
  for (let i = 0; i < totalSlides; i++) {
    const dot = document.createElement("div");
    dot.classList.add("dot");
    dot.setAttribute("data-index", i);
    dotsContainer.appendChild(dot);
  }

  const dots = document.querySelectorAll(".dot");

  let currentIndex = 0;

  function updateSlider() {
    slides.style.transform = `translateX(${-currentIndex * 100}%)`;

    // Actualiza el estado de los puntos
    dots.forEach((dot, index) => {
      dot.classList.toggle("active", index === currentIndex);
    });
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % totalSlides;
    updateSlider();
  }

  function prevSlide() {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
    updateSlider();
  }

  function jumpToSlide(index) {
    currentIndex = index;
    updateSlider();
  }

  // Establece la clase "active" en el primer punto y muestra la primera imagen
  dots[0].classList.add("active");
  updateSlider();

  next.addEventListener("click", nextSlide);
  prev.addEventListener("click", prevSlide);

  dots.forEach((dot, index) => {
    dot.addEventListener("click", () => jumpToSlide(index));
  });
});


function togglePassword(passwordId) {
  const passwordInput = document.getElementById(passwordId);
  const passwordIcon = passwordInput.nextElementSibling;

  if (passwordInput.type === "password") {
      passwordInput.type = "text";
      passwordIcon.classList.remove("fa-eye");
      passwordIcon.classList.add("fa-eye-slash");
  } else {
      passwordInput.type = "password";
      passwordIcon.classList.remove("fa-eye-slash");
      passwordIcon.classList.add("fa-eye");
  }
}


// /SCRIPT DE LA PAGINA Producto.html, FLECHAS DEL CONTENEDOR DE IMAGENES PARTE INFERIOR/ 

document.addEventListener("DOMContentLoaded", function () {
    const tarjetasContainer = document.querySelector(".contenedor-tarjetas");

    document.querySelector(".flecha-izquierda").addEventListener("click", function () {
        const currentPosition = tarjetasContainer.scrollLeft;
        tarjetasContainer.scrollTo({
            left: currentPosition - 300, // Ajusta el valor según tus necesidades
            behavior: "smooth" // Agrega la animación de desplazamiento suave
        });
    });

    document.querySelector(".flecha-derecha").addEventListener("click", function () {
        const currentPosition = tarjetasContainer.scrollLeft;
        tarjetasContainer.scrollTo({
            left: currentPosition + 310,
            behavior: "smooth"
        });
    });
});


//Busqueda

$(document).ready(function() {
  function buscarProductos() {
    var query = $('#searchInput').val();
    $.ajax({
      url: 'search.php',
      type: 'GET',
      data: { q: query },
      success: function(data) {
        $('#datafetch').html(data);
      },
      error: function() {
        alert('Hubo un error al realizar la búsqueda.');
      }
    });
  }


  $('#searchInput').keyup(function() {
    buscarProductos();
  });
});





