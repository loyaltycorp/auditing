<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands;

use Illuminate\Console\Command;
use LoyaltyCorp\Auditing\DataTransferObjects\LogLine;
use LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\SearchLogWriterInterface;

final class LogUnindexedSearchItemCommand extends Command
{
    /**
     * Construct command to index search items.
     */
    public function __construct()
    {
        $this->description = 'Log items not indexed in search.';
        $this->signature = 'auditing:log:search-items';

        parent::__construct();
    }

    /**
     * Handle command.
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface $logWriter
     * @param \LoyaltyCorp\Auditing\Interfaces\Services\SearchLogWriterInterface $searchLogWriter
     *
     * @return void
     *
     * @throws \Exception Exception from DateTime if any
     */
    public function handle(
        LogWriterInterface $logWriter,
        SearchLogWriterInterface $searchLogWriter
    ): void {
        $this->info('Indexing log items for search...');

        $lines = $logWriter->listByLineStatus(LogLine::LINE_STATUS_NOT_INDEXED);

        $searchLogWriter->bulkWrite($lines);

        foreach ($lines as $line) {
            $logWriter->update($line['requestId'], new LogLine(
                $line['clientIp'],
                LogLine::LINE_STATUS_INDEXED,
                new \DateTime($line['occurredAt']),
                $line['requestData'],
                $line['responseData']
            ));
        }

        $this->info('Done.');
    }
}
