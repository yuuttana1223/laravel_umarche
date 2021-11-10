<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories =
            [
                'ゲーム' => ['PS5', 'PS4', 'Switch'],
                'ミュージック' => ['J-POP', 'ロック', 'クラシック'],
                '本' => ['アダルト', 'コミック', 'ラノベ']
            ];
        $foreign_id = 0;

        foreach ($categories as $primary => $secondaries) {
            DB::table('primary_categories')->insert([
                'name' => $primary,
            ]);
            $foreign_id++;
            foreach ($secondaries as $secondary) {
                DB::table('secondary_categories')->insert([
                    'primary_category_id' => $foreign_id,
                    'name' => $secondary,
                ]);
            }
        }
    }
}
