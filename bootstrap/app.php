<?php

use App\Exceptions\Handler;
use App\Http\Kernel as HttpKernel;
use App\Console\Kernel as ConsoleKernel;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Application;

$app = new Application(
    dirname(__DIR__)
);

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    HttpKernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    ConsoleKernel::class
);

$app->singleton(
    ExceptionHandler::class,
    Handler::class
);

return $app;
