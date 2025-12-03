@extends('layouts.app')

@section('title', 'Mis Reservas')

@php
    use Carbon\Carbon;
@endphp

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <h1 class="text-2xl font-semibold text-primary">Mis productos reservados</h1>
    <p class="text-sm text-slate-600">
        Puedes asegurar el equipo pagando el 50% por 48 horas o completar el 100% ahora. Si no completas el pago antes de vencer, la reserva se libera y se reembolsa el adelanto.
    </p>

    {{-- Mensaje de confirmación (reserva creada o cancelada) --}}
    @if(session('status'))
        <div id="reservation-status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm">
            {{ session('status') }}
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const flash = document.getElementById('reservation-status');
                if (!flash) return;

                setTimeout(() => {
                    flash.style.transition = 'opacity 0.5s ease';
                    flash.style.opacity = '0';
                    setTimeout(() => flash.remove(), 600);
                }, 4000);
            });
        </script>
    @endif

    @if($reservas->isEmpty())
        <div class="rounded-xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500 shadow-sm">
            No tienes productos reservados.
            <a href="{{ route('shop.index') }}" class="text-indigo-600 hover:underline">Explora la tienda</a>.
        </div>
    @else
        <div class="space-y-4">
            @foreach ($reservas as $reserva)
                @php
                    $producto = $reserva->product;
                    $nombre = $producto->nombre ?? $producto->name ?? 'Producto';
                    $precio = $producto->price ?? null;
                    $adelanto = $precio ? $precio * 0.5 : null;
                    $expira = $reserva->created_at->copy()->addHours(48);
                    $expirada = now()->greaterThanOrEqualTo($expira);
                @endphp
                <article class="flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm md:flex-row md:items-center">
                    {{-- Imagen del producto --}}
                    <img src="{{ $producto->image_url ?? '' }}" alt="{{ $nombre }}" class="h-20 w-20 rounded-xl object-cover">

                    <div class="flex-1 space-y-2">
                        {{-- Nombre del producto --}}
                        <p class="text-lg font-semibold text-secondary leading-tight">
                            {{ $nombre }}
                        </p>

                        {{-- Fecha de reserva --}}
                        <p class="text-sm text-slate-500">
                            Reservado el {{ $reserva->created_at->format('d/m/Y H:i') }}
                        </p>

                        {{-- Estado y vencimiento --}}
                        <div class="flex flex-wrap items-center gap-2 text-sm font-semibold {{ $expirada ? 'text-rose-700' : 'text-emerald-700' }}">
                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $expirada ? 'bg-rose-50 text-rose-700 ring-rose-100' : 'bg-emerald-50 text-emerald-700 ring-emerald-100' }}">
                                {{ $expirada ? 'Reserva expirada' : 'Reserva activa' }}
                            </span>
                            @if(!$expirada)
                                <span>Vence en <span data-countdown="{{ $expira->toIso8601String() }}" class="font-bold text-emerald-700">48h</span></span>
                            @else
                                <span>Vencida</span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500">
                            Se libera el {{ $expira->format('d/m/Y H:i') }} si no completas el pago.
                        </p>

                        {{-- Costos de referencia --}}
                        @if($precio)
                            <div class="text-sm text-slate-700 space-y-1">
                                <p class="flex items-center gap-2">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300"></span>
                                    <span>Precio total: S/ {{ number_format($precio, 2) }}</span>
                                </p>
                                @if($adelanto)
                                    <p class="flex items-center gap-2">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-300"></span>
                                        <span>Adelanto sugerido (50%): S/ {{ number_format($adelanto, 2) }}</span>
                                    </p>
                                @endif
                            </div>
                        @endif

                        {{-- Acciones --}}
                        <div class="mt-3 flex flex-wrap items-center gap-3">
                            <a href="{{ route('checkout.show') }}"
                               class="inline-flex items-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 {{ $expirada ? 'pointer-events-none opacity-50' : '' }}">
                                Completar compra ahora
                            </a>
                            <form action="{{ route('reservations.destroy', $reserva) }}" method="POST"
                                  onsubmit="return confirm('¿Cancelar esta reserva? Se liberará el stock y se reembolsará el adelanto.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center rounded-lg border border-rose-200 px-4 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50">
                                    Cancelar reserva
                                </button>
                            </form>
                            <a href="{{ route('support.index') }}" class="text-sm font-semibold text-indigo-600 hover:underline md:ml-auto">
                                ¿Necesitas ayuda?
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>

{{-- Contador de vencimiento (48h) --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const countdowns = document.querySelectorAll('[data-countdown]');
        const formatter = (n) => n.toString().padStart(2, '0');

        countdowns.forEach((el) => {
            const expiry = new Date(el.getAttribute('data-countdown')).getTime();
            const card = el.closest('article');
            const tick = () => {
                const diff = expiry - Date.now();
                if (diff <= 0) {
                    el.textContent = 'expirada';
                    if (card) card.classList.add('opacity-80');
                    return true;
                }
                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                el.textContent = `${formatter(hours)}h ${formatter(minutes)}m`;
                return false;
            };

            // Primera pintura inmediata
            const expired = tick();
            if (expired) return;

            // Actualiza cada minuto
            const interval = setInterval(() => {
                if (tick()) clearInterval(interval);
            }, 60000);
        });
    });
</script>
@endsection
