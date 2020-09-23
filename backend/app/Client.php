<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    
   
    protected $fillable = [
        'id',
        'name',
        'cpf',
        'email',
        'date_nasc',
        'cep',
        'street',
        'number',
        'complement',
        'city',
        'state',
        'heigthboard',
        'fone',
        'celular',
        'status' 
    ];
    protected $table = "clients";

}
