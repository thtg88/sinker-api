<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'path' => 'required|string|max:255',
            'type' => 'required|string|in:'.
                implode(',', config('app.event_types')),
        ];
    }
}
