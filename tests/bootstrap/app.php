<?php
declare(strict_types=1);

$basePath = \realpath(\dirname(__DIR__));
require_once $basePath . '/../vendor/autoload.php';

use EoneoPay\Externals\Environment\Exceptions\InvalidPathException;
use EoneoPay\Externals\Environment\Loader;
use EoneoPay\Externals\Logger\Logger;
use Laravel\Lumen\Application;
use LoyaltyCorp\Auditing\Bridge\Laravel\Providers\LoyaltyCorpAuditingProvider;
use LoyaltyCorp\Auditing\Bridge\Laravel\Providers\LoyaltyCorpAuditingSearchProvider;
use LoyaltyCorp\Search\Interfaces\ClientInterface;
use Tests\LoyaltyCorp\Auditing\Stubs\Client\SearchClientStub;

// Load env.php or .env if it exists
try {
    (new Loader($basePath ?: ''))->load();
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

$app = new Application($basePath ?: '');

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
$app->register(LoyaltyCorpAuditingSearchProvider::class);

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(ClientInterface::class, SearchClientStub::class);

return $app;
