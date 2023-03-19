<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1 ; $i <= 5 ; $i++) {
    
            $item = new \App\Models\Item();
            $item -> name = 'テスト- '. $i;
            $item -> save();
    
        }
    }
}
