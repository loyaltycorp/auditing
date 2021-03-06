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
            ['AttributeName' => 'requestId', 'AttributeType' => self::DATA_TYPE_STRING],
            ['AttributeName' => 'lineStatus', 'AttributeType' => self::DATA_TYPE_NUMBER]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getKeySchema(): array
    {
        return [
            // first index has to be of type HASH
            ['AttributeName' => 'requestId', 'KeyType' => self::KEY_TYPE_HASH],
            ['AttributeName' => 'lineStatus', 'KeyType' => self::KEY_TYPE_RANGE]
        ];
    }
}
