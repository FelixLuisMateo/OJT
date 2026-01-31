<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * This file is the front controller for all HTTP requests entering
 * your application and bootstraps the framework. It is the file you
 * should point your web server to (document root = public/).
 *
 * Make sure you have run composer install and configured your .env.
 */

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides an autoloader for this application. We'll simply
| require it so we can use all of the framework and other libraries
| that are available to the application.
|
*/

require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so we will load up the
| auto-generated application instance that is available for use.
| This gives us access to the service container, config, etc.
|
*/

$app = require_once __DIR__ . '/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we must handle the incoming request
| through the kernel, and send the response back to the client.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();

$response = $kernel->handle($request);

$response->send();

$kernel->terminate($request, $response);