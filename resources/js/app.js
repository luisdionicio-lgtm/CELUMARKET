// Importa la configuración inicial de Laravel (Axios, CSRF, etc.)
import './bootstrap';

// Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// --- IMPORTA el drawer del carrito (fuera del DOMContentLoaded) ---
import './cart-drawer';

// --- SCRIPT GLOBAL PARA EL MODAL Y SEARCH ---
document.addEventListener('DOMContentLoaded', function () {
    // ----------------------------
    // MODAL DE AUTENTICACIÓN
    // ----------------------------
    const modalOverlay = document.getElementById('auth-modal-overlay');
    const closeModalBtn = document.getElementById('auth-modal-close-btn');
    const openModalBtns = document.querySelectorAll('.btn-open-auth-modal');

    const openModal = () => modalOverlay && (modalOverlay.style.display = 'flex');
    const closeModal = () => modalOverlay && (modalOverlay.style.display = 'none');

    openModalBtns.forEach(btn => btn.addEventListener('click', openModal));
    closeModalBtn?.addEventListener('click', closeModal);
    modalOverlay?.addEventListener('click', (event) => {
        if (event.target === modalOverlay) closeModal();
    });

    // Tabs dentro del modal
    const tabLinks = document.querySelectorAll('.auth-tab-link');
    const tabContents = document.querySelectorAll('.auth-tab-content');

    tabLinks.forEach(link => {
        link.addEventListener('click', function () {
            const tabId = this.dataset.tab;
            tabLinks.forEach(l => l.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            document.getElementById(tabId)?.classList.add('active');
        });
    });

    // ----------------------------
    // BUSCADOR EN TIEMPO REAL
    // ----------------------------
    const searchInput = document.getElementById('searchInput');
    const productList = document.getElementById('productList');

    if (searchInput && productList) {
        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase();
            productList.querySelectorAll('.producto').forEach(producto => {
                const nombre = producto.querySelector('.nombre')?.textContent.toLowerCase() || '';
                producto.style.display = nombre.includes(query) ? 'block' : 'none';
            });
        });
    }
});
