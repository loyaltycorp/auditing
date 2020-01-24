<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands;

use EoneoPay\Utils\DateTime;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher as IlluminateDisptacher;
use LoyaltyCorp\Auditing\Bridge\Laravel\Jobs\SearchLogWriterJob;
use LoyaltyCorp\Auditing\DataTransferObjects\LogLine;
use LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface;

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
     * @param \Illuminate\Contracts\Bus\Dispatcher $dispatcher
     * @param \LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface $logWriter
     *
     * @return void
     *
     * @throws \Exception
     */
    public function handle(IlluminateDisptacher $dispatcher, LogWriterInterface $logWriter): void
    {
        $lines = $logWriter->listByLineStatus(LogLine::LINE_STATUS_NOT_INDEXED);

        foreach ($lines as $line) {
            $dispatcher->dispatch(new SearchLogWriterJob($line['requestId'], new LogLine(
                $line['clientIp'],
                $line['lineStatus'],
                new DateTime($line['occurredAt']),
                $line['providerId'],
                $line['requestData'],
                $line['responseData']
            )));
        }

        $this->info('Writing logs to search queued for processing.');
    }
}
