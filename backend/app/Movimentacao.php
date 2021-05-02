<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    protected $table = 'movimentacoes';
    protected $fillable = [
        'descricao',
        'dt_vencimento',
        'valor',
        'comprovante',
        'user_id',
        'tipo_movimentacao_id'
    ];

    public function tipo_movimentacao()
    {
        return $this->belongsTo(TipoMovimentacao::class,'tipo_movimentacao_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
