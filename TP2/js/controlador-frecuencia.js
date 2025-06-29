//  controlador de los select de 'frecuencia' al agregar/editar hábito
 
 var selectNumero = document.querySelector(".num-frec");
        //  completa los números del select
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