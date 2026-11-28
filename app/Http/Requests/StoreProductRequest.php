<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:150'],
            'price' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'cost_price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'is_active' => ['required', 'boolean'],
            'image' => ['bail', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'cost_price.numeric' => 'Informe um custo válido.',
            'cost_price.min' => 'O custo deve ser zero ou maior.',
            'cost_price.max' => 'O custo deve ser de até R$ 999.999,99.',
            'image.uploaded' => 'Não foi possível enviar a foto. Envie um arquivo de até 2 MB.',
            'image.image' => 'Envie uma foto em JPG, PNG ou WebP.',
            'image.mimes' => 'Envie uma foto em JPG, PNG ou WebP.',
            'image.max' => 'A foto deve ter no máximo 2 MB.',
        ];
    }
}
