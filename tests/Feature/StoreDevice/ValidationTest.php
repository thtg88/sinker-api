<?php

namespace Tests\Feature\StoreDevice;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\Feature\TestCase;

class ValidationTest extends TestCase
{
    use WithRoute;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function name_string_validation_errors(): void
    {
        $response = $this->loginAs($this->user)
            ->json('post', $this->route(), [
                'name' => ['AAAA'],
            ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'name' => 'The name must be a string.',
            ]);
    }

    /** @test */
    public function name_max_validation_errors(): void
    {
        $response = $this->loginAs($this->user)
            ->json('post', $this->route(), [
                'name' => Str::random(256),
            ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'name' => 'The name must not be greater than 255 characters.',
            ]);
    }
}
