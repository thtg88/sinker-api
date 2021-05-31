<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

final class LatestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate(['t' => 'nullable|date_format:U']);

        $models = Event::query()
            ->latest('created_at')
            ->where('user_id', $request->user()->id)
            ->when(!empty($request->t), static function ($query) use ($request) {
                $query->where(
                    'created_at',
                    '>=',
                    Carbon::createFromFormat('U', $request->t)
                        ->toDateTimeString()
                );
            })
            ->whereDoesntHave('device_events', static function ($query) use ($request) {
                $query->where('device_id', '=', $request->device()->id);
            })
            ->get();

        return response()->json([
            'data' => EventResource::collection($models),
        ]);
    }
}
