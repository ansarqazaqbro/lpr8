<?php

use App\Support\ApiFormat;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // Ошибки валидации -> 422 в Формате C
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return ApiFormat::error(422, 'Ошибка валидации', $e->errors());
            }
        });

        // Модель не найдена -> 404
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return ApiFormat::error(404, 'Ресурс не найден');
            }
        });

        // HTTP-ошибки (404, 405 и др.)
        $exceptions->render(function (HttpExceptionInterface $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                $code = $e->getStatusCode();
                $message = match ($code) {
                    404 => 'Ресурс не найден',
                    405 => 'Метод не разрешён',
                    default => $e->getMessage() ?: 'Ошибка запроса',
                };

                return ApiFormat::error($code, $message);
            }
        });
    })->create();
