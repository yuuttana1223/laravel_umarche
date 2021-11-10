<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('images')->insert([
                'owner_id' => 1,
                'filename' => "sample{$i}.jpg",
                'title' => null,
            ]);
        }
    }
}
