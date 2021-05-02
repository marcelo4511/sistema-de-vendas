<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoEntradaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_movimentacao')->insert([
            'descricao' => 'Entrada',
        ]);
        DB::table('tipo_movimentacao')->insert([
            'descricao' => 'Saida',
        ]);
    }
}
