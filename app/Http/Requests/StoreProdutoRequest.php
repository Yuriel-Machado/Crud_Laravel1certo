<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdutoRequest extends FormRequest
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
        'nome' => ['required', 'string', 'max:255'],
        'descricao' => ['required', 'string'],
        'preco' => ['required', 'numeric', 'min:0'],
        'cep' => ['required', 'string', 'max:9'],
        'bairro' => ['required', 'string', 'max:255'],
    ];
}
}
