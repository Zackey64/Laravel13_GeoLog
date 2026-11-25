<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * 都道府県マスタ
 */
class Prefecture extends Model
{
    protected $fillable = [
        'code',
        'name',
    ];

    public function casts(): array
    {
        return [
            'code' => 'integer',
        ];
    }

    /**
     * 市区町村とのリレーション
     * 都道府県に属する市区町村を取得する
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    /**
     * 道の駅とのリレーション
     * 都道府県に属する道の駅を取得する
     */
    public function stations(): HasManyThrough
    {
        return $this->hasManyThrough(
            Station::class,
            City::class,
            'prefecture_id', // cities.prefecture_id
            'city_id',       // stations.city_id
            'id',            // prefectures.id
            'id'             // cities.id
        );
    }
}
