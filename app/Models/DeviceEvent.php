<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class DeviceEvent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id',
        'event_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'device_id' => 'integer',
        'event_id' => 'integer',
    ];

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
