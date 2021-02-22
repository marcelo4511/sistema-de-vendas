<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   
   protected $table = "products";
    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'estoque',
        'subtotal',
        'imagem',
        'status',
        'category_id'
    ];
    
    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
