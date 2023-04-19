<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemReview;
use App\Models\Genre;

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
    



    /*
    *リレーション
    */
    public function reviews(){
        return $this->hasMany(ItemReview::class)->orderBy('updated_at','desc');
    }

    public function genres(){
        return $this->belongsToMany(Genre::class,'genre_item');
    }


}
