<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Services;

use LoyaltyCorp\Auditing\Interfaces\Services\UuidGeneratorInterface;
use LoyaltyCorp\Auditing\Services\UuidGenerator;
use Ramsey\Uuid\UuidFactoryInterface;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Services\UuidGenerator
 */
class UuidGeneratorTest extends TestCase
{
    /**
     * Test that uuid generator will return a valid v4 uuid.
     *
     * @return void
     */
    public function testUuid4(): void
    {
        $uuid4 = $this->getGenerator()->uuid4();

        $this->assertUuid4($uuid4);
    }

    /**
     * Get uuid generator.
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Services\UuidGeneratorInterface
     */
    private function getGenerator(): UuidGeneratorInterface
    {
        return new UuidGenerator(
            $this->createApplication()->make(UuidFactoryInterface::class)
        );
    }
}
