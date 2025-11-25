<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartQuantityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.integer' => 'La cantidad debe ser un número entero.',
            'quantity.min' => 'La cantidad mínima es 1.',
        ];
    }

    /**
     * Cantidad saneada con mínimo de 1.
     */
    public function quantity(): int
    {
        return max(1, (int) $this->input('quantity', 1));
    }
}
