<?php

namespace App\Http\Controllers;

use App\Helpers\EventHelper;
use App\Http\Requests\StoreEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class StoreEventController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Http\Requests\StoreEventRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(StoreEventRequest $request): JsonResponse
    {
        $device = $this->deviceOrFail($request);

        EventHelper::deleteFromPathAndUser($request->path, $request->user());

        $model = Event::create(array_merge($request->validated(), [
            'user_id' => $request->user()->id,
        ]));

        $model->device_events()->create([
            'device_id' => $device->id,
        ]);

        return response()->json([
            'data' => new EventResource($model),
        ], Response::HTTP_CREATED);
    }
}
