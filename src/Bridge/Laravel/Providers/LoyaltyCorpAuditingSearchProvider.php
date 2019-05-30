<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Bridge\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\LogUnindexedSearchItemCommand;
use LoyaltyCorp\Auditing\Interfaces\Services\SearchLogWriterInterface;
use LoyaltyCorp\Auditing\Services\SearchLogWriter;

class LoyaltyCorpAuditingSearchProvider extends ServiceProvider
{
    /**
     * @noinspection PhpMissingParentCallCommonInspection Parent implementation is empty
     *
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->app->singleton(SearchLogWriterInterface::class, SearchLogWriter::class);

        $this->registerCommands();
    }

    /**
     * Register commands.
     *
     * @return void
     */
    private function registerCommands(): void
    {
        $this->app->singleton('command.log.audit.search_items', LogUnindexedSearchItemCommand::class);

        $this->commands([
            'command.log.audit.search_items'
        ]);
    }
}
