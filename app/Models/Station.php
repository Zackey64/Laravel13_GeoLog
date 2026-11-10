<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 道の駅マスタ
 */
class Station extends Model
{
    protected $fillable = [
        'city_id',
        'code',
        'name',
        'address',
        'official_url',
        'image_path',
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
     * 市区町村とのリレーション
     * 市区町村が属する道の駅を取得する
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * 訪問履歴とのリレーション
     * 道の駅に属する訪問履歴を取得する
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    // ================================
    // スコープ
    // ================================
    /**
     * 都道府県コード＋駅コード順に並べるスコープ
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->join('cities', 'stations.city_id', '=', 'cities.id')
            ->join('prefectures', 'cities.prefecture_id', '=', 'prefectures.id')
            ->select('stations.*')
            ->orderBy('prefectures.code')
            ->orderBy('stations.code');
    }

    /**
     * 訪問済みの道の駅
     */
    public function scopeVisited(Builder $query): Builder
    {
        return $query->whereHas('visits');
    }

    /**
     * 未訪問の道の駅
     */
    public function scopeNotVisited(Builder $query): Builder
    {
        return $query->whereDoesntHave('visits');
    }

    // ================================
    // アクセサ
    // ================================

    /**
     * 訪問済みかどうかのアクセサ
     */
    protected function visited(): Attribute
    {
        return Attribute::get(
            fn () => $this->visits()->exists()
        );
    }

    /**
     * 駅コードのアクセサ
     * 都道府県名と駅コードを結合して取得する
     */
    protected function stationCode(): Attribute
    {
        return Attribute::get(
            fn () => mb_substr($this->city->prefecture->name, 0, 1)
                .' '
                .str_pad($this->code, 2, '0', STR_PAD_LEFT)
        );
    }
}
