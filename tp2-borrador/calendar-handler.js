// esto seria para que los habitos completos se guarden en calendar y l hacer clic en un dia, se abra un modal flotante informativo
// no estaria funcionando

document.addEventListener('DOMContentLoaded', function () {
    const calendar = document.querySelector('#calendar');

    // Escuchar clics en los días del calendario
    calendar.addEventListener('click', function (event) {
        const target = event.target;

        // Verificar si se hizo clic en un día del calendario
        if (target.tagName === 'BUTTON' || target.closest('button')) {
            const dayButton = target.tagName === 'BUTTON' ? target : target.closest('button');
            const selectedDate = dayButton.getAttribute('data-date'); // Suponiendo que DaisyUI asigna data-date a los días

            if (selectedDate) {
                // Llamar a la función para cargar los hábitos completados
                cargarHabitosDelDia(selectedDate);
            }
        }
    });

    // Función para cargar los hábitos completados en el modal
    function cargarHabitosDelDia(fecha) {
        // Realizar una solicitud al servidor para obtener los hábitos del día
        fetch(`obtener_habitos.php?fecha=${fecha}`)
            .then((response) => response.json())
            .then((data) => {
                // Actualizar el contenido del modal con los hábitos
                const modalTitulo = document.querySelector('#modal-titulo');
                const modalContenido = document.querySelector('#modal-contenido');

                modalTitulo.textContent = `Hábitos completados el ${fecha}`;
                modalContenido.innerHTML = data.length
                    ? `<ul>${data.map((habito) => `<li>${habito}</li>`).join('')}</ul>`
                    : 'No hay hábitos completados para este día.';

                // Abrir el modal
                document.querySelector('#modal-dia').checked = true;
            })
            .catch((error) => {
                console.error('Error al cargar los hábitos:', error);
            });
    }
});