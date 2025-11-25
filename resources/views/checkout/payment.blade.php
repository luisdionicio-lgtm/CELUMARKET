@extends('layouts.app')

@section('title', 'Metodo de pago')

@section('content')
@php
    $selectedMethod = old('metodo', $payment['metodo'] ?? 'card');
@endphp
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-10">
    <div class="mx-auto max-w-6xl space-y-8 px-4">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Checkout</p>
                <h1 class="mt-1 text-3xl font-bold text-slate-900">Metodo de pago</h1>
                <p class="text-sm text-slate-600">Elige como quieres completar tu compra.</p>
            </div>
            <div class="flex items-center gap-4 text-sm text-slate-500">
                <div class="flex items-center gap-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 font-semibold text-emerald-700">1</span>
                    <span class="font-semibold text-emerald-700">Envio</span>
                </div>
                <div class="h-px w-10 bg-slate-300"></div>
                <div class="flex items-center gap-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 font-semibold text-white">2</span>
                    <span class="font-semibold text-slate-800">Pago</span>
                </div>
                <div class="h-px w-10 bg-slate-300"></div>
                <div class="flex items-center gap-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 font-semibold text-slate-500">3</span>
                    <span class="font-semibold text-slate-500">Confirmacion</span>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                @if (session('status'))
                    <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('checkout.payment.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="space-y-4">
                        <p class="text-sm font-semibold text-slate-800">Metodo de pago</p>

                        <div class="grid gap-4 md:grid-cols-2" id="payment-methods">
                            {{-- TARJETA --}}
                            <div
                                data-method-card="card"
                                class="rounded-2xl border {{ $selectedMethod === 'card' ? 'border-indigo-500 shadow-lg shadow-indigo-100 bg-indigo-50/60' : 'border-slate-200' }} bg-white p-5 transition duration-200 hover:-translate-y-1 hover:shadow-md"
                            >
                                <div class="flex items-start gap-3">
                                    <input
                                        id="metodo_card"
                                        type="radio"
                                        name="metodo"
                                        value="card"
                                        class="mt-1 h-5 w-5 text-indigo-600 focus:ring-indigo-500"
                                        {{ $selectedMethod === 'card' ? 'checked' : '' }}
                                    >
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <label for="metodo_card" class="text-base font-semibold text-slate-900">Tarjeta</label>
                                                <p class="text-sm text-slate-500">Visa, Mastercard y mas (simulado)</p>
                                            </div>
                                            <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">Seguro</span>
                                        </div>

                                        <div data-method-panel="card" class="mt-4 space-y-3 {{ $selectedMethod === 'card' ? '' : 'hidden' }}">
                                            <div class="grid gap-3 md:grid-cols-2">
                                                <div class="space-y-1">
                                                    <label class="text-sm font-semibold text-slate-700" for="card_number">Numero de tarjeta</label>
                                                    <input
                                                        type="text"
                                                        name="card_number"
                                                        id="card_number"
                                                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:ring-indigo-500"
                                                        placeholder="0000 0000 0000 0000"
                                                    >
                                                </div>
                                                <div class="space-y-1">
                                                    <label class="text-sm font-semibold text-slate-700" for="card_holder">Nombre del titular</label>
                                                    <input
                                                        type="text"
                                                        name="card_holder"
                                                        id="card_holder"
                                                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:ring-indigo-500"
                                                        placeholder="Como aparece en la tarjeta"
                                                    >
                                                </div>
                                                <div class="space-y-1">
                                                    <label class="text-sm font-semibold text-slate-700" for="card_expiry">Fecha de vencimiento (MM/YY)</label>
                                                    <input
                                                        type="text"
                                                        name="card_expiry"
                                                        id="card_expiry"
                                                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:ring-indigo-500"
                                                        placeholder="MM/YY"
                                                    >
                                                </div>
                                                <div class="space-y-1">
                                                    <label class="text-sm font-semibold text-slate-700" for="card_cvv">CVV</label>
                                                    <input
                                                        type="text"
                                                        name="card_cvv"
                                                        id="card_cvv"
                                                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:ring-indigo-500"
                                                        placeholder="123"
                                                    >
                                                </div>
                                            </div>
                                            <div class="rounded-lg border border-indigo-100 bg-indigo-50 px-4 py-3 text-xs text-indigo-700">
                                                Este flujo es de prueba y no procesa cargos reales.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- PAGOEFECTIVO / YAPE / PLIN --}}
                            <div
                                data-method-card="cash"
                                class="rounded-2xl border {{ $selectedMethod === 'cash' ? 'border-indigo-500 shadow-lg shadow-indigo-100 bg-indigo-50/60' : 'border-slate-200' }} bg-white p-5 transition duration-200 hover:-translate-y-1 hover:shadow-md"
                            >
                                <div class="flex items-start gap-3">
                                    <input
                                        id="metodo_cash"
                                        type="radio"
                                        name="metodo"
                                        value="cash"
                                        class="mt-1 h-5 w-5 text-indigo-600 focus:ring-indigo-500"
                                        {{ $selectedMethod === 'cash' ? 'checked' : '' }}
                                    >
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <label for="metodo_cash" class="text-base font-semibold text-slate-900">PagoEfectivo / Yape / Plin</label>
                                                <p class="text-sm text-slate-500">Genera un codigo y confirma manualmente.</p>
                                            </div>
                                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">QR</span>
                                        </div>

                                        <div data-method-panel="cash" class="mt-4 space-y-3 {{ $selectedMethod === 'cash' ? '' : 'hidden' }}">
                                            <div class="space-y-3 rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-5">
                                                <div id="qr-box" class="flex flex-col items-center gap-3">
                                                    <div class="flex h-28 w-28 items-center justify-center rounded-lg bg-white text-sm font-semibold text-slate-500" id="qr-placeholder">
                                                        QR simulado
                                                    </div>
                                                    <img id="qr-image" src="" alt="QR" class="hidden h-40 w-40 rounded-lg border border-slate-200 bg-white object-contain">

                                                    <button type="button" id="btn-generate-qr" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                        Generar codigo
                                                    </button>
                                                    <p class="text-xs text-slate-500">Usalo en tu app para validar el pago.</p>
                                                </div>

                                                <div id="qr-meta" class="hidden space-y-2 rounded-lg border border-slate-200 bg-white px-4 py-3">
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500">Codigo de pago</span>
                                                        <button type="button" id="btn-copy-code" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">Copiar</button>
                                                    </div>
                                                    <div class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 text-sm font-mono font-semibold text-slate-900">
                                                        <span id="qr-code-text">--</span>
                                                        <span id="qr-timer" class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">15:00</span>
                                                    </div>
                                                    <div id="qr-status" class="text-xs text-slate-500">Esperando confirmacion...</div>
                                                </div>
                                            </div>

                                            <div class="space-y-2">
                                                <label class="text-sm font-semibold text-slate-700" for="input-code">Codigo de operacion</label>
                                                <input
                                                    type="text"
                                                    id="input-code"
                                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:ring-indigo-500"
                                                    placeholder="Ingresa el codigo generado"
                                                >
                                                <button type="button" id="btn-confirm-code" class="w-full rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                                    Confirmar pago
                                                </button>
                                                <div id="qr-alert" class="hidden rounded-lg px-3 py-2 text-xs"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @error('metodo')
                        <p class="text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-800" for="notas">Notas (opcional)</label>
                        <textarea
                            id="notas"
                            name="notas"
                            rows="3"
                            class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:ring-indigo-500"
                            placeholder="Indica referencias para la entrega o comentarios sobre el pago."
                        >{{ old('notas', $payment['notas'] ?? '') }}</textarea>
                        @error('notas')
                        <p class="text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-3 border-t border-slate-200 pt-4 md:flex-row md:items-center md:justify-between">
                        <div class="text-sm text-slate-500">
                            Revisaras el resumen antes de confirmar el pedido.
                        </div>
                        <div class="flex gap-3">
                            <a
                                href="{{ route('checkout.shipping') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                            >
                                Volver
                            </a>
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                Continuar al resumen
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <aside class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Resumen</p>
                        <h2 class="text-lg font-bold text-slate-900">Tu pedido</h2>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                        {{ $totals['quantity'] }} articulo{{ $totals['quantity'] === 1 ? '' : 's' }}
                    </span>
                </div>

                <div class="space-y-3">
                    @foreach($items as $item)
                        <div class="flex items-center gap-3 rounded-xl border border-slate-100 p-3">
                            <div class="h-14 w-14 flex-none overflow-hidden rounded-lg bg-slate-50">
                                <img
                                    src="{{ $item->product->image_src ?? $item->product->image_url ?? 'https://via.placeholder.com/80' }}"
                                    alt="{{ $item->product->name }}"
                                    class="h-full w-full object-cover"
                                >
                            </div>
                            <div class="flex-1">
                                <p class="truncate text-sm font-semibold text-slate-900">{{ $item->product->name }}</p>
                                <p class="text-xs text-slate-500">Cantidad: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-sm font-semibold text-slate-900">
                                S/ {{ number_format($item->subtotal, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-2 border-t border-slate-200 pt-4 text-sm text-slate-600">
                    <div class="flex justify-between">
                        <span>Productos</span>
                        <span>S/ {{ number_format($totals['price'], 2) }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-slate-900">
                        <span>Total</span>
                        <span>S/ {{ number_format($totals['price'], 2) }}</span>
                    </div>
                </div>

                <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    Los datos se guardan de forma temporal hasta confirmar el pedido.
                </div>
            </aside>
        </div>
    </div>
</div>

<script>
(function () {
    const cards = document.querySelectorAll('[data-method-card]');
    const panels = document.querySelectorAll('[data-method-panel]');
    const radios = document.querySelectorAll('input[name="metodo"]');

    const update = (value) => {
        cards.forEach((card) => {
            const active = card.dataset.methodCard === value;
            card.classList.toggle('border-indigo-500', active);
            card.classList.toggle('shadow-lg', active);
            card.classList.toggle('shadow-indigo-100', active);
            card.classList.toggle('bg-indigo-50', active);
        });

        panels.forEach((panel) => {
            panel.classList.toggle('hidden', panel.dataset.methodPanel !== value);
        });
    };

    const checked = document.querySelector('input[name="metodo"]:checked');
    update(checked ? checked.value : 'card');

    radios.forEach((radio) => {
        radio.addEventListener('change', (event) => update(event.target.value));
    });
})();

// --- QR logic ---
(function () {
    const btnGenerate = document.getElementById('btn-generate-qr');
    const btnConfirm = document.getElementById('btn-confirm-code');
    const btnCopy = document.getElementById('btn-copy-code');
    const qrImage = document.getElementById('qr-image');
    const qrPlaceholder = document.getElementById('qr-placeholder');
    const qrMeta = document.getElementById('qr-meta');
    const qrCodeText = document.getElementById('qr-code-text');
    const qrTimer = document.getElementById('qr-timer');
    const qrStatus = document.getElementById('qr-status');
    const qrAlert = document.getElementById('qr-alert');
    const inputCode = document.getElementById('input-code');

    const routes = {
        generate: @json(route('checkout.payment.qr')),
        status: (id) => @json(route('checkout.payment.status', ['payment' => '__ID__'])).replace('__ID__', id),
        confirm: @json(route('checkout.payment.qr.confirm')),
        onComplete: @json(route('checkout.complete')),
    };

    let state = {
        paymentId: null,
        expiresAt: null,
        pollInterval: null,
        timerInterval: null,
    };

    const setAlert = (message, tone = 'info') => {
        if (!qrAlert) return;
        const tones = {
            info: 'bg-blue-50 border-blue-200 text-blue-800',
            success: 'bg-emerald-50 border-emerald-200 text-emerald-800',
            error: 'bg-rose-50 border-rose-200 text-rose-800',
            warning: 'bg-amber-50 border-amber-200 text-amber-800',
        };
        qrAlert.className = `rounded-lg px-3 py-2 text-xs border ${tones[tone] ?? tones.info}`;
        qrAlert.textContent = message;
        qrAlert.classList.remove('hidden');
    };

    const clearAlert = () => {
        if (!qrAlert) return;
        qrAlert.classList.add('hidden');
        qrAlert.textContent = '';
    };

    const setStatus = (text) => {
        if (qrStatus) qrStatus.textContent = text;
    };

    const disableButtons = (loading) => {
        if (btnGenerate) btnGenerate.disabled = loading;
        if (btnConfirm) btnConfirm.disabled = loading;
    };

    const stopTimers = () => {
        if (state.pollInterval) clearInterval(state.pollInterval);
        if (state.timerInterval) clearInterval(state.timerInterval);
    };

    const updateTimer = () => {
        if (!state.expiresAt || !qrTimer) return;
        const diff = state.expiresAt.getTime() - Date.now();
        if (diff <= 0) {
            qrTimer.textContent = '00:00';
            stopTimers();
            setAlert('El codigo expiro, genera uno nuevo.', 'warning');
            setStatus('Expirado');
            return;
        }
        const minutes = Math.floor(diff / 60000);
        const seconds = Math.floor((diff % 60000) / 1000);
        qrTimer.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    };

    const startTimer = (expiresAt) => {
        state.expiresAt = new Date(expiresAt);
        updateTimer();
        state.timerInterval = setInterval(updateTimer, 1000);
    };

    const startPolling = () => {
        if (state.pollInterval) clearInterval(state.pollInterval);
        state.pollInterval = setInterval(async () => {
            if (!state.paymentId) return;
            try {
                const response = await fetch(routes.status(state.paymentId));
                const data = await response.json();

                if (data.status === 'completed') {
                    stopTimers();
                    setStatus('Pago confirmado');
                    setAlert('Pago confirmado, redirigiendo...', 'success');
                    setTimeout(() => {
                        window.location.href = routes.onComplete;
                    }, 1200);
                } else if (data.status === 'expired') {
                    stopTimers();
                    setStatus('Expirado');
                    setAlert('El codigo expiro, genera uno nuevo.', 'warning');
                }
            } catch (error) {
                console.error('Error consultando estado', error);
            }
        }, 3000);
    };

    const handleGenerate = async () => {
        clearAlert();
        disableButtons(true);

        try {
            const response = await fetch(routes.generate, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ method: 'yape' }),
            });

            const data = await response.json();
            if (!data.success) {
                throw new Error(data.message || 'No se pudo generar el codigo');
            }

            state.paymentId = data.payment_id;
            if (qrMeta) qrMeta.classList.remove('hidden');

            if (qrPlaceholder) qrPlaceholder.classList.add('hidden');
            if (qrImage) {
                qrImage.src = data.qr_url;
                qrImage.classList.remove('hidden');
            }

            if (qrCodeText) qrCodeText.textContent = data.payment_code;
            setStatus('Escanea el QR y confirma el pago.');

            startTimer(data.expires_at);
            startPolling();
        } catch (error) {
            setAlert(error.message || 'Error generando el codigo', 'error');
        } finally {
            disableButtons(false);
        }
    };

    const handleConfirm = async () => {
        if (!state.paymentId) {
            setAlert('Genera un codigo antes de confirmar.', 'warning');
            return;
        }

        const code = inputCode?.value?.trim();
        if (!code) {
            setAlert('Ingresa el codigo mostrado para confirmar.', 'warning');
            return;
        }

        clearAlert();
        disableButtons(true);

        try {
            const response = await fetch(routes.confirm, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ payment_id: state.paymentId, code }),
            });

            const data = await response.json();
            if (!data.success) {
                throw new Error(data.message || 'No se pudo confirmar el pago');
            }

            stopTimers();
            setStatus('Pago confirmado');
            setAlert('Pago confirmado, redirigiendo...', 'success');
            setTimeout(() => {
                window.location.href = routes.onComplete;
            }, 1200);
        } catch (error) {
            setAlert(error.message || 'Error al confirmar pago', 'error');
        } finally {
            disableButtons(false);
        }
    };

    const handleCopy = async () => {
        if (!qrCodeText || !qrCodeText.textContent) return;
        try {
            await navigator.clipboard.writeText(qrCodeText.textContent);
            setAlert('Codigo copiado al portapapeles.', 'info');
        } catch (_) {
            setAlert('No se pudo copiar el codigo.', 'warning');
        }
    };

    btnGenerate?.addEventListener('click', handleGenerate);
    btnConfirm?.addEventListener('click', handleConfirm);
    btnCopy?.addEventListener('click', handleCopy);
})();
</script>
@endsection
