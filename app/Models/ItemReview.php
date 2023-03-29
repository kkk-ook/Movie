<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemReview extends Model
{
    use HasFactory;

    // リレーションシップ
    public function user() {

        return $this->belongsTo(App\Models\User::class, 'user_id', 'id')
            ->select('id', 'name');

    }
}
