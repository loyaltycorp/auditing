<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Managers;

use LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface;
use LoyaltyCorp\Auditing\Managers\DocumentManager;
use Tests\LoyaltyCorp\Auditing\Stubs\DtoStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Services\UuidGeneratorStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Manager
 * @covers \LoyaltyCorp\Auditing\Managers\DocumentManager
 */
class DocumentManagerTest extends TestCase
{
    /**
     * Test put item to db successfully.
     *
     * @return void
     */
    public function testPutItemSuccessfully(): void
    {
        $result = $this->getDocumentManager([
            'test' => 'ok'
        ])->create(new DtoStub());

        self::assertSame('ok', $result->get('test'));
    }

    /**
     * Get document manager.
     *
     * @param mixed[]|null $data Response data
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface
     */
    private function getDocumentManager(?array $data = null): DocumentManagerInterface
    {
        return new DocumentManager(
            $this->getConnection($this->createMockHandler($data)),
            new UuidGeneratorStub()
        );
    }
}
