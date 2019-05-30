<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Bridge\Laravel\Providers;

use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\LogUnindexedSearchItemCommand;
use LoyaltyCorp\Auditing\Interfaces\Services\SearchLogWriterInterface;
use LoyaltyCorp\Auditing\Services\SearchLogWriter;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Bridge\Laravel\Providers\LoyaltyCorpAuditingSearchProvider
 */
class LoyaltyCorpAuditingSearchProviderTest extends TestCase
{
    /**
     * Test bindings
     *
     * @return void
     */
    public function testServiceProviderBindings(): void
    {
        $app = $this->createApplication();

        self::assertInstanceOf(SearchLogWriter::class, $app->make(SearchLogWriterInterface::class));

        self::assertInstanceOf(LogUnindexedSearchItemCommand::class, $app->make('command.log.audit.search_items'));
    }
}
