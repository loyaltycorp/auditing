<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Entities;

use Tests\LoyaltyCorp\Auditing\Stubs\EntityStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Entity
 */
class EntityTest extends TestCase
{
    public function testEntity(): void
    {
        $entity = new EntityStub();

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
