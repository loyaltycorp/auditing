<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs;

use LoyaltyCorp\Auditing\Document;

/**
 * @coversNothing
 */
class DocumentStub extends Document
{
    /**
     * {@inheritdoc}
     */
    public function getTableName(): string
    {
        return 'EntityStub';
    }

    /**
     * {@inheritdoc}
     */
    protected function getAttributeDefinition(): array
    {
        return [
            ['AttributeName' => 'attr1', 'AttributeType' => 'S'],
            ['AttributeName' => 'attr2', 'AttributeType' => 'S']
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getKeySchema(): array
    {
        return [
            ['AttributeName' => 'attr1', 'KeyType' => 'HASH'],
            ['AttributeName' => 'attr2', 'KeyType' => 'RANGE']
        ];
    }
}
