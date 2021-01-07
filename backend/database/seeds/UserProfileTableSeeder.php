<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_profile')->insert([
            'data_nasc' => Carbon::parse('2000-01-01'),
            'gender' => 'Masculino',
            'about' => 'é o CEO da empresa Marcelo LTDA',
            'phone' => '9999999999',
            'user_id' => 1
        ]);
    }
}
