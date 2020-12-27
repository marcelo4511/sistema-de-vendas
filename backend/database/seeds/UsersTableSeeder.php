<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin'),
            'type_user_id' => 1
        ]);
        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@test.com',
            'password' => Hash::make('secret'),
            'type_user_id' => 2
        ]);
    }
}
