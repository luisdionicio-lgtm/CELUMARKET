// Importa la configuración inicial de Laravel (incluye Axios, etc.)
import './bootstrap';

// Importa Alpine.js para manejar interactividad en el frontend
import Alpine from 'alpinejs';

// Asigna Alpine al objeto global window
window.Alpine = Alpine;

// Inicia Alpine.js
Alpine.start();

// --- INICIO SCRIPT DEL MODAL DE LOGIN ---

// Espera a que el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", function() {

    // Obtiene elementos del DOM relacionados con el modal
    const modalOverlay = document.getElementById('auth-modal-overlay');
    const closeModalBtn = document.getElementById('auth-modal-close-btn');
    const openModalBtns = document.querySelectorAll('.btn-open-auth-modal');

    // Función para ABRIR el modal
    function openModal() {
        if (modalOverlay) modalOverlay.style.display = 'flex';
    }

    // Función para CERRAR el modal
    function closeModal() {
        if (modalOverlay) modalOverlay.style.display = 'none';
    }

    // Asocia el evento de clic a cada botón que abre el modal
    openModalBtns.forEach(btn => {
        btn.addEventListener('click', openModal);
    });

    // Asocia el evento de clic al botón que cierra el modal
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    // Cierra el modal si se hace clic fuera del contenido (en el overlay)
    if (modalOverlay) {
        modalOverlay.addEventListener('click', function(event) {
            if (event.target === modalOverlay) {
                closeModal();
            }
        });
    }

    // Manejo de pestañas dentro del modal (login / registro)
    const tabLinks = document.querySelectorAll('.auth-tab-link');
    const tabContents = document.querySelectorAll('.auth-tab-content');

    // Asocia el evento de clic a cada pestaña
    tabLinks.forEach(link => {
        link.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');

            // Quita la clase 'active' de todas las pestañas y contenidos
            tabLinks.forEach(l => l.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));

            // Activa la pestaña y contenido correspondiente
            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });

});