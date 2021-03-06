<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Detail;

class Sale extends Model
{
    protected $fillable = [
        'dataVenda',
        'total',
        'client_id',
        'situacao_id'
    ];

    protected $table = 'sales';
    protected $date = 'dataVenda';
    
    public function details_sales()
    {
        return $this->hasMany(Detail::class);
    }

    public function clients()
    {
        return $this->belongsTo(Client::class,'client_id');
    }

    public function formapagamento()
    {
        return $this->hasOne(FormaPagamento::class);
    }

    public function situacao()
    {
        return $this->belongsTo(Situacao::class,'situacao_id');
    }
}