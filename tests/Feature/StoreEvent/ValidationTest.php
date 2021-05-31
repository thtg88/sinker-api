<?php

namespace Tests\Feature\StoreEvent;

use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\Feature\TestCase;

class ValidationTest extends TestCase
{
    use WithRoute;

    /** @test */
    public function path_required_validation_errors(): void
    {
        $response = $this->loginAs($this->user)
            ->json('post', $this->route());

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'path' => 'The path field is required.',
            ]);
    }

    /** @test */
    public function type_required_validation_errors(): void
    {
        $response = $this->loginAs($this->user)
            ->json('post', $this->route());

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'type' => 'The type field is required.',
            ]);
    }

    /** @test */
    public function path_string_validation_errors(): void
    {
        $response = $this->loginAs($this->user)
            ->json('post', $this->route(), [
                'path' => ['AAAA'],
            ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'path' => 'The path must be a string.',
            ]);
    }

    /** @test */
    public function type_string_validation_errors(): void
    {
        $response = $this->loginAs($this->user)
            ->json('post', $this->route(), [
                'type' => ['AAAA'],
            ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'type' => 'The type must be a string.',
            ]);
    }

    /** @test */
    public function path_max_validation_errors(): void
    {
        $response = $this->loginAs($this->user)
            ->json('post', $this->route(), [
                'path' => Str::random(256),
            ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'path' => 'The path must not be greater than 255 characters.',
            ]);
    }

    /** @test */
    public function type_in_validation_errors(): void
    {
        $response = $this->loginAs($this->user)
            ->json('post', $this->route(), [
                'type' => 'AAAA',
            ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'type' => 'The selected type is invalid.',
            ]);
    }
}
