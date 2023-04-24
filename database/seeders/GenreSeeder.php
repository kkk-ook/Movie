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
            'SF・ファンタジー',
            'アニメ',
            'CGアニメ',
            'ハイブリッド実写CG',
            'ディズニー',
            'キッズ',
            'コメディ',
            'ヒューマンドラマ',
            'サスペンス・ミステリー',
            'スリラー',
            'スポーツ',
            'ノンフィクション',
            'ドキュメンタリー',
            '青春',
            'ラブロマンス',
            'ミュージカル',
            'ホラー',
            '戦争',
            'ギャング・マフィア',
            'スプラッター',
            'ヤクザ・任侠',
        ];

        foreach ($genres as $genre) {
            Genre::create([ 
                'name'=>$genre
            ]);
        }
    }
}
