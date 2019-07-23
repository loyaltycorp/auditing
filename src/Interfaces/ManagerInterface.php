<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use LoyaltyCorp\Auditing\Document;
use LoyaltyCorp\Auditing\Interfaces\Services\UuidGeneratorInterface;

interface ManagerInterface
{
    /**
     * Get db client.
     *
     * @return \Aws\DynamoDb\DynamoDbClient
     */
    public function getDbClient(): DynamoDbClient;

    /**
     * Get document object.
     *
     * @param string $documentClass
     *
     * @return \LoyaltyCorp\Auditing\Document
     */
    public function getDocumentObject(string $documentClass): Document;

    /**
     * Get generator.
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Services\UuidGeneratorInterface
     */
    public function getGenerator(): UuidGeneratorInterface;

    /**
     * Get marshaler.
     *
     * @return \Aws\DynamoDb\Marshaler
     */
    public function getMarshaler(): Marshaler;

    /**
     * Render the table name
     *
     * @param string $tableName
     *
     * @return string
     */
    public function getTableName(string $tableName): string;
}
