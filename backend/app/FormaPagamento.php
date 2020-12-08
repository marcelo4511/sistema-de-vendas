<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    protected $fillable = [
        'id',
        'tipo_forma_pagamento',
        'parcelas',
        'entrada',
        'sale_id'
    ];
    protected $table = 'forma_pagamento'; 

}
