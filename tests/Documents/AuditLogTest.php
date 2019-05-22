<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Documents;

use LoyaltyCorp\Auditing\Documents\AuditLog;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Documents\AuditLog
 */
class AuditLogTest extends TestCase
{
    /**
     * Test audit log entity returns expected schema array
     *
     * @return void
     */
    public function testEntity(): void
    {
        $entity = new AuditLog();

        self::assertSame('AuditLog', $entity->getTableName());
        self::assertSame([
            'TableName' => $entity->getTableName(),
            'KeySchema' => [
                ['AttributeName' => 'requestId', 'KeyType' => 'HASH']
            ],
            'AttributeDefinitions' => [
                ['AttributeName' => 'requestId', 'AttributeType' => 'S']
            ],
            'ProvisionedThroughput' => [
                'ReadCapacityUnits' => 10,
                'WriteCapacityUnits' => 10
            ]
        ], $entity->toArray());
    }
}
