<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $table = 'details_sales'; 
    protected $fillable = [
        'id',
        'price',
        'quantidade',
        'subtotal',
        'product_id',
        'sale_id'
    ];


    public function products()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class,'sale_id');
    }
}
