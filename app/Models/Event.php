<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
        'type',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
    ];

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function device_events(): HasMany
    {
        return $this->hasMany(DeviceEvent::class);
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
