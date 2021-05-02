<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillsToReceive extends Model
{
    protected $table = 'bills_to_receive';
    protected $fillable = [
        'descricao',
        'dt_vencimento',
        'valor',
        'comprovante',
        'situacao_id',
        'user_id'
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
