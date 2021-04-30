<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $fillable = [
        'id',
        'name',
        'cnpj_cpf',
        'email',
        'cep',
        'street',
        'number',
        'complement',
        'city',
        'state',
        'heigthboard',
        'fone',
        'celular',
        'responsavel',
        'status' 
    ];
    protected $table = "fornecedor";

}
