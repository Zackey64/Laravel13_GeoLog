<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    /**
     * 訪問履歴とのリレーション
     * 市区町村に属する訪問履歴を取得する
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    // ================================
    // スコープ
    // ================================

    /**
     * 訪問済みの市町村
     */
    public function scopeVisited(Builder $query): Builder
    {
        return $query->where(function ($query) {
            $query->whereHas('visits')
                ->orWhereHas('stations.visits');
        });
    }

    /**
     * 未訪問の市町村
     */
    public function scopeNotVisited(Builder $query): Builder
    {
        return $query
            ->whereDoesntHave('visits')
            ->whereDoesntHave('stations.visits');
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
            fn () => $this->visits()->exists() || $this->stations()
                ->whereHas('visits')->exists()
        );
    }

    /**
     * 訪問回数のアクセサ
     */
    protected function visitCount(): Attribute
    {
        return Attribute::get(
            fn () => $this->visits()->count()
                + $this->stations()
                    ->withCount('visits')
                    ->get()
                    ->sum('visits_count')
        );
    }
}
