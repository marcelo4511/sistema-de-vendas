<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
            'dataVenda'  => 'required',
            'client_id'  => 'required',
            "details_sales" => "required|array",
            
            'details_sales.*.product_id' => 'required',
            'details_sales.*.price' => 'required',
            'details_sales.*.quantidade' => 'required',
            'details_sales.*.subtotal' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'dataVenda.required' => 'Campo Data da Venda é requirido' ,
            'client_id.required' => 'Campo Cliente é requirido',
            'details_sales.*.product_id.required' => 'O campo Produto é obrigatório',
            'details_sales.*.quantidade.required' => 'O campo quantidade é obrigatório',
            'details_sales.*.price.min' => 'O campo quantidade é obrigatório',
        ];
    }
}
