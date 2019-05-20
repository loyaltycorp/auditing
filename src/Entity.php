<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing;

use LoyaltyCorp\Auditing\Interfaces\DynamoDbAwareInterface;
use LoyaltyCorp\Auditing\Interfaces\EntityInterface;

abstract class Entity implements DynamoDbAwareInterface, EntityInterface
{
    /**
     * Attribute definitions.
     *
     * @var mixed[]
     */
    private $attributes;

    /**
     * Key schema.
     *
     * @var mixed[]
     */
    private $keys;

    /**
     * Provisioned throughput read capacity.
     *
     * @var int
     */
    private $readCapacity;

    /**
     * Provisioned throughput write capacity.
     *
     * @var int
     */
    private $writeCapacity;

    /**
     * Schema constructor.
     *
     * @param int|null $readCapacity
     * @param int|null $writeCapacity
     */
    public function __construct(
        ?int $readCapacity = null,
        ?int $writeCapacity = null
    ) {
        $this->attributes = $this->getAttributeDefinition();
        $this->keys = $this->getKeySchema();
        $this->readCapacity = $readCapacity ?? self::DEFAULT_READ_CAPACITY;
        $this->writeCapacity = $writeCapacity ?? self::DEFAULT_WRITE_CAPACITY;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            self::TABLE_NAME_KEY => $this->getTableName(),
            self::KEY_SCHEMA_KEY => $this->keys,
            'AttributeDefinitions' => $this->attributes,
            'ProvisionedThroughput' => [
                'ReadCapacityUnits' => $this->readCapacity,
                'WriteCapacityUnits' => $this->writeCapacity
            ]
        ];
    }

    /**
     * Get table attribute definition.
     *
     * @return mixed[]
     */
    abstract protected function getAttributeDefinition(): array;

    /**
     * Get table key schema.
     *
     * @return mixed[]
     */
    abstract protected function getKeySchema(): array;
}
