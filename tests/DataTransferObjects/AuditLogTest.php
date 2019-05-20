<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\DataTransferObjects;

use LoyaltyCorp\Auditing\DataTransferObjects\AuditLog;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\DataTransferObjects\AuditLog
 */
class AuditLogTest extends TestCase
{
    /**
     * Test dto successfully.
     *
     * @return void
     */
    public function testDto(): void
    {
        $dto = new AuditLog(
            'request-id',
            '2019-05-17 00:00:00'
        );

        self::assertSame('AuditLog', $dto->getTableName());
        self::assertSame([
            'occurredAt' => '2019-05-17 00:00:00',
            'requestId' => 'request-id'
        ], $dto->toArray());
    }
}
