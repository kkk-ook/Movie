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
        for($i = 1 ; $i <= 11 ; $i++) {
    
            $item = new \App\Models\Item();
            $item -> name = 'テスト- '. $i;
            $item -> kana = 'あああ';
            $item -> status = 'active';
            $item ->  type= $i;
            $item ->  detail= 'テストテストテスト'.$i;
            $item -> save();
    
        }
    }
}
