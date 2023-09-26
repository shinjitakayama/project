<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

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
            'email' => 's24midnight@icloud.com',
            'password' => '12345678',
            'stop_flg' => '1',
            'deleted_at' => Carbon::now(),
            'icon' => '画像',
            'introduction' => '宜しくお願いします。',
            'name' => 'takayama',
            'remember_token' => '',
        ]);
    }
}
