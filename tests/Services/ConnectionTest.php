<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Services;

use Aws\DynamoDb\DynamoDbClient;
use LoyaltyCorp\Auditing\Services\Connection;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Services\Connection
 */
class ConnectionTest extends TestCase
{
    /**
     * Ensure the connection returned is the same as the one supplied
     *
     * @return void
     */
    public function testConnectionClientGetter(): void
    {
        $dynamoDbClient = new DynamoDbClient(['region' => 'ap-southeast-2', 'version' => 'latest']);
        $connection = new Connection(
            $dynamoDbClient
        );

        $connectionClient = $connection->getClient();

        self::assertSame($dynamoDbClient, $connectionClient);
    }

    /**
     * Ensure table prefix supplies value passed into the constructor, unmodified
     *
     * @return void
     */
    public function testTablePrefix(): void
    {
        $dynamoDbClient = new DynamoDbClient(['region' => 'ap-southeast-2', 'version' => 'latest']);
        $connection = new Connection($dynamoDbClient, 'a-prefix');

        self::assertSame('a-prefix', $connection->getTablePrefix());
    }
}
