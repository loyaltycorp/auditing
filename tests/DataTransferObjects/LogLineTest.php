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
        self::assertSame(['customer_id' => 11], $instance->getRequestData());
        self::assertSame(['customer_name' => 'John'], $instance->getResponseData());
        self::assertSame(1, $instance->getStatus());
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
        // Cannot use assertSame() as there's object inside array.
        self::assertEquals(
            [
                'clientIp' => '127.0.0.1',
                'occurredAt' => new DateTime('2019-05-20T11:12:13Z'),
                'requestData' => ['customer_id' => 11],
                'responseData' => ['customer_name' => 'John'],
                'status' => 1
            ],
            $this->getInstance()->toArray()
        );
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
        self::assertSame('LogLine', $this->getInstance()->getTableName());
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
            new DateTime('2019-05-20T11:12:13Z'),
            ['customer_id' => 11],
            ['customer_name' => 'John'],
            1
        );
    }
}
