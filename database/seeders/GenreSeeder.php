<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres  = [ 
            'アクション',
            'アニメ',
            'SF・ファンタジー',
            'キッズ',
            'コメディ',
            'サスペンス・ミステリー',
            'スリラー',
            '戦争',
            'ディズニー',
            'ドキュメンタリー',
            'ヒューマンドラマ',
            'ホラー',
            'ミュージカル',
            'ラブロマンス',
        ];

        foreach ($genres as $genre) {
            Genre::create([ 
                'name'=>$genre
            ]);
        }
    }
}
