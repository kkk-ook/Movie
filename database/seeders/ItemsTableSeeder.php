<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;
class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1 ; $i <= 11 ; $i++) {
    
            $item = new \App\Models\Item();
            $item -> name = 'テスト- '. $i;
            $item->kana = 'テスト- '. $i;
            $item ->  type= $i;
            $item -> save();
            
            $genres = Genre::inRandomOrder()->take(2)->pluck('id');
            $item->genres()->attach(
                // アイテムとジャンルを紐付ける
                $genres
            );
        }
    }
}
