@extends('layouts.app')

@section('title', 'Confirmar Pago')

@section('content')
<div class="mx-auto max-w-xl space-y-6">
    <h1 class="text-2xl font-bold text-primary">Confirmar pago</h1>

    <form method="POST" action="{{ route('cart.processPayment') }}" class="space-y-4">
        @csrf

        <div>
            <label for="method" class="block text-sm font-semibold text-slate-600">Método de pago</label>
            <select name="method" id="method" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                <option value="card" {{ old('method') === 'card' ? 'selected' : '' }}>Tarjeta de crédito</option>
                <option value="cash" {{ old('method') === 'cash' ? 'selected' : '' }}>Pago efectivo</option>
            </select>
            @error('method')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div id="card-fields" class="space-y-4">
            <div>
                <label for="card_number" class="block text-sm font-semibold text-slate-600">Número de tarjeta</label>
                <input type="text" name="card_number" id="card_number" value="{{ old('card_number') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="1234 5678 9012 3456">
                @error('card_number')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex gap-4">
                <div class="w-1/2">
                    <label for="expiry" class="block text-sm font-semibold text-slate-600">Vencimiento</label>
                    <input type="text" name="expiry" id="expiry" value="{{ old('expiry') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="MM/AA">
                    @error('expiry')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-1/2">
                    <label for="cvv" class="block text-sm font-semibold text-slate-600">CVV</label>
                    <input type="text" name="cvv" id="cvv" value="{{ old('cvv') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="123">
                    @error('cvv')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div id="cash-fields" class="hidden">
            <label for="payment_code" class="block text-sm font-semibold text-slate-600">Código de pago</label>
            <input type="text" name="payment_code" id="payment_code" value="{{ old('payment_code') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="Código generado por PagoEfectivo">
            @error('payment_code')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full rounded-xl bg-emerald-600 px-6 py-3 text-white font-semibold text-sm transition hover:bg-emerald-700">
            Confirmar y pagar
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const methodSelect = document.getElementById('method');
    const cardFields = document.getElementById('card-fields');
    const cashFields = document.getElementById('cash-fields');

    function toggleFields() {
        if (methodSelect.value === 'card') {
            cardFields.classList.remove('hidden');
            cashFields.classList.add('hidden');
        } else {
            cardFields.classList.add('hidden');
            cashFields.classList.remove('hidden');
        }
    }

    methodSelect.addEventListener('change', toggleFields);
    toggleFields(); // inicializa según el valor actual
});
</script>
@endsection