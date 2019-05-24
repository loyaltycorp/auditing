<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Bridge\Laravel\Providers;

use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\CreateSchemaCommand;
use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\DropSchemaCommand;
use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\LogUnindexedSearchItemCommand;
use LoyaltyCorp\Auditing\Client\Connection;
use LoyaltyCorp\Auditing\Client\SearchClient;
use LoyaltyCorp\Auditing\Interfaces\Client\ConnectionInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaManagerInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\SearchLogWriterInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\UuidGeneratorInterface;
use LoyaltyCorp\Auditing\Managers\DocumentManager;
use LoyaltyCorp\Auditing\Managers\SchemaManager;
use LoyaltyCorp\Auditing\Services\LogWriter;
use LoyaltyCorp\Auditing\Services\SearchLogWriter;
use LoyaltyCorp\Auditing\Services\UuidGenerator;
use LoyaltyCorp\Search\Interfaces\ClientInterface;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidFactoryInterface;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @noinspection EfferentObjectCouplingInspection High coupling required to test all required services are bound
 *
 * @covers \LoyaltyCorp\Auditing\Bridge\Laravel\Providers\LoyaltyCorpAuditingProvider
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects) High coupling required to test all required services are bound
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

        // clients
        self::assertInstanceOf(Connection::class, $app->make(ConnectionInterface::class));
        self::assertInstanceOf(SearchClient::class, $app->make(ClientInterface::class));
        // managers
        self::assertInstanceOf(DocumentManager::class, $app->make(DocumentManagerInterface::class));
        self::assertInstanceOf(SchemaManager::class, $app->make(SchemaManagerInterface::class));
        // services
        self::assertInstanceOf(LogWriter::class, $app->make(LogWriterInterface::class));
        self::assertInstanceOf(SearchLogWriter::class, $app->make(SearchLogWriterInterface::class));
        self::assertInstanceOf(UuidFactory::class, $app->make(UuidFactoryInterface::class));
        self::assertInstanceOf(UuidGenerator::class, $app->make(UuidGeneratorInterface::class));
        // commands
        self::assertInstanceOf(CreateSchemaCommand::class, $app->make('command.create.audit.schema'));
        self::assertInstanceOf(DropSchemaCommand::class, $app->make('command.drop.audit.schema'));
        self::assertInstanceOf(LogUnindexedSearchItemCommand::class, $app->make('command.log.audit.search_items'));
    }
}
