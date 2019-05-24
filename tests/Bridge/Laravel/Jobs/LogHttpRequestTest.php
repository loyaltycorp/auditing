<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Bridge\Laravel\Jobs;

use EoneoPay\Utils\DateTime;
use LoyaltyCorp\Auditing\Bridge\Laravel\Jobs\LogHttpRequest;
use LoyaltyCorp\Auditing\DataTransferObjects\LogLine;
use Tests\LoyaltyCorp\Auditing\Stubs\Services\LogWriterStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Bridge\Laravel\Jobs\LogHttpRequest
 */
class LogHttpRequestTest extends TestCase
{
    /**
     * Ensure the same DTO is passed through to the log writer
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testSomething(): void
    {
        $logWriter = new LogWriterStub();
        $logLine = new LogLine(
            '127.0.0.1',
            new DateTime(),
            '{}',
            '{}',
            0
        );

        $this->getInstance($logLine)->handle($logWriter);
        $writtenDto = $logWriter->writtenDtos[0] ?? null;

        self::assertSame($logLine, $writtenDto);
    }

    /**
     * Instantiate a LogHttpRequest
     *
     * @param \LoyaltyCorp\Auditing\DataTransferObjects\LogLine $logLine
     *
     * @return \LoyaltyCorp\Auditing\Bridge\Laravel\Jobs\LogHttpRequest
     */
    private function getInstance(LogLine $logLine): LogHttpRequest
    {
        return new LogHttpRequest($logLine);
    }
}
