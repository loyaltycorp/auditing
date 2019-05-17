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
            ['AttributeName' => 'occurredAt', 'AttributeType' => 'S'],
            ['AttributeName' => 'requestId', 'AttributeType' => 'S']
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getKeySchema(): array
    {
        return [
            ['AttributeName' => 'occurredAt', 'KeyType' => 'HASH'],
            ['AttributeName' => 'requestId', 'KeyType' => 'RANGE']
        ];
    }
}
