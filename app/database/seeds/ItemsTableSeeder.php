<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'items_name' => 'cup',
            'price' => 1000,
            'description' => '使いやすいです。',
            'image' => '画像',
            'state' => '新品です。',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'users_id' => 1,
            'hide_flg' => 1,
            'selling' => 1,

        ]);
    }
}
