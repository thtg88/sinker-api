<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

final class Device extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'uuid',
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
     * The "booted" method of the model.
     *
     * @return void
     */
    #[\Override]
    protected static function booted(): void
    {
        static::creating(function ($model) {
            if ($model->uuid === null) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

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
