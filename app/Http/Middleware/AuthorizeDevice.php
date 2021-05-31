<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorizeDevice
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $device = $request->device();

        abort_unless(
            $device,
            Response::HTTP_FORBIDDEN,
            'You must provide a valid device ID in the ' .
                config('app.auth_headers.device_id') . ' HTTP header'
        );

        return $next($request);
    }
}
