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
     * @var string|null
     */
    private $prefix;

    /**
     * Connection constructor.
     *
     * @param \Aws\DynamoDb\DynamoDbClient $dynamoDbClient
     * @param string|null $prefix
     */
    public function __construct(DynamoDbClient $dynamoDbClient, ?string $prefix = null)
    {
        $this->client = $dynamoDbClient;
        $this->prefix = $prefix;
    }

    /**
     * {@inheritdoc}
     */
    public function getClient(): DynamoDbClient
    {
        return $this->client;
    }

    /**
     * {@inheritdoc}
     */
    public function getTablePrefix(): ?string
    {
        return $this->prefix;
    }
}
