// /SCRIPT DE LA PAGINA Producto.html, Botones aumentar y descrementar cantidad productos/ 

const cantidad = document.getElementById("cantidad");
function stepper(btn){
    let id = btn.getAttribute("id");
    let min = Number(cantidad.getAttribute("min"));
    let max = Number(cantidad.getAttribute("max"));
    let step = Number(cantidad.getAttribute("step"));
    let val = Number(cantidad.getAttribute("value"));
    let calcStep = (id == "increment") ? (step*1) : (step * -1);
    let newValue = val + calcStep;

    if(newValue >= min && newValue <= max){
        cantidad.setAttribute("value", newValue.toString());
    }
}

function swapImages(clickedElement) {
    var izquierdaContainer = document.getElementById("izquierda");
    var medioContainer = document.getElementById("medio");

    if (clickedElement.parentNode === izquierdaContainer) {
        medioContainer.innerHTML = clickedElement.innerHTML;
    } else if (clickedElement.parentNode === medioContainer) {
        izquierdaContainer.innerHTML = clickedElement.innerHTML;
    }
}

