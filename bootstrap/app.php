<?php

use App\Exceptions\ExternalApiException;
use App\Http\Middleware\IsLoggedIn;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function Pest\Laravel\instance;

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
    // All unhandled exceptions will come here
    ->withExceptions(function (Exceptions $exceptions) {
        // Note: in laravel 12 only renderable and reportable are supported, render and report are depreceated
        // renderable - method that controls how exceptions are converted into HTTP responses.
        // reportable - method that controls how exceptions are logged or reported (e.g., to Sentry, Bugsnag, etc.).
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

            if ($e instanceof TokenInvalidException) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?: 'invalid token'
                ], $e->getCode() ?: 400);
            }

            // Exception handling for AuthorizationException (policy or gate)
            if ($e instanceof AccessDeniedHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?: 'Unauthorized action!',
                ], $e->getCode() ?: 403);
            }

            // fallback exception handler
            return response()->json([
                'success' => false,
                'message' => config('app.debug') ? $e->getMessage() : null,
                'stack' => config('app.debug') ? $e->getTrace() : null,
            ], $e->getCode() ?: 500);
        });
    })
    ->create();
