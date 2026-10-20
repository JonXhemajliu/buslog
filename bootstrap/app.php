<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\AuthCheck;
use App\Http\Middleware\CheckCompany;
use App\Http\Middleware\CheckEmployee;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth.check' => AuthCheck::class,
            'check.company' => CheckCompany::class,
            'check.employee' => CheckEmployee::class,
        ]);
    })
  ->withExceptions(function (Exceptions $exceptions): void {
    $exceptions->render(function (NotFoundHttpException|MethodNotAllowedHttpException $e, $request) {
        if ($request->expectsJson()) {
            return null;
        }

        return response()->view('pages.error', [], 404);
    });
})->create();