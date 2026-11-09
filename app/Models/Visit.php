<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 訪問履歴
 */
class Visit extends Model
{
    protected $fillable = [
        'city_id',
        'station_id',
        'image_path',
        'context',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }
}
