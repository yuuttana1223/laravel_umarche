<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 1; $i <= 10; $i++) {
            DB::table('shops')->insert([
                'owner_id' => $i,
                'name' => "店名$i",
                'information' => "ここに店名{$i}の情報が入ります。ここに店名{$i}の情報が入ります。ここに店名{$i}の情報が入ります。ここに店名{$i}の情報が入ります。",
                'filename' => '',
                'is_selling' => true,
            ]);
        }
    }
}
