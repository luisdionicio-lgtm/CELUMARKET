/**
 * Drawer del Carrito — CELU MARKET
 * Comparación y carrito en el panel lateral.
 */

(function () {
    const drawer = document.getElementById('cart-drawer');
    const backdrop = document.getElementById('cart-backdrop');
    const closeBtn = drawer?.querySelector('[data-close-cart]');
    const openBtns = document.querySelectorAll('[data-open-cart]');
    const list = document.getElementById('cart-item-list');
    const emptyState = document.getElementById('cart-empty-state');
    const subtotalEl = document.querySelector('[data-cart-subtotal]');
    const summaryEl = document.querySelector('[data-cart-summary]');
    const countEls = document.querySelectorAll('[data-cart-count]');
    const compareTable = document.getElementById('cart-compare-table');
    const tabButtons = document.querySelectorAll('[data-cart-tab]');
    const tabPanels = document.querySelectorAll('[data-cart-panel]');

    let hideBackdropTimeout;

    const state = {
        items: Array.isArray(window.__cartItems) ? window.__cartItems : [],
    };
    window.__cartItems = state.items;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    const buildHeaders = (extra = {}) => ({
        'X-Requested-With': 'XMLHttpRequest',
        ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
        ...extra,
    });

    const cartUrl = (productId) => `/cart/${productId}`;

    const persistQuantity = async (productId, quantity) => {
        const response = await fetch(cartUrl(productId), {
            method: 'PATCH',
            credentials: 'same-origin',
            headers: buildHeaders({ 'Content-Type': 'application/json' }),
            body: JSON.stringify({ quantity }),
        });

        if (response.status >= 400) {
            throw new Error('No se pudo actualizar el carrito');
        }
    };

    const persistRemoval = async (productId) => {
        const response = await fetch(cartUrl(productId), {
            method: 'DELETE',
            credentials: 'same-origin',
            headers: buildHeaders(),
        });

        if (response.status >= 400) {
            throw new Error('No se pudo eliminar el producto');
        }
    };

    const handleError = (message) => {
        console.error(message);
        alert(message);
    };

    const formatCurrency = (value) =>
        new Intl.NumberFormat('es-PE', {
            style: 'currency',
            currency: 'PEN',
            minimumFractionDigits: 2,
        }).format(value || 0);

    const setActiveTab = (tabName) => {
        tabButtons.forEach((button) => {
            const active = button.dataset.cartTab === tabName;
            button.classList.toggle('bg-white', active);
            button.classList.toggle('text-gray-900', active);
            button.classList.toggle('shadow-sm', active);
        });

        tabPanels.forEach((panel) => {
            panel.classList.toggle('hidden', panel.dataset.cartPanel !== tabName);
        });
    };

    const renderCompareTable = () => {
        if (!compareTable) return;

        if (state.items.length < 2) {
            compareTable.innerHTML = `
                <p class="text-sm text-gray-500">
                    ${state.items.length === 0 ? 'No hay productos para comparar.' : 'Agrega un producto mas para comparar.'}
                </p>`;
            return;
        }

        const featureMap = [
            { key: 'ram', label: 'RAM' },
            { key: 'storage', label: 'Almacenamiento' },
            { key: 'processor', label: 'Procesador' },
            { key: 'camera', label: 'Camara' },
            { key: 'screen', label: 'Pantalla' },
            { key: 'battery', label: 'Bateria' },
            { key: 'price', label: 'Precio', formatter: formatCurrency },
        ];

        const headers = state.items
            .map(
                (item) => `
                <th class="w-[180px] px-4 py-3 text-center align-top">
                    <div class="flex flex-col items-center gap-2">
                        <div class="flex h-16 w-16 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-white">
                            <img src="${item.image ?? 'https://via.placeholder.com/80'}"
                                 class="h-16 w-auto object-contain">
                        </div>
                        <div class="space-y-0.5">
                            <p class="text-sm font-semibold text-gray-900 leading-tight text-center">${item.name}</p>
                            <p class="text-xs text-gray-500 text-center">${item.brand ?? ''}</p>
                        </div>
                    </div>
                </th>
            `
            )
            .join('');

        const rows = featureMap
            .map((feature) => {
                const cells = state.items
                    .map((item) => {
                        let val = item[feature.key] ?? 'N/D';
                        if (feature.formatter) val = feature.formatter(item[feature.key]);
                        const isPrice = feature.key === 'price';
                        const classes = isPrice
                            ? 'px-4 py-3 text-sm font-semibold text-blue-600 text-center'
                            : 'px-4 py-3 text-sm text-gray-700 text-center';
                        return `<td class="${classes}">${val}</td>`;
                    })
                    .join('');

                return `
            <tr class="border-b border-gray-100 bg-white">
                <th class="w-[160px] bg-gray-50 px-4 py-3 text-sm font-semibold text-gray-900 text-left">${feature.label}</th>
                ${cells}
            </tr>`;
            })
            .join('');

        compareTable.innerHTML = `
            <div class="min-w-[720px] overflow-x-auto">
                <table class="w-full table-fixed border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-white">
                            <th class="w-[160px] px-4 py-3 text-xs font-semibold text-gray-500 uppercase text-left">Caracteristica</th>
                            ${headers}
                        </tr>
                    </thead>
                    <tbody>${rows}</tbody>
                </table>
            </div>`;
    };

    const renderItems = () => {
        if (!list || !emptyState) return;

        list.innerHTML = '';

        if (!state.items.length) {
            list.classList.add('hidden');
            emptyState.classList.remove('hidden');
        } else {
            list.classList.remove('hidden');
            emptyState.classList.add('hidden');

            state.items.forEach((item) => {
                const article = document.createElement('article');
                article.className = 'flex gap-4 rounded-2xl border border-gray-100 p-4';

                article.innerHTML = `
                    <img src="${item.image ?? 'https://via.placeholder.com/80'}"
                         class="h-20 w-20 rounded-xl object-cover">

                    <div class="flex flex-1 flex-col gap-2">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">${item.name}</h3>
                            <p class="text-xs text-gray-500">${item.brand ?? ''}</p>
                        </div>

                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <button class="px-2 border rounded-full" data-dec="${item.id}">-</button>
                            <span>${item.quantity}</span>
                            <button class="px-2 border rounded-full" data-inc="${item.id}">+</button>
                        </div>

                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <span>${formatCurrency(item.price * item.quantity)}</span>
                            <button class="text-rose-500" data-remove="${item.id}">
                                <i class="fa-solid fa-trash pointer-events-none"></i>
                            </button>
                        </div>
                    </div>
                `;

                list.appendChild(article);
            });
        }

        subtotalEl.textContent = formatCurrency(
            state.items.reduce((t, i) => t + i.price * i.quantity, 0)
        );

        summaryEl.textContent =
            state.items.length > 0
                ? `Tienes ${state.items.length} productos en tu carrito`
                : 'Tu carrito esta vacio';

        countEls.forEach((el) => (el.textContent = state.items.length));

        renderCompareTable();
    };

    const adjustQuantity = async (id, delta) => {
        const item = state.items.find((i) => i.id === id);
        if (!item) return;

        const nextQuantity = Math.max(0, item.quantity + delta);

        if (nextQuantity < 1) {
            await removeItem(id);
            return;
        }

        try {
            await persistQuantity(id, nextQuantity);
            item.quantity = nextQuantity;
            renderItems();
        } catch (error) {
            handleError('No se pudo actualizar la cantidad. Intenta nuevamente.');
        }
    };

    const removeItem = async (id) => {
        const previous = [...state.items];

        try {
            await persistRemoval(id);
            state.items = state.items.filter((i) => i.id !== id);
            window.__cartItems = state.items;
            renderItems();
        } catch (error) {
            state.items = previous;
            window.__cartItems = state.items;
            handleError('No se pudo eliminar el producto del carrito.');
        }
    };

    const openDrawer = () => {
        drawer.classList.remove('translate-x-full');
        drawer.classList.add('translate-x-0');
        showBackdrop();
    };

    const closeDrawer = () => {
        drawer.classList.add('translate-x-full');
        drawer.classList.remove('translate-x-0');
        hideBackdrop();
    };

    const showBackdrop = () => {
        backdrop.classList.remove('hidden');
        requestAnimationFrame(() => backdrop.classList.remove('opacity-0'));
    };

    const hideBackdrop = () => {
        backdrop.classList.add('opacity-0');
        hideBackdropTimeout = setTimeout(() => backdrop.classList.add('hidden'), 300);
    };

    openBtns.forEach((btn) =>
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            openDrawer();
        })
    );

    closeBtn?.addEventListener('click', closeDrawer);
    backdrop?.addEventListener('click', closeDrawer);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeDrawer();
    });

    list.addEventListener('click', (e) => {
        const incBtn = e.target.closest('[data-inc]');
        if (incBtn) {
            adjustQuantity(Number(incBtn.dataset.inc), 1);
            return;
        }

        const decBtn = e.target.closest('[data-dec]');
        if (decBtn) {
            adjustQuantity(Number(decBtn.dataset.dec), -1);
            return;
        }

        const removeBtn = e.target.closest('[data-remove]');
        if (removeBtn) {
            removeItem(Number(removeBtn.dataset.remove));
        }
    });

    tabButtons.forEach((tab) =>
        tab.addEventListener('click', () => setActiveTab(tab.dataset.cartTab))
    );

    setActiveTab('cart');
    renderItems();
})();
