<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Services;

use Aws\DynamoDb\DynamoDbClient;
use LoyaltyCorp\Auditing\Interfaces\Services\ConnectionInterface;

class Connection implements ConnectionInterface
{
    /**
     * @var \Aws\DynamoDb\DynamoDbClient
     */
    private $client;

    /**
     * Connection constructor.
     *
     * @param \Aws\DynamoDb\DynamoDbClient $dynamoDbClient
     */
    public function __construct(DynamoDbClient $dynamoDbClient)
    {
        $this->client = $dynamoDbClient;
    }

    /**
     * {@inheritdoc}
     */
    public function getClient(): DynamoDbClient
    {
        return $this->client;
    }
}
