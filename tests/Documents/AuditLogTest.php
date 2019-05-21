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
                ['AttributeName' => 'occurredAt', 'KeyType' => 'HASH'],
                ['AttributeName' => 'clientId', 'KeyType' => 'RANGE'],
                ['AttributeName' => 'requestData', 'KeyType' => 'RANGE'],
                ['AttributeName' => 'requestId', 'KeyType' => 'RANGE'],
                ['AttributeName' => 'responseData', 'KeyType' => 'RANGE'],
                ['AttributeName' => 'status', 'KeyType' => 'RANGE']
            ],
            'AttributeDefinitions' => [
                ['AttributeName' => 'clientIp', 'AttributeType' => 'S'],
                ['AttributeName' => 'occurredAt', 'AttributeType' => 'S'],
                ['AttributeName' => 'requestData', 'AttributeType' => 'S'],
                ['AttributeName' => 'requestId', 'AttributeType' => 'S'],
                ['AttributeName' => 'responseData', 'AttributeType' => 'S'],
                ['AttributeName' => 'status', 'AttributeType' => 'N']
            ],
            'ProvisionedThroughput' => [
                'ReadCapacityUnits' => 10,
                'WriteCapacityUnits' => 10
            ]
        ], $entity->toArray());
    }
}
