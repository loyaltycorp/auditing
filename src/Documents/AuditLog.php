<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Documents;

use LoyaltyCorp\Auditing\Document;

final class AuditLog extends Document
{
    /**
     * {@inheritdoc}
     */
    public function getTableName(): string
    {
        return 'AuditLog';
    }

    /**
     * {@inheritdoc}
     */
    protected function getAttributeDefinition(): array
    {
        return [
            ['AttributeName' => 'clientIp', 'AttributeType' => self::DATA_TYPE_STRING],
            ['AttributeName' => 'occurredAt', 'AttributeType' => self::DATA_TYPE_STRING],
            ['AttributeName' => 'requestData', 'AttributeType' => self::DATA_TYPE_STRING],
            ['AttributeName' => 'requestId', 'AttributeType' => self::DATA_TYPE_STRING],
            ['AttributeName' => 'responseData', 'AttributeType' => self::DATA_TYPE_STRING],
            ['AttributeName' => 'status', 'AttributeType' => self::DATA_TYPE_NUMBER]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getKeySchema(): array
    {
        return [
            // first index has to be of type HASH
            ['AttributeName' => 'occurredAt', 'KeyType' => self::KEY_TYPE_HASH],
            ['AttributeName' => 'clientId', 'KeyType' => self::KEY_TYPE_RANGE],
            ['AttributeName' => 'requestData', 'KeyType' => self::KEY_TYPE_RANGE],
            ['AttributeName' => 'requestId', 'KeyType' => self::KEY_TYPE_RANGE],
            ['AttributeName' => 'responseData', 'KeyType' => self::KEY_TYPE_RANGE],
            ['AttributeName' => 'status', 'KeyType' => self::KEY_TYPE_RANGE]
        ];
    }
}
