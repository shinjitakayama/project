<?php

use Illuminate\Database\Seeder;
// use Caebon\Carbon;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'email' => 's24midnight@icloud.com',
            'password' => '1234',
            'name' => 'takayama',
            'remember_token' => ''
        ]);
    }
}
