<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_users')->insert([
            'descricao' => 'Admin',
        ]);
        DB::table('type_users')->insert([
            'descricao' => 'Caixa',
        ]);
        DB::table('type_users')->insert([
            'descricao' => 'Vendedor',
        ]);
    }
}
