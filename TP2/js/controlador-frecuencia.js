 var selectNumero = document.querySelector(".num-frec");
        for (var i = 0; i <= 60; i++) {
            var opcion = document.createElement("option");
            opcion.value = i;
            opcion.text = i;
            selectNumero.appendChild(opcion);
        }
        
        // cambiar vez/veces según cantidad
        selectNumero.addEventListener("change", function() {
            var spanTexto = document.getElementById("vez");
            if (this.value == "1") {
                spanTexto.innerText = "vez por";
            } else {
                spanTexto.innerText = "veces por";
            }
        });