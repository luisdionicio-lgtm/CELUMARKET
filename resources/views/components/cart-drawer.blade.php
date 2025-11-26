@php
    $cartCount = $cartCount ?? 0;
    $cartSummaryText = $cartSummaryText ?? 'Tu carrito está vacío';
@endphp

<!-- Backdrop del carrito -->
<div
    id="cart-backdrop"
    class="fixed inset-0 z-40 hidden bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300"
></div>

<!-- Drawer del carrito -->
<aside
    id="cart-drawer"
    class="fixed right-0 top-0 z-50 flex h-full w-full max-w-[450px] translate-x-full flex-col overflow-hidden border-l border-gray-200 bg-white p-6 shadow-2xl transition-transform duration-300 ease-out"
    aria-hidden="true"
>
    <button
        type="button"
        data-close-cart
        class="absolute right-4 top-4 text-gray-400 transition hover:text-gray-600"
        aria-label="Cerrar carrito"
    >
        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 6 6 18M6 6l12 12" />
        </svg>
    </button>

    <div class="flex items-center gap-3">
        <div class="rounded-full bg-gray-100 p-3 text-gray-700">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h15l-1.5 9h-12z" />
                <circle cx="9" cy="19" r="1.5" />
                <circle cx="17" cy="19" r="1.5" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Carrito de Compras</h2>
            <p class="text-sm text-gray-500" data-cart-summary>{{ $cartSummaryText }}</p>
        </div>
    </div>

    <div class="mt-6 flex rounded-xl bg-gray-100 p-1 text-sm font-semibold text-gray-600">
        <button
            type="button"
            class="flex-1 rounded-lg bg-white py-2 text-center text-gray-900 shadow-sm transition"
            data-cart-tab="cart"
        >
            Carrito (<span data-cart-count>{{ $cartCount }}</span>)
        </button>
        <button
            type="button"
            class="flex-1 rounded-lg py-2 text-center transition hover:text-gray-900"
            data-cart-tab="compare"
        >
            Comparar
        </button>
    </div>

    <div class="mt-6 flex-1 min-h-0 overflow-y-auto">
        <div data-cart-panel="cart">
        <div class="mt-6 hidden space-y-4" id="cart-item-list"></div>

        <div
            class="mt-6 flex h-full flex-col items-center justify-center text-center text-gray-500"
            id="cart-empty-state"
        >
            <div class="rounded-full bg-gray-100 p-6 text-4xl text-gray-300">
                <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h15l-1.5 9h-12z" />
                    <circle cx="9" cy="19" r="1.5" />
                    <circle cx="17" cy="19" r="1.5" />
                </svg>
            </div>
            <p class="mt-3 text-lg font-semibold text-gray-900">Tu carrito está vacío</p>
            <p class="text-sm text-gray-500">Agrega productos para comenzar.</p>
        </div>
    </div>

    <div
        data-cart-panel="compare"
        class="mt-6 hidden"
        id="cart-compare-panel"
    >
        <div
            id="cart-compare-table"
            class="h-full w-full overflow-x-auto rounded-2xl border border-gray-200 bg-gray-50 p-4"
        >
            <p class="text-sm text-gray-500">Agrega productos para comparar sus características.</p>
        </div>
    </div>

    </div>

    <div class="border-t border-gray-200 pt-4">
        <div class="flex items-center justify-between text-gray-900">
            <span class="text-sm font-semibold">Subtotal</span>
            <span class="text-2xl font-bold" data-cart-subtotal>S/ 0.00</span>
        </div>

        <!-- ✔ Este SI lleva al checkout -->
        <a
            href="{{ route('checkout.show') }}"
            class="mt-4 block w-full rounded-xl bg-gray-900 py-3 text-center font-semibold text-white transition hover:bg-black"
        >
            Continuar con la compra
        </a>
    </div>
</aside>
