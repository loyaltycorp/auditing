<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use LoyaltyCorp\Auditing\Exceptions\InvalidDocumentClassException;
use LoyaltyCorp\Auditing\Interfaces\ManagerInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\ConnectionInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\UuidGeneratorInterface;

final class Manager implements ManagerInterface
{
    /**
     * @var \LoyaltyCorp\Auditing\Interfaces\Services\ConnectionInterface
     */
    private $connection;

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
     * @param \LoyaltyCorp\Auditing\Interfaces\Services\ConnectionInterface $connection
     * @param \LoyaltyCorp\Auditing\Interfaces\Services\UuidGeneratorInterface $generator
     */
    public function __construct(
        ConnectionInterface $connection,
        UuidGeneratorInterface $generator
    ) {
        $this->connection = $connection;
        $this->generator = $generator;
        $this->marshaler = new Marshaler();
    }

    /**
     * Get DynamoDb client.
     *
     * @return \Aws\DynamoDb\DynamoDbClient
     */
    public function getDbClient(): DynamoDbClient
    {
        return $this->connection->getClient();
    }

    /**
     * Get document object.
     *
     * @param string $documentClass
     *
     * @return \LoyaltyCorp\Auditing\Document
     */
    public function getDocumentObject(string $documentClass): Document
    {
        if (\class_exists($documentClass) !== true) {
            throw new InvalidDocumentClassException(
                \sprintf('Provided document class (%s) is invalid or does not exist.', $documentClass)
            );
        }

        $document = new $documentClass();

        if (($document instanceof Document) !== true) {
            throw new InvalidDocumentClassException(
                \sprintf('Provided document class (%s) is invalid or does not exist.', $documentClass)
            );
        }

        return $document;
    }

    /**
     * Get generator.
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Services\UuidGeneratorInterface
     */
    public function getGenerator(): UuidGeneratorInterface
    {
        return $this->generator;
    }

    /**
     * Get marshaler.
     *
     * @return \Aws\DynamoDb\Marshaler
     */
    public function getMarshaler(): Marshaler
    {
        return $this->marshaler;
    }

    /**
     * {@inheritdoc}
     */
    public function getTableName(string $tableName): string
    {
        return \sprintf(
            '%s%s',
            $this->connection->getTablePrefix() ?? '',
            $tableName
        );
    }
}
