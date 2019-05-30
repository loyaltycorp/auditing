<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Bridge\Laravel\Jobs;

use EoneoPay\Utils\DateTime;
use LoyaltyCorp\Auditing\Bridge\Laravel\Jobs\SearchLogWriterJob;
use LoyaltyCorp\Auditing\DataTransferObjects\LogLine;
use Tests\LoyaltyCorp\Auditing\Stubs\Services\LogWriterStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Services\SearchLogWriterStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

class SearchLogWriterJobTest extends TestCase
{
    /**
     * Test handle search log writer job.
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testHandlingJob(): void
    {
        $logWriter = new LogWriterStub();
        $logLine = new LogLine(
            '127.0.0.1',
            0,
            new DateTime(),
            '{}',
            '{}'
        );
        $searchLogWriter = new SearchLogWriterStub();
        $expected = \array_merge($logLine->toArray(), ['requestId' => 'request-id']);

        $this->getJobInstance('request-id', $logLine)
            ->handle($logWriter, $searchLogWriter);


        $loggedLine = $searchLogWriter->loggedLines[0] ?? null;
        self::assertSame($expected, $loggedLine);
    }

    /**
     * Get job instance.
     *
     * @param string $requestId Log line request id
     * @param \LoyaltyCorp\Auditing\DataTransferObjects\LogLine $logLine Log line dto
     *
     * @return \LoyaltyCorp\Auditing\Bridge\Laravel\Jobs\SearchLogWriterJob
     */
    private function getJobInstance(string $requestId, LogLine $logLine): SearchLogWriterJob
    {
        return new SearchLogWriterJob($requestId, $logLine);
    }
}
