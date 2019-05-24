<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\DataTransferObjects;

use DateTime;
use LoyaltyCorp\Auditing\DataTransferObjects\LogLine;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * Class LogLineDtoTest
 *
 * @covers \LoyaltyCorp\Auditing\DataTransferObjects\LogLine
 */
class LogLineTest extends TestCase
{
    /**
     * Test the DTO to ensure serialization is possible, and it keeps required properties
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testDeserialization(): void
    {
        $logLine = new LogLine(
            '127.0.0.1',
            new DateTime('2019-05-01T12:12:12'),
            '{"data":"some good content"}',
            '{"data":"even better content"}',
            0
        );

        $serialized = \serialize($logLine);
        $unserialized = \unserialize($serialized);

        self::assertEquals($logLine, $unserialized);
    }

    /**
     * Test getTableName() method
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testGetTableName(): void
    {
        self::assertSame('AuditLog', $this->getInstance()->getTableName());
    }

    /**
     * Test getters
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testGetters(): void
    {
        $instance = $this->getInstance();
        self::assertSame('127.0.0.1', $instance->getClientIp());
        self::assertEquals(new DateTime('2019-05-20T11:12:13Z'), $instance->getOccurredAt());
        self::assertSame('HTTP request heads and bodies', $instance->getRequestData());
        self::assertSame('HTTP response heads and bodies', $instance->getResponseData());
        self::assertSame(1, $instance->getLineStatus());
    }

    /**
     * Test toArray() method
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testToArray(): void
    {
        self::assertSame(
            [
                'clientIp' => '127.0.0.1',
                'lineStatus' => 1,
                'occurredAt' => '2019-05-20T11:12:13Z',
                'requestData' => 'HTTP request heads and bodies',
                'responseData' => 'HTTP response heads and bodies'
            ],
            $this->getInstance()->toArray()
        );
    }

    /**
     * Get instance of LogLine
     *
     * @return \LoyaltyCorp\Auditing\DataTransferObjects\LogLine
     *
     * @throws \Exception
     */
    private function getInstance(): LogLine
    {
        return new LogLine(
            '127.0.0.1',
            1,
            new DateTime('2019-05-20T11:12:13Z'),
            'HTTP request heads and bodies',
            'HTTP response heads and bodies',
        );
    }
}
