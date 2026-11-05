<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 都道府県マスタ
 */
class Prefecture extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];

    /**
     * 市区町村とのリレーション
     * 都道府県に属する市区町村を取得する
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
