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
     * 道の駅が属する市区町村を取得する
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
     * 訪問履歴が存在する道の駅を取得するスコープ
     */
    public function scopeHasVisits(Builder $query): Builder
    {
        return $query->whereHas('visits');
    }

    /**
     * 訪問履歴が存在しない道の駅を取得するスコープ
     */
    public function scopeHasNoVisits(Builder $query): Builder
    {
        return $query->whereDoesntHave('visits');
    }

    // ================================
    // アクセサ
    // ================================

    /**
     * 訪問履歴が存在するかどうかのアクセサ
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
