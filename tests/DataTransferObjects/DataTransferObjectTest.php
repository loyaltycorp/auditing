<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\DataTransferObjects;

use Tests\LoyaltyCorp\Auditing\Stubs\DtoStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\DataTransferObject
 */
class DataTransferObjectTest extends TestCase
{
    /**
     * Test dto successfully.
     *
     * @return void
     */
    public function testDto(): void
    {
        $dto = new DtoStub();

        self::assertSame('DtoStub', $dto->getTableName());
        self::assertSame(['key' => 'value'], $dto->toArray());
    }
}
