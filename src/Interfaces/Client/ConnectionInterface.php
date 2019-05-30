<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces\Client;

use Aws\DynamoDb\DynamoDbClient;

interface ConnectionInterface
{
    /**
     * Get dynamodb client.
     *
     * @return \Aws\DynamoDb\DynamoDbClient
     */
    public function getDbClient(): DynamoDbClient;
}
