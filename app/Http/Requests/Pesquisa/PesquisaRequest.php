<?php

namespace App\Http\Requests\Pesquisa;

use Illuminate\Foundation\Http\FormRequest;

class PesquisaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pesquisa' => 'nullable|string|max:255',
            'genero' => 'nullable|string',
            'idioma' => 'nullable|string',
            'estado' => 'nullable|string',
            'min' => 'nullable|numeric|min:0',
            'max' => 'nullable|numeric|min:0',
            'ordem' => 'nullable|string|in:preco_asc,preco_desc,data_asc,data_desc',
        ];
    }

    public function getFiltros(): array
    {
        return [
            'pesquisa' => $this->input('pesquisa', ''),
            'genero' => $this->input('genero', '*'),
            'idioma' => $this->input('idioma', '*'),
            'estado' => $this->input('estado', '*'),
            'min' => $this->input('min', ''),
            'max' => $this->input('max', ''),
            'ordem' => $this->input('ordem', 'preco_desc'),
        ];
    }
}
