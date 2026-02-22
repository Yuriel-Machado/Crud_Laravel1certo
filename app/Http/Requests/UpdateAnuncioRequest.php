<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnuncioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
 public function rules(): array
{
    return [
        'titulo' => ['required', 'string', 'max:255'],
        'descricao' => ['required', 'string'],
        'preco_venda' => ['required', 'numeric', 'min:0'],
        'produtos' => ['required', 'array', 'min:1'],
        'produtos.*' => ['integer', 'exists:produtos,id'],
            'quantidades' => ['nullable', 'array'],
            'quantidades.*' => ['nullable', 'integer', 'min:1'],
    ];
}
}
