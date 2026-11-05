<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 道の駅マスタ
 */
class Station extends Model
{
    protected $fillable = [
        'city_id',
        'name',
    ];

    /**
     * 市区町村とのリレーション
     * 市区町村が属する道の駅を取得する
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
