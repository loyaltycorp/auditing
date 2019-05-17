<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Bridge\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\DropSchemaCommand;
use LoyaltyCorp\Auditing\Client\Connection;
use LoyaltyCorp\Auditing\CreateSchemaCommand;
use LoyaltyCorp\Auditing\Interfaces\Client\ConnectionInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\AuditorInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaInterface;
use LoyaltyCorp\Auditing\Manager\Auditor;
use LoyaltyCorp\Auditing\Managers\Schema;

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
        $this->app->singleton(ConnectionInterface::class, function () {
            return new Connection(
                \env('AWS_DYNAMODB_ACCESS_KEY_ID'),
                \env('AWS_DYNAMODB_SECRET_ACCESS_KEY'),
                \env('AWS_DYNAMODB_REGION'),
                \env('AWS_DYNAMODB_ENDPOINT'),
                \env('AWS_DYNAMODB_VERSION', 'latest')
            );
        });

        // bind managers
        $this->app->singleton(AuditorInterface::class, Auditor::class);
        $this->app->singleton(SchemaInterface::class, Schema::class);

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
        $this->app->singleton('command.create.auditschema', function () {
            return new CreateSchemaCommand();
        });
        $this->app->singleton('command.drop.auditschema', function () {
            return new DropSchemaCommand();
        });

        $this->commands([
            'command.create.auditschema',
            'command.drop.auditschema'
        ]);
    }
}
