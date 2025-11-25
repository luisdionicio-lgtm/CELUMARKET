<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'method' => ['required', 'in:card,cash'],
            'card_number' => ['required_if:method,card', 'string', 'min:12', 'max:19'],
            'expiry' => ['required_if:method,card', 'string', 'min:4', 'max:7'],
            'cvv' => ['required_if:method,card', 'string', 'min:3', 'max:4'],
            'payment_code' => ['required_if:method,cash', 'string', 'min:4', 'max:30'],
        ];
    }

    public function messages(): array
    {
        return [
            'method.required' => 'Selecciona un método de pago.',
            'method.in' => 'Método de pago inválido.',
            'card_number.required_if' => 'Ingresa el número de tarjeta.',
            'expiry.required_if' => 'Ingresa la fecha de vencimiento.',
            'cvv.required_if' => 'Ingresa el código CVV.',
            'payment_code.required_if' => 'Ingresa el código de pago.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'method' => $this->input('method') ? strtolower($this->input('method')) : null,
        ]);
    }
}
