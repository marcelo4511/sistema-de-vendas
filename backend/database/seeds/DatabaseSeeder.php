<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TypeUserTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SituacaoTableSeeder::class);
        $this->call(UserProfileTableSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(TipoEntradaSeeder::class);
    }
}
