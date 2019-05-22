<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Services;

use LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface;
use LoyaltyCorp\Auditing\Services\LogWriter;
use Tests\LoyaltyCorp\Auditing\Stubs\DtoStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Managers\DocumentManagerStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Services\LogWriter
 */
class LogWriterTest extends TestCase
{
    /**
     * Test list logs items by line status returns expected number of results.
     *
     * @return void
     */
    public function testListByLineStatusSuccessfully(): void
    {
        $result = $this->getService()->listByLineStatus(1);

        self::assertCount(1, $result->toArray()['Items']);
    }

    /**
     * Test write log successfully.
     *
     * @return void
     */
    public function testWriteSuccessfully(): void
    {
        $result = $this->getService()->write(new DtoStub());

        self::assertSame('ok', $result->get('test'));
    }

    /**
     * Get log writer service.
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface
     */
    private function getService(): LogWriterInterface
    {
        return new LogWriter(new DocumentManagerStub());
    }
}
