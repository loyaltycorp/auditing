<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Entities;

use LoyaltyCorp\Auditing\Entity;

final class AuditLog extends Entity
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
