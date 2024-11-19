<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (PDOException $e, Request $request) {
            if ($e->getCode() === '23505') {
                preg_match_all('/\(([^)]+)\)/', $e, $matches);
                $key = $matches[1][0];
                $value = $matches[1][1];
                return response()->json([
                    'code' => $e->getCode(),
                    'message' => 'O ' . $key . ' deve ser único. O valor ' . $value . ' já existe.',
                    'detail' => $e
                ], 400);
            }
        });
    })->create();
