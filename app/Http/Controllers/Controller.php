<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

abstract class Controller
{
    protected function deviceOrFail(Request $request): Device
    {
        $device = $request->device();

        abort_unless($device, Response::HTTP_NOT_FOUND);

        return $device;
    }
}
