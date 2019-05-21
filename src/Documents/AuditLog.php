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
            ['AttributeName' => 'occurredAt', 'AttributeType' => self::DATA_TYPE_STRING],
            ['AttributeName' => 'requestId', 'AttributeType' => self::DATA_TYPE_STRING]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getKeySchema(): array
    {
        return [
            ['AttributeName' => 'occurredAt', 'KeyType' => self::KEY_TYPE_HASH],
            ['AttributeName' => 'requestId', 'KeyType' => self::KEY_TYPE_RANGE]
        ];
    }
}
