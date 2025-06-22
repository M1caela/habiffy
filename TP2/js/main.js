// Llenar los números del primer select (0 a 60)

let selectNumero = document.getElementById("num-frec");
for (let i = 0; i <= 60; i++) {
    let opcion = document.createElement("option");
    opcion.value = i;
    opcion.text = i;
    selectNumero.appendChild(opcion);
}

// Escuchar el cambio en el número seleccionado
selectNumero.addEventListener("change", function() {
    let spanTexto = document.getElementById("vez");
    if (this.value == "1") {
        spanTexto.innerText = "vez por";
    } else {
        spanTexto.innerText = "veces por";
    }
});
