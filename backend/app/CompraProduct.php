<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompraProduct extends Model
{
    protected $table = 'compra_product';
    protected $fillable = [
        'compra_id',
        'produto_id'
    ];

}
