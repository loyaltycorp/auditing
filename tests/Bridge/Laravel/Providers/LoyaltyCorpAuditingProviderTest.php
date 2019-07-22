<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Bridge\Laravel\Providers;

use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\CreateSchemaCommand;
use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\DropSchemaCommand;
use LoyaltyCorp\Auditing\Bridge\Laravel\Http\Middlewares\AuditMiddleware;
use LoyaltyCorp\Auditing\Bridge\Laravel\Providers\LoyaltyCorpAuditingProvider;
use LoyaltyCorp\Auditing\Bridge\Laravel\Services\HttpLogger;
use LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces\HttpLoggerInterface;
use LoyaltyCorp\Auditing\Interfaces\ManagerInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaManagerInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\ConnectionFactoryInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\LogLineFactoryInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\SearchLogWriterInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\UuidGeneratorInterface;
use LoyaltyCorp\Auditing\Manager;
use LoyaltyCorp\Auditing\Managers\DocumentManager;
use LoyaltyCorp\Auditing\Managers\SchemaManager;
use LoyaltyCorp\Auditing\Services\ConnectionFactory;
use LoyaltyCorp\Auditing\Services\Factories\Psr7Factory;
use LoyaltyCorp\Auditing\Services\LogLineFactory;
use LoyaltyCorp\Auditing\Services\LogWriter;
use LoyaltyCorp\Auditing\Services\SearchLogWriter;
use LoyaltyCorp\Auditing\Services\UuidGenerator;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Tests\LoyaltyCorp\Auditing\Stubs\Vendor\Illuminate\ApplicationStub;
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
     * Ensure middleware is applied on boot when appropriate
     *
     * @return void
     */
    public function testMiddlewareAppliedWhenEnabled(): void
    {
        /**
         * Illuminate's packages have odd type hints
         *
         * @var \Tests\LoyaltyCorp\Auditing\Stubs\Vendor\Illuminate\ApplicationStub $application
         * @var \Illuminate\Contracts\Foundation\Application $application
         */
        $application = new ApplicationStub();
        \putenv('AUDITING_MIDDLEWARE=true');
        $auditingProvider = new LoyaltyCorpAuditingProvider($application);

        $auditingProvider->boot();

        self::assertSame([AuditMiddleware::class], $application->getMiddlewares());
    }

    /**
     * Use a spy to ensure middleware is not used when disabled
     *
     * @return void
     */
    public function testMiddlewareNotAppliedWhenDisabled(): void
    {
        /**
         * Illuminate's packages have odd type hints
         *
         * @var \Tests\LoyaltyCorp\Auditing\Stubs\Vendor\Illuminate\ApplicationStub $application
         * @var \Illuminate\Contracts\Foundation\Application $application
         */
        $application = new ApplicationStub();
        \putenv('AUDITING_MIDDLEWARE=false');
        $auditingProvider = new LoyaltyCorpAuditingProvider($application);

        $auditingProvider->boot();

        self::assertSame([], $application->getMiddlewares());
    }

    /**
     * Test bindings
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testServiceProviderBindings(): void
    {
        $app = $this->createApplication();

        // assert that there are bound items
        self::assertGreaterThan(0, $app->getBindings());
        // clients
        self::assertInstanceOf(ConnectionFactory::class, $app->make(ConnectionFactoryInterface::class));
        // managers
        self::assertInstanceOf(DocumentManager::class, $app->make(DocumentManagerInterface::class));
        self::assertInstanceOf(Manager::class, $app->make(ManagerInterface::class));
        self::assertInstanceOf(SchemaManager::class, $app->make(SchemaManagerInterface::class));
        // services
        self::assertInstanceOf(HttpLoggerInterface::class, $app->make(HttpLogger::class));
        self::assertInstanceOf(LogLineFactoryInterface::class, $app->make(LogLineFactory::class));
        self::assertInstanceOf(LogWriter::class, $app->make(LogWriterInterface::class));
        self::assertInstanceOf(Psr7Factory::class, $app->make(HttpMessageFactoryInterface::class));
        self::assertInstanceOf(SearchLogWriter::class, $app->make(SearchLogWriterInterface::class));
        self::assertInstanceOf(UuidFactory::class, $app->make(UuidFactoryInterface::class));
        self::assertInstanceOf(UuidGenerator::class, $app->make(UuidGeneratorInterface::class));
        // commands
        self::assertInstanceOf(CreateSchemaCommand::class, $app->make('command.create.audit.schema'));
        self::assertInstanceOf(DropSchemaCommand::class, $app->make('command.drop.audit.schema'));
    }
}
