<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Bridge\Laravel\Providers;

use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\CreateSchemaCommand;
use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\DropSchemaCommand;
use LoyaltyCorp\Auditing\Client\Connection;
use LoyaltyCorp\Auditing\Interfaces\Client\ConnectionInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\AuditorInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaInterface;
use LoyaltyCorp\Auditing\Manager\Auditor;
use LoyaltyCorp\Auditing\Managers\Schema;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Bridge\Laravel\Providers\LoyaltyCorpAuditingProvider
 */
class LoyaltyCorpAuditingProviderTest extends TestCase
{
    /**
     * Test bindings
     *
     * @return void
     */
    public function testServiceProviderBindings(): void
    {
        $app = $this->createApplication();

        self::assertInstanceOf(Auditor::class, $app->make(AuditorInterface::class));
        self::assertInstanceOf(Connection::class, $app->make(ConnectionInterface::class));
        self::assertInstanceOf(Schema::class, $app->make(SchemaInterface::class));

        self::assertInstanceOf(CreateSchemaCommand::class, $app->make('command.create.auditschema'));
        self::assertInstanceOf(DropSchemaCommand::class, $app->make('command.drop.auditschema'));
    }
}
