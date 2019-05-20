<?php
declare(strict_types=1);

$basePath = realpath(dirname(__DIR__));
require_once $basePath . '/../vendor/autoload.php';

use EoneoPay\Externals\Environment\Exceptions\InvalidPathException;
use EoneoPay\Externals\Environment\Loader;
use EoneoPay\Externals\Logger\Logger;
use Laravel\Lumen\Application;
use LoyaltyCorp\Auditing\Bridge\Laravel\Providers\LoyaltyCorpAuditingProvider;

// Load env.php or .env if it exists
try {
    (new Loader($basePath))->load();
} catch (InvalidPathException $exception) {
    // Log and continue as per normal since env may not be needed
    (new Logger())->exception($exception);
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Application($basePath);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(LoyaltyCorpAuditingProvider::class);

return $app;
