<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Documents;

use Tests\LoyaltyCorp\Auditing\Stubs\DocumentStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Document
 */
class DocumentTest extends TestCase
{
    /**
     * Test entity successfully.
     *
     * @return void
     */
    public function testEntity(): void
    {
        $entity = new DocumentStub();

        self::assertSame('EntityStub', $entity->getTableName());
        self::assertSame([
            'TableName' => $entity->getTableName(),
            'KeySchema' => [
                ['AttributeName' => 'attr1', 'KeyType' => 'HASH'],
                ['AttributeName' => 'attr2', 'KeyType' => 'RANGE']
            ],
            'AttributeDefinitions' => [
                ['AttributeName' => 'attr1', 'AttributeType' => 'S'],
                ['AttributeName' => 'attr2', 'AttributeType' => 'S']
            ],
            'ProvisionedThroughput' => [
                'ReadCapacityUnits' => 10,
                'WriteCapacityUnits' => 10
            ]
        ], $entity->toArray());
    }
}
