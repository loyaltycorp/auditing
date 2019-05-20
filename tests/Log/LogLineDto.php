<?php
declare(strict_types=1);

namespace Tests\Auditing\Log;

use Auditing\Log\LogLineDto;
use DateTime;
use PHPUnit\Framework\TestCase;

// TODO PHPUnit\Framework\TestCase is to be replaced with: Tests\EoneoPay\Externals\TestCase;

/**
 * Class LogLineDtoTest
 *
 * @covers \Auditing\Log\LogLineDto
 */
class LogLineDtoTest extends TestCase
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
        $instance = new LogLineDto(
            '127.0.0.1',
            new DateTime('2019-05-20T11:12:13Z'),
            ['customer_id' => 11],
            ['customer_name' => 'John'],
            1
        );
        self::assertSame('127.0.0.1', $instance->getClientIp());
        self::assertEqual(new DateTime('2019-05-20T11:12:13Z'), $instance->getOccurredAt());
        self::assertSame(['customer_id' => 11], $instance->getRequestData());
        self::assertSame(['customer_name' => 'John'], $instance->getResponseData());
        self::assertSame(1, $instance->getStatus());
    }
}
