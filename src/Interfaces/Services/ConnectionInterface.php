<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces\Services;

use Aws\DynamoDb\DynamoDbClient;

interface ConnectionInterface
{
    /**
     * Get the DynamoDb client for this connection
     *
     * @return \Aws\DynamoDb\DynamoDbClient
     */
    public function getClient(): DynamoDbClient;
}
