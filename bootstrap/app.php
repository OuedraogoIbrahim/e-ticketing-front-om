<?php

use App\Http\Middleware\CheckTokenMiddleware;
use App\Http\Middleware\GuestCustomMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\LocaleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->appendToGroup('guest-user', GuestCustomMiddleware::class);
    $middleware->appendToGroup('auth-user', CheckTokenMiddleware::class);
    $middleware->web(LocaleMiddleware::class);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    //
  })->create();
