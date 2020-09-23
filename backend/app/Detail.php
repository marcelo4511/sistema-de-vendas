<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use app\Sale;
class Detail extends Model
{
    protected $fillable = [
        'id',
        'price',
        'descount',
        'subtotal',
        'product_id',
    ];
    protected $table = 'details_sales'; 


    public function products()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function sale(){
        return $this->belongsTo(Sale::class);
       }
}
