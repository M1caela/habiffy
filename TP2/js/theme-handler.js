// Guardar el tema (dark/light) seleccionado en localStorage

document.addEventListener('DOMContentLoaded', function () {
     // Restaurar el tema desde localStorage al cargar la página
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        document.documentElement.setAttribute('data-theme', savedTheme);
        const themeButtons = document.querySelectorAll('.theme-controller');
        themeButtons.forEach((button) => {
            if (button.value === savedTheme) {
                button.checked = true;
            }
        });
    }

      // Escuchar cambios en los botones de selección de tema
    const themeButtons = document.querySelectorAll('.theme-controller');
    themeButtons.forEach((button) => {
        button.addEventListener('change', function () {
            const selectedTheme = this.value;
            document.documentElement.setAttribute('data-theme', selectedTheme);
            localStorage.setItem('theme', selectedTheme);  // Guardar el tema en localStorage
        });
    });
});