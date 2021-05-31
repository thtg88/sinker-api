<?php

namespace App\Helpers;

use App\Models\Event;
use App\Models\User;

final class EventHelper
{
    public static function deleteFromPathAndUser(
        string $path,
        User $user
    ): void {
        Event::query()
            ->where('path', $path)
            ->where('user_id', $user->id)
            ->delete();
    }
}
