<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Client;

use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Client\Connection
 */
class ConnectionTest extends TestCase
{
    /**
     * Test that get db client returns dynamodb client.
     *
     * @return void
     */
    public function testGetDbClient(): void
    {
        $conn = $this->getConnection($this->getMockHandler());

        self::assertSame('localhost', $conn->getDbClient()->getEndpoint()->getHost());
        self::assertSame(8000, $conn->getDbClient()->getEndpoint()->getPort());
        self::assertSame('ap-southeast-2', $conn->getDbClient()->getRegion());
    }
}
