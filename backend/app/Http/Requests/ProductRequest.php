<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required',
            'price'         => 'required',
            'description'   => 'required',
            'price'         => 'required',
            'estoque'       => 'required',
            'imagem'        => 'required',
            'status'        => 'required',
            'category_id'   => 'required'
           // 'imagem'        => "required|mimes:pdf|max:10000"

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'status.required' => 'O campo Status é obrigatório .',
            'description.required' => 'O campo Descrição é obrigatório .',
            'price.required' => 'O campo Preço é obrigatório .',
            'estoque.required' => 'O campo Estoque é obrigatório .',
            'imagem.required' => 'O campo Imagem é obrigatório .',
            'category_id.required' => 'O campo Categoria é obrigatório .',
        ];
    }
}
