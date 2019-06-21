<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Services;

use EoneoPay\Utils\DateTime;
use GuzzleHttp\Psr7\BufferStream;
use LoyaltyCorp\Auditing\Services\LogLineFactory;
use Tests\LoyaltyCorp\Auditing\Stubs\Services\LogLineFactory\RequestStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Services\LogLineFactory\ResponseStub;
use Tests\LoyaltyCorp\Auditing\TestCase;
use Zend\Diactoros\Request;

/**
 * @covers \LoyaltyCorp\Auditing\Services\LogLineFactory
 */
class LogLineFactoryTest extends TestCase
{
    /**
     * Test creating a log line DTO using the factory
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testCreation(): void
    {
        $logLineFactory = $this->getInstance();

        $dto = $logLineFactory->create(
            '127.0.0.1',
            new DateTime('2019-05-05 12:12:12'),
            new RequestStub(),
            new ResponseStub()
        );

        self::assertSame('127.0.0.1', $dto->getClientIp());
        self::assertSame('2019-05-05 12:12:12', $dto->getOccurredAt()->format('Y-m-d H:i:s'));
        self::assertIsString($dto->getResponseData());
    }

    /**
     * Test creating a log line DTO using the factory
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testCreationEmptyRequestBecomesNull(): void
    {
        $request = new Request(null, null, new BufferStream());

        $logLineFactory = $this->getInstance();

        $dto = $logLineFactory->create(
            '127.0.0.1',
            new DateTime('2019-05-05 12:12:12'),
            $request,
            new ResponseStub()
        );

        self::assertSame('127.0.0.1', $dto->getClientIp());
        self::assertSame('2019-05-05 12:12:12', $dto->getOccurredAt()->format('Y-m-d H:i:s'));
        self::assertNull($dto->getRequestData());
        self::assertIsString($dto->getResponseData());
    }

    /**
     * Test the truncating of request/response body
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testCreationTruncatesBody(): void
    {
        $logLineFactory = $this->getInstance();

        $dto = $logLineFactory->create(
            '127.0.0.1',
            new DateTime(),
            new RequestStub(200000),
            new ResponseStub(200000)
        );

        self::assertSame(100000, \strlen($dto->getRequestData() ?? ''));
        self::assertSame(100000, \strlen($dto->getResponseData() ?? ''));
    }

    /**
     * Instantiate a new log line factory
     *
     * @return \LoyaltyCorp\Auditing\Services\LogLineFactory
     */
    private function getInstance(): LogLineFactory
    {
        return new LogLineFactory();
    }
}
