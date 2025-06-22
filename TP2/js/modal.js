function mostrarConfirmacion({ titulo, mensaje, onConfirm }) {
    const modal = document.getElementById("modalConfirm");
    const tituloElem = document.getElementById("modal-titulo");
    const mensajeElem = document.getElementById("modal-mensaje");
    const btnConfirmar = document.getElementById("btn-confirmar");

    if (tituloElem) tituloElem.innerText = titulo;
    if (mensajeElem) mensajeElem.innerText = mensaje;

    if (btnConfirmar) {
        // Limpio event listeners anteriores
        const nuevoBoton = btnConfirmar.cloneNode(true);
        btnConfirmar.parentNode.replaceChild(nuevoBoton, btnConfirmar);

        nuevoBoton.addEventListener("click", function () {
            if (typeof onConfirm === "function") {
                onConfirm();
            }
        });
    }

    document.getElementById("modal-alerta").checked = true;
}

  