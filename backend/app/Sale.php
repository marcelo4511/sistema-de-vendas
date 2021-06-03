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
        'situacao_id',
        'user_id'
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

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

   // public function getTotalAttribute($total)
//{
//return $this->attributes['total'] = sprintf('R$ %s', number_format($this->attributes['total'], 2,",","."));
//}

}