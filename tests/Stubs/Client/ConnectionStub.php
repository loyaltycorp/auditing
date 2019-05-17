<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Client;

use Aws\DynamoDb\DynamoDbClient;
use LoyaltyCorp\Auditing\Interfaces\Client\ConnectionInterface;

class ConnectionStub implements ConnectionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDbClient(): DynamoDbClient
    {
        return new AwsClientInterface();
    }
}
