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
            'アドベンチャー',
            'アニメ',
            'SF・ファンタジー',
            'キッズ',
            'ギャング・マフィア',
            'コメディ',
            'サスペンス・ミステリー',
            'スプラッター',
            'スポーツ',
            'スリラー',
            '青春',
            '戦争',
            'ディズニー',
            'ドキュメンタリー',
            'ヒューマンドラマ',
            'ホラー',
            'ミュージカル',
            'ヤクザ・任侠',
            'ラブロマンス',
        ];

        foreach ($genres as $genre) {
            Genre::create([ 
                'name'=>$genre
            ]);
        }
    }
}
