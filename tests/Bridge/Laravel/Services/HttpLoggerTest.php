<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Bridge\Laravel\Services;

use EoneoPay\Utils\DateTime;
use LoyaltyCorp\Auditing\Bridge\Laravel\Services\HttpLogger;
use Tests\LoyaltyCorp\Auditing\Stubs\Bridge\Laravel\DispatcherStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Services\LogLineFactory\RequestStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Services\LogLineFactory\ResponseStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Services\LogLineFactoryStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Bridge\Laravel\Services\HttpLogger
 */
class HttpLoggerTest extends TestCase
{
    /**
     * Test the record method does not throw an Exception
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testRecordingDoesNotThrowException(): void
    {
        $dispatcher = new DispatcherStub();

        $this->getInstance($dispatcher)->record(
            '127.0.0.1',
            new DateTime(),
            new RequestStub(),
            new ResponseStub()
        );

        // The record method simply passes this data on as a middleman
        $this->addToAssertionCount(1);
    }

    /**
     * Instantiate a http logger
     *
     * @param \Tests\LoyaltyCorp\Auditing\Stubs\Bridge\Laravel\DispatcherStub|null $dispatcher
     *
     * @return \LoyaltyCorp\Auditing\Bridge\Laravel\Services\HttpLogger
     */
    private function getInstance(?DispatcherStub $dispatcher = null): HttpLogger
    {
        return new HttpLogger(
            $dispatcher ?? new DispatcherStub(),
            new LogLineFactoryStub()
        );
    }
}
