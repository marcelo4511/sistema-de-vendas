<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMovimentacao extends Model
{
    protected $table = 'tipo_movimentacao';
    protected $fillable = [
        'descricao',
    ];

    public function movimentacoes()
    {
        return $this->hasMany(Movimentacao::class);
    }
}
