<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $fillable = [
        'id',
        'data_compra',
        'total',
        'fornecedor_id',
        'situacao_id',
        'user_id'
    ];

    protected $table = 'compras';

    public function produtos()
    {
        return $this->belongsToMany(Product::class,'compra_product')->withPivot('subtotal');
    }
    public function situacao()
    {
        return $this->belongsTo(Situacao::class,'situacao_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class,'fornecedor_id');
    }
}
