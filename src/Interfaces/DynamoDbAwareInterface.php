<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces;

interface DynamoDbAwareInterface
{
    /**
     * Default throughput read capacity
     *
     * @const int
     */
    public const DEFAULT_READ_CAPACITY = 10;

    /**
     * Default throughput read capacity
     *
     * @const int
     */
    public const DEFAULT_WRITE_CAPACITY = 10;

    /**
     * The key schema key.
     *
     * @const string
     */
    public const KEY_SCHEMA_KEY = 'KeySchema';

    /**
     * The table item key.
     *
     * @const string
     */
    public const TABLE_ITEM_KEY = 'Item';

    /**
     * The table key key.
     *
     * @const string
     */
    public const TABLE_KEY_KEY = 'Key';

    /**
     * The table name key.
     *
     * @const string
     */
    public const TABLE_NAME_KEY = 'TableName';
}
