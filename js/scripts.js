function stepper(btn){
    let targetId = btn.getAttribute("data-target-id");
    let cantidad = document.getElementById(targetId);

    if (!cantidad) {
        console.error('El elemento con ID "' + targetId + '" no se encontró');
        return;
    }

    let min = Number(cantidad.getAttribute("min"));
    let max = Number(cantidad.getAttribute("max"));
    let step = Number(cantidad.getAttribute("step"));
    let val = Number(cantidad.getAttribute("value"));
    let calcStep = (btn.id === "increment") ? step : -step;
    let newValue = val + calcStep;

    if(newValue >= min && newValue <= max){
        cantidad.setAttribute("value", newValue.toString());

        // Llama a actualizaCantidad después de actualizar el valor del input
        actualizaCantidad(newValue, targetId.split('_')[1]);
    }
}
