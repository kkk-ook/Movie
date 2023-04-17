<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemReview;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'kana',
        'status',
        'type',
        'detail',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    const STATUS = [
        'active' => [ 'label' => '有効', 'class' => 'bg-primary' ],
        'inactive' => [ 'label' => '無効', 'class' => 'bg-secondary' ],
    ];

    const TYPE = [
        1 => [ 'label' => 'アクション'],
        2 => [ 'label' => 'アニメ'],
        3 => [ 'label' => 'SF・ファンタジー'],
        4 => [ 'label' => 'キッズ'],
        5 => [ 'label' => 'コメディ'],
        6 => [ 'label' => 'サスペンス・ミステリー'],
        7 => [ 'label' => 'スリラー'],
        8 => [ 'label' => '戦争'],
        9 => [ 'label' => 'ディズニー'],
        10 => [ 'label' => 'ドキュメンタリー'],
        11 => [ 'label' => 'ヒューマンドラマ'],
        12 => [ 'label' => 'ホラー'],
        13 => [ 'label' => 'ミュージカル'],
        14 => [ 'label' => 'ラブロマンス'],
    ];


    public function getStatusLabelAttribute()
    {
        // 状態値
        $status = $this->attributes['status'];

        // 定義されていなければ無効を返す
        if (!isset(self::STATUS[$status])) {
            return '無効';
        }

        return self::STATUS[$status]['label'];
    }

    public function getStatusClassAttribute()
    {
        // 状態値
        $status = $this->attributes['status'];

        // 定義されていなければ空を返す
        if (!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['class'];
    }
    
    public function getTypeLabelAttribute()
    {
        // 状態値
        $type = $this->attributes['type'];

        // 定義されていなければ空を返す
        if (!isset(self::TYPE[$type])) {
            return '';
        }

        return self::TYPE[$type]['label'];
    }


    /*
    *リレーション
    */
    public function reviews()
    {
        return $this->hasMany(ItemReview::class)->orderBy('updated_at','desc');
    }


}
