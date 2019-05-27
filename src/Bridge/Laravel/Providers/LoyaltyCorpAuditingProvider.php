<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Bridge\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\CreateSchemaCommand;
use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\DropSchemaCommand;
use LoyaltyCorp\Auditing\Bridge\Laravel\Services\HttpLogger;
use LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces\HttpLoggerInterface;
use LoyaltyCorp\Auditing\Client\Connection;
use LoyaltyCorp\Auditing\Interfaces\Client\ConnectionInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaManagerInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\LogLineFactoryInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\UuidGeneratorInterface;
use LoyaltyCorp\Auditing\Managers\DocumentManager;
use LoyaltyCorp\Auditing\Managers\SchemaManager;
use LoyaltyCorp\Auditing\Services\Factories\Psr7Factory;
use LoyaltyCorp\Auditing\Services\LogLineFactory;
use LoyaltyCorp\Auditing\Services\LogWriter;
use LoyaltyCorp\Auditing\Services\UuidGenerator;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;

/**
 * @noinspection EfferentObjectCouplingInspection High coupling required to ensure all services are bound
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects) High coupling required to ensure all services are bound
 */
class LoyaltyCorpAuditingProvider extends ServiceProvider
{
    /**
     * @noinspection PhpMissingParentCallCommonInspection Parent implementation is empty
     *
     * {@inheritdoc}
     */
    public function register(): void
    {
        // bind client/connection
        $this->app->singleton(ConnectionInterface::class, static function () {
            return new Connection(
                \env('AWS_DYNAMODB_ACCESS_KEY_ID'),
                \env('AWS_DYNAMODB_SECRET_ACCESS_KEY'),
                \env('AWS_DYNAMODB_REGION'),
                \env('AWS_DYNAMODB_ENDPOINT'),
                \env('AWS_DYNAMODB_VERSION', 'latest')
            );
        });
        $this->app->singleton(UuidFactoryInterface::class, UuidFactory::class);

        // bind managers
        $this->app->singleton(DocumentManagerInterface::class, DocumentManager::class);
        $this->app->singleton(SchemaManagerInterface::class, SchemaManager::class);

        // bind services
        $this->app->singleton(HttpLoggerInterface::class, HttpLogger::class);
        $this->app->singleton(LogWriterInterface::class, LogWriter::class);
        $this->app->singleton(UuidGeneratorInterface::class, UuidGenerator::class);
        $this->app->singleton(LogLineFactoryInterface::class, LogLineFactory::class);

        // bind factories
        $this->app->singleton(HttpMessageFactoryInterface::class, Psr7Factory::class);

        // register commands
        $this->registerCommands();
    }

    /**
     * Register commands.
     *
     * @return void
     */
    private function registerCommands(): void
    {
        $this->app->singleton('command.create.auditschema', CreateSchemaCommand::class);
        $this->app->singleton('command.drop.auditschema', DropSchemaCommand::class);

        $this->commands([
            'command.create.auditschema',
            'command.drop.auditschema'
        ]);
    }
}
