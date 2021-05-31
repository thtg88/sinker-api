<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeviceResource;
use App\Models\Device;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate(['name' => 'nullable|string|max:255']);

        $model = Device::create([
            'name' => $request->name,
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'data' => new DeviceResource($model),
        ], Response::HTTP_CREATED);
    }
}
