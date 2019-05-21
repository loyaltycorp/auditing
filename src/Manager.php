<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use LoyaltyCorp\Auditing\Interfaces\Client\ConnectionInterface;
use LoyaltyCorp\Auditing\Interfaces\DynamoDbAwareInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\UuidGeneratorInterface;

abstract class Manager implements DynamoDbAwareInterface
{
    /**
     * DynamoDb client.
     *
     * @var \Aws\DynamoDb\DynamoDbClient
     */
    private $dbClient;

    /**
     * Uuid generator instance.
     *
     * @var \LoyaltyCorp\Auditing\Interfaces\Services\UuidGeneratorInterface
     */
    private $generator;

    /**
     * DynamoDb marshaler.
     *
     * @var \Aws\DynamoDb\Marshaler
     */
    private $marshaler;

    /**
     * Manager constructor.
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\Client\ConnectionInterface $connection
     * @param \LoyaltyCorp\Auditing\Interfaces\Services\UuidGeneratorInterface $generator
     */
    public function __construct(ConnectionInterface $connection, UuidGeneratorInterface $generator)
    {
        $this->dbClient = $connection->getDbClient();
        $this->generator = $generator;
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
     * Get generator.
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Services\UuidGeneratorInterface
     */
    protected function getGenerator(): UuidGeneratorInterface
    {
        return $this->generator;
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
