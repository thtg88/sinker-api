<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    #[\Override]
    public function render($request, Throwable $e)
    {
        return $this->renderJson($request, $e);
    }

    /**
     * Render an exception into a JSON HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    protected function renderJson($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            $msg = $exception->getMessage() ?: 'Resource not found.';

            return response()->json(
                ['errors' => ['resource_not_found' => [$msg]]],
                Response::HTTP_NOT_FOUND
            );
        }

        if ($exception instanceof AuthenticationException) {
            $msg = $exception->getMessage() ?: 'Unauthenticated.';

            return response()->json(
                ['errors' => ['unauthenticated' => [$msg]]],
                Response::HTTP_UNAUTHORIZED
            );
        }

        if ($exception instanceof AuthorizationException) {
            $msg = $exception->getMessage() ?: 'Forbidden.';

            return response()->json(
                ['errors' => ['forbidden' => [$msg]]],
                Response::HTTP_FORBIDDEN
            );
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(
                ['errors' => ['method_not_allowed' => ['Method not allowed.']]],
                Response::HTTP_METHOD_NOT_ALLOWED
            );
        }

        if ($exception instanceof ThrottleRequestsException) {
            $msg = $exception->getMessage() ?: 'Too Many Attempts.';

            return response()->json(
                ['errors' => ['too_many_attempts' => [$msg]]],
                Response::HTTP_TOO_MANY_REQUESTS
            );
        }

        if ($exception instanceof HttpException) {
            $status_code = $exception->getStatusCode();

            if ($status_code === Response::HTTP_UNAUTHORIZED) {
                $msg = $exception->getMessage() ?: 'Unauthorized.';

                return response()->json(
                    ['errors' => ['unauthorized' => [$msg]]],
                    $status_code
                );
            }

            if ($status_code === Response::HTTP_FORBIDDEN) {
                $msg = $exception->getMessage() ?: 'Forbidden.';

                return response()->json(
                    ['errors' => ['forbidden' => [$msg]]],
                    $status_code
                );
            }

            if ($status_code === Response::HTTP_NOT_FOUND) {
                $msg = $exception->getMessage() ?: 'Resource not found.';

                return response()->json(
                    ['errors' => ['resource_not_found' => [$msg]]],
                    $status_code
                );
            }
        }

        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    #[\Override]
    public function register()
    {
    }
}
