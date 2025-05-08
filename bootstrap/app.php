<?php

use Illuminate\Http\Request;
use App\Http\Middleware\IsLoggedIn;
use Illuminate\Foundation\Application;
use App\Exceptions\ExternalApiException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'loggedIn' => IsLoggedIn::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Note: in laravel 12 only renderable and reportable are supported, render and report are depreceated
        $exceptions->renderable(function (Throwable $e, Request $request) {
            if (!$request->is('api/*')) {
                return null;  // let Laravel render non-API errors as usual
            }

            if ($e instanceof ValidationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            }

            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not Found',
                ], 404);
            }

            if ($e instanceof ExternalApiException) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'endpoint' => $e->getEndpoint(),
                    'rawResponse' => $e->getResponseData(),
                ], $e->getCode() ?: 500);
            }

            return response()->json([
                'success' => false,
                'message' => 'Server error',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        });
    })
    ->create();
