<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Managers;

use LoyaltyCorp\Auditing\Interfaces\Managers\AuditorInterface;
use LoyaltyCorp\Auditing\Manager\Auditor;
use Tests\LoyaltyCorp\Auditing\Stubs\DtoStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Manager
 * @covers \LoyaltyCorp\Auditing\Manager\Auditor
 */
class AuditorTest extends TestCase
{
    /**
     * Test log audit data successfully.
     *
     * @return void
     */
    public function testLog(): void
    {
        $dto = new DtoStub();

        self::assertSame($dto, $this->getAuditor()->log($dto));
    }

    /**
     * Get audit manager.
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Managers\AuditorInterface
     */
    private function getAuditor(): AuditorInterface
    {
        return new Auditor($this->getConnection($this->getMockHandler()));
    }
}
