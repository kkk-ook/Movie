<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1 ; $i <= 11 ; $i++) {
    
            $item = new \App\Models\User();
            $item -> name = '太朗- '. $i;
            $item -> save();
    
        }
    }
}
