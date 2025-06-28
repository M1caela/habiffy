    // controlador de checkbox para 'completar' habito 
    
    function marcarCompletado(checkbox) {
        const id = checkbox.getAttribute('data-id');
        const estado = checkbox.checked ? 1 : 0;

        fetch('marcar_completado.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&completado=${estado}`
        }).then(() => {
            location.reload(); 
        });
    }
 