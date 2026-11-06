<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 市区町村マスタ
 */
class City extends Model
{
    protected $fillable = [
        'prefecture_id',
        'code',
        'name',
        'kana',
        'latitude',
        'longitude',
    ];

    public function casts(): array
    {
        return [
            'code' => 'integer',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    /**
     * 都道府県とのリレーション
     * 市区町村が属する都道府県を取得する
     */
    public function prefecture(): BelongsTo
    {
        return $this->belongsTo(Prefecture::class);
    }

    /**
     * 道の駅とのリレーション
     * 市区町村に属する道の駅を取得する
     */
    public function stations(): HasMany
    {
        return $this->hasMany(Station::class);
    }
}
