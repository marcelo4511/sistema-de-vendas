<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcessosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accessos')->insert([
            'pagina' => 'catalogo',
            'link' => 'catalogo'
        ]);

        DB::table('accessos')->insert([
            'pagina' => 'categorias',
            'link' => 'categorias'
        ]);

        DB::table('accessos')->insert([
            'pagina' => 'produtos',
            'link' => 'produtos'
        ]);

        DB::table('accessos')->insert([
            'pagina' => 'usuarios',
            'link' => 'usuarios'
        ]);
    }
}
