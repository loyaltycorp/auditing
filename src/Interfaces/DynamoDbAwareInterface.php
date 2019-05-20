<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces;

interface DynamoDbAwareInterface
{
    /**
     * Binary data type
     *
     * @const string
     */
    public const DATA_TYPE_BINARY= 'B';

    /**
     * Binary set data type
     *
     * @const string
     */
    public const DATA_TYPE_BINARY_SET = 'BS';

    /**
     * Boolean data type
     *
     * @const string
     */
    public const DATA_TYPE_BOOL = 'BOOL';

    /**
     * Number data type
     *
     * @const string
     */
    public const DATA_TYPE_NUMBER = 'N';

    /**
     * Number set data type
     *
     * @const string
     */
    public const DATA_TYPE_NUMBER_SET = 'NS';

    /**
     * String data type
     *
     * @const string
     */
    public const DATA_TYPE_STRING = 'S';

    /**
     * String set data type
     *
     * @const string
     */
    public const DATA_TYPE_STRING_SET = 'SS';

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
     * The key type hash.
     *
     * @const string
     */
    public const KEY_TYPE_HASH = 'HASH';

    /**
     * The key type range.
     *
     * @const string
     */
    public const KEY_TYPE_RANGE = 'RANGE';

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
