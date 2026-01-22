<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @psalm-suppress MissingTemplateParam
 */
class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    #[\Override]
    public function definition()
    {
        return [
            'path' => 'path/to/file',
            'type' => Arr::random(config('app.event_types')),
        ];
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function forUser(User $user): self
    {
        return $this->state(['user_id' => $user->id]);
    }
}
