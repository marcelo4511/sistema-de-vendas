<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillsToPay extends Model
{
    protected $table = 'bills_to_pay';
    protected $fillable = [
        'descricao',
        'dt_vencimento',
        'valor',
        'comprovante',
        'user_id',
        'situacao_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function situacao()
    {
        return $this->belongsTo(Situacao::class,'situacao_id');
    }
}
