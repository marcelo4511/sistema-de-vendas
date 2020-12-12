<?php

use App\Situacao;
use Illuminate\Database\Seeder;

class SituacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Situacao::create([
            'descricao'      => 'Aguardando pagamento',
        ]);

        Situacao::create([
            'descricao'      => 'Pagamento aprovado',
        ]);
    }
}
