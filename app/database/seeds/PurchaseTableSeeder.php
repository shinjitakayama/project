<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class PurchaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('purchase')->insert([
            'users_id' => 1,
            'users_name' => 'takayama',
            'postal_code' => '663-8101',
            'address' => '兵庫県西宮市松山町',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'items_id' => 1,
            'tel' => '08061546455',
        ]);
    }
}
