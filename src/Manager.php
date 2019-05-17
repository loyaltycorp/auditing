<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use LoyaltyCorp\Auditing\Interfaces\Client\ConnectionInterface;
use LoyaltyCorp\Auditing\Interfaces\DynamoDbAwareInterface;

abstract class Manager implements DynamoDbAwareInterface
{
    /**
     * @var \Aws\DynamoDb\DynamoDbClient
     */
    private $dbClient;

    /**
     * @var \Aws\DynamoDb\Marshaler
     */
    private $marshaler;

    /**
     * Auditor constructor.
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\Client\ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->dbClient = $connection->getDbClient();
        $this->marshaler = new Marshaler();
    }

    /**
     * Get db client.
     *
     * @return \Aws\DynamoDb\DynamoDbClient
     */
    protected function getDbClient(): DynamoDbClient
    {
        return $this->dbClient;
    }

    /**
     * Get marshaler.
     *
     * @return \Aws\DynamoDb\Marshaler
     */
    protected function getMarshaler(): Marshaler
    {
        return $this->marshaler;
    }
}
